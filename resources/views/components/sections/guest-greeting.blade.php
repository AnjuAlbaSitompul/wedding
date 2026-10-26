@props(['guestName'])

<section id="scene-greeting" class="wedding-section">
    <div class="text-center max-w-2xl">
        <p class="font-elegant text-xl md:text-2xl text-wedding-deep/70 mb-2 reveal">Kepada Yth.</p>
        <p class="font-heading text-base md:text-lg text-wedding-deep/60 mb-4 reveal">Bapak/Ibu/Saudara/i</p>

        <p class="guest-name font-script text-4xl md:text-6xl text-wedding-deep glow-text break-words">{{ $guestName }}</p>

        <x-ui.section-divider />

        <p class="font-body text-sm md:text-base text-wedding-deep/70 reveal">
            Mohon maaf apabila ada kesalahan dalam penulisan nama/gelar
        </p>
    </div>
</section>
