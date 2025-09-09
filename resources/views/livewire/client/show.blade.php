<div>
    <x-page-heading title="Show Client: {{ $this->form->clientNumber }}" />
    <div class="show-information">
        <div class="detail-information">
            <x-common.form-header title="Personal Information" />
            <flux:input disabled wire:model="form.firstName" label="First Name" />
            <flux:input disabled wire:model="form.lastName" label="Last Name" />
            <flux:date-picker disabled wire:model="form.dob" label="Date of Birth" type="date" selectable-header
                with-today />
            <flux:date-picker disabled wire:model="form.effectiveDate" type="date" label="Effective Date"
                selectable-header with-today />
            <flux:input disabled wire:model="form.ssn" mask="9999" type="password" viewable label="SSN" />
            <flux:select disabled wire:model="form.housingStatusId" variant="listbox" label="Housing Status" filter>
                @if($this->form->housingStatuses)
                    @foreach ($this->form->housingStatuses as $status)
                        <flux:select.option value="{{ $status->id }}" wire:key="{{ $status->id }}">
                            {{ $status->name }}
                        </flux:select.option>
                    @endforeach
                @endif
            </flux:select>
            <flux:select disabled wire:model.live="form.healthcareProviderId" variant="listbox"
                label="Healthcare Provider" filter>
                @isset($this->form->healthcareProviders)

                    @foreach ($this->form->healthcareProviders as $healthcareProvider)
                        <flux:select.option value="{{ $healthcareProvider->id }}" wire:key="{{ $healthcareProvider->id }}">
                            {{ $healthcareProvider->name }}
                        </flux:select.option>
                    @endforeach
                @endisset

            </flux:select>

            <flux:select disabled wire:model.live="form.healthcareProviderPlanId" variant="listbox"
                label="Healthcare Provider Plan" filter>
                @isset($this->form->healthcareProviderPlans)
                    @foreach ($this->form->healthcareProviderPlans as $healthcareProviderPlan)
                        <flux:select.option value="{{ $healthcareProviderPlan->id }}"
                            wire:key="{{ $healthcareProviderPlan->id }}">
                            {{ $healthcareProviderPlan->name }}
                        </flux:select.option>
                    @endforeach
                @endisset

            </flux:select>
            <flux:select disabled wire:model.live="form.incomeTypeId" variant="listbox" label="Income Type" filter>
                @foreach ($this->form->incomeTypes as $incomeType)
                    <flux:select.option value="{{ $incomeType->id }}" wire:key="{{ $incomeType->id }}">
                        {{ $incomeType->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:fieldset>
                <div class="space-y-3">
                    <flux:switch disabled label="Is Deceased" align="left" wire:model="form.isDeceased" />
                    <flux:switch disabled label="Hispanic" align="left" wire:model="form.hispanic" />
                </div>
            </flux:fieldset> {{-- Identification Card --}}


            <x-common.form-header title="Identification" />

            <flux:select disabled wire:model="form.legalStatusId" variant="listbox" label="Legal Status" filter>
                @if ($this->form->statuses)
                    @foreach ($this->form->statuses as $status)
                        <flux:select.option value="{{ $status->id }}" wire:key="{{ $status->id }}">
                            {{ $status->name }}
                        </flux:select.option>
                    @endforeach
                @endif

            </flux:select>
            <flux:select disabled wire:model="form.identificationTypeId" variant="listbox" label="Identification Type"
                filter>
                @if ($this->form->identificationTypes)
                    @foreach ($this->form->identificationTypes as $identificationType)
                        <flux:select.option value="{{ $identificationType->id }}" wire:key="{{ $identificationType->id }}">
                            {{ $identificationType->name }}
                        </flux:select.option>
                    @endforeach
                @endif

            </flux:select>
            <flux:input disabled uppercase wire:model="form.identificationNumber" label="Identification Number" />

            <flux:date-picker disabled wire:model="form.identificationExpirationDate" type="date"
                label="Identification Expiration Date" selectable-header with-today />

            <x-common.form-header title="Income Information" />

            <flux:checkbox.group disabled variant="cards" class="flex-col">
                <flux:checkbox wire:model.live='form.editAddPayment' value="newsletter" icon="currency-dollar"
                    label="Add or Edit Payments"
                    description="These payments will be used to calculate the client's income." />
                <flux:radio.group :disabled="!$this->form->editAddPayment" wire:model="form.frequencyPayment"
                    label="Frequency Income" variant="cards" class="max-sm:flex-col">
                    @foreach (\App\Enums\PaymentFrequency::cases() as $frequency)
                        <flux:radio value="{{ $frequency->value }}" label="{{ $frequency->label() }}" />
                    @endforeach
                </flux:radio.group>
            </flux:checkbox.group>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col justify-between space-y-2">
                    <flux:input disabled wire:model="form.paymentAmount" type="number" size="sm" label="Income Amount"
                        placeholder="Enter payment amount" />
                    <flux:button size="sm" disabled type="button" icon="plus" variant="primary">Add Payment
                    </flux:button>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($this->form->paymentAmounts as $index => $payment)
                        <flux:badge disabled wire:key="{{ $index }}" color="emerald" class="w-min">
                            {{ $payment }}
                            <flux:badge.close />
                        </flux:badge>
                    @endforeach
                </div>
            </div>

            {{-- Contact & Demographics --}}
            <x-common.form-header title="Contact & Demographics" />
            <div class="col-span-2">
                <flux:input disabled type="email" wire:model="form.email" label="Email" />
            </div>
            <flux:select disabled wire:model="form.genderId" variant="listbox" label="Gender" filter>

                @foreach ($this->form->genders as $gender)
                    <flux:select.option value="{{ $gender->id }}" wire:key="{{ $gender->id }}">
                        {{ $gender->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select disabled wire:model="form.ethnicityId" variant="listbox" label="Ethnicity">
                @foreach ($this->form->ethnicities as $ethnicity)
                    <flux:select.option value="{{ $ethnicity->id }}" wire:key="{{ $ethnicity->id }}">
                        {{ $ethnicity->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select disabled wire:model.live="form.cityDistrictId" variant="listbox" label="City District" filter>
                @foreach ($this->form->cityDistricts as $cityDistrict)
                    <flux:select.option value="{{ $cityDistrict->id }}" wire:key="{{ $cityDistrict->id }}">
                        {{ $cityDistrict->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select disabled wire:model.live="form.countyDistrictId" variant="listbox" clearable searchable
                label="County District" filter>
                @foreach ($this->form->countyDistricts as $countyDistrict)
                    <flux:select.option value="{{ $countyDistrict->id }}" wire:key="{{ $countyDistrict->id }}">
                        {{ $countyDistrict->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:select disabled wire:model.live="form.cityId" variant="listbox" clearable searchable label="City"
                filter>
                @foreach ($this->form->cities ?? [] as $city)
                    <flux:select.option value="{{ $city->id }}" wire:key="{{ $city->id }}">
                        {{ $city->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>


            {{-- Address Info --}}


            <x-common.form-header title="Address" />

            <div class="grid grid-cols-4 gap-4 items-center">
                <div class="col-span-3 space-y-4">
                    <x-common.summary-item label="Address" value="{{ $this->form->addressFormatted }}" />
                    <x-common.summary-item label="Postal Code" value="{{ $this->form->addressPostalCode }}" />
                    <x-common.summary-item label="County" value="{{ $this->form->addressCountyName }}" />
                    <x-common.summary-item label="City" value="{{ $this->form->addressCityName }}" />
                    <x-common.summary-item label="State" value="{{ $this->form->addressStateAbbreviation }}" />
                </div>
            </div>
            <flux:error name="form.addressId" />
            {{-- Action Buttons --}}
            <flux:button.group class="justify-end  ">
                <flux:button wire:click="goBack" type="button" variant="primary" icon="arrow-uturn-left">Go Back
                </flux:button>
            </flux:button.group>
        </div>
    </div>

</div>
