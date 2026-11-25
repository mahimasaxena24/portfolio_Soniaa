/* Opening, story, contact, and privacy-limited engagement interactions. */
(() => {
    const screen = document.querySelector('.opening-screen');

    if (!screen) return;

    const focusButton = screen.querySelector('.focus-control');
    const fieldState = document.querySelector('#field-state');
    const liveStatus = screen.querySelector('#field-status');

    if (!focusButton) return;

    const label = focusButton.querySelector('.focus-control__label');
    const canTrackPointer = window.matchMedia('(pointer: fine)').matches;
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const analyticsUrl = new URL('api/track.php', document.baseURI).toString();
    const pageStartedAt = performance.now();
    let pageTimeSent = false;
    let pointerFrame = 0;
    let nextPointer = null;

    const trackEvent = (eventName, details = {}) => {
        const body = JSON.stringify({ event: eventName, details });

        try {
            fetch(analyticsUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body,
                keepalive: true,
            }).catch(() => {});
        } catch (error) {
            // Engagement tracking is optional and must never interrupt the experience.
        }
    };

    const recordPageTime = () => {
        if (pageTimeSent) return;
        pageTimeSent = true;

        const seconds = Math.floor((performance.now() - pageStartedAt) / 1000);
        if (seconds < 5) return;

        const roundedSeconds = Math.round(seconds / 5) * 5;
        const body = JSON.stringify({ event: 'engagement_time', details: { seconds: roundedSeconds } });
        const payload = new Blob([body], { type: 'application/json' });

        if (!navigator.sendBeacon || !navigator.sendBeacon(analyticsUrl, payload)) {
            trackEvent('engagement_time', { seconds: roundedSeconds });
        }
    };

    trackEvent('page_view');
    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target.closest('[data-analytics]') : null;
        if (target) trackEvent('cta_click', { target: target.dataset.analytics });

        const chapterLink = event.target instanceof Element
            ? event.target.closest('.story-index a[href^="#"]')
            : null;
        if (chapterLink) trackEvent('chapter_navigation', { chapter: chapterLink.hash.slice(1) });

        const inPageLink = event.target instanceof Element
            ? event.target.closest('a[href^="#"]:not(.skip-link)')
            : null;
        const destination = inPageLink ? document.getElementById(inPageLink.hash.slice(1)) : null;

        if (inPageLink && destination) {
            event.preventDefault();
            destination.scrollIntoView({
                behavior: reduceMotion ? 'auto' : 'smooth',
                block: 'start',
            });

            if (window.location.hash !== inPageLink.hash) {
                window.history.pushState(null, '', inPageLink.hash);
            }
        }
    });
    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'hidden') recordPageTime();
    });
    window.addEventListener('pagehide', recordPageTime);

    focusButton.addEventListener('click', () => {
        const isFocused = screen.dataset.state !== 'focused';

        screen.dataset.state = isFocused ? 'focused' : 'searching';
        focusButton.setAttribute('aria-pressed', String(isFocused));

        if (label) {
            label.textContent = isFocused ? 'SHOW THE FULL PICTURE' : 'FOCUS MY STORY';
        }

        if (fieldState) {
            fieldState.textContent = isFocused ? 'STORY / IN FOCUS' : 'STORY / BEGINNING';
        }

        if (liveStatus) {
            liveStatus.textContent = isFocused
                ? 'The story is in focus. Scroll down to follow it.'
                : 'The story is ready. Scroll down to follow it.';
        }

        trackEvent('focus_toggle', { focused: isFocused });
    });

    if (canTrackPointer && !reduceMotion) {
        screen.addEventListener('pointermove', (event) => {
            const bounds = screen.getBoundingClientRect();
            nextPointer = {
                x: Math.round((event.clientX / window.innerWidth) * 100) + '%',
                y: Math.round((event.clientY / window.innerHeight) * 100) + '%',
                fieldX: Math.round((event.clientX - bounds.left - bounds.width / 2) * 0.018),
                fieldY: Math.round((event.clientY - bounds.top - bounds.height / 2) * 0.018),
            };

            if (pointerFrame) return;

            pointerFrame = window.requestAnimationFrame(() => {
                if (screen.dataset.state !== 'focused' && nextPointer) {
                    screen.style.setProperty('--pointer-x', nextPointer.x);
                    screen.style.setProperty('--pointer-y', nextPointer.y);
                    screen.style.setProperty('--parallax-x', nextPointer.fieldX + 'px');
                    screen.style.setProperty('--parallax-y', nextPointer.fieldY + 'px');
                }

                pointerFrame = 0;
            });
        });

        screen.addEventListener('pointerleave', () => {
            if (pointerFrame) {
                window.cancelAnimationFrame(pointerFrame);
                pointerFrame = 0;
            }

            screen.style.setProperty('--pointer-x', '50%');
            screen.style.setProperty('--pointer-y', '50%');
            screen.style.setProperty('--parallax-x', '0px');
            screen.style.setProperty('--parallax-y', '0px');
        });
    }

    const workMap = document.querySelector('.work-map');

    if (workMap) {
        const workNodes = Array.from(workMap.querySelectorAll('[data-work]'));
        const workDetails = Array.from(workMap.querySelectorAll('[data-work-detail]'));

        workNodes.forEach((node) => {
            node.addEventListener('click', () => {
                const selectedWork = node.dataset.work;

                workMap.dataset.activeWork = selectedWork;

                workNodes.forEach((item) => {
                    const isSelected = item === node;
                    item.classList.toggle('is-active', isSelected);
                    item.setAttribute('aria-pressed', String(isSelected));
                });

                workDetails.forEach((detail) => {
                    detail.hidden = detail.dataset.workDetail !== selectedWork;
                });

                trackEvent('work_select', { work: selectedWork });
            });
        });
    }

    const contactForm = document.querySelector('#contact-form');

    if (contactForm) {
        const contactStatus = contactForm.querySelector('#contact-status');
        const submitButton = contactForm.querySelector('button[type="submit"]');
        const submitLabel = submitButton?.querySelector('.focus-control__label');
        const fields = ['name', 'email', 'message'];

        const setFieldError = (fieldName, message) => {
            const field = contactForm.elements.namedItem(fieldName);
            const error = document.getElementById('contact-' + fieldName + '-error');

            if (!field || !error) return;

            field.setAttribute('aria-invalid', message ? 'true' : 'false');
            error.textContent = message || '';
        };

        const clearFormErrors = () => {
            fields.forEach((fieldName) => setFieldError(fieldName, ''));
            contactStatus?.classList.remove('is-error');
        };

        const showContactStatus = (message, isError = false) => {
            if (!contactStatus) return;
            contactStatus.textContent = message;
            contactStatus.classList.toggle('is-error', isError);
        };

        const query = new URLSearchParams(window.location.search);
        if (query.get('contact') === 'sent') {
            showContactStatus('Thanks — your message has been received and saved.');
        } else if (query.get('contact') === 'error') {
            showContactStatus('We could not save your message. Please check the fields and try again.', true);
        }

        fields.forEach((fieldName) => {
            const field = contactForm.elements.namedItem(fieldName);
            field?.addEventListener('input', () => {
                setFieldError(fieldName, '');
                if (!contactForm.querySelector('[aria-invalid="true"]')) {
                    contactStatus?.classList.remove('is-error');
                }
            });
        });

        contactForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            clearFormErrors();

            const name = contactForm.elements.namedItem('name');
            const email = contactForm.elements.namedItem('email');
            const message = contactForm.elements.namedItem('message');
            const errors = {};

            if (name.value.trim().length < 2) errors.name = 'Please enter your name.';
            if (!email.validity.valid || !email.value.trim()) errors.email = 'Please enter a valid email address.';
            if (message.value.trim().length < 10) errors.message = 'Please write at least 10 characters.';

            if (Object.keys(errors).length) {
                Object.entries(errors).forEach(([fieldName, text]) => setFieldError(fieldName, text));
                showContactStatus('Please review the fields marked below.', true);
                contactForm.elements.namedItem(Object.keys(errors)[0]).focus();
                return;
            }

            if (submitButton) submitButton.disabled = true;
            if (submitLabel) submitLabel.textContent = 'SENDING…';
            showContactStatus('Sending your note…');

            try {
                const response = await fetch(contactForm.action, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(Object.fromEntries(new FormData(contactForm).entries())),
                    credentials: 'same-origin',
                });
                const result = await response.json();

                if (!response.ok || !result.ok) {
                    const serverErrors = result.errors || {};
                    Object.entries(serverErrors).forEach(([fieldName, text]) => setFieldError(fieldName, text));
                    showContactStatus(result.message || 'We could not save your message. Please try again.', true);

                    const firstInvalid = Object.keys(serverErrors)[0];
                    if (firstInvalid) contactForm.elements.namedItem(firstInvalid)?.focus();
                    return;
                }

                contactForm.reset();
                clearFormErrors();
                showContactStatus(result.message || 'Thanks — your message has been received and saved.');
            } catch (error) {
                showContactStatus('The connection failed, so your note was not saved. Please try again.', true);
            } finally {
                if (submitButton) submitButton.disabled = false;
                if (submitLabel) submitLabel.textContent = 'SEND A NOTE';
            }
        });
    }

    const principleOrbit = document.querySelector('.principle-orbit');

    if (principleOrbit) {
        const principleButtons = Array.from(principleOrbit.querySelectorAll('[data-principle]'));
        const principleCurrent = principleOrbit.querySelector('#principle-current');
        const principleDescription = document.querySelector('#principle-description');
        const principleMeanings = {
            LISTEN: 'To me, listening means making room to hear what people are saying.',
            'STAY CURIOUS': 'To me, staying curious means asking questions and remaining open to learning.',
            'SPEAK HONESTLY': 'To me, speaking honestly means saying what I mean with care.',
            'GROW TOGETHER': 'To me, growing together means learning and making progress as a team.',
        };

        principleButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const shouldSelect = button.getAttribute('aria-pressed') !== 'true';

                principleButtons.forEach((item) => {
                    const isSelected = item === button && shouldSelect;
                    item.setAttribute('aria-pressed', String(isSelected));
                    item.classList.toggle('is-selected', isSelected);
                });

                principleOrbit.classList.toggle('has-selection', shouldSelect);
                trackEvent('principle_select', {
                    principle: button.dataset.principle.toLowerCase().replace(/ /g, '_'),
                    selected: shouldSelect,
                });

                if (principleCurrent) {
                    principleCurrent.replaceChildren();
                    const words = (shouldSelect ? button.dataset.principle : 'OUR VALUES').split(' ');

                    words.forEach((word, index) => {
                        if (index > 0) principleCurrent.append(document.createElement('br'));
                        principleCurrent.append(document.createTextNode(word));
                    });
                }

                if (principleDescription) {
                    principleDescription.textContent = shouldSelect
                        ? principleMeanings[button.dataset.principle]
                        : 'Choose a word to see how I explain it in everyday language.';
                }
            });
        });
    }

    const story = document.querySelector('.story-sequence');

    if (story) {
        const chapters = Array.from(story.querySelectorAll('.story-chapter'));
        const chapterLinks = Array.from(story.querySelectorAll('.story-index a'));
        const routeProgress = story.querySelector('.story-thread-art__progress');
        const indexProgress = story.querySelector('#story-progress');
        const storyCursor = story.querySelector('.story-signal-cursor');
        let scrollFrame = 0;

        if (canTrackPointer && !reduceMotion && storyCursor) {
            let cursorFrame = 0;
            let cursorPosition = null;

            story.addEventListener('pointermove', (event) => {
                const bounds = story.getBoundingClientRect();
                cursorPosition = {
                    x: Math.round(event.clientX - bounds.left),
                    y: Math.round(event.clientY - bounds.top),
                };

                if (cursorFrame) return;

                cursorFrame = window.requestAnimationFrame(() => {
                    if (cursorPosition) {
                        storyCursor.style.transform = 'translate3d(' + cursorPosition.x + 'px, ' + cursorPosition.y + 'px, 0) translate(-50%, -50%)';
                        storyCursor.classList.add('is-visible');
                    }

                    cursorFrame = 0;
                });
            });

            story.addEventListener('pointerleave', () => {
                if (cursorFrame) {
                    window.cancelAnimationFrame(cursorFrame);
                    cursorFrame = 0;
                }

                cursorPosition = null;
                storyCursor.classList.remove('is-visible');
            });
        }

        if (!reduceMotion && 'IntersectionObserver' in window) {
            const revealItems = Array.from(story.querySelectorAll(
                '.chapter-heading, .origin-layout, .origin-trace, .work-intro, .work-map, .quest-layout, .quest-note, .people-layout, .story-endline, .connection-layout'
            ));

            if (revealItems.length) {
                story.classList.add('has-reveal');
                revealItems.forEach((item) => item.setAttribute('data-reveal', ''));

                const revealObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) return;

                        entry.target.classList.add('is-revealed');
                        observer.unobserve(entry.target);
                    });
                }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

                revealItems.forEach((item) => revealObserver.observe(item));
            }
        }

        const viewedChapters = new Set();

        const updateStoryProgress = () => {
            const bounds = story.getBoundingClientRect();
            const travel = bounds.height + window.innerHeight;
            const progress = Math.max(0, Math.min(1, (window.innerHeight - bounds.top) / travel));

            if (routeProgress) {
                routeProgress.style.strokeDashoffset = String(1 - progress);
            }

            if (indexProgress) {
                indexProgress.style.transform = 'scaleY(' + progress + ')';
            }
        };

        const requestStoryProgress = () => {
            if (scrollFrame) return;

            scrollFrame = window.requestAnimationFrame(() => {
                updateStoryProgress();
                scrollFrame = 0;
            });
        };

        updateStoryProgress();
        window.addEventListener('scroll', requestStoryProgress, { passive: true });
        window.addEventListener('resize', requestStoryProgress);

        if ('IntersectionObserver' in window && chapterLinks.length) {
            const chapterObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;

                    chapters.forEach((chapter) => {
                        chapter.classList.toggle('is-current', chapter === entry.target);
                    });

                    if (!viewedChapters.has(entry.target.id)) {
                        viewedChapters.add(entry.target.id);
                        trackEvent('chapter_view', { chapter: entry.target.id });
                    }

                    chapterLinks.forEach((link) => {
                        const isCurrent = link.hash === '#' + entry.target.id;
                        link.classList.toggle('is-active', isCurrent);

                        if (isCurrent) {
                            link.setAttribute('aria-current', 'location');
                        } else {
                            link.removeAttribute('aria-current');
                        }
                    });
                });
            }, { rootMargin: '-38% 0px -52% 0px', threshold: 0 });

            chapters.forEach((chapter) => chapterObserver.observe(chapter));
        }
    }
})();
