<section id="scene-gallery" class="wedding-section">
    <div class="text-center mb-8">
        <h3 class="font-heading text-3xl md:text-4xl text-wedding-deep reveal">Our Moments</h3>
        <div class="wedding-divider"><i class="fa-solid fa-camera"></i></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4 max-w-3xl w-full">
        @for ($i = 1; $i <= 6; $i++)
            <div class="aspect-square rounded-xl overflow-hidden bg-white/70 border border-white/60 shadow-md reveal group">
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#E3F2FD] to-[#90CAF9] transition-transform duration-500 group-hover:scale-110">
                    <i class="fa-regular fa-image text-4xl text-white/80"></i>
                </div>
            </div>
        @endfor
    </div>

    <p class="font-body text-xs text-wedding-deep/50 mt-6 reveal">Foto galeri akan segera hadir</p>
</section>
