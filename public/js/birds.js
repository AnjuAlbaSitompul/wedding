(function () {
    'use strict';

    if (!window.gsap || !window.ScrollTrigger || !window.MotionPathPlugin) {
        return;
    }

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    gsap.registerPlugin(ScrollTrigger, MotionPathPlugin);

    const MAX_BIRDS = 6;
    let activeBirds = 0;

    /*
     * Paths are in % of the section box (x: 0 = left edge, y: 0 = top edge) and converted to px at fly time.
     * The sprite faces left; birds heading right are mirrored automatically.
     */
    const moments = [
        { section: '#scene-forest', count: 4, path: [[-10, 62], [25, 42], [65, 28], [112, 8]], duration: 7, size: [40, 64], onOpen: true },
        { section: '#scene-gate', count: 2, path: [[50, 55], [44, 36], [28, -10]], duration: 3.5, size: [48, 72], scale: [0.4, 1.4], opacity: [1, 0] },
        { section: '#scene-couple-intro', pair: true, duration: 5, size: [44, 60] },
        { section: '#scene-akad', count: 1, path: [[110, 22], [60, 14], [-12, 20]], duration: 11, size: [36, 48], opacity: [0.6, 0.6] },
        { section: '#scene-resepsi', count: 1, path: [[-12, 18], [45, 10], [112, 16]], duration: 11, size: [36, 48], opacity: [0.6, 0.6] },
        { section: '#scene-closing', count: 5, path: [[30, 75], [42, 45], [55, 20], [62, -5]], duration: 6, size: [40, 64], scale: [1, 0.3], opacity: [1, 0.2] },
    ];

    function createBird(section, size) {
        const flyer = document.createElement('div');
        flyer.className = 'bird-flyer';
        flyer.setAttribute('aria-hidden', 'true');
        flyer.style.width = gsap.utils.random(size[0], size[1]) + 'px';
        flyer.style.zIndex = '25';

        const sprite = document.createElement('span');
        sprite.className = 'sprite-bird';
        sprite.style.animationDuration = gsap.utils.random(0.5, 0.8) + 's';
        sprite.style.animationDelay = -gsap.utils.random(0, 0.6) + 's';
        flyer.appendChild(sprite);

        section.appendChild(flyer);
        activeBirds++;

        return flyer;
    }

    function release(bird) {
        bird.remove();
        activeBirds--;
    }

    function toPx(points, width, height, jitter) {
        return points.map(([x, y]) => ({
            x: (x + gsap.utils.random(-jitter, jitter)) / 100 * width,
            y: (y + gsap.utils.random(-jitter, jitter)) / 100 * height,
        }));
    }

    function face(bird, path) {
        // Sprite looks left: mirror when the overall movement goes right.
        const sprite = bird.firstChild;
        sprite.style.transform = path[path.length - 1].x > path[0].x ? 'scaleX(-1)' : '';
    }

    function fly(moment, attempt = 0) {
        const section = document.querySelector(moment.section);

        if (!section) {
            return;
        }

        // Respect the on-screen cap by waiting (up to ~5 s) instead of dropping the moment.
        const needed = moment.pair ? 2 : moment.count;
        if (activeBirds + needed > MAX_BIRDS && attempt < 6) {
            gsap.delayedCall(0.8, () => fly(moment, attempt + 1));

            return;
        }

        if (moment.pair) {
            flyPair(section, moment);

            return;
        }

        const { width, height } = section.getBoundingClientRect();
        const count = Math.max(0, Math.min(moment.count, MAX_BIRDS - activeBirds));
        const [scaleFrom, scaleTo] = moment.scale || [1, 1];
        const [opacityFrom, opacityTo] = moment.opacity || [1, 1];

        for (let i = 0; i < count; i++) {
            const bird = createBird(section, moment.size);
            const path = toPx(moment.path, width, height, 6);
            face(bird, path);

            gsap.set(bird, { x: path[0].x, y: path[0].y, xPercent: -50, yPercent: -50, scale: scaleFrom, opacity: opacityFrom });
            gsap.to(bird, {
                motionPath: { path, curviness: 1.4 },
                scale: scaleTo,
                opacity: opacityTo,
                duration: moment.duration + gsap.utils.random(-0.8, 0.8),
                delay: i * gsap.utils.random(0.15, 0.4),
                ease: 'sine.inOut',
                onComplete: () => release(bird),
            });
        }
    }

    /** Two birds come in from opposite sides, meet above the title, then leave upward together. */
    function flyPair(section, moment) {
        const { width, height } = section.getBoundingClientRect();
        const meet = { x: width * 0.5, y: height * 0.14 };

        [-1, 1].forEach((side) => {
            const bird = createBird(section, moment.size);
            const start = { x: width * (side < 0 ? -0.1 : 1.1), y: height * 0.35 };
            const near = { x: meet.x + side * 28, y: meet.y };
            const exit = { x: meet.x + side * 60 + width * 0.15, y: -height * 0.15 };
            face(bird, [start, near]);

            gsap.set(bird, { x: start.x, y: start.y, xPercent: -50, yPercent: -50 });
            gsap.timeline({ onComplete: () => release(bird) })
                .to(bird, { motionPath: { path: [start, { x: (start.x + near.x) / 2, y: height * 0.2 }, near], curviness: 1.2 }, duration: moment.duration * 0.55, ease: 'sine.out' })
                .add(() => face(bird, [near, exit]))
                .to(bird, { motionPath: { path: [near, { x: (near.x + exit.x) / 2, y: meet.y - height * 0.08 }, exit], curviness: 1.2 }, duration: moment.duration * 0.45, ease: 'sine.in' });
        });
    }

    moments.forEach((moment) => {
        if (moment.onOpen) {
            // The forest is already visible behind the envelope: wait until it opens.
            if (window.invitationOpened || !document.getElementById('entry-overlay')) {
                fly(moment);
            } else {
                window.addEventListener('invitation:opened', () => gsap.delayedCall(0.4, () => fly(moment)), { once: true });
            }

            return;
        }

        ScrollTrigger.create({ trigger: moment.section, start: 'top 60%', once: true, onEnter: () => fly(moment) });
    });

    /* Ambient: a small, faint bird crosses the viewport every 15–30 s so the page never feels static. */
    const ambientLayer = document.createElement('div');
    ambientLayer.className = 'fixed inset-0 z-[24] pointer-events-none overflow-hidden';
    ambientLayer.setAttribute('aria-hidden', 'true');
    document.body.appendChild(ambientLayer);

    function ambient() {
        if (!document.hidden && activeBirds < MAX_BIRDS && !document.getElementById('entry-overlay')) {
            const width = window.innerWidth;
            const height = window.innerHeight;
            const leftToRight = Math.random() < 0.5;
            const y = gsap.utils.random(0.08, 0.3) * height;
            const path = [
                { x: leftToRight ? -40 : width + 40, y },
                { x: width / 2, y: y - gsap.utils.random(20, 60) },
                { x: leftToRight ? width + 40 : -40, y: y + gsap.utils.random(-30, 30) },
            ];
            const bird = createBird(ambientLayer, [28, 36]);
            face(bird, path);
            gsap.set(bird, { x: path[0].x, y: path[0].y, xPercent: -50, yPercent: -50, opacity: 0.4 });
            gsap.to(bird, { motionPath: { path, curviness: 1.3 }, duration: gsap.utils.random(12, 16), ease: 'none', onComplete: () => release(bird) });
        }

        gsap.delayedCall(gsap.utils.random(15, 30), ambient);
    }

    gsap.delayedCall(gsap.utils.random(15, 30), ambient);
})();
