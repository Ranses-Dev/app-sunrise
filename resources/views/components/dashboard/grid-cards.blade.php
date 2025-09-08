@props(['clientsAliveCount' => 0,
        'clientsIdentificationsDueCount' => 0,
        'clientsIdentificationsOverdueCount' => 0,
        'clientsCertificationsDueCount' => 0,
        'clientsCertificationsOverdueCount' => 0,
])
<div class="bg-white   dark:bg-gray-900">
    <div class="mx-auto w-full ">
        <div class="mx-auto max-w-2xl lg:max-w-none">
            <div class="text-left border-b border-[var(--color-accent-content)] ">
                <h2
                    class="text-5xl font-thin  tracking-tight text-balance text-[var(--color-accent-content)]  dark:text-white">
                    Dashboard</h2>

            </div>
            <dl
                class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-5">

                <x-dashboard.grid.card class="bg-[var(--card-total-bg)] text-[var(--card-total-fg)]"
                    title="Total Clients" value="{{ $clientsAliveCount }}">
                    <x-slot:icon>
                        <x-heroicon-o-users class="w-6 h-6" />
                    </x-slot:icon>
                    <x-slot:action>
                        <flux:button variant="subtle" wire:click='goToTotalClients' icon="arrow-right">See More
                        </flux:button>
                    </x-slot:action>
                </x-dashboard.grid.card>
                <x-dashboard.grid.card class="bg-[var(--card-due-bg)] text-[var(--card-due-fg)]"
                    title="Identifications Due" value="{{ $clientsIdentificationsDueCount }}">
                    <x-slot:icon>
                        <x-heroicon-o-document class="w-6 h-6" />
                    </x-slot:icon>
                    <x-slot:action>
                        <flux:button variant="subtle" wire:click='goToIdentificationsDue' icon="arrow-right">See More
                        </flux:button>
                    </x-slot:action>
                </x-dashboard.grid.card>
                <x-dashboard.grid.card class="bg-[var(--card-overdue-bg)] text-[var(--card-overdue-fg)]"
                    title="Identifications Overdue" value="{{ $clientsIdentificationsOverdueCount }}">
                    <x-slot:icon>
                        <x-heroicon-o-document class="w-6 h-6" />
                    </x-slot:icon>
                   <x-slot:action>
                        <flux:button variant="subtle" wire:click='goToIdentificationsOverdue' icon="arrow-right">See More
                        </flux:button>
                    </x-slot:action>
                </x-dashboard.grid.card>
                <x-dashboard.grid.card class="bg-[var(--card-redue-bg)] text-[var(--card-redue-fg)]"
                    title="Clients with Re-Certification Due" value="{{ $clientsCertificationsDueCount }}">
                    <x-slot:icon>
                        <x-heroicon-o-document class="w-6 h-6" />
                    </x-slot:icon>
                    <x-slot:action>
                        <flux:button variant="subtle" wire:click='goToCertificationsDue' icon="arrow-right">See More
                        </flux:button>
                    </x-slot:action>
                </x-dashboard.grid.card>
                <x-dashboard.grid.card class="bg-[var(--card-reoverdue-bg)] text-[var(--card-reoverdue-fg)]"
                    title="Clients with Re-Certification Overdue" value="{{ $clientsCertificationsOverdueCount }}">
                    <x-slot:icon>
                        <x-heroicon-o-document class="w-6 h-6" />
                    </x-slot:icon>
                    <x-slot:action>
                        <flux:button variant="subtle" wire:click='goToCertificationsOverdue' icon="arrow-right">See More
                        </flux:button>
                    </x-slot:action>
                </x-dashboard.grid.card>

            </dl>
        </div>
    </div>
</div>
