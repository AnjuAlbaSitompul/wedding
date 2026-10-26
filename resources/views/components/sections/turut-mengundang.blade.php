<section id="scene-turut-mengundang" class="wedding-section">
    <div class="mb-8 text-center">
        <p class="eyebrow reveal">Dengan Hormat</p>
        <h3 class="section-title mt-4 font-heading text-3xl text-wedding-ink reveal md:text-4xl">Turut Mengundang</h3>
        <x-ui.section-divider />
    </div>

    <div class="wedding-card w-full max-w-md stagger-children">
        <ul class="space-y-5 text-center">
            @foreach (config('wedding.turut_mengundang', []) as $family)
                <li class="font-elegant text-lg leading-snug text-wedding-ink md:text-xl">{{ $family }}</li>
            @endforeach
        </ul>
    </div>
</section>
