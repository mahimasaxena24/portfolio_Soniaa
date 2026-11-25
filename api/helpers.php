<?php
declare(strict_types=1);

function private_data_directory(): string
{
    $configuredDirectory = getenv('SONIAA_PRIVATE_DATA_DIR');

    if (is_string($configuredDirectory) && trim($configuredDirectory) !== '') {
        return rtrim($configuredDirectory, "\\/");
    }

    return rtrim(sys_get_temp_dir(), "\\/") . DIRECTORY_SEPARATOR . 'soniaa-private-data';
}

function append_private_json_line(string $filename, array $record): bool
{
    $allowedFiles = ['contact-submissions.jsonl', 'engagement-events.jsonl'];
    if (!in_array($filename, $allowedFiles, true)) {
        return false;
    }

    $directory = private_data_directory();
    if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) {
        return false;
    }

    $line = json_encode(
        $record,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );

    if (!is_string($line)) {
        return false;
    }

    $path = $directory . DIRECTORY_SEPARATOR . $filename;
    return @file_put_contents($path, $line . PHP_EOL, FILE_APPEND | LOCK_EX) !== false;
}

function utc_timestamp(): string
{
    return (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format(DateTimeInterface::ATOM);
}

function request_is_same_origin(): bool
{
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    if ($origin === '') {
        $fetchSite = strtolower($_SERVER['HTTP_SEC_FETCH_SITE'] ?? '');
        return $fetchSite === '' || $fetchSite === 'same-origin';
    }

    $requestScheme = 'http';
    if (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') {
        $requestScheme = 'https';
    } elseif (in_array(strtolower($_SERVER['REQUEST_SCHEME'] ?? ''), ['http', 'https'], true)) {
        $requestScheme = strtolower($_SERVER['REQUEST_SCHEME']);
    }

    $originParts = parse_url($origin);
    $requestParts = parse_url($requestScheme . '://' . ($_SERVER['HTTP_HOST'] ?? ''));

    if (!is_array($originParts) || !is_array($requestParts)) {
        return false;
    }

    $originScheme = strtolower((string)($originParts['scheme'] ?? ''));
    $requestOriginScheme = strtolower((string)($requestParts['scheme'] ?? ''));
    $originHost = strtolower((string)($originParts['host'] ?? ''));
    $requestHost = strtolower((string)($requestParts['host'] ?? ''));
    $originPort = $originParts['port'] ?? ($originScheme === 'https' ? 443 : 80);
    $requestPort = $requestParts['port'] ?? ($requestOriginScheme === 'https' ? 443 : 80);

    return in_array($originScheme, ['http', 'https'], true)
        && $originScheme === $requestOriginScheme
        && $originHost !== ''
        && $originHost === $requestHost
        && $originPort === $requestPort;
}

function request_has_json_content_type(): bool
{
    $contentType = strtolower(trim(explode(';', $_SERVER['CONTENT_TYPE'] ?? '')[0]));
    return $contentType === 'application/json';
}

function send_json_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

function contact_response(bool $jsonRequest, bool $success, string $message, array $errors = [], int $status = 200): void
{
    if ($jsonRequest) {
        send_json_response([
            'ok' => $success,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }

    $destination = '../index.php?contact=' . ($success ? 'sent' : 'error') . '#contact';
    header('Location: ' . $destination, true, 303);
    exit;
}

function record_engagement_event(string $event, array $details = []): bool
{
    return append_private_json_line('engagement-events.jsonl', [
        'occurred_at' => utc_timestamp(),
        'event' => $event,
        'details' => $details,
    ]);
}

function scalar_request_value($value): string
{
    return is_string($value) || is_numeric($value) ? (string)$value : '';
}

function text_length(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}
