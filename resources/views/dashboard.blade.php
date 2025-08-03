<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <livewire:dashboard.clients-by-program>
                <livewire:dashboard.card-clients-active-by-user />
                <livewire:dashboard.card-clients-by-program />
                <livewire:dashboard.card-clients-program-summary />
        </div>
        <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-1 gap-4">
            <div class="col-span-1">
                <livewire:dashboard.table-client-due-by-user />
            </div>
            <div class="col-span-1">
                <livewire:dashboard.table-client-overdue-by-user />
            </div>
        </div>
    </div>
</x-layouts.app>
