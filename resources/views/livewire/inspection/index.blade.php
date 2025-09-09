<div class="space-y-4">
    <x-page-heading title="Inspections" />
    <div class="flex justify-end">
        @can('create', \App\Models\Client::class)
            <flux:button.group>
                <livewire:components.buttons.create-button @create="create" />
                <livewire:components.buttons.export-button @export="export" />
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
    <flux:table :paginate="$this->form->results()">
        <flux:table.columns>
            <flux:table.column>Address</flux:table.column>
            <flux:table.column>Requested Date</flux:table.column>
            <flux:table.column>Requested Scheduled Date</flux:table.column>
            <flux:table.column>Program Branch</flux:table.column>
            <flux:table.column>Housing Type</flux:table.column>
            <flux:table.column>Housing Inspector</flux:table.column>
            <flux:table.column>Status</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->form->results() as $result)
                <flux:table.row :key="$result->id">
                    <flux:table.cell>{{ $result->address?->address_formatted  }}</flux:table.cell>
                    <flux:table.cell>{{ $result->inspection_requested_date?->format('m-d-Y') }}</flux:table.cell>
                    <flux:table.cell>{{ $result->inspection_requested_scheduled_date?->format('m-d-Y') }}</flux:table.cell>
                    <flux:table.cell>{{ $result->programBranch?->name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->housingType?->name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->housingInspector?->name }}</flux:table.cell>
                    <flux:table.cell>
                        @if ($result->inspection_status === App\Enums\InspectionStatus::PASS)
                            <flux:badge variant="solid" color="green">{{ $result->inspection_status }}</flux:badge>
                        @elseif ($result->inspection_status === App\Enums\InspectionStatus::FAIL)
                            <flux:badge variant="solid" color="red">{{ $result->inspection_status }}</flux:badge>
                        @else
                            {{ $result->inspection_status }}
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                            <flux:menu>
                                <flux:menu.item icon="eye" wire:click="show({{$result->id}})">Show</flux:menu.item>
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
    <livewire:components.modal-delete />
</div>
