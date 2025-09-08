@props(['progress' => 0, 'value' => 0, 'title' => ''])
@php
    if ($progress <= 30) {
        $barColor = 'bg-red-500 dark:bg-red-400';
    } elseif ($progress <= 75) {
        $barColor = 'bg-yellow-500 dark:bg-yellow-400';
    } else {
        $barColor = 'bg-green-600 dark:bg-green-500';
    }
@endphp
<div>
    <div aria-hidden="true">
        <p class=" font-bold text-sm ">{{ $title }}</p>
        <div class="  text-sm font-thin text-gray-700 text-center dark:text-gray-300">
            <span class="text-xl">{{ $value }}</span>
        </div>
        <div class="overflow-hidden rounded-full bg-gray-200 dark:bg-white/10">
            <div style="width: {{ $progress }}%" class="h-2 rounded-full {{ $barColor }}"></div>
        </div>
        <div class="  text-sm font-thin text-gray-700 text-center dark:text-gray-300">
            <span class="text-xl">{{ $progress }}%</span>
        </div>
    </div>
</div>
