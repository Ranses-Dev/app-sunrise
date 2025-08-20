<div class="space-y-4">
    <x-page-heading title="Create Contract Howpa" />
    <div class="grid  grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <form wire:submit.prevent="create" class="col-span-3 grid grid-cols-3 gap-4">
            <flux:card class="space-y-4">
                <flux:heading size="lg">Client Information</flux:heading>
                <div class="flex flex-row gap-4 justify-end items-end">
                    <livewire:components.common.client-search-select />
                    @if($this->form->client)
                        <flux:button wire:click="clearClient" variant="danger" icon="x-mark">Clear Client
                        </flux:button>
                    @endif
                </div>
                <div class="grid grid-cols-3 justify-center items-center gap-1">
                    @session('ssnSearch')
                        <div class="col-span-3">
                            <x-common.alert-information text="{{ session('ssnSearch') }}" />
                        </div>
                    @endsession
                    <flux:error class="col-span-3" name="ssnSearch" />
                    @if ($this->form->client)
                        <div class="grid grid-cols-3 gap-4 col-span-3">
                            <x-common.summary-item label="Full Name" value="{{ $this->form->client->full_name }}" />
                            <x-common.summary-item label="Client Number" value="{{ $this->form->client->client_number }}" />
                            <x-common.summary-item label="Address" value="{{ $this->form->client->address }}" />
                            <div class="grid grid-cols-2 col-span-3 gap-4">
                                <flux:input type="text" label="SSN" mask="999-99-9999" wire:model='form.howpaSsn' />
                                <flux:input type="text" label="Howpa Client Number" wire:model='form.howpaClientNumber' />
                            </div>
                            <div class="grid grid-cols-2 col-span-3 gap-4">
                                <flux:date-picker label="Date" wire:model='form.date' selectable-header with-today />
                                <flux:date-picker label="Re-Certification Date" wire:model='form.reCertificationDate'
                                    selectable-header with-today />
                            </div>
                            <div class="grid grid-cols-2 col-span-3 gap-4">
                                <flux:select label="Program Branch" wire:model.live='form.programBranchId' clearable
                                    variant="listbox" searchable placeholder="Program Branches...">
                                    @if ($this->form->programBranches)
                                        @foreach($this->form->programBranches as $programBranch)
                                            <flux:select.option value="{{ $programBranch->id }}">{{ $programBranch->name }}
                                            </flux:select.option>
                                        @endforeach
                                    @endif
                                </flux:select>
                                <flux:select label="Client Service Specialist" wire:model='form.clientServiceSpecialistId'
                                    clearable variant="listbox" searchable placeholder="Client Service Specialists...">
                                    @if ($this->form->clientServiceSpecialists)
                                        @foreach($this->form->clientServiceSpecialists as $clientServiceSpecialist)
                                            <flux:select.option value="{{ $clientServiceSpecialist->id }}">
                                                {{ $clientServiceSpecialist->name }}
                                            </flux:select.option>
                                        @endforeach
                                    @endif
                                </flux:select>
                            </div>
                            <div class="grid grid-cols-2 col-span-3 gap-4">
                                <flux:select label="City" wire:model='form.cityId' clearable variant="listbox" searchable
                                    placeholder="Choose cities...">
                                    @if ($this->form->cities)
                                        @foreach($this->form->cities as $city)
                                            <flux:select.option value="{{ $city->id }}">{{ $city->name }}
                                            </flux:select.option>
                                        @endforeach
                                    @endif
                                </flux:select>
                                <flux:select wire:model='form.clientPhoneNumberId' label="Phone" variant="listbox" clearable
                                    searchable placeholder="Choose phone...">
                                    @if($this->form->clientPhoneNumbers)
                                        @forelse($this->form->clientPhoneNumbers as $phoneNumber)
                                            <flux:select.option value="{{ $phoneNumber->id }}">
                                                {{ $phoneNumber->phone_number }}
                                            </flux:select.option>
                                        @empty
                                            <flux:select.option disabled>No phone numbers found</flux:select.option>
                                        @endforelse
                                    @endif
                                </flux:select>
                            </div>
                            <div class="grid grid-cols-2 col-span-3 gap-4">
                                <flux:input type="number" label="Number of Bedrooms Required"
                                    wire:model='form.numberBedroomsReq' />
                                <flux:input type="number" label="Number of Bedrooms Approved"
                                    wire:model='form.numberBedroomsApproved' />
                            </div>
                        </div>
                    @endif
                    <flux:error class="col-span-3" name="form.clientId" />
                </div>
            </flux:card>
            <flux:card class="space-y-4">
                <flux:heading size="lg">Household Income & Assets</flux:heading>
                @if (!$this->form->client)
                    <x-common.alert-information text="Please search for a client to view their income and assets." />
                @else
                    <div class="grid grid-cols-3 justify-center items-center gap-4">
                        <div class="grid col-span-3 grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <flux:input icon="currency-dollar" label="Annual Gross Income" readonly
                                    value="{{ $this->form->client->total_income }}" />
                            </div>
                            <div class="col-span-1">
                                <flux:input icon="currency-dollar" label="Monthly Gross Income" readonly
                                    value="{{ $this->form->client->total_income_monthly }}" />
                            </div>
                        </div>
                        <div class="col-span-3 space-y-4">
                            <div class="py-2">
                                <span class="text-sm text-gray-500 ">If you check any of the boxes below, please
                                    describe/list in
                                    the space provided.</span>
                            </div>
                            <flux:checkbox.group>
                                <flux:checkbox
                                    label="Applicant or any of household members own or have an interest in any real estate, boat, and/or mobile home."
                                    value="{{ true }}" wire:model.live='form.ownsRealEstate' />
                                <flux:checkbox label="Own any stock or bonds" wire:model.live='form.ownAnyStockOrBonds'
                                    value="{{ true }}" />
                                <flux:checkbox label="Have Savings Account" wire:model.live='form.hasSavings'
                                    value="{{ true }}" />
                                <flux:checkbox label="Have Checking Account" wire:model.live='form.hasCheckingAccount'
                                    value="{{ true }}" />
                            </flux:checkbox.group>
                        </div>
                        <div class="grid col-span-3 grid-cols-2 justify-center gap-2">
                            <flux:field>
                                <flux:label>Saving Account</flux:label>
                                <flux:input type="numeric" :disabled="!$this->form->hasSavings" icon="currency-dollar"
                                    wire:model='form.savingsBalance' />
                                <flux:description>List current balance in Savings Account.</flux:description>
                                <flux:error name="form.savingsBalance" />
                            </flux:field>
                            <flux:field>
                                <flux:label>Checking Account</flux:label>
                                <flux:input type="numeric" :disabled="!$this->form->hasCheckingAccount"
                                    wire:model='form.checkingAvgBalanceSixMonths' icon="currency-dollar" />
                                <flux:description>Average Balance Checking Account for the past 6 months
                                </flux:description>
                                <flux:error name="form.checkingAvgBalanceSixMonths" />
                            </flux:field>
                        </div>
                        <div class="col-span-3">
                            <flux:textarea wire:model="form.assetsNotes" label="Assets Notes" />
                        </div>
                    </div>
                @endif
            </flux:card>
            <flux:card class="space-y-4">
                <flux:heading size="lg">Recent Living Situation</flux:heading>
                @if (!$this->form->client)
                    <x-common.alert-information
                        text="Please search for a client to specify their recent living situation." />
                @else
                    <flux:radio.group wire:model.live="form.recentLivingSituation"
                        label="Select your recent living situation">
                        <div class="grid grid-cols-2 gap-2">
                            @if ($this->form->recentLivingSituations)
                                @foreach ($this->form->recentLivingSituations as $situation)
                                    <flux:radio value="{{ $situation->name }}" label="{{ $situation->value }}" />
                                @endforeach
                            @endif
                        </div>
                    </flux:radio.group>
                    <flux:textarea
                        :disabled="$this->form->recentLivingSituation!=App\Enums\RecentLivingSituation::OTHER->name"
                        wire:model="form.recentLivingSituationNotes" label="Describe your recent living situation" />
                @endif
            </flux:card>
            <div class="col-span-3">
                <livewire:howpa-contract.relationships.households wire:key="households-{{ $this->form->clientId }}"
                    clientId="{{ $this->form->clientId }}" />
            </div>
            <div class="col-span-3">
                <flux:card class="space-y-4">
                    <flux:heading>Relative / Friend information</flux:heading>
                    @if (!$this->form->client)
                        <x-common.alert-information
                            text="Please search for a client to specify their relative information." />
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 space-y-4 gap-4">
                            <div class="col-span-1 md:col-span-2 sm:w-full md:w-1/2 lg:w-1/3">
                                <flux:select variant="listbox" wire:model='form.emergencyContactId' searchable
                                    placeholder="Choose emergency contacts...">
                                    @if ($this->form->emergencyContacts)
                                        @foreach ($this->form->emergencyContacts as $contact)
                                            <flux:select.option value="{{ $contact->id }}">
                                                {{ $contact->name }}
                                            </flux:select.option>
                                        @endforeach
                                    @endif
                                </flux:select>
                            </div>
                            <div class="grid grid-cols-4 w-full md:w-1/2 lg:w-3/4 gap-4">

                                <div class="col-span-3 space-y-4">
                                    <x-common.summary-item label="Full Name"
                                        value="{{ $this->form->emergencyContactOne->name ?? '' }}" />
                                    <x-common.summary-item label="Address"
                                        value="{{ $this->form->emergencyContactOne->address ?? '' }}" />
                                    <x-common.summary-item label="Relationship"
                                        value="{{ $this->form->emergencyContactOne?->householdRelationType?->name ?? '' }}" />
                                    <x-common.summary-item label="Phone"
                                        value="{{ $this->form->emergencyContactOne?->phone_number ?? '' }}" />
                                </div>

                                <div class="flex flex-col justify-center items-center">
                                    @if (!$this->form->emergencyContactOne)
                                        <flux:button icon="plus" wire:click='addEmergencyContactOne' variant="primary">Add
                                        </flux:button>
                                    @else
                                        <flux:button icon="trash" wire:click='removeEmergencyContactOne' variant="danger">Remove
                                        </flux:button>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-4 w-full md:w-1/2 lg:w-3/4 gap-4">
                                <div class="col-span-3 space-y-4">
                                    <x-common.summary-item label="Full Name"
                                        value="{{ $this->form->emergencyContactTwo->name ?? '' }}" />
                                    <x-common.summary-item label="Address"
                                        value="{{ $this->form->emergencyContactTwo->address ?? '' }}" />
                                    <x-common.summary-item label="Relationship"
                                        value="{{ $this->form->emergencyContactTwo?->householdRelationType?->name ?? '' }}" />
                                    <x-common.summary-item label="Phone"
                                        value="{{ $this->form->emergencyContactTwo?->phone_number ?? '' }}" />
                                </div>
                                <div class="flex flex-col justify-center items-center">
                                    @if (!$this->form->emergencyContactTwo)
                                        <flux:button icon="plus" wire:click='addEmergencyContactTwo' variant="primary">Add
                                        </flux:button>
                                    @else
                                        <flux:button icon="trash" wire:click='removeEmergencyContactTwo' variant="danger">Remove
                                        </flux:button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endif
                </flux:card>
            </div>

            <div class="col-span-3 flex justify-end items-end">
                <flux:button.group class="buttons">
                    <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
                    <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
                    <flux:button type="button" wire:click="createAndAddNew" icon="squares-plus" variant="filled">
                        Save & New
                    </flux:button>
                </flux:button.group>
            </div>
        </form>
    </div>




</div>
