@props(['title' => null])
<div class="bg-white dark:bg-gray-900 shadow rounded-2xl p-6">
    @if ($title)
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4  border-b-2 border-gray-200 dark:border-gray-100">{{ $title }}</h3>
    @endif
    <div {{ $attributes->merge(['class' => 'space-y-4']) }}>
        {{ $slot }}
    </div>
</div>
