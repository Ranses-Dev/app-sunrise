<div class="space-y-4">
    <x-page-heading title="Inspections" />
    <div class="flex justify-end">
        @can('create', \App\Models\Client::class)
            <flux:button.group>
                <livewire:components.buttons.create-button @create="create" />
                <livewire:components.buttons.export-button @export="export" />
                <livewire:components.buttons.export-excel-button @export="exportExcel" />
            </flux:button.group>
        @endcan
    </div>

    <x-common.card-filter x-data>

        <flux:input label="Search" wire:model.live.debounce1000ms="form.filters.search"
            placeholder="Type your search..." />

        <flux:select label="Program Branch" wire:model.live="form.filters.programBranchId" variant="listbox" clearable
            placeholder="Program Branch...">
            @if ($this->form->programBranches)
                @foreach ($this->form->programBranches as $branch)
                    <flux:select.option value="{{ $branch->id }}">{{ $branch->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select label="Housing Inspectors" wire:model="form.filters.housingInspectorId" variant="listbox" clearable
            placeholder="Housing Inspectors...">
            @if ($this->form->users)
                @foreach ($this->form->users as $user)
                    <flux:select.option value="{{ $user->id }}">{{ $user->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:date-picker label="Requested Date" mode="range"
            wire:model.live.debounce1000ms='form.filters.inspectionRequestedDateRange' />
        <flux:date-picker label="Requested Schedule" mode="range"
            wire:model.live.debounce1000ms='form.filters.inspectionRequestedScheduledRange' />

        <div class="grid grid-cols-3">
            <flux:fieldset>
                <flux:legend>Requested Incomplete</flux:legend>
                <div class="space-y-3">
                    <flux:switch wire:model.live.debounce1000ms="form.filters.inspectionRequestedIncomplete"
                        align="left" />
                </div>
            </flux:fieldset>
            <flux:fieldset>
                <flux:legend>Requested Not Scheduled</flux:legend>
                <div class="space-y-3">
                    <flux:switch wire:model.live.debounce1000ms="form.filters.inspectionRequestedNotScheduled"
                        align="left" />
                </div>
            </flux:fieldset>


        </div>
        <flux:radio.group wire:model.live.debounce1000ms="form.filters.inspectionStatus" label="Status" variant="pills">
            @if ($this->form->inspectionStatuses)
                @foreach ($this->form->inspectionStatuses as $status)
                    <flux:radio varia value="{{ $status->value }}" label="{{ ucfirst($status->name) }}" />
                @endforeach
            @endif
        </flux:radio.group>

    </x-common.card-filter>
    <x-common.container-table>
        <div class="flex justify-end mb-2">
            <livewire:components.modal-columns :columns="$this->form->columns"
                :columns-selected="$this->form->columnsSelected" />
        </div>
        <flux:table :paginate="$this->form->results()">
            <flux:table.columns>
                @if (in_array('address', $this->form->columnsSelected))
                    <flux:table.column>Address</flux:table.column>
                @endif
                @if (in_array('program_branch', $this->form->columnsSelected))
                    <flux:table.column>Branch</flux:table.column>
                @endif
                @if (in_array('inspection_requested_date', $this->form->columnsSelected))
                    <flux:table.column>Requested Date</flux:table.column>
                @endif
                @if (in_array('inspection_requested_incomplete', $this->form->columnsSelected))
                    <flux:table.column>Requested Incomplete</flux:table.column>
                @endif
                @if (in_array('inspection_requested_incomplete_notes', $this->form->columnsSelected))
                    <flux:table.column>Requested Incomplete Notes</flux:table.column>
                @endif
                @if (in_array('inspection_requested_not_scheduled', $this->form->columnsSelected))
                    <flux:table.column>Requested Not Scheduled</flux:table.column>
                @endif
                @if (in_array('inspection_requested_not_scheduled_notes', $this->form->columnsSelected))
                    <flux:table.column>Requested Not Scheduled Notes</flux:table.column>
                @endif
                @if (in_array('inspection_requested_scheduled_date', $this->form->columnsSelected))
                    <flux:table.column>Requested Scheduled Date</flux:table.column>
                @endif
                @if (in_array('landlord_name', $this->form->columnsSelected))
                    <flux:table.column>Landlord Name</flux:table.column>
                @endif
                @if (in_array('landlord_contact_information', $this->form->columnsSelected))
                    <flux:table.column>Landlord Contact Information</flux:table.column>
                @endif
                @if (in_array('landlord_address', $this->form->columnsSelected))
                    <flux:table.column>Landlord Address</flux:table.column>
                @endif
                @if (in_array('landlord_howpa', $this->form->columnsSelected))
                    <flux:table.column>Landlord HOWPA</flux:table.column>
                @endif
                @if (in_array('tenant_name', $this->form->columnsSelected))
                    <flux:table.column>Tenant Name</flux:table.column>
                @endif
                @if (in_array('tenant_howpa', $this->form->columnsSelected))
                    <flux:table.column>Tenant HOWPA</flux:table.column>
                @endif
                @if (in_array('tenant_contact_information', $this->form->columnsSelected))
                    <flux:table.column>Tenant Contact Information</flux:table.column>
                @endif
                @if (in_array('tenant_address', $this->form->columnsSelected))
                    <flux:table.column>Tenant Address</flux:table.column>
                @endif
                @if (in_array('housing_type', $this->form->columnsSelected))
                    <flux:table.column>Housing Type</flux:table.column>
                @endif
                @if (in_array('number_of_bedrooms', $this->form->columnsSelected))
                    <flux:table.column>Number of Bedrooms</flux:table.column>
                @endif
                @if (in_array('housing_inspector', $this->form->columnsSelected))
                    <flux:table.column>Housing Inspector</flux:table.column>
                @endif
                @if (in_array('inspection_status', $this->form->columnsSelected))
                    <flux:table.column>Inspection Status</flux:table.column>
                @endif
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->form->results() as $result)
                    <flux:table.row :key="$result->id">
                        @if (in_array('address', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->address?->address_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('program_branch', $this->form->columnsSelected))
                            <flux:table.cell>{{$result->programBranch?->name}}</flux:table.cell>
                        @endif
                        @if (in_array('inspection_requested_date', $this->form->columnsSelected))
                            <flux:table.cell>{{$result->inspection_requested_date_formatted}}</flux:table.cell>
                        @endif
                        @if (in_array('inspection_requested_incomplete', $this->form->columnsSelected))
                            <flux:table.cell>{{$result->inspection_requested_incomplete ? 'Yes' : 'No'}}</flux:table.cell>
                        @endif
                        @if (in_array('inspection_requested_incomplete_notes', $this->form->columnsSelected))
                            <flux:table.cell>{{$result->inspection_requested_incomplete_notes}}</flux:table.cell>
                        @endif
                        @if (in_array('inspection_requested_not_scheduled', $this->form->columnsSelected))
                            <flux:table.cell>{{$result->inspection_requested_not_scheduled ? 'Yes' : 'No'}}</flux:table.cell>
                        @endif
                        @if (in_array('inspection_requested_not_scheduled_notes', $this->form->columnsSelected))
                            <flux:table.cell>{{$result->inspection_requested_not_scheduled_notes}}</flux:table.cell>
                        @endif
                        @if (in_array('inspection_requested_scheduled_date', $this->form->columnsSelected))
                            <flux:table.cell>{{$result->inspection_requested_scheduled_date_formatted}}</flux:table.cell>
                        @endif
                        @if (in_array('landlord_name', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->landlord_name }}</flux:table.cell>
                        @endif
                        @if (in_array('landlord_contact_information', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->landlord_contact_information }}</flux:table.cell>
                        @endif
                        @if (in_array('landlord_address', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->landlordAddress?->address_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('landlord_howpa', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->landlordHowpa?->full_name }}</flux:table.cell>
                        @endif
                        @if (in_array('tenant_name', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->tenant_name }}</flux:table.cell>
                        @endif
                        @if (in_array('tenant_howpa', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->tenantHowpa?->full_name }}</flux:table.cell>
                        @endif
                        @if (in_array('tenant_contact_information', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->tenant_contact_information }}</flux:table.cell>
                        @endif
                        @if (in_array('tenant_address', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->tenantAddress?->address_formatted }}</flux:table.cell>
                        @endif
                        @if (in_array('housing_type', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->housingType?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('number_of_bedrooms', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->number_of_bedrooms }}</flux:table.cell>
                        @endif
                        @if (in_array('housing_inspector', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->housingInspector?->name }}</flux:table.cell>
                        @endif
                        @if (in_array('inspection_status', $this->form->columnsSelected))
                            <flux:table.cell>{{ $result->inspection_status }}</flux:table.cell>
                        @endif
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="eye" wire:click="show({{$result->id}})">Show</flux:menu.item>
                                    <flux:menu.item wire:click="edit({{$result->id}})" icon="pencil-square">Edit
                                    </flux:menu.item>
                                    <flux:menu.item wire:click="delete({{$result->id}})" icon="trash" variant="danger">
                                        Delete
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
        <livewire:components.modal-delete />
    </x-common.container-table>
</div>
