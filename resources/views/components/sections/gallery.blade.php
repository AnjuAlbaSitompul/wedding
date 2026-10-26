<section id="scene-gallery" class="wedding-section" data-nav="Galeri">
    <div class="mb-10 text-center">
        <p class="eyebrow reveal">Our Moments</p>
        <h3 class="section-title mt-4 font-heading text-3xl text-wedding-ink reveal md:text-4xl">Galeri</h3>
    </div>

    <div class="gallery-grid grid w-full max-w-3xl grid-cols-2 gap-3 md:grid-cols-3 md:gap-5">
        @for ($i = 1; $i <= 6; $i++)
            <figure class="gallery-tile group">
                <div class="gallery-fill">
                    <i class="fa-regular fa-image text-3xl text-white/85" aria-hidden="true"></i>
                </div>
            </figure>
        @endfor
    </div>

    <p class="mt-8 font-body text-[10px] uppercase tracking-[0.35em] text-wedding-deep/45 reveal">Foto galeri akan segera hadir</p>
</section>
