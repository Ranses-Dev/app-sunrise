<div class="space-y-4">
    <x-page-heading title="Contract Meals List" />
    <div class="flex justify-between">
        <flux:input wire:model.live.debounce1000="search" class="input-search" icon="magnifying-glass"
            placeholder="Search ..." />
        @can('create', \App\Models\ContractMeal::class)
            <flux:button wire:click="create" variant="primary" icon="plus">Create</flux:button>
        @endcan
    </div>
    <livewire:contract-meal.stats />
    <x-common.container-table>
        <flux:table :paginate="$this->results">
            <flux:table.columns>
                <flux:table.column>Client Name</flux:table.column>
                <flux:table.column>Code</flux:table.column>
                <flux:table.column>Contract Type</flux:table.column>
                <flux:table.column>Food Cost</flux:table.column>
                <flux:table.column>Delivery Cost</flux:table.column>
                <flux:table.column>Program Delivery Cost</flux:table.column>
                <flux:table.column>Is Active</flux:table.column>
                <flux:table.column>Termination Reason</flux:table.column>
                <flux:table.column>Re-Certification Date</flux:table.column>
                <flux:table.column>Notes</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->results as $result)
                    <flux:table.row :key="$result->id">
                        <flux:table.cell>{{ $result->client?->full_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->code }}</flux:table.cell>
                        <flux:table.cell>{{ $result->mealContractType?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->foodCost?->cost }}</flux:table.cell>
                        <flux:table.cell>{{ $result->deliveryCost?->cost }}</flux:table.cell>
                        <flux:table.cell>{{ $result->programDeliveryCost?->cost }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :icon="$result->is_active ? 'check' : 'no-symbol'"
                                :color="$result->is_active ? 'green' : 'red'">
                                {{ $result->is_active ? 'Yes' : 'No' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $result->terminationReason?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->recertification_date?->format('m/d/Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $result->notes }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                                <flux:menu>
                                    @can('view', $result)
                                        <flux:menu.item icon="eye">Show</flux:menu.item>
                                    @endcan
                                    @can('update', $result)
                                        <flux:menu.item wire:click="edit({{$result->id}})" icon="pencil-square">Edit
                                        </flux:menu.item>
                                    @endcan
                                    @can('delete', $result)
                                        <flux:menu.item wire:click="delete({{$result->id}})" icon="trash" variant="danger">
                                            Delete
                                        </flux:menu.item>
                                    @endcan
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </x-common.container-table>
    <livewire:components.modal-delete />
</div>
