(function () {
    'use strict';

    const weddingDate = new Date('2026-11-28T09:00:00+07:00').getTime();
    const container = document.querySelector('.countdown');

    if (!container) {
        return;
    }

    const daysElement = document.querySelector('[data-countdown-days]');
    const hoursElement = document.querySelector('[data-countdown-hours]');
    const minutesElement = document.querySelector('[data-countdown-minutes]');
    const secondsElement = document.querySelector('[data-countdown-seconds]');

    function pad(value) {
        return String(value).padStart(2, '0');
    }

    function updateCountdown() {
        const difference = weddingDate - Date.now();

        if (difference <= 0) {
            container.innerHTML = '<p class="font-elegant text-xl md:text-2xl text-wedding-deep text-center">Alhamdulillah, hari bahagia telah tiba!</p>';
            window.clearInterval(intervalId);

            return;
        }

        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((difference % (1000 * 60)) / 1000);

        if (daysElement) {
            daysElement.textContent = pad(days);
        }

        if (hoursElement) {
            hoursElement.textContent = pad(hours);
        }

        if (minutesElement) {
            minutesElement.textContent = pad(minutes);
        }

        if (secondsElement) {
            secondsElement.textContent = pad(seconds);
        }
    }

    const intervalId = window.setInterval(updateCountdown, 1000);
    updateCountdown();
})();
