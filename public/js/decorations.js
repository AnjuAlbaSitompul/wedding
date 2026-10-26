(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
        return;
    }

    const leafColors = ['#90CAF9', '#BBDEFB', '#E3F2FD', '#FFFFFF', '#E8EAF6'];

    function createCanvasScene(canvasId, options) {
        const canvas = document.getElementById(canvasId);

        if (!canvas) {
            return null;
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

        function draw() {
            context.clearRect(0, 0, width, height);

            particles.forEach((particle) => {
                options.update(particle, width, height);
                options.render(context, particle);
            });

            window.requestAnimationFrame(draw);
        }

        resize();
        window.addEventListener('resize', resize);
        draw();

        return canvas;
    }

    createCanvasScene('leaves-canvas', {
        count: 18,
        create: (width, height) => ({
            x: Math.random() * width,
            y: Math.random() * -height,
            size: 6 + Math.random() * 8,
            speedY: 0.4 + Math.random() * 0.9,
            speedX: -0.4 + Math.random() * 0.8,
            rotation: Math.random() * Math.PI * 2,
            rotationSpeed: (-0.02 + Math.random() * 0.04) || 0.01,
            sway: Math.random() * Math.PI * 2,
            color: leafColors[Math.floor(Math.random() * leafColors.length)],
            height: height,
        }),
        update: (particle, width, height) => {
            particle.sway += 0.01;
            particle.y += particle.speedY;
            particle.x += particle.speedX + Math.sin(particle.sway) * 0.4;
            particle.rotation += particle.rotationSpeed;

            if (particle.y > height + 20) {
                particle.y = -20;
                particle.x = Math.random() * width;
            }

            if (particle.x < -20) {
                particle.x = width + 20;
            }

            if (particle.x > width + 20) {
                particle.x = -20;
            }
        },
        render: (context, particle) => {
            context.save();
            context.translate(particle.x, particle.y);
            context.rotate(particle.rotation);
            context.fillStyle = particle.color;
            context.globalAlpha = 0.75;
            context.beginPath();
            context.ellipse(0, 0, particle.size / 2, particle.size, 0, 0, Math.PI * 2);
            context.fill();
            context.restore();
        },
    });

    createCanvasScene('particles-canvas', {
        count: 30,
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
