<?php
$pageTitle = 'Idea to Execution | Soniaa';
$pageDescription = 'My story begins with an uncertain start and an idea: make everyday work easier for new businesses.';
?>
<?php require __DIR__ . '/partials/head.php'; ?>

<a class="skip-link" href="#main">Skip to content</a>

<?php require __DIR__ . '/partials/site-header.php'; ?>

<main id="main" class="site-main">
<section class="opening-screen" data-state="searching" aria-labelledby="opening-title">
        <div class="opening-screen__grain" aria-hidden="true"></div>

        <div class="signal-field" aria-hidden="true">
            <div class="signal-field__glow"></div>
            <svg class="signal-field__drawing" viewBox="0 0 900 900" fill="none">
                <defs>
                    <radialGradient id="core-glow" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(480 445) rotate(90) scale(310)">
                        <stop stop-color="#C7F36B" stop-opacity=".28" />
                        <stop offset=".45" stop-color="#75DAD1" stop-opacity=".08" />
                        <stop offset="1" stop-color="#0B1010" stop-opacity="0" />
                    </radialGradient>
                    <linearGradient id="route-gradient" x1="116" y1="650" x2="776" y2="204" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#F3A64A" stop-opacity=".12" />
                        <stop offset=".47" stop-color="#C7F36B" />
                        <stop offset="1" stop-color="#75DAD1" stop-opacity=".38" />
                    </linearGradient>
                    <pattern id="micro-grid" width="28" height="28" patternUnits="userSpaceOnUse">
                        <circle cx="1" cy="1" r=".8" fill="#F1EFE6" fill-opacity=".18" />
                    </pattern>
                </defs>

                <circle cx="480" cy="445" r="315" fill="url(#core-glow)" />
                <circle class="signal-field__grid" cx="480" cy="445" r="360" fill="url(#micro-grid)" />

                <g class="signal-field__orbits">
                    <ellipse cx="480" cy="445" rx="310" ry="158" transform="rotate(-34 480 445)" stroke="#F1EFE6" stroke-opacity=".1" />
                    <ellipse cx="480" cy="445" rx="270" ry="116" transform="rotate(43 480 445)" stroke="#F1EFE6" stroke-opacity=".12" stroke-dasharray="2 11" />
                    <circle cx="480" cy="445" r="224" stroke="#F1EFE6" stroke-opacity=".08" stroke-dasharray="1 8" />
                </g>

                <g class="signal-field__threads">
                    <path d="M52 571C145 495 180 621 270 547C352 480 325 402 430 416C522 429 520 554 622 510C713 470 689 345 851 275" stroke="#D7DED3" stroke-opacity=".28" stroke-width="1.2" />
                    <path d="M41 334C160 368 177 262 292 314C398 362 355 245 483 287C600 326 655 443 860 411" stroke="#D7DED3" stroke-opacity=".19" />
                    <path d="M94 749C215 631 275 749 354 629C414 537 365 502 483 445C591 393 628 294 783 164" stroke="#D7DED3" stroke-opacity=".17" />
                    <path class="signal-field__route" d="M115 652C220 559 264 628 345 544C421 464 395 401 481 445C564 488 624 466 684 376C739 293 756 238 804 205" stroke="url(#route-gradient)" stroke-width="2" />
                </g>

                <g class="signal-field__nodes">
                    <circle cx="115" cy="652" r="3" fill="#F3A64A" />
                    <circle cx="345" cy="544" r="3" fill="#C7F36B" />
                    <circle cx="481" cy="445" r="5" fill="#C7F36B" />
                    <circle cx="684" cy="376" r="3" fill="#75DAD1" />
                    <circle cx="804" cy="205" r="3" fill="#75DAD1" />
                    <circle class="signal-field__pulse" cx="481" cy="445" r="18" stroke="#C7F36B" stroke-opacity=".62" />
                    <circle class="signal-field__pulse signal-field__pulse--delay" cx="481" cy="445" r="30" stroke="#C7F36B" stroke-opacity=".32" />
                </g>

                <g class="signal-field__ticks" stroke="#F1EFE6" stroke-opacity=".42">
                    <path d="M480 83v18M480 789v18M118 445h18M824 445h18" />
                    <path d="m224 188 12 12M724 690l12 12M223 702l13-13M724 200l13-13" />
                </g>
            </svg>
            <span class="field-coordinate field-coordinate--top">STORY / 01</span>
            <span class="field-coordinate field-coordinate--bottom">MY STORY <i></i> START HERE</span>
        </div>

        <div class="opening-screen__content">
            <p class="opening-kicker"><span>MY STORY</span><span class="opening-kicker__slash">/</span><span>i-SMOKESTACK</span></p>
            <h1 class="opening-title" id="opening-title" aria-label="I started with one idea">
                <span class="opening-title__line opening-title__line--one" aria-hidden="true">I STARTED</span>
                <span class="opening-title__line opening-title__line--two" aria-hidden="true">WITH ONE</span>
                <span class="opening-title__line opening-title__line--three" aria-hidden="true">IDEA<span class="opening-title__period">.</span></span>
            </h1>
            <div class="opening-screen__bottom">
                <p class="opening-caption">MY IDEA:<br>MAKE RUNNING A<br>BUSINESS SIMPLER.</p>
                <button class="focus-control" type="button" aria-pressed="false" data-analytics="focus_signal">
                    <span class="focus-control__orb" aria-hidden="true"><span></span></span>
                    <span class="focus-control__label">FOCUS MY STORY</span>
                    <span class="focus-control__arrow" aria-hidden="true">↗</span>
                </button>
            </div>
        </div>

        <div class="opening-screen__side-note" aria-hidden="true">
            <span>EVERY PATH STARTS SOMEWHERE</span>
            <span class="opening-screen__side-line"></span>
            <span>ORIGIN <b>·</b> 2018</span>
        </div>

        <p class="screen-reader-status" id="field-status" aria-live="polite">The story is ready. Scroll down to follow it.</p>
    </section>
