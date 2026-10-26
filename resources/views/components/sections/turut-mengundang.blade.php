<section id="scene-turut-mengundang" class="wedding-section">
    <div class="text-center mb-8">
        <h3 class="font-heading text-3xl md:text-4xl text-wedding-deep reveal">Turut Mengundang</h3>
        <div class="wedding-divider"><i class="fa-solid fa-leaf"></i></div>
    </div>

    <div class="wedding-card max-w-md w-full stagger-children">
        <ul class="space-y-4 text-center">
            @foreach (config('wedding.turut_mengundang', []) as $family)
                <li class="font-elegant text-lg md:text-xl text-wedding-deep">{{ $family }}</li>
            @endforeach
        </ul>
    </div>
</section>
