(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        return;
    }

    const isSmallScreen = window.innerWidth < 768;
    const scenes = [];

    function createCanvasScene(canvasId, options) {
        const canvas = document.getElementById(canvasId);

        if (!canvas) {
            return;
        }

        const context = canvas.getContext('2d');
        let width = 0;
        let height = 0;
        let particles = [];

        function resize() {
            const ratio = Math.min(window.devicePixelRatio || 1, 2);
            width = window.innerWidth;
            height = window.innerHeight;
            canvas.width = width * ratio;
            canvas.height = height * ratio;
            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
            context.setTransform(ratio, 0, 0, ratio, 0, 0);
            particles = Array.from({ length: options.count }, () => options.create(width, height));
        }

        resize();
        window.addEventListener('resize', resize);

        scenes.push(() => {
            context.clearRect(0, 0, width, height);
            particles.forEach((particle) => {
                options.update(particle, width, height);
                options.render(context, particle);
            });
        });
    }

    // One shared loop, paused while the tab is hidden (saves battery on phones).
    let frameId = null;

    function loop() {
        scenes.forEach((draw) => draw());
        frameId = window.requestAnimationFrame(loop);
    }

    function start() {
        if (frameId === null && !document.hidden) {
            frameId = window.requestAnimationFrame(loop);
        }
    }

    document.addEventListener('visibilitychange', () => {
        if (document.hidden && frameId !== null) {
            window.cancelAnimationFrame(frameId);
            frameId = null;
        } else {
            start();
        }
    });

    function loadImages(sources) {
        return Promise.all(sources.map((src) => new Promise((resolve) => {
            const image = new Image();
            image.onload = () => resolve(image);
            image.onerror = () => resolve(null);
            image.src = src;
        }))).then((images) => images.filter(Boolean));
    }

    loadImages([1, 2, 3, 4].map((n) => '/images/leaves/leaf-' + n + '.webp')).then((leaves) => {
        if (leaves.length) {
            createCanvasScene('leaves-canvas', {
                count: isSmallScreen ? 12 : 18,
                create: (width, height) => ({
                    x: Math.random() * width,
                    y: Math.random() * -height,
                    size: 14 + Math.random() * 14,
                    speedY: 0.4 + Math.random() * 0.8,
                    speedX: -0.4 + Math.random() * 0.8,
                    rotation: Math.random() * Math.PI * 2,
                    rotationSpeed: (-0.02 + Math.random() * 0.04) || 0.01,
                    sway: Math.random() * Math.PI * 2,
                    image: leaves[Math.floor(Math.random() * leaves.length)],
                }),
                update: (particle, width, height) => {
                    particle.sway += 0.01;
                    particle.y += particle.speedY;
                    particle.x += particle.speedX + Math.sin(particle.sway) * 0.4;
                    particle.rotation += particle.rotationSpeed;

                    if (particle.y > height + 30) {
                        particle.y = -30;
                        particle.x = Math.random() * width;
                    }

                    if (particle.x < -30) {
                        particle.x = width + 30;
                    }

                    if (particle.x > width + 30) {
                        particle.x = -30;
                    }
                },
                render: (context, particle) => {
                    const image = particle.image;
                    const h = particle.size;
                    const w = h * (image.width / image.height);

                    context.save();
                    context.translate(particle.x, particle.y);
                    context.rotate(particle.rotation);
                    context.globalAlpha = 0.8;
                    context.drawImage(image, -w / 2, -h / 2, w, h);
                    context.restore();
                },
            });
        }

        start();
    });

    createCanvasScene('particles-canvas', {
        count: isSmallScreen ? 18 : 30,
        create: (width, height) => ({
            x: Math.random() * width,
            y: Math.random() * height,
            size: 1 + Math.random() * 2.5,
            speedX: -0.2 + Math.random() * 0.4,
            speedY: -0.4 + Math.random() * 0.2,
            alpha: 0.2 + Math.random() * 0.6,
            alphaSpeed: 0.005 + Math.random() * 0.015,
            phase: Math.random() * Math.PI * 2,
        }),
        update: (particle, width, height) => {
            particle.phase += particle.alphaSpeed;
            particle.x += particle.speedX;
            particle.y += particle.speedY;

            if (particle.y < -10) {
                particle.y = height + 10;
                particle.x = Math.random() * width;
            }

            if (particle.x < -10) {
                particle.x = width + 10;
            }

            if (particle.x > width + 10) {
                particle.x = -10;
            }
        },
        render: (context, particle) => {
            context.save();
            context.globalAlpha = particle.alpha * (0.6 + 0.4 * Math.sin(particle.phase));
            context.fillStyle = '#FFFFFF';
            context.beginPath();
            context.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            context.fill();
            context.restore();
        },
    });
})();
