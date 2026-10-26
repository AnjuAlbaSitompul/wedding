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

        gsap.to('.gate-door-left', {
            rotationY: -80,
            transformOrigin: 'left center',
            ease: 'none',
            scrollTrigger: {
                trigger: scene,
                start: 'center center',
                end: 'bottom top',
                scrub: 1,
            },
        });

        gsap.to('.gate-door-right', {
            rotationY: 80,
            transformOrigin: 'right center',
            ease: 'none',
            scrollTrigger: {
                trigger: scene,
                start: 'center center',
                end: 'bottom top',
                scrub: 1,
            },
        });

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

        const bride = document.querySelector('.character-bride');
        const groom = document.querySelector('.character-groom');

        if (bride) {
            gsap.fromTo(
                bride,
                { x: '-20vw' },
                {
                    x: '120vw',
                    duration: 8,
                    repeat: -1,
                    ease: 'power1.inOut',
                    yoyo: true,
                }
            );
        }

        if (groom) {
            gsap.fromTo(
                groom,
                { x: '-25vw' },
                {
                    x: '115vw',
                    duration: 8,
                    delay: 0.5,
                    repeat: -1,
                    ease: 'power1.inOut',
                    yoyo: true,
                }
            );
        }

        gsap.utils.toArray('.petal').forEach((petal, index) => {
            gsap.to(petal, {
                y: '+=100',
                rotation: '+=360',
                opacity: 0,
                duration: 3 + Math.random() * 2,
                delay: index * 0.3,
                repeat: -1,
                ease: 'power1.in',
            });
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

        window.addEventListener('load', () => ScrollTrigger.refresh());
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
