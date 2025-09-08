<div >
    <x-page-heading title="Edit Inspection" />
 <div class="form">
    <form wire:submit.prevent="save" class="space-y-4">

           <x-common.form-header title="Inspection Address" />
            <div class="grid grid-cols-4   justify-center items-center">
                <div class="col-span-3 space-y-4">
                    <x-common.summary-item label="Address" value="{{ $this->form->inspectionAddressFormatted }}" />
                </div>
                <livewire:components.common.address-search-select  @selected="selectedInspectionAddress($event.detail.addressId)" wire:key='inspection-address-search-select' />
            </div>
            <flux:error name="form.addressId" />

        <flux:select variant="listbox" clearable label="Program Branch" wire:model.live="form.programBranchId">
            @if($this->form->programBranches)
                @foreach($this->form->programBranches as $branch)
                    <flux:select.option value="{{ $branch->id }}">{{ $branch->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>

        @if ($this->form->showButtonsSelectClientsFromHowpa())
  <div class="grid grid-cols-2 border-2 p-2 rounded-md border-gray-300">
            <flux:label>Select Landlord From Howpa</flux:label>
            <livewire:components.common.client-howpa-select wire:key='landlord-search-select' @selected="selectedLandlord($event.detail.id)" label="Search Landlord" />
        </div>

        <div class="grid grid-cols-2 border-2 p-2 rounded-md border-gray-300">
            <flux:label>Select Tenant From Howpa</flux:label>
            <livewire:components.common.client-howpa-select wire:key='tenant-search-select' @selected="selectedTenant($event.detail.id)" label="Search Tenant" />
        </div>
        @endif

        <flux:date-picker wire:model="form.inspectionRequestedDate" clearable label="Inspection Requested Date" selectable-header
            with-today />

        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <flux:field variant="inline" class="justify-center items-center">
                    <flux:label>Requested Incomplete</flux:label>
                    <flux:switch wire:model.live="form.inspectionRequestedIncomplete" />
                    <flux:error name="form.inspectionRequestedIncomplete" />
                </flux:field>
            </div>
            <div class="col-span-4">
                <flux:textarea :disabled="!$form->inspectionRequestedIncomplete" label="Requested Incomplete Notes"
                    wire:model='form.inspectionRequestedIncompleteNotes' />
            </div>
        </div>
 <flux:date-picker wire:model="form.inspectionRequestedScheduledDate" clearable label="Inspection Requested Scheduled Date" selectable-header
            with-today />
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <flux:field variant="inline" class="justify-center items-center">
                    <flux:label>Requested Not Scheduled</flux:label>
                    <flux:switch wire:model.live="form.inspectionRequestedNotScheduled" />
                    <flux:error name="form.inspectionRequestedNotScheduled" />
                </flux:field>
            </div>
            <div class="col-span-4">
                <flux:textarea :disabled="!$form->inspectionRequestedNotScheduled" label="Requested Not Scheduled Notes"
                    wire:model='form.inspectionRequestedNotScheduledNotes' />
            </div>
        </div>
       <flux:input label="Landlord Name" wire:model='form.landlordName' />
      <flux:input label="Landlord Contact Information" wire:model='form.landlordContactInformation'/>

            <x-common.form-header title="Landlord Address" />
            <div class="grid grid-cols-4   justify-center items-center">
                <div class="col-span-3 space-y-4">
                    <x-common.summary-item label="Address" value="{{ $this->form->landlordAddressFormatted }}" />
                </div>
                <livewire:components.common.address-search-select  @selected="selectedLandlordAddress($event.detail.addressId)" wire:key='inspection-landlord-search-select' />
            </div>
            <flux:error name="form.landlordAddressId" />

        <flux:input label="Tenant Name" wire:model='form.tenantName' />
      <flux:input label="Tenant Contact Information" wire:model='form.tenantContactInformation'/>

            <x-common.form-header title="Tenant Address" />
            <div class="grid grid-cols-4   justify-center items-center">
                <div class="col-span-3 space-y-4">
                    <x-common.summary-item label="Address" value="{{ $this->form->tenantAddressFormatted }}" />
                </div>
                <livewire:components.common.address-search-select  @selected="selectedTenantAddress($event.detail.addressId)" wire:key='inspection-tenant-search-select' />
            </div>
            <flux:error name="form.tenantAddressId" />

        <flux:select variant="listbox" searchable clearable label="Housing Type" wire:model="form.housingTypeId">
            @if($this->form->housingTypes)
                @foreach($this->form->housingTypes as $type)
                    <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:input label="Number of Bedrooms" type="number" min="1" wire:model='form.numberOfBedrooms'/>
        <flux:select variant="listbox" searchable clearable label="Housing Inspector" wire:model="form.housingInspectorId">
            @if($this->form->users)
                @foreach($this->form->users as $inspector)
                    <flux:select.option value="{{ $inspector->id }}">{{ $inspector->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>

        <flux:select variant="listbox" searchable clearable label="Inspection Status" wire:model.live="form.inspectionStatus">
            @if($this->form->inspectionStatuses)
                @foreach($this->form->inspectionStatuses as $status)
                    <flux:select.option value="{{ $status->value }}">{{ $status->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
       <div class="flex justify-end">
        <flux:button.group class="justify-end  ">
                <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
                <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>

        </flux:button.group>
</div>

</form>
</div>


</div>
