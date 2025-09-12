<div class="space-y-4">
    <x-page-heading title="Clients" />
    <div class="flex justify-end">

        <div>
            @can('create', \App\Models\Client::class)
                <flux:button.group>
                    <livewire:components.buttons.create-button @create="create" />
                    <livewire:components.buttons.export-button @export="exportClientListPdf" />
                    <livewire:components.buttons.export-excel-button @export="exportExcel" />
                </flux:button.group>
            @endcan
        </div>
    </div>
    <x-common.card-filter>
        <flux:input wire:model.live.debounce1000ms="form.filters.search" label="Search"></flux:input>
        <flux:select wire:model.live="form.filters.legal_status_id" variant="listbox" label="Legal Status" clearable
            searchable placeholder="Choose legal status...">
            @if ($this->form->statuses)
                @foreach ($this->form->statuses as $status)
                    <flux:select.option value="{{ $status->id }}">{{ $status->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.identification_type_id" variant="listbox" label="Identification Type"
            clearable searchable placeholder="Choose identification type...">
            @if ($this->form->identificationTypes)
                @foreach ($this->form->identificationTypes as $type)
                    <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.ethnicity_id" variant="listbox" label="Ethnicity" clearable
            searchable placeholder="Choose ethnicity...">
            @if ($this->form->ethnicities)
                @foreach ($this->form->ethnicities as $ethnicity)
                    <flux:select.option value="{{ $ethnicity->id }}">{{ $ethnicity->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.healthcare_provider_id" variant="listbox" label="Healthcare Provider"
            clearable searchable placeholder="Choose healthcare provider...">
            @if ($this->form->healthcareProviders)
                @foreach ($this->form->healthcareProviders as $provider)
                    <flux:select.option value="{{ $provider->id }}">{{ $provider->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.income_type_id" variant="listbox" label="Income Type" clearable
            searchable placeholder="Choose income type...">
            @if ($this->form->incomeTypes)
                @foreach ($this->form->incomeTypes as $incomeType)
                    <flux:select.option value="{{ $incomeType->id }}">{{ $incomeType->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.gender_id" variant="listbox" label="Gender" clearable searchable
            placeholder="Choose gender...">
            @if ($this->form->genders)
                @foreach ($this->form->genders as $gender)
                    <flux:select.option value="{{ $gender->id }}">{{ $gender->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.city_district_id" variant="listbox" clearable searchable
            label="City District" filter>
            @foreach ($this->form->cityDistricts as $cityDistrict)
                <flux:select.option value="{{ $cityDistrict->id }}" wire:key="{{ $cityDistrict->id }}">
                    {{ $cityDistrict->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model.live="form.filters.countyDistrictId" variant="listbox" clearable searchable
            label="County District" filter>
            @foreach ($this->form->countyDistricts as $countyDistrict)
                <flux:select.option value="{{ $countyDistrict->id }}" wire:key="{{ $countyDistrict->id }}">
                    {{ $countyDistrict->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model.live="form.filters.city_id" variant="listbox" clearable searchable label="City" filter>
            @foreach ($this->form->citiesFiltered ?? [] as $city)
                <flux:select.option value="{{ $city->id }}" wire:key="{{ $city->id }}">
                    {{ $city->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:input.group class="flex flex-col">
            <div>
                <flux:label>Age Range</flux:label>
            </div>
            <div class="flex flex-row mt-2 gap-1">
                <flux:field>
                    <flux:input.group>
                        <flux:input.group.prefix>From</flux:input.group.prefix>
                        <flux:input type="number" wire:model.live.debounce1000ms="form.filters.from_age"
                            placeholder="18" />
                    </flux:input.group>
                </flux:field>
                <flux:field>
                    <flux:input.group>
                        <flux:input.group.prefix>To</flux:input.group.prefix>
                        <flux:input type="number" wire:model.live.debounce1000ms="form.filters.to_age"
                            placeholder="50" />
                    </flux:input.group>

                </flux:field>
            </div>

        </flux:input.group>
        <flux:fieldset>
            <flux:legend>Programs</flux:legend>
            <div class="flex flex-row items-center gap-4">
                <div>
                    <flux:switch wire:model.live="form.filters.has_howpa" label="HOWPA" align="left" />
                </div>
                <div>
                    <flux:switch wire:model.live="form.filters.has_meals" label="MEALS" align="left" />
                </div>
            </div>
        </flux:fieldset>
        <flux:fieldset>
            <flux:legend>Additional Info</flux:legend>
            <div class="flex flex-row items-center gap-4">
                <div>
                    <flux:switch wire:model.live="form.filters.hispanic" label="HISPANIC" align="left" />
                </div>
                <div>
                    <flux:switch wire:model.live="form.filters.isDeceased" label="DECEASED" align="left" />
                </div>
            </div>
        </flux:fieldset>
    </x-common.card-filter>
    <x-common.container-table>
        <div class="flex justify-end mb-2">
            <livewire:components.modal-columns :columns="$this->form->columns"
                :columns-selected="$this->form->columnsSelected" />
        </div>
        <flux:table :paginate="$this->form->results()">
            <flux:table.columns>
                @if (in_array('full_name', $this->form->columnsSelected))
                    <flux:table.column>Full Name</flux:table.column>
                @endif
                @if (in_array('dob', $this->form->columnsSelected))
                    <flux:table.column>DOB</flux:table.column>
                @endif
                @if (in_array('age', $this->form->columnsSelected))
                    <flux:table.column>Age</flux:table.column>
                @endif
                @if (in_array('ssn', $this->form->columnsSelected))
                    <flux:table.column>SSN</flux:table.column>
                @endif
                @if (in_array('client_number', $this->form->columnsSelected))
                    <flux:table.column>Client #</flux:table.column>
                @endif
                @if (in_array('howpa_client_number', $this->form->columnsSelected))
                    <flux:table.column>HOPWA Client #</flux:table.column>
                @endif
                @if (in_array('meal_client_number', $this->form->columnsSelected))
                    <flux:table.column>MEALS Client #</flux:table.column>
                @endif
                @if (in_array('effective_date', $this->form->columnsSelected))
                    <flux:table.column>Effective Date</flux:table.column>
                @endif
                @if (in_array('legal_status', $this->form->columnsSelected))
                    <flux:table.column>Legal Status</flux:table.column>
                @endif
                @if (in_array('identification_type', $this->form->columnsSelected))
                    <flux:table.column>Identification Type</flux:table.column>
                @endif
                @if (in_array('identification_number', $this->form->columnsSelected))
                    <flux:table.column>Identification Number</flux:table.column>
                @endif
                @if (in_array('identification_expiration_date', $this->form->columnsSelected))
                    <flux:table.column>Identification Expiration Date</flux:table.column>
                @endif
                @if (in_array('address_formatted', $this->form->columnsSelected))
                    <flux:table.column>Address</flux:table.column>
                @endif
                @if (in_array('city_district', $this->form->columnsSelected))
                    <flux:table.column>City District</flux:table.column>
                @endif
                @if (in_array('county_district', $this->form->columnsSelected))
                    <flux:table.column>County District</flux:table.column>
                @endif
                @if (in_array('city', $this->form->columnsSelected))
                    <flux:table.column>City</flux:table.column>
                @endif
                @if (in_array('email', $this->form->columnsSelected))
                    <flux:table.column>Email</flux:table.column>
                @endif
                @if (in_array('income', $this->form->columnsSelected))
                    <flux:table.column>Income</flux:table.column>
                @endif
                @if (in_array('gender', $this->form->columnsSelected))
                    <flux:table.column>Gender</flux:table.column>
                @endif
                @if (in_array('is_deceased', $this->form->columnsSelected))
                    <flux:table.column>Is Deceased</flux:table.column>
                @endif
                @if (in_array('ethnicity', $this->form->columnsSelected))
                    <flux:table.column>Ethnicity</flux:table.column>
                @endif
                @if (in_array('healthcare_provider', $this->form->columnsSelected))
                    <flux:table.column>Healthcare Provider</flux:table.column>
                @endif
                @if (in_array('healthcare_provider_plan', $this->form->columnsSelected))
                    <flux:table.column>Healthcare Provider Plan</flux:table.column>
                @endif
                @if (in_array('housing_status', $this->form->columnsSelected))
                    <flux:table.column>Housing Status</flux:table.column>
                @endif
                @if (in_array('income_category', $this->form->columnsSelected))
                    <flux:table.column>Income Category</flux:table.column>
                @endif
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->form->results() as $result)
                    <flux:table.row :key="$result->id">
                        @if (in_array('full_name', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->full_name }}</flux:table.cell>
                        @endif
                        @if (in_array('dob', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->dob_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('age', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->age }}</flux:table.cell>
                        @endif
                        @if (in_array('ssn', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->howpa_ssn }}</flux:table.cell>
                        @endif
                        @if (in_array('client_number', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client_number }}</flux:table.cell>
                        @endif
                        @if (in_array('howpa_client_number', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->howpa_client_number }}</flux:table.cell>
                        @endif
                        @if (in_array('meal_client_number', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->meal_client_number }}</flux:table.cell>
                        @endif
                        @if (in_array('effective_date', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->effective_date_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('legal_status', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->legalStatus?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('identification_type', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->identificationType?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('identification_number', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->identification_number }}</flux:table.cell>
                        @endif
                        @if (in_array('identification_expiration_date', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->identification_expiration_date_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('address_formatted', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->address_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('city_district', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->cityDistrict?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('county_district', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->countyDistrict?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('city', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->city?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('email', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->email }}</flux:table.cell>
                        @endif
                        @if (in_array('income', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->income_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('gender', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->gender?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('is_deceased', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->is_deceased ? 'Yes' : 'No' }}</flux:table.cell>
                        @endif
                        @if (in_array('ethnicity', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->ethnicity?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('healthcare_provider', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->healthcareProvider?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('healthcare_provider_plan', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->healthcareProviderPlan?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('housing_status', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->housingStatus?->name }}</flux:table.cell>
                        @endif
                        <flux:table.cell>
                            @if (in_array('income_category', $this->form->columnsSelected))
                                @if ($result->income_category)
                                    <flux:badge color="green">{{"$result->income_category" }}</flux:badge>
                                @else
                                    <flux:badge color="red">N/A</flux:badge>
                                @endif
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                                <flux:menu>
                                    @can('view', $result)
                                        <flux:menu.item icon="eye" wire:click="show({{$result->id}})">Show</flux:menu.item>
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
