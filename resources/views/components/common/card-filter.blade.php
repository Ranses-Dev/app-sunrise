<x-common.container-table>
    <div class="col-span-5 flex items-center mb-2">
        <flux:icon name="adjustments-horizontal" class="mr-2 text-gray-500 dark:text-gray-400" />
        <span class="text-md font-semibold text-gray-700 dark:text-gray-200">Filters</span>
        <div class="flex-1 border-b border-gray-200 dark:border-gray-700 ml-3"></div>
    </div>
    {{ $slot }}
</x-common.container-table>