<section class="story-sequence" id="journey" aria-label="My professional story">
    <div class="story-sequence__bridge" aria-hidden="true"><span></span></div>
    <span class="story-signal-cursor" aria-hidden="true"></span>

    <div class="story-layout">
        <nav class="story-index" aria-label="Story chapters">
            <p class="story-index__label">FOLLOW THE STORY</p>
            <span class="story-index__rail" aria-hidden="true"><span id="story-progress"></span></span>
            <a class="is-active" href="#origin" aria-label="Chapter 1: Where I began" aria-current="location"><span>01</span><span>MY BEGINNING</span></a>
            <a href="#work" aria-label="Chapter 2: My work"><span>02</span><span>MY WORK</span></a>
            <a href="#quest" aria-label="Chapter 3: My company’s goal"><span>03</span><span>OUR GOAL</span></a>
            <a href="#people" aria-label="Chapter 4: People and guidance"><span>04</span><span>PEOPLE</span></a>
            <a href="#contact" aria-label="Chapter 5: Get in touch"><span>05</span><span>CONTACT</span></a>
        </nav>

        <div class="story-content">
            <svg class="story-thread-art" viewBox="0 0 1000 3300" preserveAspectRatio="none" fill="none" aria-hidden="true">
                <defs>
                <linearGradient id="story-thread-gradient" x1="270" y1="0" x2="720" y2="3300" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#75DAD1" stop-opacity=".1" />
                        <stop offset=".45" stop-color="#C7F36B" />
                        <stop offset="1" stop-color="#F3A64A" stop-opacity=".52" />
                    </linearGradient>
                </defs>
                <path class="story-thread-art__base" d="M240 0C700 150 810 235 573 410C335 585 190 623 340 820C490 1017 837 1059 671 1260C505 1460 210 1507 347 1720C484 1933 830 1967 685 2180C575 2342 398 2450 725 2600C870 2750 280 2910 420 3050S700 3160 600 3300" pathLength="1" />
                <path class="story-thread-art__progress" d="M240 0C700 150 810 235 573 410C335 585 190 623 340 820C490 1017 837 1059 671 1260C505 1460 210 1507 347 1720C484 1933 830 1967 685 2180C575 2342 398 2450 725 2600C870 2750 280 2910 420 3050S700 3160 600 3300" pathLength="1" stroke="url(#story-thread-gradient)" />
            </svg>

            <section class="story-chapter story-chapter--origin" id="origin" aria-labelledby="origin-title">
                <div class="chapter-heading">
                    <p class="chapter-kicker"><span>01</span> WHERE I BEGAN <i>·</i> 2018</p>
                    <span class="chapter-heading__rule" aria-hidden="true"></span>
                </div>

                <div class="origin-layout">
                    <div class="origin-year" aria-hidden="true">2018</div>
                    <div class="origin-copy">
                        <h2 id="origin-title">My beginning<br>was uncertain.</h2>
                        <p class="origin-copy__disclaimer">This story is retold in first person using public information; these are not Soniaa’s exact words.</p>
                        <p>My start was uncertain. As I learned about the challenges businesses face behind the scenes, one idea took shape: make the everyday work of running a business easier to handle. That idea became i-SmokeStack.</p>
                        <a class="source-link" href="https://www.i-smokestack.com/founder-note/" target="_blank" rel="noopener noreferrer" data-analytics="source_founder_note">READ MY FOUNDER NOTE <span aria-hidden="true">↗</span></a>
                    </div>
                </div>

                <div class="origin-trace" aria-label="Verified story milestones">
                    <div class="origin-trace__start"><span class="trace-node" aria-hidden="true"></span><span class="trace-label">MY IDEA</span><strong>2018</strong><small>I had an idea at an uncertain time.</small></div>
                    <span class="origin-trace__line" aria-hidden="true"><span></span></span>
                    <div class="origin-trace__end"><span class="trace-node" aria-hidden="true"></span><span class="trace-label">TODAY</span><strong>I’M THE FOUNDER</strong><small>i-SmokeStack</small></div>
                </div>
            </section>

            <section class="story-chapter story-chapter--work" id="work" aria-labelledby="work-title">
                <div class="chapter-heading">
                    <p class="chapter-kicker"><span>02</span> MY WORK <i>·</i> TWO AREAS</p>
                    <span class="chapter-heading__rule" aria-hidden="true"></span>
                </div>

                <div class="work-intro">
                    <h2 id="work-title">My work has<br><em>two sides.</em></h2>
                    <p>I care about marketing and sales. At i-SmokeStack, we help new businesses simplify the everyday tasks that keep a business running. Choose an area to learn more.</p>
                </div>

                <div class="work-map" data-active-work="marketing">
                    <div class="work-map__nodes" role="group" aria-label="Explore Soniaa's publicly described work">
                        <button class="work-node is-active" type="button" data-work="marketing" aria-pressed="true" aria-controls="work-detail-marketing">
                            <span class="work-node__number">01</span>
                            <span class="work-node__title">MARKETING<br><i>+</i> SALES</span>
                            <span class="work-node__signal" aria-hidden="true"></span>
                        </button>
                        <button class="work-node" type="button" data-work="process" aria-pressed="false" aria-controls="work-detail-process">
                            <span class="work-node__number">02</span>
                            <span class="work-node__title">NEW BUSINESS<br>TASKS</span>
                            <span class="work-node__signal" aria-hidden="true"></span>
                        </button>
                    </div>

                    <div class="work-map__details" aria-live="polite">
                        <article class="work-detail" id="work-detail-marketing" data-work-detail="marketing">
                            <p class="work-detail__eyebrow">SONIAA SPECIALIST <span>PUBLIC PAGE</span></p>
                            <p>I’m passionate about marketing and sales. Through consulting, I help organizations update the way they market their work.</p>
                            <a class="source-link" href="https://in.linkedin.com/company/soniaspecialist" target="_blank" rel="noopener noreferrer" data-analytics="source_soniaa_specialist">SEE MY PUBLIC PAGE <span aria-hidden="true">↗</span></a>
                        </article>
                        <article class="work-detail" id="work-detail-process" data-work-detail="process" hidden>
                            <p class="work-detail__eyebrow">i-SMOKESTACK <span>ABOUT THE COMPANY</span></p>
                            <p>At i-SmokeStack, we help new businesses simplify their routines—the everyday steps that keep a business running—so teams can work with more clarity.</p>
                            <a class="source-link" href="https://i-smokestack.com/about/" target="_blank" rel="noopener noreferrer" data-analytics="source_about_work">HOW WE HELP <span aria-hidden="true">↗</span></a>
                        </article>
                    </div>
                </div>
            </section>

            <section class="story-chapter story-chapter--quest" id="quest" aria-labelledby="quest-title">
                <div class="chapter-heading">
                    <p class="chapter-kicker"><span>03</span> OUR BIG IDEA <i>·</i> i-SMOKESTACK</p>
                    <span class="chapter-heading__rule" aria-hidden="true"></span>
                </div>

                <div class="quest-layout">
                    <div class="quest-copy">
                        <p class="quest-copy__label">OUR AIM</p>
                        <h2 id="quest-title">Make better<br>decisions—<br><em>before they cost.</em></h2>
                        <p class="quest-copy__summary">In everyday words, we help teams choose a better next step before a problem becomes expensive to fix.</p>
                        <a class="source-link" href="https://i-smokestack.com/about/" target="_blank" rel="noopener noreferrer" data-analytics="source_about_quest">READ ABOUT OUR GOAL <span aria-hidden="true">↗</span></a>
                    </div>

                    <div class="principle-orbit" aria-label="Published i-SmokeStack principles">
                        <div class="principle-orbit__center"><span id="principle-current" aria-hidden="true">OUR<br>VALUES</span></div>
                        <button class="principle-orbit__word principle-orbit__word--one" type="button" data-principle="LISTEN" aria-pressed="false">LISTEN</button>
                        <button class="principle-orbit__word principle-orbit__word--two" type="button" data-principle="STAY CURIOUS" aria-pressed="false">STAY CURIOUS</button>
                        <button class="principle-orbit__word principle-orbit__word--three" type="button" data-principle="SPEAK HONESTLY" aria-pressed="false">SPEAK HONESTLY</button>
                        <button class="principle-orbit__word principle-orbit__word--four" type="button" data-principle="GROW TOGETHER" aria-pressed="false">GROW TOGETHER</button>
                        <span class="principle-orbit__ring principle-orbit__ring--one" aria-hidden="true"></span>
                        <span class="principle-orbit__ring principle-orbit__ring--two" aria-hidden="true"></span>
                    </div>
                </div>
                <p class="quest-note"><span id="principle-description" aria-live="polite">Choose a word to see how I explain it in everyday language.</span> These are principles we publish at i-SmokeStack.</p>
            </section>

            <section class="story-chapter story-chapter--people" id="people" aria-labelledby="people-title">
                <div class="chapter-heading">
                    <p class="chapter-kicker"><span>04</span> A NOTE I’D LIKE TO SHARE</p>
                    <span class="chapter-heading__rule" aria-hidden="true"></span>
                </div>

                <div class="people-layout">
                    <div class="people-heading">
                        <p class="people-heading__label">A NOTE FROM AN INTERN</p>
                        <h2 id="people-title">Let me share<br><em>a thank-you.</em></h2>
                    </div>
                    <figure class="people-voice">
                        <span class="people-voice__quote-mark" aria-hidden="true">“</span>
                        <blockquote>Guidance and encouragement whenever I was stuck.</blockquote>
                        <figcaption>
                            <span>— Aayushi Surana</span>
                            <span>These are Aayushi Surana’s words from her public post about interning at i-SmokeStack. She thanked Soniaa Specialist, Rashee M. and Jai Khanna for their guidance.</span>
                        </figcaption>
                        <a class="source-link" href="https://www.linkedin.com/posts/aayushi-surana-bbb92620b_intern-gratitude-gratitude-activity-6845992181291905024-7qfm" target="_blank" rel="noopener noreferrer" data-analytics="source_intern_post">READ THE PUBLIC POST <span aria-hidden="true">↗</span></a>
                    </figure>
                </div>

                <div class="story-endline">
                    <span class="story-endline__node" aria-hidden="true"></span>
                    <p>MY STORY CONTINUES</p>
                    <a href="https://www.linkedin.com/in/soniaspecialist/" target="_blank" rel="noopener noreferrer" data-analytics="linkedin_profile">VIEW MY LINKEDIN <span aria-hidden="true">↗</span></a>
                    <a href="#top" data-analytics="return_to_opening">BACK TO MY BEGINNING <span aria-hidden="true">↑</span></a>
                </div>
            </section>

            <section class="story-chapter story-chapter--connection" id="contact" aria-labelledby="contact-title">
                <div class="chapter-heading">
                    <p class="chapter-kicker"><span>05</span> LET’S KEEP IN TOUCH <i>·</i> YOUR TURN</p>
                    <span class="chapter-heading__rule" aria-hidden="true"></span>
                </div>

                <div class="connection-layout">
                    <div class="connection-intro">
                        <p class="connection-intro__label">WHAT WOULD YOU LIKE TO ASK ME?</p>
                        <h2 id="contact-title">Let’s <em>talk.</em></h2>
                        <p>If my story sparked a question, leave me a note and an email address where I can reach you.</p>
                    </div>

                    <form class="connection-form" id="contact-form" action="api/contact.php" method="post">
                        <div class="connection-field">
                            <label for="contact-name">NAME</label>
                            <input id="contact-name" name="name" type="text" autocomplete="name" maxlength="80" required aria-describedby="contact-name-error">
                            <span class="connection-field__error" id="contact-name-error"></span>
                        </div>

                        <div class="connection-field">
                            <label for="contact-email">EMAIL</label>
                            <input id="contact-email" name="email" type="email" autocomplete="email" maxlength="254" required aria-describedby="contact-email-error">
                            <span class="connection-field__error" id="contact-email-error"></span>
                        </div>

                        <div class="connection-field">
                            <label for="contact-message">MESSAGE</label>
                            <textarea id="contact-message" name="message" rows="5" minlength="10" maxlength="5000" required aria-describedby="contact-message-error"></textarea>
                            <span class="connection-field__error" id="contact-message-error"></span>
                        </div>

                        <div class="connection-form__trap" aria-hidden="true">
                            <label for="contact-website">Leave this field empty</label>
                            <input id="contact-website" name="website" type="text" tabindex="-1" autocomplete="off">
                        </div>

                        <p class="connection-form__status" id="contact-status" role="status" aria-live="polite"><?php
                            if (($_GET['contact'] ?? '') === 'sent') {
                                echo 'Thanks — your message has been received and saved.';
                            } elseif (($_GET['contact'] ?? '') === 'error') {
                                echo 'We could not save your message. Please check the fields and try again.';
                            }
                        ?></p>

                        <button class="focus-control connection-submit" type="submit">
                            <span class="focus-control__orb" aria-hidden="true"><span></span></span>
                            <span class="focus-control__label">SEND A NOTE</span>
                            <span class="focus-control__arrow" aria-hidden="true">↗</span>
                        </button>

                        <p class="connection-form__note">Your note is saved separately. The site counts basic page interactions, not what you write here.</p>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>

</main>

<?php require __DIR__ . '/partials/site-footer.php'; ?>
