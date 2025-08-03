@can('viewAny', \App\Models\Client::class)
    <flux:navlist.item icon="user-group" href="{{ route('clients.index') }}" :current="request()->routeIs('clients.*')"
        wire:navigate>Client</flux:navlist.item>
@endcan
@can('viewAny', \App\Models\ContractMeal::class)
    <flux:navlist.item icon="bookmark-square" href="{{ route('contract-meals.index') }}"
        :current="request()->routeIs('contract-meals.*')" wire:navigate>Contract Meals
    </flux:navlist.item>
@endcan
@can('viewAny', \App\Models\HowpaContract::class)
    <flux:navlist.item icon="bookmark-square" href="{{ route('howpa.contracts.index') }}"
        :current="request()->routeIs('howpa.contracts.*')" wire:navigate>Howpa Contracts
    </flux:navlist.item>
@endcan
