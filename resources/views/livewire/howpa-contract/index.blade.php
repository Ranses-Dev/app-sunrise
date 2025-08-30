<div class="space-y-4">
    <x-page-heading title="HOPWA Contracts" />
    <div class="flex justify-end">

        @can('create', \App\Models\HowpaContract::class)
            <flux:button.group>
                <livewire:components.buttons.create-button @create="create" />
                <livewire:components.buttons.export-button @export="export" />
            </flux:button.group>
        @endcan
    </div>
    <x-common.card-filter>
        <flux:input wire:model.live.debounce1000="form.filters.search" label="Search" icon="magnifying-glass"
            placeholder="Search ..." />
        <flux:select clearable wire:model.live='form.filters.programBranchId' variant="listbox" label="Program Branch"
            searchable placeholder="Program Branch...">
            @if ($this->form->programBranches)
                @foreach ($this->form->programBranches as $branch)
                    <flux:select.option value="{{ $branch->id }}">{{ $branch->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select clearable wire:model.live='form.filters.clientServiceSpecialistId' variant="listbox"
            label="Client Service Specialist" searchable placeholder="Client Service Specialist...">
            @if ($this->form->clientServiceSpecialists)
                @foreach ($this->form->clientServiceSpecialists as $specialist)
                    <flux:select.option value="{{ $specialist->id }}">{{ $specialist->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:date-picker clearable label="Date" mode="range" wire:model.live.debounce1000ms='form.filters.rangeDate' />
        <flux:date-picker clearable label="Re-Certification Date" mode="range"
            wire:model.live.debounce1000ms='form.filters.rangeReCertificationDate' />
    </x-common.card-filter>
    <x-common.container-table>
        <flux:table :paginate="$this->form->result()">
            <flux:table.columns>
                <flux:table.column>Full Name</flux:table.column>
                <flux:table.column>Howpa Client Number</flux:table.column>
                <flux:table.column>Program</flux:table.column>
                <flux:table.column>City</flux:table.column>
                <flux:table.column>Date</flux:table.column>
                <flux:table.column>Re-Certification Date</flux:table.column>
                <flux:table.column>Status</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->form->result() as $result)
                    <flux:table.row :key="$result->id">
                        <flux:table.cell>{{ $result->client?->full_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->client?->howpa_client_number }}</flux:table.cell>
                        <flux:table.cell>{{ $result->programBranch?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->city?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->date?->format('m/d/Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $result->re_certification_date?->format('m/d/Y') }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge variant="solid" color="{{ $result->is_active ? 'green' : 'red' }}">
                                {{ $result->is_active ? 'Active' : 'Inactive' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                                <flux:menu>
                                    @can('view', $result)
                                        <flux:menu.item icon="eye">Show</flux:menu.item>
                                    @endcan
                                    @can('update', $result)
                                        <flux:menu.item wire:click="edit({{$result->id}})" icon="pencil-square">Edit
                                        </flux:menu.item>
                                    @endcan
                                    @can('delete', $result)
                                        <flux:menu.item wire:click="delete({{$result->id}})" icon="trash" variant="danger">
                                            Delete
                                        </flux:menu.item>
                                    @endcan
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </x-common.container-table>
    <livewire:components.modal-delete />
</div>
