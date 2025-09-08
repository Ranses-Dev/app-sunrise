<div >
    <x-page-heading title="Edit Client: {{ $this->form->clientNumber }}" />
    <div class="form">
        <form wire:submit.prevent="update"  >
                {{-- Personal Information Card --}}

                     <x-common.form-header title="Personal Information" />
                        <flux:input wire:model="form.firstName" label="First Name" />
                        <flux:input wire:model="form.lastName" label="Last Name" />
                        <flux:date-picker wire:model="form.dob" label="Date of Birth" type="date" selectable-header
                            with-today />
                        <flux:date-picker wire:model="form.effectiveDate" type="date" label="Effective Date"
                            selectable-header with-today />
                        <flux:input wire:model="form.ssn" mask="9999" type="password" viewable label="SSN" />
                        <flux:select wire:model="form.housingStatusId" variant="listbox" clearable searchable
                            label="Housing Status" filter>
                            @if($this->form->housingStatuses)
                                @foreach ($this->form->housingStatuses as $status)
                                    <flux:select.option value="{{ $status->id }}" wire:key="{{ $status->id }}">
                                        {{ $status->name }}
                                    </flux:select.option>
                                @endforeach
                            @endif
                        </flux:select>
                        <flux:select wire:model.live="form.healthcareProviderId" variant="listbox" clearable searchable
                            label="Healthcare Provider" filter>
                            @foreach ($this->form->healthcareProviders as $healthcareProvider)
                                <flux:select.option value="{{ $healthcareProvider->id }}"
                                    wire:key="{{ $healthcareProvider->id }}">
                                    {{ $healthcareProvider->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:select wire:model.live="form.healthcareProviderPlanId" variant="listbox" clearable
                            searchable label="Healthcare Provider Plan" filter>
                            @foreach ($this->form->healthcareProviderPlans as $healthcareProviderPlan)
                                <flux:select.option value="{{ $healthcareProviderPlan->id }}"
                                    wire:key="{{ $healthcareProviderPlan->id }}">
                                    {{ $healthcareProviderPlan->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
 <flux:select wire:model.live="form.incomeTypeId" variant="listbox" clearable
                            searchable label="Income Type" filter>
                            @foreach ($this->form->incomeTypes as $incomeType)
                                <flux:select.option value="{{ $incomeType->id }}"
                                    wire:key="{{ $incomeType->id }}">
                                    {{ $incomeType->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:fieldset>
                            <div class="space-y-3">
                                <flux:switch label="Is Deceased" align="left" wire:model="form.isDeceased" />
                                <flux:switch label="Hispanic" align="left" wire:model="form.hispanic" />
                            </div>
                    </flux:fieldset>



                {{-- Identification Card --}}


                      <x-common.form-header title="Identification" />

                        <flux:select wire:model="form.legalStatusId" variant="listbox" clearable searchable
                            label="Legal Status" filter>
                            @foreach ($this->form->statuses as $status)
                                <flux:select.option value="{{ $status->id }}" wire:key="{{ $status->id }}">
                                    {{ $status->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model="form.identificationTypeId" variant="listbox" clearable searchable
                            label="Identification Type" filter>
                            @foreach ($this->form->identificationTypes as $identificationType)
                                <flux:select.option value="{{ $identificationType->id }}"
                                    wire:key="{{ $identificationType->id }}">
                                    {{ $identificationType->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:input uppercase wire:model="form.identificationNumber" label="Identification Number" />

                        <flux:date-picker wire:model="form.identificationExpirationDate" type="date"
                            label="Identification Expiration Date" selectable-header with-today />

                    <div class="mt-4">
                        <flux:tab.group>
                            <flux:tabs wire:model.live="tabPicture">
                                <flux:tab name="actual-picture">Existing Picture</flux:tab>
                                <flux:tab name="upload-picture">Upload File</flux:tab>
                                <flux:tab name="take-picture">Take Picture</flux:tab>
                            </flux:tabs>
                            <flux:tab.panel name="actual-picture">
                                @if ($this->form->existsFileIdentificationCard)
                                    <div class="flex justify-center items-center w-full">
                                        <flux:link href="{{ route('clients.download.picture', $this->form->id) }}" external
                                            variant="ghost">
                                            <div class="flex flex-row space-x-2">
                                                <flux:icon.arrow-down-tray />
                                                <span> Download
                                                </span>
                                            </div>
                                        </flux:link>
                                    </div>
                                @endif
                            </flux:tab.panel>
                            <flux:tab.panel name="upload-picture">
                                <div class="flex justify-center items-center">
                                    <flux:input type="file" accept="image/*,application/pdf"
                                        wire:model="form.identificationPicture" />
                                </div>
                                <flux:error name="form.identificationPicture" />
                            </flux:tab.panel>
                            <flux:tab.panel name="take-picture"> @livewire('components.camera-capture')
                                @if ($this->form->identificationPictureBase64)
                                    <div class="rounded-md   m-4 border-2  border-gray-500">
                                        <img src="{{ $this->form->identificationPictureBase64 }}" alt="Captured Image"
                                            class="w-full h-auto   " />
                                    </div>
                                @endif
                                <div class="flex justify-center">
                                    <flux:button wire:click='showCamera'>Take Picture</flux:button>
                                </div>
                                <flux:error name="form.identificationPictureBase64" />
                            </flux:tab.panel>
                        </flux:tab.group>
                    </div>





                    <x-common.form-header title="Income Information" />

                        <flux:checkbox.group variant="cards" class="flex-col">
                            <flux:checkbox wire:model.live='form.editAddPayment' value="newsletter"
                                icon="currency-dollar" label="Add or Edit Payments"
                                description="These payments will be used to calculate the client's income." />
                            <flux:radio.group :disabled="!$this->form->editAddPayment"
                                wire:model="form.frequencyPayment" label="Frequency Income" variant="cards"
                                class="max-sm:flex-col">
                                @foreach (\App\Enums\PaymentFrequency::cases() as $frequency)
                                    <flux:radio value="{{ $frequency->value }}" label="{{ $frequency->label() }}" />
                                @endforeach
                            </flux:radio.group>
                        </flux:checkbox.group>
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col justify-between space-y-2">
                                <flux:input :disabled="!$this->form->editAddPayment" wire:model="form.paymentAmount"
                                    type="number" size="sm" label="Income Amount" placeholder="Enter payment amount" />
                                <flux:button size="sm" :disabled="!$this->form->editAddPayment" wire:click='addPayment'
                                    type="button" icon="plus" variant="primary">Add Payment
                                </flux:button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($this->form->paymentAmounts as $index => $payment)
                                    <flux:badge wire:key="{{ $index }}" color="emerald" class="w-min">
                                        {{ $payment }}
                                        <flux:badge.close wire:click="deletePayment({{ $payment }})" />
                                    </flux:badge>
                                @endforeach
                            </div>
                        </div>


                {{-- Contact & Demographics --}}



                       <x-common.form-header title="Contact & Demographics" />
                        <div class="col-span-2">
                            <flux:input type="email" wire:model="form.email" label="Email" />
                        </div>
                        <flux:select wire:model="form.genderId" variant="listbox" clearable searchable label="Gender"
                            filter>
                            @foreach ($this->form->genders as $gender)
                                <flux:select.option value="{{ $gender->id }}" wire:key="{{ $gender->id }}">
                                    {{ $gender->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model="form.ethnicityId" variant="listbox" clearable searchable
                            label="Ethnicity" filter>
                            @foreach ($this->form->ethnicities as $ethnicity)
                                <flux:select.option value="{{ $ethnicity->id }}" wire:key="{{ $ethnicity->id }}">
                                    {{ $ethnicity->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.live="form.cityDistrictId" variant="listbox" clearable searchable
                            label="City District" filter>
                            @foreach ($this->form->cityDistricts as $cityDistrict)
                                <flux:select.option value="{{ $cityDistrict->id }}" wire:key="{{ $cityDistrict->id }}">
                                    {{ $cityDistrict->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.live="form.countyDistrictId" variant="listbox" clearable searchable
                            label="County District" filter>
                            @foreach ($this->form->countyDistricts as $countyDistrict)
                                <flux:select.option value="{{ $countyDistrict->id }}" wire:key="{{ $countyDistrict->id }}">
                                    {{ $countyDistrict->name }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.live="form.cityId" variant="listbox" clearable searchable label="City"
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
                                <x-common.summary-item label="Postal Code"
                                    value="{{ $this->form->addressPostalCode }}" />
                                <x-common.summary-item label="County" value="{{ $this->form->addressCountyName }}" />
                                <x-common.summary-item label="City" value="{{ $this->form->addressCityName }}" />
                                <x-common.summary-item label="State"
                                    value="{{ $this->form->addressStateAbbreviation }}" />
                            </div>
                            <div>
                                 <livewire:components.common.address-search-select @selected="handleSelectedAddress($event.detail.addressId)" />
                            </div>
                        </div>
                        <flux:error name="form.addressId" />





            {{-- Action Buttons --}}
            <flux:button.group class="justify-end  ">
                <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
                <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
            </flux:button.group>
        </form>
    </div>
    <flux:tab.group>
        <flux:tabs wire:model="tabRelationships">
            <flux:tab name="client-files">Attachments</flux:tab>
            <flux:tab name="household-members">Household Members</flux:tab>
            <flux:tab name="client-phone-numbers">Phone Numbers</flux:tab>
            <flux:tab name="client-emergency-contacts">Emergency Contacts</flux:tab>
        </flux:tabs>
        <flux:tab.panel name="client-files">
            <livewire:client.relationships.client-files wire:key='client-files' :clientId="$this->form->id" />
        </flux:tab.panel>
        <flux:tab.panel name="household-members">
            <livewire:client.relationships.household-members wire:key='household-members' :clientId="$this->form->id" />
        </flux:tab.panel>
        <flux:tab.panel name="client-phone-numbers">
            <livewire:client.relationships.client-phone-numbers wire:key='client-phone-numbers'
                :clientId="$this->form->id" />
        </flux:tab.panel>
        <flux:tab.panel name="client-emergency-contacts">
            <livewire:client.relationships.emergency-contact wire:key='client-emergency-contacts'
                :clientId="$this->form->id" />
        </flux:tab.panel>
    </flux:tab.group>
</div>
