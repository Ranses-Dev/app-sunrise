<div class="space-y-4">
    <x-page-heading title="Meal Contracts" />
    <div class="flex justify-end">
        @can('create', \App\Models\ContractMeal::class)
            <flux:button.group>
                <livewire:components.buttons.create-button @create="create" />
                <livewire:components.buttons.export-button @export="export" />
            </flux:button.group>
        @endcan
    </div>
    <livewire:contract-meal.stats />
    <x-common.card-filter>
        <flux:input wire:model.live.debounce1000ms='form.filters.search' label="Search"></flux:input>
        <flux:select clearable wire:model.live='form.filters.clientServiceSpecialistId' variant="listbox"
            label="Client Service Specialist" searchable placeholder="Client Service Specialist...">
            @if ($this->form->clientServiceSpecialists)
                @foreach ($this->form->clientServiceSpecialists as $specialist)
                    <flux:select.option value="{{ $specialist->id }}">{{ $specialist->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select clearable wire:model.live='form.filters.programBranchId' variant="listbox" label="Program Branch"
            searchable placeholder="Program Branch...">
            @if ($this->form->programBranches)
                @foreach ($this->form->programBranches as $branch)
                    <flux:select.option value="{{ $branch->id }}">{{ $branch->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
    </x-common.card-filter>
    <x-common.container-table>
        <flux:table :paginate="$this->form->results()">
            <flux:table.columns>
                <flux:table.column>Client Name</flux:table.column>
                <flux:table.column>Specialist Name</flux:table.column>
                <flux:table.column>Code</flux:table.column>
                <flux:table.column>Contract Type</flux:table.column>
                <flux:table.column>Food Cost</flux:table.column>
                <flux:table.column>Delivery Cost</flux:table.column>
                <flux:table.column>Program Delivery Cost</flux:table.column>
                <flux:table.column>Is Active</flux:table.column>
                <flux:table.column>Re-Certification Date</flux:table.column>
                <flux:table.column>Termination Reason</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->form->results() as $result)
                    <flux:table.row :key="$result->id">
                        <flux:table.cell>{{ $result->client?->full_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->clientServiceSpecialist?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->code }}</flux:table.cell>
                        <flux:table.cell>{{ $result->mealContractType?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->foodCost?->formatted_currency }}</flux:table.cell>
                        <flux:table.cell>{{ $result->deliveryCost?->formatted_currency }}</flux:table.cell>
                        <flux:table.cell>{{ $result->programDeliveryCost?->formatted_currency }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :icon="$result->is_active ? 'check' : 'no-symbol'"
                                :color="$result->is_active ? 'green' : 'red'">
                                {{ $result->is_active ? 'Yes' : 'No' }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>{{ $result->recertification_date?->format('m/d/Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $result->terminationReason?->name }}</flux:table.cell>

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
