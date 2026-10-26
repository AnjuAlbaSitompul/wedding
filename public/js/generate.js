(function () {
    'use strict';

    const form = document.getElementById('generate-form');

    if (!form) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const errorElement = document.getElementById('generate-error');
    const resultBox = document.getElementById('generate-result');
    const previewElement = document.getElementById('result-preview');
    const urlElement = document.getElementById('result-url');
    const whatsappLink = document.getElementById('generate-wa');
    const copyButton = document.getElementById('generate-copy');
    const copyLabel = document.getElementById('generate-copy-label');
    const submitButton = form.querySelector('button[type="submit"]');

    function showError(message) {
        if (!errorElement) {
            return;
        }

        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    }

    function showResult(data) {
        errorElement?.classList.add('hidden');

        if (previewElement) {
            previewElement.textContent = data.preview;
        }

        if (urlElement) {
            urlElement.value = data.url;
        }

        if (whatsappLink) {
            whatsappLink.href = data.wa_link;
        }

        resultBox?.classList.remove('hidden');
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        errorElement?.classList.add('hidden');

        const formData = new FormData(form);

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Membuat link...';
        }

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData,
        })
            .then(async (response) => {
                if (response.redirected || !response.headers.get('content-type')?.includes('application/json')) {
                    throw new Error('Sesi Anda telah berakhir. Muat ulang halaman dan coba lagi.');
                }

                const data = await response.json();

                if (!response.ok) {
                    const firstError = data.errors ? Object.values(data.errors)[0][0] : 'Terjadi kesalahan. Coba lagi.';
                    throw new Error(firstError);
                }

                return data;
            })
            .then(showResult)
            .catch((error) => showError(error.message))
            .finally(() => {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Generate Link';
                }
            });
    });

    copyButton?.addEventListener('click', () => {
        const url = urlElement?.value || '';

        if (!url) {
            return;
        }

        const feedback = () => {
            if (copyLabel) {
                copyLabel.textContent = 'Link disalin!';
                window.setTimeout(() => {
                    copyLabel.textContent = 'Copy Link';
                }, 2000);
            }
        };

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(feedback).catch(feedback);
        } else {
            feedback();
        }
    });
})();
