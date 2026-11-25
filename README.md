# The Idea To Execution

A small PHP foundation for Soniaa's interactive i-SmokeStack founder story. The visual direction uses a continuous signal motif that can evolve from scattered paths into a clear route as the experience is built.

## Project structure

```text
.
├── index.php
├── api/
│   ├── contact.php
│   ├── helpers.php
│   └── track.php
├── partials/
│   ├── head.php
│   ├── site-header.php
│   └── site-footer.php
└── assets/
    ├── favicon.svg
    ├── css/
    │   └── main.css
    └── js/
        └── main.js
```

Shared page chrome lives in `partials/`. Keep page content in PHP files at the project root and shared styling or interactions in `assets/`.

## Run with XAMPP

1. Copy this project folder into XAMPP's `htdocs` directory, for example `C:\xampp\htdocs\clarity-signal`.
2. Open the XAMPP Control Panel and start **Apache**.
3. Visit `http://localhost/clarity-signal/` in a browser.

PHP pages must be opened through `localhost`; opening `index.php` directly from File Explorer will not run PHP.

## Contact and engagement data

The connection form validates in the browser and again in PHP. Valid submissions are appended to `contact-submissions.jsonl`; approved engagement events are appended to `engagement-events.jsonl`. These files are created outside the public site in PHP's temporary directory, usually `C:\xampp\tmp\soniaa-private-data` on XAMPP. No MySQL setup is needed.

Engagement records include event names, approved chapter or control values, and rounded time on page. They do not include names, email addresses, IP addresses, referrers, user agents, cookies, or visitor IDs. Contact details are stored separately from engagement events. The form currently saves messages to the server inbox; it does not send email.

To try it locally, open the site through `localhost`, submit a valid message, and check the success status. Then inspect `contact-submissions.jsonl` and `engagement-events.jsonl` in the private data directory. Try an invalid email or a short message to see the validation feedback. The private directory must be writable by Apache. If your PHP temporary directory is different, `sys_get_temp_dir()` in PHP returns its location; you can set `SONIAA_PRIVATE_DATA_DIR` to another writable path outside `htdocs`.

## Run with PHP's built-in server

From the project folder, run `php -S localhost:8000` and open `http://localhost:8000/`.
"# portfolio_Soniaa" 
