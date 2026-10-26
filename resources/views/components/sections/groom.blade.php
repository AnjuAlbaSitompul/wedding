@php
    $person = config('wedding.groom');
@endphp

<section id="scene-groom" class="wedding-section">
    <div class="wedding-card max-w-md text-center stagger-children">
        <div class="w-40 h-40 mx-auto mb-6 rounded-full bg-gradient-to-br from-[#90CAF9] to-[#1565C0] flex items-center justify-center shadow-lg">
            @if ($person['photo'])
                <img src="{{ asset($person['photo']) }}" alt="{{ $person['nickname'] }}" class="w-full h-full rounded-full object-cover">
            @else
                <i class="fa-solid fa-user-tie text-5xl text-white"></i>
            @endif
        </div>

        <p class="font-heading text-sm text-wedding-blue uppercase tracking-widest mb-2">Mempelai Pria</p>
        <h3 class="font-script text-4xl text-wedding-deep mb-2">{{ $person['nickname'] }}</h3>
        <p class="font-elegant text-lg text-wedding-deep/80 mb-6">{{ $person['full_name'] }}</p>

        <div class="border-t border-wedding-blue/30 pt-4">
            <p class="font-body text-sm text-wedding-deep/70 mb-1">Putra dari</p>
            <p class="font-elegant text-base text-wedding-deep">{{ $person['father'] }}</p>
            <p class="font-elegant text-base text-wedding-deep">&amp; {{ $person['mother'] }}</p>
        </div>

        @if ($person['instagram'])
            <a href="https://instagram.com/{{ $person['instagram'] }}" target="_blank" rel="noopener" class="inline-block mt-4 text-wedding-blue hover:text-wedding-deep transition">
                <i class="fa-brands fa-instagram text-2xl"></i>
            </a>
        @endif
    </div>
</section>
