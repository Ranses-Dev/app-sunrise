<div class="space-y-4">
    <x-page-heading title="Howpa Contracts List" />
    <div class="flex justify-between">
        <flux:input wire:model.live.debounce1000="search" class="input-search" icon="magnifying-glass"
            placeholder="Search ..." />
        @can('create', \App\Models\HowpaContract::class)
            <flux:button wire:click="create" variant="primary" icon="plus">Create</flux:button>
        @endcan
    </div>
    <x-common.container-table>
        <flux:table :paginate="$this->form->result()">
            <flux:table.columns>
                <flux:table.column>First Name</flux:table.column>
                <flux:table.column>Last Name</flux:table.column>
                <flux:table.column>Program</flux:table.column>
                <flux:table.column>City</flux:table.column>
                <flux:table.column>Date</flux:table.column>
                <flux:table.column>Number of Bedrooms Required</flux:table.column>
                <flux:table.column>Number of Bedrooms Approved</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->form->result() as $result)
                    <flux:table.row :key="$result->id">
                        <flux:table.cell>{{ $result->client?->first_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->client?->last_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->programBranch?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->city?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->date?->format('m/d/Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $result->bedrooms_required }}</flux:table.cell>
                        <flux:table.cell>{{ $result->bedrooms_approved }}</flux:table.cell>
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
