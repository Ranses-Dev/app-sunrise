<div class="w-full">
    <div class="flex justify-center items-center">
        <flux:button wire:click='handleShowModal' variant="primary" icon="magnifying-glass-circle" />
    </div>

    <flux:modal name="search-address" wire:model='showModal' class="w-full max-h-screen  max-w-7xl overflow-y-auto">
        <div class="space-y-4 w-full">
            <x-page-heading title="Addresses" />
            <x-common.card-filter>
                <div class="col-span-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <flux:input label="Search" clearable wire:model.live.debounce.1000ms="form.filters.deliveryLine1"
                        placeholder="Search by address..." />
                    <flux:select label="Cities" variant="combobox" clearable
                        wire:model.live.debounce.1000ms="form.filters.city" placeholder="Cities...">
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
                                <flux:select.option value="{{ $county->county_name }}">{{ $county->county_name }}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                    <flux:select label="States" variant="combobox"
                        wire:model.live.debounce.1000ms="form.filters.stateAbbreviation" clearable
                        placeholder="States...">
                        @if ($this->form->states)
                            @foreach ($this->form->states as $state)
                                <flux:select.option value="{{ $state->state_abbreviation }}">{{ $state->state_abbreviation }}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                </div>
            </x-common.card-filter>
            <flux:table :paginate="$this->form->results()">
                <flux:table.columns>
                    <flux:table.column> </flux:table.column>
                    <flux:table.column>Address</flux:table.column>
                    <flux:table.column>City</flux:table.column>
                    <flux:table.column>County</flux:table.column>
                    <flux:table.column>State</flux:table.column>
                    <flux:table.column>Postal Code</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($this->form->results() as $result)
                        <flux:table.row :key="$result->id">
                            <flux:table.cell>
                                <flux:button wire:click="selectAddress({{ $result->id }})" variant="primary" icon="check">
                                    Select</flux:button>
                            </flux:table.cell>
                            <flux:table.cell>{{ $result->address_formatted }}</flux:table.cell>
                            <flux:table.cell>{{ $result->city }}</flux:table.cell>
                            <flux:table.cell>{{ $result->county_name }}</flux:table.cell>
                            <flux:table.cell>{{ $result->state_abbreviation }}</flux:table.cell>
                            <flux:table.cell>{{ $result->postal_code }}</flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>
    </flux:modal>
</div>
