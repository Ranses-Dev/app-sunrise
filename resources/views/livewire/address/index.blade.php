<div class="space-y-4">

    <x-page-heading title="Addresses" />
    <div class="flex justify-end">
        <flux:button wire:click="create" variant="primary" icon="plus">Create</flux:button>
    </div>
    <x-common.card-filter>

        <flux:input label="Search" clearable wire:model.live.debounce.1000ms="form.filters.deliveryLine1"
            placeholder="Search by address..." />
        <flux:select label="Cities" variant="combobox" clearable wire:model.live.debounce.1000ms="form.filters.city"
            placeholder="Cities...">
            @if ($this->form->cities)
                @foreach ($this->form->cities as $city)
                    <flux:select.option value="{{ $city->city }}">{{ $city->city }}</flux:select.option>
                @endforeach
            @else
                <flux:select.option disabled>No cities available</flux:select.option>
            @endif
        </flux:select>
        <flux:select label="Counties" variant="combobox" clearable
            wire:model.live.debounce.1000ms="form.filters.countyName" placeholder="Counties...">
            @if ($this->form->counties)
                @foreach ($this->form->counties as $county)
                    <flux:select.option value="{{ $county->county_name }}">{{ $county->county_name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select label="States" variant="combobox" wire:model.live.debounce.1000ms="form.filters.stateAbbreviation"
            clearable placeholder="States...">
            @if ($this->form->states)
                @foreach ($this->form->states as $state)
                    <flux:select.option value="{{ $state->state_abbreviation }}">{{ $state->state_abbreviation }}
                    </flux:select.option>
                @endforeach
            @endif
        </flux:select>

    </x-common.card-filter>
    <flux:table :paginate="$this->form->results()">
        <flux:table.columns class="text-black p-4">
            <flux:table.column>Address</flux:table.column>
            <flux:table.column>City</flux:table.column>
            <flux:table.column>County</flux:table.column>
            <flux:table.column>State</flux:table.column>
            <flux:table.column>Postal Code</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->form->results() as $result)
                <flux:table.row :key="$result->id">
                    <flux:table.cell>{{ $result->address_formatted }}</flux:table.cell>
                    <flux:table.cell>{{ $result->city }}</flux:table.cell>
                    <flux:table.cell>{{ $result->county_name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->state_abbreviation }}</flux:table.cell>
                    <flux:table.cell>{{ $result->postal_code }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                            <flux:menu>
                                <flux:menu.item icon="eye" wire:click="show({{$result->id}})">Show</flux:menu.item>
                                <flux:menu.item wire:click="edit({{$result->id}})" icon="pencil-square">Edit
                                </flux:menu.item>
                                <flux:menu.item wire:click="delete({{$result->id}})" icon="trash" variant="danger">Delete
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
