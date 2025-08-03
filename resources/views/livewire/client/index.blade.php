<div class="space-y-4">
    <x-page-heading title="Clients List" />
    <div class="flex justify-between">
        <flux:input wire:model.live.debounce1000="search" class="input-search" icon="magnifying-glass"
            placeholder="Search ..." />
        <div>
            @can('create', \App\Models\Client::class)
                <flux:button.group>
                    <livewire:components.buttons.create-button @create="create" />
                    <livewire:components.buttons.export-button @export="exportClientListPdf" />
                </flux:button.group>
            @endcan
        </div>
    </div>
    <x-common.container-table>
        <flux:table :paginate="$this->results">
            <flux:table.columns>
                <flux:table.column>First Name </flux:table.column>
                <flux:table.column>Last Name</flux:table.column>
                <flux:table.column>Client Number</flux:table.column>
                <flux:table.column>DOB</flux:table.column>
                <flux:table.column>Age</flux:table.column>
                <flux:table.column>Monthly Income</flux:table.column>
                <flux:table.column>Annual Income</flux:table.column>
                <flux:table.column>Gross Monthly Income</flux:table.column>
                <flux:table.column>Gross Annual Income</flux:table.column>
                <flux:table.column>Households</flux:table.column>
                <flux:table.column>Income Category (%)</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Address</flux:table.column>
                <flux:table.column>Zipcode</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->results as $result)
                    <flux:table.row :key="$result->id">
                        <flux:table.cell>{{ $result->first_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->last_name }}</flux:table.cell>
                        <flux:table.cell>{{ $result->client_number }}</flux:table.cell>
                        <flux:table.cell>{{ $result->dob->format('m/d/Y') }}</flux:table.cell>
                        <flux:table.cell>{{ $result->age }}</flux:table.cell>
                        <flux:table.cell>{{ $result->income_monthly }}</flux:table.cell>
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

                        <flux:table.cell>{{ $result->email }}</flux:table.cell>
                        <flux:table.cell>{{ $result->address }}</flux:table.cell>
                        <flux:table.cell>{{ $result->zip_code }}</flux:table.cell>
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
