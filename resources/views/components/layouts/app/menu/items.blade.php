@can('viewAny', \App\Models\Address::class)
    <flux:navlist.item icon="map" href="{{ route('addresses.index') }}" wire:current wire:navigate
        :current="request()->routeIs('addresses.*')">Address</flux:navlist.item>
@endcan
@can('viewAny', \App\Models\Client::class)
    <flux:navlist.item icon="user-group" href="{{ route('clients.index') }}" :current="request()->routeIs('clients.*')"
        wire:navigate>Client</flux:navlist.item>
@endcan
@can('viewAny', \App\Models\ContractMeal::class)
    <flux:navlist.item icon="folder-open" href="{{ route('contract-meals.index') }}"
        :current="request()->routeIs('contract-meals.*')" wire:navigate>Meal Contracts
    </flux:navlist.item>
@endcan
@can('viewAny', \App\Models\HowpaContract::class)
    <flux:navlist.item icon="circle-stack" href="{{ route('howpa.contracts.index') }}"
        :current="request()->routeIs('howpa.contracts.*')" wire:navigate>Howpa Contracts
    </flux:navlist.item>
@endcan
@can('viewAny', \App\Models\Inspection::class)
    <flux:navlist.item icon="clipboard-document-list" href="{{ route('inspections.index') }}" wire:current wire:navigate
        :current="request()->routeIs('inspections.*')">Inspections</flux:navlist.item>
@endcan



