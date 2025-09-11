<div class="space-y-4">
    <x-page-heading title="HOWPA Contracts" />
    <div class="flex justify-end">

        @can('create', \App\Models\HowpaContract::class)
            <flux:button.group>
                <livewire:components.buttons.create-button @create="create" />
                <livewire:components.buttons.export-button @export="export" />
                <livewire:components.buttons.export-excel-button @export="exportExcel" />
            </flux:button.group>
        @endcan
    </div>
    <x-common.card-filter>
        <flux:input wire:model.live.debounce1000="form.filters.search" label="Search" icon="magnifying-glass"
            placeholder="Search ..." />
        <flux:select clearable wire:model.live='form.filters.programBranchId' variant="listbox" label="Program Branch"
            searchable placeholder="Program Branch...">
            @if ($this->form->programBranches)
                @foreach ($this->form->programBranches as $branch)
                    <flux:select.option value="{{ $branch->id }}">{{ $branch->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select clearable wire:model.live='form.filters.clientServiceSpecialistId' variant="listbox"
            label="Client Service Specialist" searchable placeholder="Client Service Specialist...">
            @if ($this->form->clientServiceSpecialists)
                @foreach ($this->form->clientServiceSpecialists as $specialist)
                    <flux:select.option value="{{ $specialist->id }}">{{ $specialist->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.cityDistrictId" variant="listbox" clearable searchable
            label="City District" filter>
            @foreach ($this->form->cityDistrictsFilter as $cityDistrict)
                <flux:select.option value="{{ $cityDistrict->id }}" wire:key="{{ $cityDistrict->id }}">
                    {{ $cityDistrict->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model.live="form.filters.countyDistrictId" variant="listbox" clearable searchable
            label="County District" filter>
            @foreach ($this->form->countyDistrictsFilter as $countyDistrict)
                <flux:select.option value="{{ $countyDistrict->id }}" wire:key="{{ $countyDistrict->id }}">
                    {{ $countyDistrict->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model.live="form.filters.cityId" variant="listbox" clearable searchable label="City" filter>
            @foreach ($this->form->citiesFilter ?? [] as $city)
                <flux:select.option value="{{ $city->id }}" wire:key="{{ $city->id }}">
                    {{ $city->name }}
                </flux:select.option>
            @endforeach
        </flux:select>
        <flux:date-picker clearable label="Date" mode="range" wire:model.live.debounce1000ms='form.filters.rangeDate' />
        <flux:date-picker clearable label="Enrollment Day" mode="range"
            wire:model.live.debounce1000ms='form.filters.rangeEnrollmentDay' />
        <flux:date-picker clearable label="Re-Certification Date" mode="range"
            wire:model.live.debounce1000ms='form.filters.rangeReCertificationDate' />
        <div class="pt-10">
            <flux:switch label="Is Active" align="left" wire:model.live="form.filters.isActive" />
        </div>

    </x-common.card-filter>
    <x-common.container-table>
        <div class="flex justify-end mb-2">
            <livewire:components.modal-columns :columns="$this->form->columns"
                :columns-selected="$this->form->columnsSelected" />
        </div>
        <flux:table :paginate="$this->form->result()">
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
                @if (in_array('client_howpa_number', $this->form->columnsSelected))
                    <flux:table.column>Client HowPA Number</flux:table.column>
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
                @if (in_array('number_bedrooms_req', $this->form->columnsSelected))
                    <flux:table.column>Bedrooms (Requested)</flux:table.column>
                @endif

                @if (in_array('number_bedrooms_approved', $this->form->columnsSelected))
                    <flux:table.column>Bedrooms (Approved)</flux:table.column>
                @endif

                @if (in_array('recent_living_situation', $this->form->columnsSelected))
                    <flux:table.column>Recent Living Situation</flux:table.column>
                @endif

                @if (in_array('recent_living_situation_notes', $this->form->columnsSelected))
                    <flux:table.column>Living Situation Notes</flux:table.column>
                @endif

                @if (in_array('owns_real_estate', $this->form->columnsSelected))
                    <flux:table.column>Owns Real Estate</flux:table.column>
                @endif

                @if (in_array('own_any_stock_or_bonds', $this->form->columnsSelected))
                    <flux:table.column>Owns Stocks/Bonds</flux:table.column>
                @endif

                @if (in_array('has_savings', $this->form->columnsSelected))
                    <flux:table.column>Has Savings</flux:table.column>
                @endif

                @if (in_array('savings_balance', $this->form->columnsSelected))
                    <flux:table.column>Savings Balance</flux:table.column>
                @endif

                @if (in_array('has_checking_account', $this->form->columnsSelected))
                    <flux:table.column>Has Checking Account</flux:table.column>
                @endif

                @if (in_array('checking_avg_balance_six_months', $this->form->columnsSelected))
                    <flux:table.column>Checking Avg Balance (6m)</flux:table.column>
                @endif

                @if (in_array('assets_notes', $this->form->columnsSelected))
                    <flux:table.column>Assets Notes</flux:table.column>
                @endif

                @if (in_array('outside_support', $this->form->columnsSelected))
                    <flux:table.column>Outside Support</flux:table.column>
                @endif

                @if (in_array('outside_support_explanation', $this->form->columnsSelected))
                    <flux:table.column>Outside Support Explanation</flux:table.column>
                @endif

                @if (in_array('committed_fraud_or_asked_to_repay', $this->form->columnsSelected))
                    <flux:table.column>Committed Fraud / Asked to Repay</flux:table.column>
                @endif

                @if (in_array('fraud_explanation', $this->form->columnsSelected))
                    <flux:table.column>Fraud Explanation</flux:table.column>
                @endif

                @if (in_array('has_aids', $this->form->columnsSelected))
                    <flux:table.column>Has AIDS</flux:table.column>
                @endif

                @if (in_array('howpa_prior_to_2023', $this->form->columnsSelected))
                    <flux:table.column>HOWPA Prior to 2023</flux:table.column>
                @endif

                @if (in_array('currently_receiving_other_aid', $this->form->columnsSelected))
                    <flux:table.column>Receiving Other Aid</flux:table.column>
                @endif

                @if (in_array('agreed_statements', $this->form->columnsSelected))
                    <flux:table.column>Agreed Statements</flux:table.column>
                @endif

                @if (in_array('emergency_contact_one', $this->form->columnsSelected))
                    <flux:table.column>Emergency Contact 1</flux:table.column>
                @endif

                @if (in_array('emergency_contact_two', $this->form->columnsSelected))
                    <flux:table.column>Emergency Contact 2</flux:table.column>
                @endif

            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->form->result() as $result)
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
                        @if (in_array('client_howpa_number', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->client?->howpa_number }}</flux:table.cell>
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
                            <flux:table.cell>{{ $result->clientServiceSpecialist?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('number_bedrooms_req', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->number_bedrooms_req }}</flux:table.column>
                        @endif

                        @if (in_array('number_bedrooms_approved', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->number_bedrooms_approved }}</flux:table.column>
                        @endif

                        @if (in_array('recent_living_situation', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->recent_living_situation_formatted }}</flux:table.column>
                        @endif

                        @if (in_array('recent_living_situation_notes', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->recent_living_situation_notes }}</flux:table.column>
                        @endif

                        @if (in_array('owns_real_estate', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->owns_real_estate ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('own_any_stock_or_bonds', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->own_any_stock_or_bonds ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('has_savings', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->has_savings ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('savings_balance', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->savings_balance_formatted }}</flux:table.column>
                        @endif

                        @if (in_array('has_checking_account', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->has_checking_account ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('checking_avg_balance_six_months', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->checking_avg_balance_six_months_formatted }}</flux:table.column>
                        @endif

                        @if (in_array('assets_notes', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->assets_notes }}</flux:table.column>
                        @endif

                        @if (in_array('outside_support', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->outside_support ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('outside_support_explanation', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->outside_support_explanation }}</flux:table.column>
                        @endif

                        @if (in_array('committed_fraud_or_asked_to_repay', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->committed_fraud_or_asked_to_repay ? 'Yes' : 'No' }}
                            </flux:table.column>
                        @endif

                        @if (in_array('fraud_explanation', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->fraud_explanation }}</flux:table.column>
                        @endif

                        @if (in_array('has_aids', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->has_aids ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('howpa_prior_to_2023', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->howpa_prior_to_2023 ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('currently_receiving_other_aid', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->currently_receiving_other_aid ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('agreed_statements', $this->form->columnsSelected))
                            <flux:table.column>{{ $result->agreed_statements ? 'Yes' : 'No' }}</flux:table.column>
                        @endif

                        @if (in_array('emergency_contact_one', $this->form->columnsSelected))
                            <flux:table.column>
                                @if ($result->emergencyContactOne)
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-medium">
                                            {{ $result->emergencyContactOne->name ?? '—' }}
                                        </span>
                                        @php
                                            $phone = $result->emergencyContactOne->phone_number ?? null;
                                            $address = $result->emergencyContactOne->address ?? null;
                                        @endphp
                                        <span class="text-xs text-gray-500">
                                            {{ $address ?: '—' }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $phone ?: '—' }}
                                        </span>
                                    </div>
                                @else
                                    —
                                @endif
                            </flux:table.column>
                        @endif

                        @if (in_array('emergency_contact_two', $this->form->columnsSelected))
                            <flux:table.column>
                                @if ($result->emergencyContactTwo)
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-medium">
                                            {{ $result->emergencyContactTwo->name ?? '—' }}
                                        </span>
                                        @php
                                            $phone = $result->emergencyContactTwo->phone_number ?? null;
                                            $address = $result->emergencyContactTwo->address ?? null;
                                        @endphp
                                        <span class="text-xs text-gray-500">
                                            {{ $address ?: '—' }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $phone ?: '—' }}
                                        </span>
                                    </div>
                                @else
                                    —
                                @endif
                            </flux:table.column>
                        @endif
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                                <flux:menu>
                                    @can('view', $result)
                                        <flux:menu.item icon="eye" wire:click='show({{ $result->id }})'>Show</flux:menu.item>
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
