<div>
    <flux:button wire:click="handleShowModal"   variant="primary"
        icon:trailing="magnifying-glass-circle">
        Search Client
    </flux:button>
    <flux:modal name="search-client" wire:model='showModal' class="w-full h-[90vh] max-w-7xl overflow-y-auto">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Clients</flux:heading>
                <flux:text class="mt-2">Search and select client.</flux:text>
                <flux:separator />
            </div>
            <div class="space-y-4 w-full">
                <div class="w-1/2">
                    <flux:input wire:model.live.debounce1000="searchClient" icon="magnifying-glass"
                        placeholder="Search ..." />
                </div>
                <flux:table :paginate="$this->results">
                    <flux:table.columns>
                        <flux:table.column></flux:table.column>
                        <flux:table.column>First Name </flux:table.column>
                        <flux:table.column>Last Name</flux:table.column>
                        <flux:table.column>Client Number</flux:table.column>
                        <flux:table.column>DOB</flux:table.column>
                        <flux:table.column>Age</flux:table.column>
                        <flux:table.column>Income</flux:table.column>
                        <flux:table.column>Total Income</flux:table.column>
                        <flux:table.column>Households</flux:table.column>
                        <flux:table.column>Income Category (%)</flux:table.column>
                        <flux:table.column>Email</flux:table.column>
                        <flux:table.column>Zipcode</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach ($this->results as $result)
                            <flux:table.row :key="$result->id">
                                <flux:table.cell>
                                    <flux:button wire:click="selectClient({{ $result->id }})" variant="primary"
                                          icon="user-plus">
                                        Select</flux:button>
                                </flux:table.cell>
                                <flux:table.cell>{{ $result->first_name }}</flux:table.cell>
                                <flux:table.cell>{{ $result->last_name }}</flux:table.cell>
                                <flux:table.cell>{{ $result->client_number }}</flux:table.cell>
                                <flux:table.cell>{{ $result->dob?->format('m/d/Y') }}</flux:table.cell>
                                <flux:table.cell>{{ $result->age }}</flux:table.cell>
                                <flux:table.cell>{{ $result->income }}</flux:table.cell>
                                <flux:table.cell>{{ $result->total_income }}</flux:table.cell>
                                <flux:table.cell>{{ $result->household_total }}</flux:table.cell>
                                <flux:table.cell> @if ($result->income_category)
                                    <flux:badge color="green">{{"$result->income_category %" }}</flux:badge>
                                @else
                                        <flux:badge color="red">N/A</flux:badge>
                                    @endif
                                </flux:table.cell>
                                <flux:table.cell>{{ $result->email }}</flux:table.cell>
                                <flux:table.cell>{{ $result->zip_code }}</flux:table.cell>

                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </div>
        </div>
    </flux:modal>
</div>
