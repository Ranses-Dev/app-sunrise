<x-common.container-table x-data>

    <div class="col-span-5 flex items-center mb-2">
        <flux:icon name="adjustments-horizontal" class="mr-2 text-gray-500 dark:text-gray-400" />
        <span class="text-md font-semibold text-gray-700 dark:text-gray-200">Filters</span>
        <div class="flex-1 border-b border-gray-200 dark:border-gray-700 ml-3"></div>
    </div>
    <div class="flex justify-end items-end col-span-4">
        <flux:button icon="x-circle" variant="primary" color="blue" @click="$wire.dispatch('reset-filters')">Reset
            Filters
        </flux:button>
    </div>
    <div class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{ $slot }}
    </div>
</x-common.container-table>
