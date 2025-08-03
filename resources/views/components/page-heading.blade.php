@props(['title' => ''])

@if ($title)
    <flux:heading
        class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2 border-b-2 border-gray-200 dark:border-gray-300 pb-2">
        {{ $title }}
    </flux:heading>
@endif
