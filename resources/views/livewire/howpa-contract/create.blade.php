<div class="space-y-4">
    <x-page-heading title="Create Contract Howpa" />
    <form >
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <flux:card class="space-y-4">
                    <flux:heading size="lg">Client Information</flux:heading>
                    <div class="grid grid-cols-3 justify-center items-center gap-1">
                        @session('ssnSearch')
                            <div class="col-span-3">
                                <x-common.alert-information text="{{ session('ssnSearch') }}" />
                            </div>
                        @endsession
                        <flux:input.group class="col-span-2 w-full">
                            <flux:input wire:model.live="ssnSearch" clearable name="ssnSearch" placeholder="SSN"
                                mask="999-99-9999" />
                            <flux:button icon="magnifying-glass" wire:click="findClientBySsn"></flux:button>
                        </flux:input.group>
                        <flux:error class="col-span-3" name="ssnSearch" />
                        @if ($this->form->client)
                            <div class="grid grid-cols-3 gap-4 col-span-3">
                                <div class="col-span-1">
                                    <flux:input label="Client Name" readonly value="{{ $this->form->client->full_name }}" />
                                </div>
                                <div class="col-span-1">
                                    <flux:input label="Client #" readonly
                                        value="{{ $this->form->client->client_number }}" />
                                </div>
                                <div class="col-span-1">
                                    <flux:date-picker label="Date" wire:model='form.date' selectable-header with-today />
                                </div>
                                <div class="col-span-3">
                                    <flux:input label="Address" readonly value="{{ $this->form->client->address }}" />
                                </div>
                                <div class="grid grid-cols-2 col-span-3 gap-4">
                                    <div>
                                        <flux:select label="City" wire:model='form.cityId' clearable variant="listbox"
                                            searchable placeholder="Choose cities...">
                                            @foreach($this->form->cities as $city)
                                                <flux:select.option value="{{ $city->id }}">{{ $city->name }}
                                                </flux:select.option>
                                            @endforeach
                                        </flux:select>
                                    </div>
                                    <div>
                                        <flux:select label="Phone" variant="listbox" clearable searchable
                                            placeholder="Choose phone...">
                                            @foreach($this->form->clientPhoneNumbers as $phoneNumber)
                                                <flux:select.option value="{{ $phoneNumber->id }}">
                                                    {{ $phoneNumber->phone_number }}
                                                </flux:select.option>
                                            @endforeach
                                        </flux:select>

                                    </div>
                                </div>
                                <div class="col-span-3">
                                    <flux:input label="SSN" readonly value="{{ $this->form->client->ssn }}" />
                                </div>
                            </div>

                        @endif
                    </div>
                </flux:card>
            </div>
            <div>
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
                                <flux:checkbox.group wire:model="notifications">
                                    <flux:checkbox
                                        label="Applicant or any of household members own or have an interest in any real estate, boat, and/or mobile home."
                                        value="push" checked />
                                    <flux:checkbox label="Own any stock or bonds" value="email" checked />
                                    <flux:checkbox label="Have Savings Account" value="app" />
                                    <flux:checkbox label="Have Checking Account" value="sms" />
                                </flux:checkbox.group>

                            </div>
                            <div class="grid col-span-3 grid-cols-2 justify-center gap-2">
                                <flux:field>
                                    <flux:label>Saving Account</flux:label>
                                    <flux:input icon="currency-dollar" />
                                    <flux:description>List current balance in Savings Account.</flux:description>
                                    <flux:error name="username" />
                                </flux:field>
                                <flux:field>
                                    <flux:label>Checking Account</flux:label>
                                    <flux:input icon="currency-dollar" />
                                    <flux:description>Average Balance Checking Account for the past 6 months
                                    </flux:description>
                                    <flux:error name="username" />
                                </flux:field>
                            </div>
                        </div>
                    @endif
                </flux:card>
            </div>

            <div>
                <flux:card class="space-y-4">
                    <flux:heading size="lg">Recent Living Situation</flux:heading>
                    @if (!$this->form->client)
                        <x-common.alert-information
                            text="Please search for a client to specify their recent living situation." />
                    @else
                        <flux:radio.group wire:model.live="form.recentLivingSituation"
                            label="Select your recent living situation">
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($this->form->recentLivingSituations as $situation)
                                    <flux:radio value="{{ $situation->name }}" label="{{ $situation->value }}" />
                                @endforeach
                            </div>
                        </flux:radio.group>
                        <flux:textarea
                            :disabled="$this->form->recentLivingSituation!=App\Enums\RecentLivingSituation::OTHER->name"
                            wire:model="form.recentLivingSituationNotes" label="Describe your recent living situation" />
                    @endif
                </flux:card>
            </div>
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
                                    <flux:field>
                                        <flux:input.group>
                                            <flux:input.group.prefix>Name:</flux:input.group.prefix>
                                            <flux:input wire:model="website" readonly
                                                placeholder="{{ $this->form->emergencyContactOne->name ?? ''  }}" />
                                        </flux:input.group>
                                    </flux:field>
                                    <flux:field>
                                        <flux:input.group>
                                            <flux:input.group.prefix>Address:</flux:input.group.prefix>
                                            <flux:input wire:model="website" readonly
                                                placeholder="{{ $this->form->emergencyContactOne->address ?? ''  }}" />
                                        </flux:input.group>
                                    </flux:field>
                                    <flux:field>
                                        <flux:input.group>
                                            <flux:input.group.prefix>Relationship:</flux:input.group.prefix>
                                            <flux:input wire:model="website" readonly
                                                placeholder="{{ $this->form->emergencyContactOne?->householdRelationType?->name ?? ''  }}" />
                                        </flux:input.group>
                                    </flux:field>
                                    <flux:field>
                                        <flux:input.group>
                                            <flux:input.group.prefix>Phone:</flux:input.group.prefix>
                                            <flux:input wire:model="website" readonly
                                                placeholder="{{ $this->form->emergencyContactOne->phone_number ?? ''  }}" />
                                        </flux:input.group>
                                    </flux:field>
                                </div>
                                <div class="flex flex-col justify-center items-center">
                                    @if (!$this->form->emergencyContactOne)
                                        <flux:button icon="plus" wire:click='addEmergencyContactOne' variant="primary">Add
                                        </flux:button>
                                    @else
                                        <flux:button icon="trash" wire:click='removeEmergencyContactOne' variant="danger">Remove</flux:button>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-4 w-full md:w-1/2 lg:w-3/4 gap-4">
                                <div class="col-span-3 space-y-4">
                                    <flux:field>
                                        <flux:input.group>
                                            <flux:input.group.prefix>Name:</flux:input.group.prefix>
                                            <flux:input wire:model="website" readonly
                                                placeholder="{{ $this->form->emergencyContactTwo?->name ?? ''  }}" />
                                        </flux:input.group>
                                    </flux:field>
                                    <flux:field>
                                        <flux:input.group>
                                            <flux:input.group.prefix>Address:</flux:input.group.prefix>
                                            <flux:input wire:model="website" readonly
                                                placeholder="{{ $this->form->emergencyContactTwo?->address ?? ''  }}" />
                                        </flux:input.group>
                                    </flux:field>
                                    <flux:field>
                                        <flux:input.group>
                                            <flux:input.group.prefix>Relationship:</flux:input.group.prefix>
                                            <flux:input wire:model="website" readonly
                                                placeholder="{{ $this->form->emergencyContactTwo?->householdRelationType?->name ?? ''  }}" />
                                        </flux:input.group>
                                    </flux:field>
                                    <flux:field>
                                        <flux:input.group>
                                            <flux:input.group.prefix>Phone:</flux:input.group.prefix>
                                            <flux:input wire:model="website" readonly
                                                placeholder="{{ $this->form->emergencyContactTwo?->phone_number ?? ''  }}" />
                                        </flux:input.group>
                                    </flux:field>
                                </div>
                                <div class="flex flex-col justify-center items-center">
                                    @if (!$this->form->emergencyContactTwo)
                                        <flux:button icon="plus" wire:click='addEmergencyContactTwo' variant="primary">Add
                                        </flux:button>
                                    @else
                                        <flux:button icon="trash" wire:click='removeEmergencyContactTwo' variant="danger">Remove</flux:button>
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
                    <flux:button  type="button" icon="squares-plus" variant="filled">
                        Save & New
                    </flux:button>
                </flux:button.group>
            </div>
        </div>





    </form>
</div>
