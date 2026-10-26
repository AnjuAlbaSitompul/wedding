(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReducedMotion || !window.lottie || !window.gsap) return;

    gsap.registerPlugin(ScrollTrigger);

    // Bird configurations per section
    const birdConfigs = [
        {
            id: 'bird-gate',
            section: '#scene-gate',
            animation: '/lottie/bird-pair.json',
            trigger: 'center center',
            position: { x: '50%', y: '40%' },
            scale: 1.2,
            behavior: 'fly-out'
        },
        {
            id: 'bird-forest',
            section: '#scene-forest',
            animation: '/lottie/bird-flying.json',
            trigger: 'top 80%',
            position: { x: '20%', y: '30%' },
            scale: 0.8,
            behavior: 'ambient'
        },
        {
            id: 'bird-couple',
            section: '#scene-couple',
            animation: '/lottie/bird-pair.json',
            trigger: 'top 70%',
            position: { x: '50%', y: '50%' },
            scale: 1,
            behavior: 'romantic-pair'
        }
    ];

    class BirdController {
        constructor() {
            this.birds = new Map();
            this.init();
        }

        init() {
            birdConfigs.forEach(config => this.createBird(config));
        }

        createBird(config) {
            const container = document.createElement('div');
            container.id = config.id;
            container.className = 'bird-lottie-container pointer-events-none';
            container.style.cssText = `
                position: absolute;
                left: ${config.position.x};
                top: ${config.position.y};
                transform: translate(-50%, -50%) scale(${config.scale});
                z-index: 25;
                width: 200px;
                height: 200px;
            `;

            const section = document.querySelector(config.section);
            if (!section) return;

            section.appendChild(container);

            // Load Lottie
            const anim = lottie.loadAnimation({
                container,
                renderer: 'svg',
                loop: config.behavior === 'ambient',
                autoplay: false,
                path: config.animation
            });

            this.birds.set(config.id, { config, container, anim, played: false });
            this.setupTrigger(config);
        }

        setupTrigger(config) {
            const bird = this.birds.get(config.id);
            if (!bird) return;

            ScrollTrigger.create({
                trigger: config.section,
                start: config.trigger,
                onEnter: () => this.triggerBird(config.id, 'enter'),
                onLeaveBack: () => this.triggerBird(config.id, 'leave'),
                once: config.behavior !== 'ambient'
            });
        }

        triggerBird(id, direction) {
            const bird = this.birds.get(id);
            if (!bird) return;

            const { anim, config, played } = bird;

            if (direction === 'enter' && !played) {
                switch (config.behavior) {
                    case 'fly-out':
                        this.animateFlyOut(bird);
                        break;
                    case 'romantic-pair':
                        this.animateRomanticPair(bird);
                        break;
                    case 'ambient':
                        anim.play();
                        break;
                }
                bird.played = true;
            }
        }

        animateFlyOut(bird) {
            const { anim, container, config } = bird;

            // Play takeoff animation first, then fly out
            anim.goToAndPlay(0, true);

            gsap.fromTo(container,
                { xPercent: -50, yPercent: -50, scale: config.scale, opacity: 1 },
                {
                    xPercent: -50,
                    yPercent: -150,
                    scale: config.scale * 0.5,
                    opacity: 0,
                    duration: 2.5,
                    ease: 'power2.out',
                    delay: 0.5,
                    onComplete: () => {
                        container.style.display = 'none';
                    }
                }
            );
        }

        animateRomanticPair(bird) {
            const { anim, container, config } = bird;

            anim.goToAndPlay(0, true);

            // Subtle circular motion
            gsap.to(container, {
                xPercent: -50,
                yPercent: -50,
                rotation: 360,
                duration: 8,
                ease: 'none',
                repeat: -1,
                transformOrigin: 'center center'
            });
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => new BirdController());
    } else {
        new BirdController();
    }
})();