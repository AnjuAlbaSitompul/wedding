(function () {
    'use strict';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const genericUrl = window.location.origin + '/';

    function playMusic() {
        const audio = document.getElementById('bg-music');
        const toggle = document.getElementById('music-toggle');

        if (!audio) {
            return Promise.resolve(false);
        }

        return audio.play()
            .then(() => {
                toggle?.classList.add('playing');
                return true;
            })
            .catch(() => false);
    }

    function pauseMusic() {
        const audio = document.getElementById('bg-music');
        const toggle = document.getElementById('music-toggle');

        if (!audio) {
            return;
        }

        audio.pause();
        toggle?.classList.remove('playing');
    }

    function initEntryOverlay() {
        const overlay = document.getElementById('entry-overlay');
        const envelope = document.getElementById('envelope');

        if (!overlay || !envelope) {
            return;
        }

        document.body.classList.add('no-scroll');
        window.weddingLenis?.stop();

        const hasGsap = typeof window.gsap !== 'undefined';
        const reduced = !hasGsap || window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const idle = reduced ? null : gsap.to(envelope, { y: -10, duration: 2, yoyo: true, repeat: -1, ease: 'sine.inOut' });

        const finish = () => {
            overlay.remove();
            document.body.classList.remove('no-scroll');
            window.weddingLenis?.start();
            window.ScrollTrigger?.refresh();
            window.invitationOpened = true;
            window.dispatchEvent(new Event('invitation:opened'));
        };

        // <button> fires click on Enter/Space, so keyboard users are covered too.
        envelope.addEventListener('click', () => {
            playMusic();
            idle?.kill();

            if (reduced) {
                overlay.style.transition = 'opacity 0.4s ease';
                overlay.style.opacity = '0';
                window.setTimeout(finish, 400);

                return;
            }

            gsap.timeline({ onComplete: finish })
                .to('.envelope-hint, .envelope-caption', { opacity: 0, duration: 0.25 })
                .to('.envelope-seal', { scale: 1.3, opacity: 0, duration: 0.4, ease: 'back.in(2)' }, '<')
                .to('.envelope-flap', { rotateX: -180, duration: 0.8, ease: 'power2.inOut' }, '-=0.1')
                .set('.envelope-flap', { zIndex: 1 })
                .to('.envelope-flowers', { opacity: 0, y: 30, duration: 0.5 }, '<')
                .to('.envelope-card', { yPercent: -60, duration: 0.9, ease: 'power3.out' })
                .to('.envelope-card', { scale: 1.6, duration: 0.6, ease: 'power2.in' })
                .to('.envelope-back, .envelope-front, .envelope-flap', { y: 120, opacity: 0, duration: 0.6, ease: 'power2.in' }, '<')
                .to(overlay, { opacity: 0, duration: 0.5 }, '-=0.3');
        }, { once: true });
    }

    function initMusicToggle() {
        const toggle = document.getElementById('music-toggle');
        const audio = document.getElementById('bg-music');

        if (!toggle || !audio) {
            return;
        }

        toggle.addEventListener('click', () => {
            if (audio.paused) {
                playMusic();
            } else {
                pauseMusic();
            }
        });
    }

    function initShareButtons() {
        const whatsappButton = document.getElementById('btn-share-wa');
        const copyButton = document.getElementById('btn-copy-link');
        const copyLabel = document.getElementById('btn-copy-label');

        whatsappButton?.addEventListener('click', () => {
            const message = "Assalamu'alaikum \u{1F90D}\n\n"
                + 'Kami mengundang Anda ke acara pernikahan kami:\n\n'
                + '\u{1F49D} Dani & Desi\n'
                + '\u{1F4C5} Sabtu, 28 November 2026\n'
                + '\u{1F552} 09.00 WIB\n'
                + '\u{1F4CD} Belawan, Medan\n\n'
                + 'Lihat undangan: ' + genericUrl;

            window.open('https://wa.me/?text=' + encodeURIComponent(message), '_blank');
        });

        copyButton?.addEventListener('click', () => {
            const showFeedback = () => {
                if (copyLabel) {
                    copyLabel.textContent = 'Link disalin!';
                    window.setTimeout(() => {
                        copyLabel.textContent = 'Copy Link';
                    }, 2000);
                }
            };

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(genericUrl).then(showFeedback).catch(showFeedback);
            } else {
                showFeedback();
            }
        });
    }

    function initRsvpForm() {
        const form = document.getElementById('rsvp-form');

        if (!form) {
            return;
        }

        const errorElement = document.getElementById('rsvp-error');
        const successElement = document.getElementById('rsvp-success');
        const wall = document.getElementById('rsvp-wall');
        const submitButton = form.querySelector('button[type="submit"]');

        function showError(message) {
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }

            successElement?.classList.add('hidden');
        }

        function appendWish(rsvp) {
            document.getElementById('rsvp-empty')?.remove();

            const card = document.createElement('div');
            card.className = 'rounded-xl bg-white/70 border border-wedding-blue/20 p-4';

            const header = document.createElement('div');
            header.className = 'flex items-center justify-between gap-2';

            const name = document.createElement('p');
            name.className = 'font-heading text-sm text-wedding-deep';
            name.textContent = rsvp.name;

            const badge = document.createElement('span');
            badge.className = 'text-[10px] font-body px-2 py-0.5 rounded-full '
                + (rsvp.attendance === 'hadir' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600');
            badge.textContent = rsvp.attendance === 'hadir' ? 'Hadir' : 'Berhalangan';

            const message = document.createElement('p');
            message.className = 'font-body text-sm text-wedding-deep/70 mt-2';
            message.textContent = rsvp.message;

            const time = document.createElement('p');
            time.className = 'font-body text-[10px] text-wedding-deep/40 mt-2';
            time.textContent = rsvp.created_at || 'Baru saja';

            header.appendChild(name);
            header.appendChild(badge);
            card.appendChild(header);
            card.appendChild(message);
            card.appendChild(time);

            wall?.prepend(card);
        }

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            const formData = new FormData(form);

            const payload = {
                name: String(formData.get('name') || '').trim(),
                attendance: String(formData.get('attendance') || ''),
                guests: parseInt(formData.get('guests'), 10) || 1,
                message: String(formData.get('message') || '').trim(),
            };

            if (!payload.name || !payload.attendance || !payload.message) {
                showError('Mohon lengkapi nama, kehadiran, dan pesan Anda.');
                return;
            }

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Mengirim...';
            }

            fetch(form.action || '/rsvp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload),
            })
                .then(async (response) => {
                    const data = await response.json().catch(() => ({}));

                    if (!response.ok) {
                        const firstError = data.errors ? Object.values(data.errors)[0][0] : 'Gagal mengirim ucapan. Coba lagi.';
                        throw new Error(firstError);
                    }

                    return data;
                })
                .then((data) => {
                    errorElement?.classList.add('hidden');
                    successElement?.classList.remove('hidden');
                    appendWish(data.rsvp);
                    form.reset();
                })
                .catch((error) => {
                    showError(error.message);
                })
                .finally(() => {
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent = 'Kirim Ucapan';
                    }
                });
        });
    }

    function init() {
        initEntryOverlay();
        initMusicToggle();
        initShareButtons();
        initRsvpForm();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
