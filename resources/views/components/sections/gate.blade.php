<section id="scene-gate" class="wedding-section relative overflow-hidden">
    <div class="absolute inset-0 z-0">
        <div class="w-full h-full bg-gradient-to-b from-[#BBDEFB] via-[#90CAF9] to-[#E3F2FD]"></div>
    </div>

    <div class="gate-light absolute inset-0 z-10 flex items-center justify-center opacity-0">
        <div class="w-[28rem] h-96 bg-white rounded-full blur-3xl opacity-90"></div>
        <div class="absolute w-72 h-96 bg-gradient-to-b from-white/85 via-[#BAE3FF]/45 to-transparent"></div>
    </div>

    <div id="gate" class="relative z-20" style="transform: scale(0.3); opacity: 0.5;">
        <div class="relative">
            <svg viewBox="0 0 200 300" class="w-48 md:w-64 h-auto mx-auto">
                <!-- Cahaya interior taman di balik pintu -->
                <ellipse cx="100" cy="220" rx="52" ry="90" fill="#E3F2FD" opacity="0.45"/>

                <!-- Tiang penopang kiri & kanan dengan tekstur batu -->
                <path d="M30,90 L30,300 L52,300 L52,102" stroke="#1565C0" stroke-width="2.5" fill="none" opacity="0.9"/>
                <path d="M170,90 L170,300 L148,300 L148,102" stroke="#1565C0" stroke-width="2.5" fill="none" opacity="0.9"/>
                <!-- Sambungan blok batu -->
                <g stroke="#1976D2" stroke-width="1" opacity="0.45">
                    <path d="M32,130 H50 M32,170 H50 M32,210 H50 M32,250 H50"/>
                    <path d="M150,130 H168 M150,170 H168 M150,210 H168 M150,250 H168"/>
                    <path d="M40,150 V168 M40,190 V208 M40,230 V248 M160,150 V168 M160,190 V208 M160,230 V248"/>
                </g>

                <!-- Ornamen lengkungan bertingkat -->
                <path d="M40,100 Q100,40 160,100" stroke="#1565C0" stroke-width="3.5" fill="none" opacity="0.9"/>
                <path d="M35,110 Q100,32 165,110" stroke="#1976D2" stroke-width="1.5" fill="none" opacity="0.6"/>
                <path d="M46,96 Q100,52 154,96" stroke="#90CAF9" stroke-width="1.5" fill="none" opacity="0.7"/>
                <path d="M70,72 L100,62 L130,72 L100,52 Z" fill="#1976D2" opacity="0.55"/>
                <circle cx="100" cy="42" r="5" fill="#1565C0" opacity="0.75"/>
                <circle cx="100" cy="42" r="9" stroke="#90CAF9" stroke-width="1" fill="none" opacity="0.6"/>

                <!-- Pilar ornamen atas tiang -->
                <path d="M24,90 H58 L52,80 L30,80 Z" fill="#1565C0" opacity="0.8"/>
                <path d="M142,90 H176 L170,80 L148,80 Z" fill="#1565C0" opacity="0.8"/>
                <circle cx="40" cy="76" r="4" stroke="#1976D2" stroke-width="1.5" fill="none" opacity="0.7"/>
                <circle cx="160" cy="76" r="4" stroke="#1976D2" stroke-width="1.5" fill="none" opacity="0.7"/>

                <g class="gate-door-left" style="transform-origin: 40px 100px;">
                    <path d="M40,100 L40,300" stroke="#1565C0" stroke-width="2.5" opacity="0.85"/>
                    <path d="M40,300 L52,300 L52,108" stroke="#1976D2" stroke-width="1.5" fill="none" opacity="0.6"/>
                    <path d="M40,150 L24,160 M40,200 L24,210 M40,250 L24,260" stroke="#1565C0" stroke-width="2" opacity="0.7"/>
                    <path d="M44,118 Q70,110 46,132" stroke="#90CAF9" stroke-width="1" fill="none" opacity="0.5"/>
                    <path d="M44,168 Q70,160 46,182" stroke="#90CAF9" stroke-width="1" fill="none" opacity="0.5"/>
                    <circle cx="47" cy="155" r="2.5" fill="#1565C0" opacity="0.8"/>
                    <circle cx="47" cy="205" r="2.5" fill="#1565C0" opacity="0.8"/>
                </g>

                <g class="gate-door-right" style="transform-origin: 160px 100px;">
                    <path d="M160,100 L160,300" stroke="#1565C0" stroke-width="2.5" opacity="0.85"/>
                    <path d="M160,300 L148,300 L148,108" stroke="#1976D2" stroke-width="1.5" fill="none" opacity="0.6"/>
                    <path d="M160,150 L176,160 M160,200 L176,210 M160,250 L176,260" stroke="#1565C0" stroke-width="2" opacity="0.7"/>
                    <path d="M156,118 Q130,110 154,132" stroke="#90CAF9" stroke-width="1" fill="none" opacity="0.5"/>
                    <path d="M156,168 Q130,160 154,182" stroke="#90CAF9" stroke-width="1" fill="none" opacity="0.5"/>
                    <circle cx="153" cy="155" r="2.5" fill="#1565C0" opacity="0.8"/>
                    <circle cx="153" cy="205" r="2.5" fill="#1565C0" opacity="0.8"/>
                </g>
            </svg>
        </div>
    </div>

    <p class="relative z-30 font-elegant text-xl md:text-3xl text-wedding-deep/70 mt-8 reveal text-center px-4">
        "Dan di antara tanda kekuasaan-Nya, Dia menciptakan pasangan hidup dari jenismu sendiri"
    </p>
</section>
