<div class="space-y-4">
    <flux:heading>County Districts</flux:heading>
    <div class="flex justify-between">
        <flux:input wire:model.live.debounce1000="search" class="input-search" icon="magnifying-glass"
            placeholder="Search ..." />
        <flux:button wire:click="create" variant="primary" icon="plus">Create</flux:button>
    </div>
    <flux:table :paginate="$this->results">
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Cities</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->results as $result)
                <flux:table.row :key="$result->id">
                    <flux:table.cell>{{ $result->name }}</flux:table.cell>
                    <flux:table.cell> @foreach ($result->cities as $city)
                        <flux:badge color="yellow">{{$city->name}}</flux:badge>
                    @endforeach
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                            <flux:menu>
                                <flux:menu.item icon="eye">Show</flux:menu.item>
                                <flux:menu.item wire:click="edit({{$result->id}})" icon="pencil-square">Edit
                                </flux:menu.item>
                                <flux:menu.item wire:click="delete({{$result->id}})" icon="trash" variant="danger">
                                    Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
    <livewire:components.modal-delete />
</div>
