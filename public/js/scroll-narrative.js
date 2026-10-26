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

    function scrollToSection(section) {
        if (window.weddingLenis) {
            window.weddingLenis.scrollTo(section, { offset: 0, duration: 1.4 });

            return;
        }

        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    /**
     * Scroll journey: walk through the mountain forest, reach the floral gate,
     * pass through it and arrive at the couple.
     * The stage is sticky, so the whole sequence is scrubbed by scroll progress.
     */
    function initJourney() {
        const journey = document.getElementById('scene-journey');

        if (!journey) {
            return;
        }

        if (prefersReducedMotion) {
            return;
        }

        journey.classList.add('is-animated');

        const stage = journey.querySelector('.journey-stage');
        const gate = journey.querySelector('.journey-gate');
        const glow = journey.querySelector('.journey-gate-glow');
        const flash = journey.querySelector('.journey-flash');
        const couple = journey.querySelector('.journey-couple');

        if (!stage || !gate || !couple) {
            journey.classList.remove('is-animated');

            return;
        }

        gsap.set(gate, { autoAlpha: 0, scale: 0.42, yPercent: 18 });
        gsap.set(couple, { autoAlpha: 0 });

        const timeline = gsap.timeline({
            defaults: { ease: 'none' },
            scrollTrigger: {
                trigger: journey,
                start: 'top top',
                end: 'bottom bottom',
                scrub: 0.55,
                invalidateOnRefresh: true,
            },
        });

        timeline
            // 1. Title dissolves while the camera pushes into the forest.
            .to('.journey-title', { autoAlpha: 0, y: -70, filter: 'blur(8px)', duration: 1 }, 0)
            .to('.journey-sun', { scale: 1.25, opacity: 0.85, duration: 2.6 }, 0)
            .to('.journey-mountains-far', { yPercent: -8, scale: 1.06, duration: 2.6 }, 0)
            .to('.journey-mountains-near', { yPercent: -16, scale: 1.1, duration: 2.6 }, 0)
            .to('.journey-trees-far', { scale: 1.2, yPercent: -5, duration: 2.6 }, 0)
            .to('.journey-mist', { opacity: 0.22, scale: 1.18, duration: 2.4 }, 0)
            .to('.journey-fg-left', { xPercent: -46, yPercent: 8, duration: 2.6 }, 0)
            .to('.journey-fg-right', { xPercent: 46, yPercent: 8, duration: 2.6 }, 0)

            // 2. The gate appears through the haze and comes closer.
            .to(gate, { autoAlpha: 1, scale: 1, yPercent: 0, duration: 1.6, ease: 'power1.out' }, 0.45)
            .to('.journey-trees-mid', { scale: 1.12, yPercent: 4, duration: 2.2 }, 0.3)

            // 3. The gate leans closer and floods the scene with light.
            .to(gate, { scale: 1.34, yPercent: 4, duration: 1.3, ease: 'power1.inOut' }, 1.9)
            .to(glow, { opacity: 0.55, duration: 1.1 }, 2.05)
            .to('.journey-trees-mid', { scale: 1.22, yPercent: 12, duration: 1.4, ease: 'power1.inOut' }, 1.9)
            .to('.journey-flash', { opacity: 0.92, duration: 0.5 }, 2.9)

            // 4. Light clears and the couple is revealed.
            .set(stage, { backgroundColor: '#EEF6FF' }, 3.45)
            .to(gate, { autoAlpha: 0, duration: 0.7, ease: 'power1.in' }, 2.85)
            .to(
                ['.journey-trees-mid', '.journey-trees-far', '.journey-mountains', '.journey-fg-left', '.journey-fg-right', '.journey-mist', '.journey-sun'],
                { opacity: 0, duration: 0.6 },
                3.4
            )
            .to(glow, { opacity: 0, duration: 0.4 }, 3.15)
            .to(flash, { opacity: 0, duration: 0.42 }, 3.42)
            .fromTo(couple, { autoAlpha: 0, y: 44 }, { autoAlpha: 1, y: 0, duration: 0.9, ease: 'power2.out' }, 3.34)
            .to(couple, { y: -18, duration: 1.2 }, 4.7);
    }

    function initReveal() {
        if (prefersReducedMotion) {
            return;
        }

        gsap.utils.toArray('.reveal').forEach((element) => {
            gsap.from(element, {
                y: 50,
                opacity: 0,
                duration: 1.1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: element,
                    start: 'top 88%',
                    toggleActions: 'play none none none',
                },
            });
        });

        gsap.utils.toArray('.stagger-children').forEach((container) => {
            gsap.from(container.children, {
                y: 34,
                opacity: 0,
                duration: 0.8,
                stagger: 0.12,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: container,
                    start: 'top 88%',
                },
            });
        });
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

        const once = (trigger, start = 'top 85%') => ({ trigger, start, once: true });

        const bismillah = document.querySelector('.bismillah-text');
        if (bismillah) {
            gsap.fromTo(bismillah,
                { clipPath: 'inset(0 50% 0 50%)', textShadow: '0 0 0 rgba(201,162,39,0)' },
                { clipPath: 'inset(0 0% 0 0%)', textShadow: '0 0 18px rgba(201,162,39,0.4)', duration: 1.3, ease: 'power2.out', scrollTrigger: once(bismillah) });
        }

        const guestName = document.querySelector('.guest-name');
        if (guestName) {
            gsap.from(splitChars(guestName), {
                opacity: 0, y: 12, duration: 0.4, stagger: { amount: 1 }, ease: 'power2.out', scrollTrigger: once(guestName),
            });
        }

        [['#scene-groom', -70], ['#scene-bride', 70]].forEach(([id, x]) => {
            const card = document.querySelector(id + ' .person-card');
            if (!card) {
                return;
            }
            gsap.from(card, { x, opacity: 0, duration: 1.1, ease: 'power3.out', scrollTrigger: once(card) });
            gsap.from(card.querySelector('.person-ornament'), { rotation: -30, scale: 0.5, opacity: 0, duration: 1.2, delay: 0.3, ease: 'power2.out', scrollTrigger: once(card) });
        });

        gsap.utils.toArray('.event-icon').forEach((icon) => {
            gsap.to(icon, { keyframes: { rotation: [0, -10, 8, -5, 0] }, duration: 0.9, delay: 0.4, ease: 'power1.inOut', scrollTrigger: once(icon) });
        });

        const gallery = document.querySelector('.gallery-grid');
        if (gallery) {
            gsap.from(gallery.children, { scale: 0.9, opacity: 0, duration: 0.8, stagger: 0.1, ease: 'power2.out', scrollTrigger: once(gallery) });
        }

        const closingFlora = document.querySelectorAll('.closing-flora img');
        if (closingFlora.length) {
            gsap.from(closingFlora, { scaleY: 0, transformOrigin: 'bottom', duration: 1.2, stagger: 0.2, ease: 'power3.out', scrollTrigger: once('#scene-closing', 'top 70%') });
        }

        gsap.utils.toArray('.floral-sway').forEach((corner) => {
            gsap.fromTo(corner, { rotation: -1.5 }, { rotation: 1.5, duration: gsap.utils.random(5, 7), yoyo: true, repeat: -1, ease: 'sine.inOut' });
        });
    }

    /** Thin reading-progress bar at the very top of the page. */
    function initScrollProgress() {
        const bar = document.getElementById('scroll-progress-bar');

        if (!bar) {
            return;
        }

        const update = () => {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            const ratio = max > 0 ? Math.min(1, Math.max(0, window.scrollY / max)) : 0;
            bar.style.transform = 'scaleX(' + ratio + ')';
        };

        update();
        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
    }

    /** Side dot navigation built from `main section[data-nav]`. */
    function initSectionNav() {
        const nav = document.getElementById('section-nav');

        if (!nav) {
            return;
        }

        const sections = Array.from(document.querySelectorAll('main section[data-nav]'));

        if (!sections.length) {
            return;
        }

        const dots = sections.map((section) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'section-nav-dot';
            dot.setAttribute('aria-label', 'Ke bagian ' + section.dataset.nav);
            dot.dataset.label = section.dataset.nav;
            dot.addEventListener('click', () => scrollToSection(section));
            nav.appendChild(dot);

            return dot;
        });

        sections.forEach((section, index) => {
            ScrollTrigger.create({
                trigger: section,
                start: 'top center',
                end: 'bottom center',
                onToggle: (self) => dots[index].classList.toggle('is-active', self.isActive),
            });
        });
    }

    function init() {
        initJourney();
        initReveal();
        initMicroMotion();
        initScrollProgress();
        initSectionNav();

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
