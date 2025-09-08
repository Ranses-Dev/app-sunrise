<div>


         <x-common.form-header title="Household Members"   />
        <flux:table :paginate="$this->records">
            <flux:table.columns>
                <flux:table.column>Full Name</flux:table.column>
                <flux:table.column>Relationship with the applicant</flux:table.column>
                <flux:table.column>Social Security</flux:table.column>
                <flux:table.column>Date of Birth</flux:table.column>
                <flux:table.column>Monthly Income</flux:table.column>
                <flux:table.column>HIV / AIDS Status</flux:table.column>
                <flux:table.column>Hispanic</flux:table.column>
                <flux:table.column class="flex text-center items-center justify-center">Race Code</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->records as $household)
                    <flux:table.row :key="$household->id">
                        <flux:table.cell>{{ $household->full_name }}</flux:table.cell>
                        <flux:table.cell>{{ $household->householdRelationTypeName }}</flux:table.cell>
                        <flux:table.cell>
                            @if ($household->ssn)
                                <flux:input type="password" value="{{ $household->ssn }}" readonly viewable />
                            @endif
                        </flux:table.cell>
                        <flux:table.cell>{{ $household->dob }}</flux:table.cell>
                        <flux:table.cell>{{ $household->monthly_income }}</flux:table.cell>
                        <flux:table.cell>{{ $household->hiv_aids_status ? 'Yes' : 'No' }}</flux:table.cell>
                        <flux:table.cell>{{ $household->hispanic ? 'Yes' : 'No' }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex flex-col justify-center items-center">
                                <strong>{{ $household->ethnicity_code }}</strong>
                                <span class="text-xs">{{ $household->ethnicity_name }}</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:button wire:click="edit({{ $household->id }})" variant="primary" size="sm" color="blue"
                                icon="pencil-square"></flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>






    <flux:modal wire:model="showEditModal" closable="{{false}}" name="edit-profile"
        class="w-full md:w-1/2 lg:w-1/3 mx-auto space-y-4">
        <div>
            <flux:heading size="lg">Edit household</flux:heading>
            <flux:separator />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <flux:input wire:model='firstName' label="First Name" placeholder="First Name" />
            <flux:input wire:model='lastName' label="Last Name" placeholder="Last Name" />
            <flux:select wire:model='genderId' label="Gender" variant="listbox" searchable
                placeholder="Choose gender...">
                @if ($genders)
                    @foreach ($genders as $option)
                        <flux:select.option value="{{ $option->id }}">{{ $option->name }}</flux:select.option>
                    @endforeach
                @endif
            </flux:select>
            <flux:select label="Relationship" wire:model='householdRelationTypeId' variant="listbox" searchable
                placeholder="Choose relationships...">
                @if ($householdRelationTypes)
                    @foreach ($householdRelationTypes as $option)
                        <flux:select.option value="{{ $option->id }}">{{ $option->name }}</flux:select.option>
                    @endforeach
                @endif
            </flux:select>
            <flux:input wire:model='ssn' label="SSN" mask="999-99-9999" placeholder="SSN" />
            <flux:input wire:model='dateOfBirth' label="Date of birth" type="date" with-today />
            <flux:switch wire:model='hivStatus' label="HIV / AIDS Status" align="left" />
            <flux:switch wire:model='hispanic' label="Hispanic" align="left" />
            <flux:select wire:model='ethnicityId' label="Race" variant="listbox" searchable
                placeholder="Choose race...">
                @if ($ethnicities)
                    @foreach ($ethnicities as $option)
                        <flux:select.option value="{{ $option->id }}">{{ $option->name }}</flux:select.option>
                    @endforeach
                @endif
            </flux:select>
        </div>
        <div class="flex justify-end">
            <flux:button.group>
                <flux:button wire:click="closeEditModal" icon="no-symbol">Cancel</flux:button>
                <flux:button wire:click="save" variant="primary" color="blue" icon="check">Save</flux:button>
            </flux:button.group>
        </div>
    </flux:modal>
</div>
