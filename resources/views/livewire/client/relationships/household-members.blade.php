<div class="space-y-4">
    <div class="flex justify-between">
        <flux:input wire:model.live.debounce1000="search" class="input-search" icon="magnifying-glass"
            placeholder="Search ..." />
        <flux:button wire:click="openModal" variant="primary" icon="plus">Create</flux:button>
    </div>
    <flux:table :paginate="$this->results">
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>DOB</flux:table.column>
            <flux:table.column>Age</flux:table.column>
            <flux:table.column>Gender</flux:table.column>
            <flux:table.column>Relation</flux:table.column>
            <flux:table.column>Ethnicity</flux:table.column>
            <flux:table.column>Monthly Income</flux:table.column>
            <flux:table.column>Annual Income</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->results as $result)
                <flux:table.row :key="$result->id">
                    <flux:table.cell>{{ $result->full_name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->dob_formatted }}</flux:table.cell>
                    <flux:table.cell>{{ $result->age }}</flux:table.cell>
                    <flux:table.cell>{{ $result->gender_name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->household_relation_type_name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->ethnicity_name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->monthly_income }}</flux:table.cell>
                    <flux:table.cell>{{ $result->formatted_income }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                            <flux:menu>

                                <flux:menu.item wire:click="edit({{$result->id}})" icon="pencil-square">Edit
                                </flux:menu.item>
                                <flux:menu.item wire:click="delete({{$result->id}})" icon="trash" variant="danger">Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
    <flux:modal :closable="false" name='confirm-delete-household-member'>
        <flux:heading size="lg">Confirm Delete</flux:heading>
        <p>Are you sure you want to delete this household member?</p>
        <div class="flex justify-end">
            <flux:button.group>
                <flux:button wire:click='cancelDelete' icon="no-symbol">Cancel</flux:button>
                <flux:button wire:click='confirmDelete' icon="trash" variant="primary" color="red">Delete</flux:button>
            </flux:button.group>
        </div>
    </flux:modal>

    <flux:modal name="edit-household-member" wire:model='showModal' wire:close='hideModal' class="min-w-max">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-2 gap-2">
                <x-forms.card-form title="{{$this->form->id ? 'Edit ' : 'Create '}} Household Member">

                    <flux:select wire:model='form.householdRelationTypeId' variant="listbox" clearable
                        placeholder="Choose  ..." label="Household Relation Type" searchable>
                        @if ($this->form->householdRelationTypes)
                            @foreach ($this->form->householdRelationTypes as $householdRelationType)
                                <flux:select.option value="{{ $householdRelationType->id }}">{{$householdRelationType->name}}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>

                    <flux:select wire:model='form.ethnicityId' variant="listbox" clearable placeholder="Choose  ..."
                        label="Ethnicity" searchable>
                        @if ($this->form->ethnicities)
                            @foreach ($this->form->ethnicities as $ethnicity)
                                <flux:select.option value="{{ $ethnicity->id }}">{{$ethnicity->name}}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>

                    <flux:select wire:model='form.genderId' variant="listbox" clearable placeholder="Choose  ..."
                        label="Gender">
                        @if ($this->form->genders)
                            @foreach ($this->form->genders as $gender)
                                <flux:select.option value="{{ $gender->id }}">{{$gender->name}}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>

                    <flux:input label="First Name" wire:model='form.firstName' placeholder="First Name" />
                    <flux:input label="Last Name" wire:model='form.lastName' placeholder="Last Name" />
                    <flux:date-picker label="DOB" with-today selectable-header wire:model='form.dob' />
                    <flux:input label="SSN" wire:model='form.ssn' mask="999-99-9999" placeholder="SSN" />

                </x-forms.card-form>
                <x-forms.card-form title="Income Information">
                    <div class="grid grid-cols-1   gap-4">
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
                    </div>
                </x-forms.card-form>
            </div>
            <div class="flex mt-4">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
