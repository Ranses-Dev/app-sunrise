<div class="space-y-4">
    <x-page-heading title="Clients" />
    <div class="flex justify-end">

        <div>
            @can('create', \App\Models\Client::class)
                <flux:button.group>
                    <livewire:components.buttons.create-button @create="create" />
                    <livewire:components.buttons.export-button @export="exportClientListPdf" />
                </flux:button.group>
            @endcan
        </div>
    </div>
    <x-common.card-filter>
        <flux:input wire:model.live.debounce1000ms="form.filters.search" label="Search"></flux:input>
        <flux:select wire:model.live="form.filters.legalStatusId" variant="listbox" label="Legal Status" clearable
            searchable placeholder="Choose legal status...">
            @if ($this->form->statuses)
                @foreach ($this->form->statuses as $status)
                    <flux:select.option value="{{ $status->id }}">{{ $status->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.identificationTypeId" variant="listbox" label="Identification Type"
            clearable searchable placeholder="Choose identification type...">
            @if ($this->form->identificationTypes)
                @foreach ($this->form->identificationTypes as $type)
                    <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.ethnicityId" variant="listbox" label="Ethnicity" clearable searchable
            placeholder="Choose ethnicity...">
            @if ($this->form->ethnicities)
                @foreach ($this->form->ethnicities as $ethnicity)
                    <flux:select.option value="{{ $ethnicity->id }}">{{ $ethnicity->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:select wire:model.live="form.filters.healthcareProviderId" variant="listbox" label="Healthcare Provider"
            clearable searchable placeholder="Choose healthcare provider...">
            @if ($this->form->healthcareProviders)
                @foreach ($this->form->healthcareProviders as $provider)
                    <flux:select.option value="{{ $provider->id }}">{{ $provider->name }}</flux:select.option>
                @endforeach
            @endif

        </flux:select>
        <flux:select wire:model.live="form.filters.genderId" variant="listbox" label="Gender" clearable searchable
            placeholder="Choose gender...">
            @if ($this->form->genders)
                @foreach ($this->form->genders as $gender)
                    <flux:select.option value="{{ $gender->id }}">{{ $gender->name }}</flux:select.option>
                @endforeach
            @endif
        </flux:select>
        <flux:fieldset>
            <flux:legend>Programs</flux:legend>
            <div class="flex flex-row items-center gap-4">
                <div>
                    <flux:switch wire:model.live="form.filters.hasHowpa" label="HOWPA" align="left" />
                </div>
                <div>
                    <flux:switch wire:model.live="form.filters.hasMeals" label="MEALS" align="left" />
                </div>
            </div>
        </flux:fieldset>
    </x-common.card-filter>
    <x-common.container-table>
        <flux:table :paginate="$this->form->results()">
            <flux:table.columns>
                <flux:table.column>Full Name</flux:table.column>
                <flux:table.column>Client Number</flux:table.column>
                <flux:table.column>Legal Status</flux:table.column>
                <flux:table.column>DOB</flux:table.column>
                <flux:table.column>Age</flux:table.column>
                <flux:table.column>Monthly Income</flux:table.column>
                <flux:table.column>Annual Income</flux:table.column>
                <flux:table.column>Gross Monthly Income</flux:table.column>
                <flux:table.column>Gross Annual Income</flux:table.column>
                <flux:table.column>Households</flux:table.column>
                <flux:table.column>Income Category (%)</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->form->results() as $result)
                    <flux:table.row :key="$result->id">
                        <flux:table.cell>{{ $result->full_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->client_number }}</flux:table.cell>
                        <flux:table.cell>{{ $result->legalStatus?->name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->dob->format('m/d/Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $result->age }}</flux:table.cell>
                        <flux:table.cell>{{ $result->income_monthly }}
                        </flux:table.cell>
                        <flux:table.cell>{{ $result->income }}</flux:table.cell>
                        <flux:table.cell>{{ $result->total_income_monthly }}</flux:table.cell>
                        <flux:table.cell>{{ $result->total_income }}</flux:table.cell>
                        <flux:table.cell>{{ $result->household_total }}</flux:table.cell>
                        <flux:table.cell> @if ($result->income_category)
                            <flux:badge color="green">{{"$result->income_category %" }}</flux:badge>
                        @else
                                <flux:badge color="red">N/A</flux:badge>
                            @endif
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