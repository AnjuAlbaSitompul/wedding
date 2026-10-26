@props(['title', 'icon' => 'fa-calendar-day', 'lines' => []])

<div class="wedding-card max-w-lg stagger-children">
    <div class="flex items-center justify-center gap-3 mb-4">
        <i class="fa-solid {{ $icon }} text-wedding-blue text-2xl"></i>
        <h4 class="font-heading text-2xl text-wedding-deep">{{ $title }}</h4>
    </div>

    @foreach ($lines as $line)
        <p class="font-body text-sm text-wedding-deep/70 text-center">{{ $line }}</p>
    @endforeach
</div>
