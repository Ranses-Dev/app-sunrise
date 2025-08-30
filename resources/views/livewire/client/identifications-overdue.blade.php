<div class="space-y-4">
    <x-page-heading title="Clients with Identifications Overdue" />
    <div class="flex justify-end">
        <livewire:components.buttons.export-button @export="export" />
    </div>
    <x-common.card-filter>

            <!-- City District Filter -->
            <div>
                <flux:label for="city_district">City District</flux:label>
                <flux:select variant="listbox" clearable wire:model.live="filters.city_district_id" id="city_district">
                    @forelse ($this->districts as $district)
                        <flux:select.option value="{{ $district->id }}">{{ $district->name }}</flux:select.option>
                    @empty
                    @endforelse
                </flux:select>
            </div>
            <!-- County District Filter -->
            <div>
                <flux:label for="county_district">County District</flux:label>
                <flux:select variant="listbox" clearable wire:model.live="filters.county_district_id"
                    id="county_district">
                    @forelse ($this->counties as $county)
                        <flux:select.option value="{{ $county->id }}">{{ $county->name }}</flux:select.option>
                    @empty
                    @endforelse
                </flux:select>
            </div>
            <!-- City Filter -->
            <div>
                <flux:label for="city">City</flux:label>
                <flux:select variant="listbox" clearable wire:model.live="filters.city_id" id="city">
                    @foreach ($this->cities as $city)
                        <flux:select.option value="{{ $city->id }}">{{ $city->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
            <!-- Range Date Filter -->
            <div>
                <flux:label for="date_from">Range Date</flux:label>
                <flux:date-picker wire:model.live='range' mode="range" clearable />
            </div>
       
    </x-common.card-filter>
    <x-common.container-table>
        <flux:table :paginate="$this->results">
            <flux:table.columns>
                <flux:table.column>Full Name</flux:table.column>
                <flux:table.column>DOB</flux:table.column>
                <flux:table.column>Age</flux:table.column>
                <flux:table.column>Email </flux:table.column>
                <flux:table.column>Client Number</flux:table.column>
                <flux:table.column>Legal Status</flux:table.column>
                <flux:table.column>Identification</flux:table.column>
                <flux:table.column>ID. Expiration Date</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->results as $result)
                    <flux:table.row :key="$result->id">
                        <flux:table.cell>{{ $result->full_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->dob?->format('m/d/Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $result->age }}</flux:table.cell>
                        <flux:table.cell>{{ $result->email }}</flux:table.cell>
                        <flux:table.cell>{{ $result->client_number }}</flux:table.cell>
                        <flux:table.cell>{{ $result->legalStatus?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->identification_data }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge variant="solid" size="sm" color="red">
                                {{ $result->identification_expiration_date?->format('m/d/Y') }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:button variant="primary" size="sm" icon="pencil-square"
                                wire:click="edit({{ $result->id }})" />
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </x-common.container-table>
</div>
