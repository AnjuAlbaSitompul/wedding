(function () {
    'use strict';

    if (typeof window.gsap === 'undefined' || typeof window.ScrollTrigger === 'undefined') {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    gsap.registerPlugin(ScrollTrigger);

    if (typeof window.Lenis !== 'undefined' && !prefersReducedMotion) {
        const lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        });

        lenis.on('scroll', ScrollTrigger.update);
        gsap.ticker.add((time) => lenis.raf(time * 1000));
        gsap.ticker.lagSmoothing(0);
        window.weddingLenis = lenis;
    }

    function initParallax() {
        gsap.utils.toArray('[data-parallax]').forEach((layer) => {
            const speed = parseFloat(layer.dataset.parallax) || 0;
            const scene = layer.closest('section');

            if (!scene) {
                return;
            }

            gsap.to(layer, {
                yPercent: speed * 50,
                ease: 'none',
                scrollTrigger: {
                    trigger: scene,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 1,
                },
            });
        });

        const forest = document.getElementById('scene-forest');

        if (forest) {
            gsap.to('.forest-foreground-left', {
                xPercent: -100,
                ease: 'none',
                scrollTrigger: {
                    trigger: forest,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 1,
                },
            });

            gsap.to('.forest-foreground-right', {
                xPercent: 100,
                ease: 'none',
                scrollTrigger: {
                    trigger: forest,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 1,
                },
            });
        }
    }

    function initGate() {
        const gate = document.getElementById('gate');
        const scene = document.getElementById('scene-gate');

        if (!gate || !scene) {
            return;
        }

        gsap.fromTo(
            gate,
            { scale: 0.3, opacity: 0.5 },
            {
                scale: 1.5,
                opacity: 1,
                ease: 'none',
                scrollTrigger: {
                    trigger: scene,
                    start: 'top bottom',
                    end: 'center center',
                    scrub: 1,
                },
            }
        );

        // Floral "curtain" parts to the sides as the gate comes into view.
        const curtain = { ease: 'none', scrollTrigger: { trigger: scene, start: 'top 60%', end: 'center center', scrub: 1 } };
        gsap.to('.gate-curtain-left', { xPercent: -70, opacity: 0.4, ...curtain });
        gsap.to('.gate-curtain-right', { xPercent: 70, opacity: 0.4, ...curtain });

        gsap.fromTo(
            '.gate-light',
            { opacity: 0 },
            {
                opacity: 1,
                ease: 'none',
                scrollTrigger: {
                    trigger: scene,
                    start: 'center center',
                    end: 'bottom top',
                    scrub: 1,
                },
            }
        );
    }

    function initCharacters() {
        if (prefersReducedMotion) {
            return;
        }

        const couple = document.querySelector('.couple-illustration');

        if (couple) {
            gsap.from(couple, {
                opacity: 0,
                y: 40,
                duration: 1.2,
                ease: 'power3.out',
                scrollTrigger: { trigger: couple, start: 'top 85%' },
                onComplete: () => gsap.to(couple, { scale: 1.02, duration: 4, yoyo: true, repeat: -1, ease: 'sine.inOut' }),
            });
        }

        gsap.to('.forest-mist', { x: '+=40', duration: 12, yoyo: true, repeat: -1, ease: 'sine.inOut' });
    }

    /**
     * Wraps every character of `element` in a span so it can be revealed one by one.
     * Words stay unbreakable (long names wrap between words) and screen readers get the plain text.
     */
    function splitChars(element) {
        const text = element.textContent.trim();
        const chars = [];
        const visual = document.createElement('span');
        visual.setAttribute('aria-hidden', 'true');

        text.split(/(\s+)/).forEach((part) => {
            if (/^\s+$/.test(part)) {
                visual.appendChild(document.createTextNode(' '));

                return;
            }

            const word = document.createElement('span');
            word.style.display = 'inline-block';
            word.style.whiteSpace = 'nowrap';
            Array.from(part).forEach((char) => {
                const span = document.createElement('span');
                span.textContent = char;
                span.style.display = 'inline-block';
                word.appendChild(span);
                chars.push(span);
            });
            visual.appendChild(word);
        });

        const readable = document.createElement('span');
        readable.className = 'sr-only';
        readable.textContent = text;

        element.replaceChildren(readable, visual);

        return chars;
    }

    function initMicroMotion() {
        if (prefersReducedMotion) {
            return;
        }

        const once = (trigger, start = 'top 80%') => ({ trigger, start, once: true });

        const bismillah = document.querySelector('.bismillah-text');
        if (bismillah) {
            gsap.fromTo(bismillah,
                { clipPath: 'inset(0 50% 0 50%)', textShadow: '0 0 0 rgba(201,162,39,0)' },
                { clipPath: 'inset(0 0% 0 0%)', textShadow: '0 0 14px rgba(201,162,39,0.45)', duration: 1.2, ease: 'power2.out', scrollTrigger: once(bismillah) });
        }

        const guestName = document.querySelector('.guest-name');
        if (guestName) {
            gsap.from(splitChars(guestName), {
                opacity: 0, y: 12, duration: 0.4, stagger: { amount: 1 }, ease: 'power2.out', scrollTrigger: once(guestName),
            });
        }

        [['#scene-groom', -80], ['#scene-bride', 80]].forEach(([id, x]) => {
            const card = document.querySelector(id + ' .person-card');
            if (!card) {
                return;
            }
            gsap.from(card, { x, opacity: 0, duration: 1.1, ease: 'power3.out', scrollTrigger: once(card) });
            gsap.from(card.querySelector('.person-ornament'), { rotation: -45, scale: 0.4, opacity: 0, duration: 1.2, delay: 0.3, ease: 'power2.out', scrollTrigger: once(card) });
        });

        gsap.utils.toArray('.event-icon').forEach((icon) => {
            gsap.to(icon, { keyframes: { rotation: [0, -12, 10, -6, 0] }, duration: 0.9, delay: 0.4, ease: 'power1.inOut', scrollTrigger: once(icon) });
        });

        const gallery = document.querySelector('.gallery-grid');
        if (gallery) {
            gsap.from(gallery.children, { scale: 0.9, opacity: 0, duration: 0.8, stagger: 0.12, ease: 'power2.out', scrollTrigger: once(gallery) });
        }

        const closingFlora = document.querySelectorAll('.closing-flora img');
        if (closingFlora.length) {
            gsap.from(closingFlora, { scaleY: 0, transformOrigin: 'bottom', duration: 1.2, stagger: 0.2, ease: 'power3.out', scrollTrigger: once('#scene-closing', 'top 70%') });
        }

        gsap.utils.toArray('.floral-sway').forEach((corner) => {
            gsap.fromTo(corner, { rotation: -2 }, { rotation: 2, duration: gsap.utils.random(4, 6), yoyo: true, repeat: -1, ease: 'sine.inOut' });
        });
    }

    function initReveal() {
        if (prefersReducedMotion) {
            return;
        }

        gsap.utils.toArray('.reveal').forEach((element) => {
            gsap.from(element, {
                y: 60,
                opacity: 0,
                duration: 1.2,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: element,
                    start: 'top 85%',
                    toggleActions: 'play none none reverse',
                },
            });
        });

        gsap.utils.toArray('.stagger-children').forEach((container) => {
            gsap.from(container.children, {
                y: 40,
                opacity: 0,
                duration: 0.8,
                stagger: 0.15,
                scrollTrigger: {
                    trigger: container,
                    start: 'top 85%',
                },
            });
        });
    }

    function init() {
        initParallax();
        initGate();
        initCharacters();
        initReveal();
        initMicroMotion();

        window.addEventListener('load', () => ScrollTrigger.refresh());

        // Lazy images change section heights when they arrive; keep trigger positions in sync.
        const refreshSoon = gsap.delayedCall(0.3, () => ScrollTrigger.refresh()).pause();
        document.querySelectorAll('img[loading="lazy"]').forEach((img) => {
            if (!img.complete) {
                img.addEventListener('load', () => refreshSoon.restart(true), { once: true });
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
