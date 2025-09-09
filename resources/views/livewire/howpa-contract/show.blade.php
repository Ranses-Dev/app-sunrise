<div>
    <x-page-heading title="Show HOWPA Contract" />
    <div class="show-information">
        <div class="detail-information">
            <x-common.form-header title="Client Information" />

            <div class="space-y-4">
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
                        <x-common.summary-item label="Address"
                            value="{{ $this->form->client->address?->address_formatted }}" />
                    </div>
                    <flux:input disabled type="text" label="SSN" mask="999-99-9999" wire:model='form.howpaSsn' />
                    <flux:input disabled type="text" label="Howpa Client Number" wire:model='form.howpaClientNumber' />
                    <flux:select disabled label="Income Type" wire:model.live='form.incomeTypeId' variant="listbox"
                        placeholder="Income Types...">
                        @if ($this->form->incomeTypes)
                            @foreach($this->form->incomeTypes as $incomeType)
                                <flux:select.option value="{{ $incomeType->id }}">{{ $incomeType->name }}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                    <flux:date-picker disabled label="Date" wire:model='form.date' selectable-header with-today />
                    <flux:date-picker disabled label="Enrollment Day" wire:model='form.enrollmentDay' selectable-header
                        with-today />
                    <flux:date-picker disabled label="Re-Certification Date" wire:model='form.reCertificationDate'
                        selectable-header with-today />
                    <flux:switch disabled label="Is Active" align="left" wire:model="form.isActive" />

                    <flux:select disabled label="Program Branch" wire:model.live='form.programBranchId' variant="listbox"
                        placeholder="Program Branches...">
                        @if ($this->form->programBranches)
                            @foreach($this->form->programBranches as $programBranch)
                                <flux:select.option value="{{ $programBranch->id }}">{{ $programBranch->name }}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                    <flux:select disabled label="Client Service Specialist" wire:model='form.clientServiceSpecialistId'
                        variant="listbox" placeholder="Client Service Specialists...">
                        @if ($this->form->clientServiceSpecialists)
                            @foreach($this->form->clientServiceSpecialists as $clientServiceSpecialist)
                                <flux:select.option value="{{ $clientServiceSpecialist->id }}">
                                    {{ $clientServiceSpecialist->name }}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                    <flux:select disabled label="City" wire:model='form.cityId' variant="listbox"
                        placeholder="Choose cities...">
                        @if ($this->form->cities)
                            @foreach($this->form->cities as $city)
                                <flux:select.option value="{{ $city->id }}">{{ $city->name }}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                    <flux:select disabled wire:model='form.clientPhoneNumberId' label="Phone" variant="listbox"
                        placeholder="Choose phone...">
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
                    <flux:input disabled type="number" label="Number of Bedrooms Required"
                        wire:model='form.numberBedroomsReq' />
                    <flux:input disabled type="number" label="Number of Bedrooms Approved"
                        wire:model='form.numberBedroomsApproved' />
                @endif
                <flux:error class="col-span-3" name="form.clientId" />
            </div>
            <x-common.form-header title="Household Income & Assets" />
            @if (!$this->form->client)
                <x-common.alert-information text="Please search for a client to view their income and assets." />
            @else
                <div class="grid grid-cols-3 justify-center items-center gap-4">
                    <div class="grid col-span-3 grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <flux:input disabled icon="currency-dollar" label="Annual Gross Income" readonly
                                value="{{ $this->form->client->total_income }}" />
                        </div>
                        <div class="col-span-1">
                            <flux:input disabled icon="currency-dollar" label="Monthly Gross Income" readonly
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
                            <flux:checkbox disabled
                                label="Applicant or any of household members own or have an interest in any real estate, boat, and/or mobile home."
                                value="{{ true }}" wire:model.live='form.ownsRealEstate' />
                            <flux:checkbox disabled label="Own any stock or bonds" wire:model.live='form.ownAnyStockOrBonds'
                                value="{{ true }}" />
                            <flux:checkbox disabled label="Have Savings Account" wire:model.live='form.hasSavings'
                                value="{{ true }}" />
                            <flux:checkbox disabled label="Have Checking Account" wire:model.live='form.hasCheckingAccount'
                                value="{{ true }}" />
                        </flux:checkbox.group>
                    </div>
                    <div class="grid col-span-3 grid-cols-2 justify-center gap-2">
                        <flux:field>
                            <flux:label>Saving Account</flux:label>
                            <flux:input disabled type="numeric" :disabled="!$this->form->hasSavings" icon="currency-dollar"
                                wire:model='form.savingsBalance' />
                            <flux:description>List current balance in Savings Account.</flux:description>
                            <flux:error name="form.savingsBalance" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Checking Account</flux:label>
                            <flux:input disabled type="numeric" :disabled="!$this->form->hasCheckingAccount"
                                wire:model='form.checkingAvgBalanceSixMonths' icon="currency-dollar" />
                            <flux:description>Average Balance Checking Account for the past 6 months
                            </flux:description>
                            <flux:error name="form.checkingAvgBalanceSixMonths" />
                        </flux:field>
                    </div>
                    <div class="col-span-3">
                        <flux:textarea disabled wire:model="form.assetsNotes" label="Assets Notes" />
                    </div>
                </div>
            @endif


            <x-common.form-header title="Recent Living Situation" />
            @if (!$this->form->client)
                <x-common.alert-information text="Please search for a client to specify their recent living situation." />
            @else
                <flux:radio.group wire:model.live="form.recentLivingSituation" label="Select your recent living situation">
                    <div class="grid grid-cols-2 gap-2">
                        @if ($this->form->recentLivingSituations)
                            @foreach ($this->form->recentLivingSituations as $situation)
                                <flux:radio disabled value="{{ $situation->name }}" label="{{ $situation->value }}" />
                            @endforeach
                        @endif

                    </div>
                </flux:radio.group>
                <flux:textarea :disabled="$this->form->recentLivingSituation!=App\Enums\RecentLivingSituation::OTHER->name"
                    wire:model="form.recentLivingSituationNotes" label="Describe your recent living situation" />
            @endif
            <x-common.form-header title="Relative / Friend information" />
            @if (!$this->form->client)
                <x-common.alert-information text="Please search for a client to specify their relative information." />
            @else
                <div class="grid grid-cols-4 w-full">
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
                </div>
                <flux:separator />
                <div class="grid grid-cols-4 w-full">
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
                </div>
            @endif
            <div class="flex justify-end mt-6">
                <flux:button.group class="buttons">
                    <flux:button wire:click="goBack" variant="primary" type="button" icon="arrow-uturn-left">Go Back
                    </flux:button>
                </flux:button.group>
            </div>
        </div>
    </div>
</div>
