<?php
declare(strict_types=1);

require __DIR__ . '/helpers.php';

$jsonRequest = request_has_json_content_type();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    contact_response($jsonRequest, false, 'This form accepts submissions only.', [], 405);
}

if (!request_is_same_origin()) {
    contact_response($jsonRequest, false, 'The request could not be verified. Please reload the page and try again.', [], 403);
}

$contentLength = (int)($_SERVER['CONTENT_LENGTH'] ?? 0);
if ($contentLength > 12000) {
    contact_response($jsonRequest, false, 'Your message is too large. Please shorten it and try again.', [], 413);
}

if ($jsonRequest) {
    $rawBody = file_get_contents('php://input');
    $input = is_string($rawBody) && strlen($rawBody) <= 12000
        ? json_decode($rawBody, true)
        : null;

    if (!is_array($input)) {
        contact_response(true, false, 'The form data could not be read. Please try again.', [], 400);
    }
} else {
    $input = $_POST;
}

if (trim(scalar_request_value($input['website'] ?? '')) !== '') {
    contact_response($jsonRequest, true, 'Thanks — your message has been received and saved.');
}

$name = trim(scalar_request_value($input['name'] ?? ''));
$email = trim(scalar_request_value($input['email'] ?? ''));
$message = trim(scalar_request_value($input['message'] ?? ''));
$errors = [];

if (text_length($name) < 2 || text_length($name) > 80 || preg_match('/[\x00-\x1F\x7F]/u', $name)) {
    $errors['name'] = 'Enter a name between 2 and 80 characters.';
}

if (strlen($email) > 254 || preg_match('/[\r\n]/', $email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Enter a valid email address.';
}

if (text_length($message) < 10 || text_length($message) > 5000) {
    $errors['message'] = 'Write a message between 10 and 5,000 characters.';
}

if ($errors) {
    contact_response($jsonRequest, false, 'Please review the fields marked below.', $errors, 422);
}

$saved = append_private_json_line('contact-submissions.jsonl', [
    'received_at' => utc_timestamp(),
    'name' => $name,
    'email' => $email,
    'message' => $message,
]);

if (!$saved) {
    contact_response($jsonRequest, false, 'We could not save your message right now. Please try again later.', [], 500);
}

record_engagement_event('contact_submit', ['source' => 'contact_form']);
contact_response($jsonRequest, true, 'Thanks — your message has been received and saved.');
