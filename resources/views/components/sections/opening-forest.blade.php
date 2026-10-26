<svg width="0" height="0" class="absolute" aria-hidden="true">
    <defs>
        <g id="forest-pine" fill="currentColor">
            <path d="M0 0 L26 44 L-26 44 Z"/>
            <path d="M0 22 L34 78 L-34 78 Z"/>
            <path d="M0 50 L44 140 L-44 140 Z"/>
            <rect x="-6" y="140" width="12" height="16"/>
        </g>
    </defs>
</svg>

<section id="scene-forest" class="wedding-section relative overflow-hidden">
    <!-- Lapisan background: langit + cahaya bulan (parallax lambat) -->
    <div class="absolute inset-0 z-0" data-parallax="0.2">
        <div class="w-full h-full bg-gradient-to-b from-[#E3F2FD] via-[#BBDEFB] to-[#90CAF9]"></div>

        <!-- Cahaya bulan -->
        <div class="absolute top-[8%] right-[14%] w-20 h-20 md:w-28 md:h-28 rounded-full bg-white/90 shadow-[0_0_80px_40px_rgba(255,255,255,0.55)]"></div>
        <div class="absolute top-[6%] right-[10%] w-52 h-52 md:w-72 md:h-72 rounded-full bg-white/25 blur-2xl"></div>

        <!-- Kabut tipis di kaki langit -->
        <div class="absolute bottom-0 inset-x-0 h-1/3 bg-gradient-to-t from-white/55 to-transparent"></div>
    </div>

    <!-- Lapisan mid: watermark nama + kabut mengambang -->
    <div class="absolute inset-0 z-10 opacity-60" data-parallax="0.5">
        <div class="w-full h-full flex items-center justify-center">
            <p class="font-script text-6xl md:text-8xl text-wedding-deep/40 select-none">Dani &amp; Desi</p>
        </div>
        <div class="absolute bottom-[18%] -left-[10%] w-[80%] h-24 bg-white/40 blur-xl rounded-full"></div>
        <div class="absolute bottom-[26%] right-[-12%] w-[70%] h-20 bg-white/30 blur-xl rounded-full"></div>
    </div>

    <!-- Landscape pinus bertingkat: siluet kiri (parallax cepat) -->
    <div class="forest-foreground-left absolute left-0 bottom-0 z-20 w-1/2 h-1/2" data-parallax="0.8">
        <svg viewBox="0 0 400 300" class="w-full h-full" preserveAspectRatio="xMidYMax slice">
            <!-- Tingkat jauh -->
            <g fill="#90CAF9" opacity="0.8">
                <use href="#forest-pine" transform="translate(46 84) scale(0.5)"/>
                <use href="#forest-pine" transform="translate(126 76) scale(0.44)"/>
                <use href="#forest-pine" transform="translate(205 82) scale(0.5)"/>
                <use href="#forest-pine" transform="translate(284 74) scale(0.42)"/>
                <use href="#forest-pine" transform="translate(350 84) scale(0.48)"/>
            </g>
            <!-- Kabut tipis antar tingkat -->
            <ellipse cx="200" cy="150" rx="232" ry="28" fill="#FFFFFF" opacity="0.35"/>
            <!-- Tingkat tengah -->
            <g fill="#1565C0" opacity="0.9">
                <use href="#forest-pine" transform="translate(76 96) scale(0.92)"/>
                <use href="#forest-pine" transform="translate(196 90) scale(0.78)"/>
                <use href="#forest-pine" transform="translate(312 94) scale(0.86)"/>
            </g>
            <ellipse cx="180" cy="214" rx="240" ry="26" fill="#FFFFFF" opacity="0.3"/>
            <!-- Tingkat terdekat -->
            <g fill="#0D47A1">
                <use href="#forest-pine" transform="translate(34 36) scale(1.55)"/>
                <use href="#forest-pine" transform="translate(170 24) scale(1.2)"/>
                <use href="#forest-pine" transform="translate(308 32) scale(1.45)"/>
            </g>
            <!-- Tepi tanah yang menutupi kaki pinus -->
            <path d="M0,220 Q70,206 140,214 Q230,198 300,208 Q356,200 400,212 L400,300 L0,300 Z" fill="#0D47A1"/>
        </svg>
    </div>

    <!-- Landscape pinus bertingkat: siluet kanan (parallax cepat) -->
    <div class="forest-foreground-right absolute right-0 bottom-0 z-20 w-1/2 h-1/2" data-parallax="0.8">
        <svg viewBox="0 0 400 300" class="w-full h-full" preserveAspectRatio="xMidYMax slice">
            <g fill="#90CAF9" opacity="0.8">
                <use href="#forest-pine" transform="translate(64 82) scale(0.46)"/>
                <use href="#forest-pine" transform="translate(152 76) scale(0.5)"/>
                <use href="#forest-pine" transform="translate(240 80) scale(0.44)"/>
                <use href="#forest-pine" transform="translate(330 72) scale(0.52)"/>
            </g>
            <ellipse cx="220" cy="148" rx="232" ry="28" fill="#FFFFFF" opacity="0.35"/>
            <g fill="#1565C0" opacity="0.9">
                <use href="#forest-pine" transform="translate(108 92) scale(0.86)"/>
                <use href="#forest-pine" transform="translate(238 86) scale(0.8)"/>
                <use href="#forest-pine" transform="translate(348 90) scale(0.98)"/>
            </g>
            <ellipse cx="240" cy="212" rx="240" ry="26" fill="#FFFFFF" opacity="0.3"/>
            <g fill="#0D47A1">
                <use href="#forest-pine" transform="translate(84 30) scale(1.45)"/>
                <use href="#forest-pine" transform="translate(238 22) scale(1.2)"/>
                <use href="#forest-pine" transform="translate(372 34) scale(1.6)"/>
            </g>
            <path d="M0,224 Q80,204 160,214 Q250,198 320,208 Q364,200 400,214 L400,300 L0,300 Z" fill="#0D47A1"/>
        </svg>
    </div>

    <div class="relative z-30 text-center px-4">
        <p class="font-elegant text-lg md:text-2xl text-wedding-deep/70 mb-4 reveal">Undangan Pernikahan</p>
        <h1 class="font-script title-display title-gradient glow-text mb-6 reveal">Dani &amp; Desi</h1>
        <p class="font-heading text-sm md:text-base text-wedding-deep/60 reveal">Scroll untuk membuka undangan</p>
        <i class="fa-solid fa-chevron-down text-3xl text-wedding-blue mt-8 animate-bounce reveal"></i>
    </div>
</section>
