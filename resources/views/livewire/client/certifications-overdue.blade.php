<div class="space-y-4">
    <x-page-heading title="Clients with certifications overdue" />
    <!-- Button moved to the end, after the table and modal -->

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
            <flux:select variant="listbox" clearable wire:model.live="filters.county_district_id" id="county_district">
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
        <!-- Specialist Filter -->
        <div>
            <flux:label for="specialist">Specialist</flux:label>
            <flux:select variant="listbox" clearable wire:model.live="filters.user_id" id="specialist">
                @forelse ($this->users as $user)
                    <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
                @empty
                @endforelse
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
                <flux:table.column>Full Name </flux:table.column>
                <flux:table.column>Client Number</flux:table.column>
                <flux:table.column>Age</flux:table.column>
                <flux:table.column>Income</flux:table.column>
                <flux:table.column>Total Income</flux:table.column>
                <flux:table.column>Households</flux:table.column>
                <flux:table.column>Income Category (%)</flux:table.column>
                <flux:table.column>Contracts</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->results as $result)
                    <flux:table.row :key="$result->id">
                        <flux:table.cell>{{ $result->full_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->client_number }}</flux:table.cell>
                        <flux:table.cell>{{ $result->age }}</flux:table.cell>
                        <flux:table.cell>{{ $result->income }}</flux:table.cell>
                        <flux:table.cell>{{ $result->total_income }}</flux:table.cell>
                        <flux:table.cell>{{ $result->household_total }}</flux:table.cell>
                        <flux:table.cell> @if ($result->income_category)
                            <flux:badge color="green">{{"$result->income_category %" }}</flux:badge>
                        @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="space-y-2">
                                @if (!$result->howpaContracts?->isEmpty())
                                    <div class=" border-dashed border-2 p-2 rounded-md">
                                        <p class="border-b mb-2">Howpa Contracts:</p>
                                        @foreach ($result->howpaContracts as $howpaContract)
                                            <flux:link wire:navigate href="{{ route('howpa.contracts.edit', $howpaContract->id) }}"
                                                class="flex items-center">
                                                <flux:badge color="red" class="mr-1">
                                                    {{ \Carbon\Carbon::parse($howpaContract->re_certification_date)->format('m/d/Y') }}
                                                </flux:badge>
                                            </flux:link>
                                        @endforeach
                                    </div>
                                @endif
                                @if (!$result->contractMeals?->isEmpty())
                                    <div class=" border-dashed border-2 p-2 rounded-md">
                                        <p class="border-b mb-2">Contract Meals:</p>
                                        @foreach ($result->contractMeals as $contractMeal)
                                            <flux:link wire:navigate href="{{ route('contract-meals.edit', $contractMeal->id) }}"
                                                class="flex items-center">
                                                <flux:badge color="red" class="mr-1">
                                                    {{ \Carbon\Carbon::parse($contractMeal->recertification_date)->format('m/d/Y') }}
                                                </flux:badge>
                                            </flux:link>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </x-common.container-table>


</div>
