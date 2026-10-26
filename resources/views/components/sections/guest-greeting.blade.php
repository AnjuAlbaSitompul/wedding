@props(['guestName'])

<section id="scene-greeting" class="wedding-section" data-nav="Kepada">
    <div class="greeting wedding-card relative w-full max-w-2xl text-center">
        <img src="{{ asset('images/floral/sprig-soft.webp') }}" alt="" aria-hidden="true" loading="lazy" decoding="async"
             class="card-sprig">

        <p class="eyebrow reveal">Kepada Yth.</p>
        <p class="mt-3 font-heading text-xs uppercase tracking-[0.3em] text-wedding-deep/55 reveal md:text-sm">Bapak / Ibu / Saudara/i</p>

        <p class="guest-name mt-5 font-script text-[2.5rem] leading-tight text-wedding-ink glow-text break-words md:text-6xl">{{ $guestName }}</p>

        <x-ui.section-divider />

        <p class="font-elegant text-base text-wedding-deep/65 reveal md:text-lg">
            Mohon maaf apabila ada kesalahan dalam penulisan nama / gelar
        </p>
    </div>
</section>
