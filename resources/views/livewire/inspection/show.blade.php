<div>
    <x-page-heading title="Show Inspection" />
    <div class="show-information">
        <div class="detail-information">
            <x-common.form-header title="Inspection Address" />
            <flux:select disabled variant="listbox" label="Program Branch" wire:model.live="form.programBranchId">
                @if($this->form->programBranches)
                    @foreach($this->form->programBranches as $branch)
                        <flux:select.option value="{{ $branch->id }}">{{ $branch->name }}</flux:select.option>
                    @endforeach
                @endif
            </flux:select>


            <flux:date-picker disabled wire:model="form.inspectionRequestedDate" label="Inspection Requested Date"
                selectable-header with-today />

            <div class="grid grid-cols-4">
                <div class="col-span-2">
                    <flux:field variant="inline" class="justify-center items-center">
                        <flux:label>Requested Incomplete</flux:label>
                        <flux:switch disabled wire:model.live="form.inspectionRequestedIncomplete" />
                        <flux:error name="form.inspectionRequestedIncomplete" />
                    </flux:field>
                </div>
                <div class="col-span-4">
                    <flux:textarea disabled label="Requested Incomplete Notes"
                        wire:model='form.inspectionRequestedIncompleteNotes' />
                </div>
            </div>
            <flux:date-picker disabled wire:model="form.inspectionRequestedScheduledDate"
                label="Inspection Requested Scheduled Date" selectable-header with-today />
            <div class="grid grid-cols-4">
                <div class="col-span-2">
                    <flux:field variant="inline" class="justify-center items-center">
                        <flux:label>Requested Not Scheduled</flux:label>
                        <flux:switch disabled wire:model.live="form.inspectionRequestedNotScheduled" />
                        <flux:error name="form.inspectionRequestedNotScheduled" />
                    </flux:field>
                </div>
                <div class="col-span-4">
                    <flux:textarea disabled label="Requested Not Scheduled Notes"
                        wire:model='form.inspectionRequestedNotScheduledNotes' />
                </div>
            </div>
            <flux:input disabled label="Landlord Name" wire:model='form.landlordName' />
            <flux:input disabled label="Landlord Contact Information" wire:model='form.landlordContactInformation' />

            <x-common.form-header title="Landlord Address" />
            <div class="grid grid-cols-4   justify-center items-center">
                <div class="col-span-4 space-y-4">
                    <x-common.summary-item label="Address" value="{{ $this->form->landlordAddressFormatted }}" />
                </div>

            </div>
            <flux:error name="form.landlordAddressId" />

            <flux:input disabled label="Tenant Name" wire:model='form.tenantName' />
            <flux:input disabled label="Tenant Contact Information" wire:model='form.tenantContactInformation' />

            <x-common.form-header title="Tenant Address" />
            <div class="grid grid-cols-4   justify-center items-center">
                <div class="col-span-4 space-y-4">
                    <x-common.summary-item label="Address" value="{{ $this->form->tenantAddressFormatted }}" />
                </div>

            </div>
            <flux:error name="form.tenantAddressId" />

            <flux:select disabled variant="listbox" label="Housing Type" wire:model="form.housingTypeId">
                @if($this->form->housingTypes)
                    @foreach($this->form->housingTypes as $type)
                        <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                    @endforeach
                @endif
            </flux:select>
            <flux:input disabled label="Number of Bedrooms" type="number" min="1" wire:model='form.numberOfBedrooms' />
            <flux:select disabled variant="listbox" label="Housing Inspector" wire:model="form.housingInspectorId">
                @if($this->form->users)
                    @foreach($this->form->users as $inspector)
                        <flux:select.option value="{{ $inspector->id }}">{{ $inspector->name }}</flux:select.option>
                    @endforeach
                @endif
            </flux:select>

            <flux:select disabled variant="listbox" label="Inspection Status" wire:model.live="form.inspectionStatus">
                @if($this->form->inspectionStatuses)
                    @foreach($this->form->inspectionStatuses as $status)
                        <flux:select.option value="{{ $status->value }}">{{ $status->name }}</flux:select.option>
                    @endforeach
                @endif
            </flux:select>
            <div class="flex justify-end">
                <div class="flex justify-end mt-6">
                    <flux:button.group class="buttons">
                        <flux:button wire:click="goBack" variant="primary" type="button" icon="arrow-uturn-left">Go Back
                        </flux:button>
                    </flux:button.group>
                </div>
            </div>

        </div>
    </div>


</div>
