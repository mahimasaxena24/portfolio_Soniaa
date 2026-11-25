<?php
declare(strict_types=1);

require __DIR__ . '/helpers.php';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    send_json_response(['ok' => false, 'message' => 'POST requests only.'], 405);
}

if (!request_is_same_origin()) {
    send_json_response(['ok' => false, 'message' => 'The request could not be verified.'], 403);
}

$contentLength = (int)($_SERVER['CONTENT_LENGTH'] ?? 0);
$rawBody = file_get_contents('php://input');

if ($contentLength > 4096 || !is_string($rawBody) || strlen($rawBody) > 4096) {
    send_json_response(['ok' => false, 'message' => 'Event payload is too large.'], 413);
}

$payload = json_decode($rawBody, true);
if (!is_array($payload) || !is_string($payload['event'] ?? null)) {
    send_json_response(['ok' => false, 'message' => 'Event payload is invalid.'], 400);
}

$event = $payload['event'];
$details = is_array($payload['details'] ?? null) ? $payload['details'] : [];
$safeDetails = [];

switch ($event) {
    case 'page_view':
        break;

    case 'chapter_view':
    case 'chapter_navigation':
        $chapter = scalar_request_value($details['chapter'] ?? '');
        if (!in_array($chapter, ['origin', 'work', 'quest', 'people', 'contact'], true)) {
            send_json_response(['ok' => false, 'message' => 'Unknown story chapter.'], 422);
        }
        $safeDetails['chapter'] = $chapter;
        break;

    case 'cta_click':
        $target = scalar_request_value($details['target'] ?? '');
        $allowedTargets = [
            'focus_signal',
            'scroll_to_trace',
            'source_founder_note',
            'source_soniaa_specialist',
            'source_about_work',
            'source_about_quest',
            'source_intern_post',
            'linkedin_profile',
            'return_to_opening',
        ];
        if (!in_array($target, $allowedTargets, true)) {
            send_json_response(['ok' => false, 'message' => 'Unknown call to action.'], 422);
        }
        $safeDetails['target'] = $target;
        break;

    case 'work_select':
        $work = scalar_request_value($details['work'] ?? '');
        if (!in_array($work, ['marketing', 'process'], true)) {
            send_json_response(['ok' => false, 'message' => 'Unknown work area.'], 422);
        }
        $safeDetails['work'] = $work;
        break;

    case 'principle_select':
        $principle = scalar_request_value($details['principle'] ?? '');
        $allowedPrinciples = ['listen', 'stay_curious', 'speak_honestly', 'grow_together'];
        if (!in_array($principle, $allowedPrinciples, true) || !is_bool($details['selected'] ?? null)) {
            send_json_response(['ok' => false, 'message' => 'Unknown principle.'], 422);
        }
        $safeDetails['principle'] = $principle;
        $safeDetails['selected'] = $details['selected'];
        break;

    case 'focus_toggle':
        if (!is_bool($details['focused'] ?? null)) {
            send_json_response(['ok' => false, 'message' => 'Focus state is invalid.'], 422);
        }
        $safeDetails['focused'] = $details['focused'];
        break;

    case 'engagement_time':
        $seconds = $details['seconds'] ?? null;
        if (!is_int($seconds) || $seconds < 5 || $seconds > 86400) {
            send_json_response(['ok' => false, 'message' => 'Engagement duration is invalid.'], 422);
        }
        $safeDetails['seconds'] = (int)(round($seconds / 5) * 5);
        break;

    default:
        send_json_response(['ok' => false, 'message' => 'Unknown event.'], 422);
}

if (!record_engagement_event($event, $safeDetails)) {
    send_json_response(['ok' => false, 'message' => 'Event storage is unavailable.'], 500);
}

send_json_response(['ok' => true], 202);
