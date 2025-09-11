<div class="space-y-4">
    <x-page-heading title="Meal Contracts" />
    <div class="flex justify-end">
        @can('create', \App\Models\ContractMeal::class)
            <flux:button.group>
                <livewire:components.buttons.create-button @create="create" />
                <livewire:components.buttons.export-button @export="export" />
                 <livewire:components.buttons.export-excel-button @export="exportExcel" />
            </flux:button.group>
        @endcan
    </div>
    <livewire:contract-meal.stats />
    <x-common.card-filter>
        <flux:input wire:model.live.debounce1000ms='form.filters.search' label="Search"></flux:input>
        <flux:select clearable wire:model.live='form.filters.clientServiceSpecialistId' variant="listbox"
            label="Client Service Specialist" searchable placeholder="Client Service Specialist...">
            @if ($this->form->clientServiceSpecialists)
                @foreach ($this->form->clientServiceSpecialists as $specialist)
                    <flux:select.option value="{{ $specialist->id }}">{{ $specialist->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select clearable wire:model.live='form.filters.programBranchId' variant="listbox" label="Program Branch"
            searchable placeholder="Program Branch...">
            @if ($this->form->programBranches)
                @foreach ($this->form->programBranches as $branch)
                    <flux:select.option value="{{ $branch->id }}">{{ $branch->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.cityDistrictId" variant="listbox" clearable searchable
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
        <flux:select wire:model.live="form.filters.cityId" variant="listbox" clearable searchable label="City" filter>
            @foreach ($this->form->cities ?? [] as $city)
                <flux:select.option value="{{ $city->id }}" wire:key="{{ $city->id }}">
                    {{ $city->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
    </x-common.card-filter>
    <x-common.container-table>
        <div class="flex justify-end mb-2">
            <livewire:components.modal-columns :columns="$this->form->columns"
                :columns-selected="$this->form->columnsSelected" />
        </div>
        <flux:table :paginate="$this->form->results()">
            <flux:table.columns>
                @if (in_array('client_full_name', $this->form->columnsSelected))
                    <flux:table.column>Client Name</flux:table.column>
                @endif
                @if (in_array('client_address_formatted', $this->form->columnsSelected))
                    <flux:table.column>Client Address</flux:table.column>
                @endif
                @if (in_array('client_dob', $this->form->columnsSelected))
                    <flux:table.column>Client Date of Birth</flux:table.column>
                @endif
                @if (in_array('client_ssn', $this->form->columnsSelected))
                    <flux:table.column>Client SSN</flux:table.column>
                @endif
                @if (in_array('client_effective_date', $this->form->columnsSelected))
                    <flux:table.column>Client Effective Date</flux:table.column>
                @endif
                @if (in_array('client_meal_number', $this->form->columnsSelected))
                    <flux:table.column>Client Meal Number</flux:table.column>
                @endif
                @if (in_array('client_legal_status', $this->form->columnsSelected))
                    <flux:table.column>Client Legal Status</flux:table.column>
                @endif
                @if (in_array('client_identification_type', $this->form->columnsSelected))
                    <flux:table.column>Client ID Type</flux:table.column>
                @endif
                @if (in_array('client_identification_number', $this->form->columnsSelected))
                    <flux:table.column>Client ID Number</flux:table.column>
                @endif
                @if (in_array('client_identification_expiration_date', $this->form->columnsSelected))
                    <flux:table.column>Client ID Expiration Date</flux:table.column>
                @endif
                @if (in_array('client_city_district', $this->form->columnsSelected))
                    <flux:table.column>Client City District</flux:table.column>
                @endif
                @if (in_array('client_county_district', $this->form->columnsSelected))
                    <flux:table.column>Client County District</flux:table.column>
                @endif
                @if (in_array('client_city', $this->form->columnsSelected))
                    <flux:table.column>Client City</flux:table.column>
                @endif
                @if (in_array('client_email', $this->form->columnsSelected))
                    <flux:table.column>Client Email</flux:table.column>
                @endif
                @if (in_array('client_income_type', $this->form->columnsSelected))
                    <flux:table.column>Client Income Type</flux:table.column>
                @endif
                @if (in_array('client_income', $this->form->columnsSelected))
                    <flux:table.column>Client Income</flux:table.column>
                @endif

                @if (in_array('client_gender', $this->form->columnsSelected))
                    <flux:table.column>Client Gender</flux:table.column>
                @endif
                @if (in_array('client_is_deceased', $this->form->columnsSelected))
                    <flux:table.column>Client Is Deceased</flux:table.column>
                @endif
                @if (in_array('client_ethnicity', $this->form->columnsSelected))
                    <flux:table.column>Client Ethnicity</flux:table.column>
                @endif
                @if (in_array('client_healthcare_provider', $this->form->columnsSelected))
                    <flux:table.column>Client Healthcare Provider</flux:table.column>
                @endif
                @if (in_array('client_healthcare_provider_plan', $this->form->columnsSelected))
                    <flux:table.column>Client Healthcare Provider Plan</flux:table.column>
                @endif
                @if (in_array('client_housing_status', $this->form->columnsSelected))
                    <flux:table.column>Client Housing Status</flux:table.column>
                @endif
                @if (in_array('client_income_category', $this->form->columnsSelected))
                    <flux:table.column>Client Income Category</flux:table.column>
                @endif
                @if (in_array('client_service_specialist', $this->form->columnsSelected))
                    <flux:table.column>Client Service Specialist</flux:table.column>
                @endif
                @if (in_array('code', $this->form->columnsSelected))
                    <flux:table.column>Code</flux:table.column>
                @endif
                @if (in_array('program_branch', $this->form->columnsSelected))
                    <flux:table.column>Program Branch</flux:table.column>
                @endif
                @if (in_array('delivery_cost', $this->form->columnsSelected))
                    <flux:table.column>Delivery Cost</flux:table.column>
                @endif
                @if (in_array('food_cost', $this->form->columnsSelected))
                    <flux:table.column>Food Cost</flux:table.column>
                @endif
                @if (in_array('program_delivery_cost', $this->form->columnsSelected))
                    <flux:table.column>Program Delivery Cost</flux:table.column>
                @endif
                @if (in_array('termination_reason', $this->form->columnsSelected))
                    <flux:table.column>Termination Reason</flux:table.column>
                @endif
                @if (in_array('is_active', $this->form->columnsSelected))
                    <flux:table.column>Is Active</flux:table.column>
                @endif
                @if (in_array('recertification_date', $this->form->columnsSelected))
                    <flux:table.column>Re-Certification Date</flux:table.column>
                @endif
                @if (in_array('notes', $this->form->columnsSelected))
                    <flux:table.column>Notes</flux:table.column>
                @endif
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->form->results() as $result)
                    <flux:table.row :key="$result->id">
                        @if (in_array('client_full_name', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->full_name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_address_formatted', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->address_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('client_dob', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->dob_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('client_ssn', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->howpa_ssn }}</flux:table.cell>
                        @endif
                        @if (in_array('client_effective_date', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->effective_date_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('client_meal_number', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->meal_number }}</flux:table.cell>
                        @endif
                        @if (in_array('client_legal_status', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->legalStatus?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_identification_type', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->identificationType?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_identification_number', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->identification_number }}</flux:table.cell>
                        @endif
                        @if (in_array('client_identification_expiration_date', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->identification_expiration_date_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('client_city_district', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->cityDistrict?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_county_district', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->countyDistrict?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_city', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->city?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_email', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->email }}</flux:table.cell>
                        @endif
                        @if (in_array('client_income_type', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->incomeType?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_income', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->income_formatted }}</flux:table.cell>
                        @endif

                        @if (in_array('client_gender', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->gender?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_is_deceased', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->is_deceased ? 'Yes' : 'No' }}</flux:table.cell>
                        @endif
                        @if (in_array('client_ethnicity', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->ethnicity?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_healthcare_provider', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->healthcareProvider?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_healthcare_provider_plan', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->healthcareProviderPlan?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_housing_status', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->housingStatus?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('client_income_category', $this->form->columnsSelected))
                            <flux:table.cell>
                                <flux:badge color="green">{{ $result->client?->incomeCategory }}</flux:badge>
                            </flux:table.cell>
                        @endif
                        @if (in_array('client_service_specialist', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client_service_specialist_name ?? "" }}</flux:table.cell>
                        @endif
                        @if (in_array('code', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->code }}</flux:table.cell>
                        @endif
                        @if (in_array('program_branch', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->programBranch?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('delivery_cost', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->deliveryCost?->formattedCurrency }}</flux:table.cell>
                        @endif
                        @if (in_array('food_cost', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->foodCost?->formattedCurrency }}</flux:table.cell>
                        @endif
                        @if (in_array('program_delivery_cost', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->programDeliveryCost?->formattedCurrency }}</flux:table.cell>
                        @endif
                        @if (in_array('termination_reason', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->terminationReason?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('is_active', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->is_active ? 'Yes' : 'No' }}</flux:table.cell>
                        @endif
                        @if (in_array('recertification_date', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->recertification_date_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('notes', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->notes }}</flux:table.cell>
                        @endif
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
