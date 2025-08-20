<div>
    <form wire:submit.prevent="update" class="space-y-6">
        <x-page-heading title="Edit Contract Meal" />
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
            <flux:card>
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Client Details</h3>
                </div>
                <flux:separator />
                <div class="flex flex-row gap-4 justify-end pt-4">
                    <livewire:components.common.client-search-select />
                    @if($client)
                        <flux:button wire:click="clearClient" variant="danger" icon="x-mark">Clear Client
                        </flux:button>
                    @endif
                </div>
                @if($client)
                    <div class="my-4 space-y-4">
                        <x-common.summary-item label="Full Name" value="{{ $client->full_name }}" />
                        <x-common.summary-item label="Email" value="{{ $client->email }}" />
                        <x-common.summary-item label="Date of Birth" value="{{ $client->dob_formatted }}" />
                        <x-common.summary-item label="Address" value="{{ $client->address }}" />
                        <x-common.summary-item label="Postal Code" value="{{ $client->zip_code }}" />
                    </div>
                @else
                    <p class="text-gray-500 italic p-4">No client selected.</p>
                @endif

            </flux:card>
            <flux:card class="space-y-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="col-span-3">
                    <flux:heading size="lg">Contract Information</flux:heading>
                    <flux:separator />
                </div>
                <div class="col-span-1">
                    <flux:label>Contract Types</flux:label>
                    <flux:select wire:model.live="form.programBranchId" variant="combobox"
                        placeholder="Choose contract type..." clearable>
                        @foreach ($form->programBranches as $programBranch)
                            <flux:select.option value="{{$programBranch->id}}">{{$programBranch->name}}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="form.programBranchId" />
                </div>
                <div class="col-span-1">
                    <flux:label>Client Service Specialists</flux:label>
                    <flux:select wire:model="form.clientServiceSpecialistId" variant="combobox"
                        placeholder="Choose contract type..." clearable>
                        @if (!empty($form->clientServiceSpecialists))
                            @foreach ($form->clientServiceSpecialists as $clientServiceSpecialist)
                                <flux:select.option value="{{$clientServiceSpecialist->id}}">{{$clientServiceSpecialist->name}}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                    <flux:error name="form.clientServiceSpecialistId" />
                </div>
                <div class="col-span-1">
                    <flux:label>Re-Certification Date</flux:label>
                    <flux:date-picker wire:model="form.recertificationDate" selectable-header with-today />
                    <flux:error name="form.recertificationDate" />
                </div>
                <div class="col-span-1">
                    <flux:label>Code</flux:label>
                    <flux:input type="text" wire:model="form.code" placeholder="Enter code..." />
                </div>

                <div class="col-span-1">
                    <flux:label>Delivery Cost</flux:label>
                    <flux:select wire:model="form.deliveryCostId" variant="combobox"
                        placeholder="Choose delivery cost..." clearable>
                        @foreach ($form->deliveryCosts as $deliveryCost)
                            <flux:select.option value="{{$deliveryCost->id}}">{{$deliveryCost->cost}}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="form.deliveryCostId" />
                </div>
                <div class="col-span-1">
                    <flux:label>Program Delivery Cost</flux:label>
                    <flux:select wire:model="form.programDeliveryCostId" variant="combobox"
                        placeholder="Choose program delivery cost..." clearable>
                        @foreach ($form->programDeliveryCosts as $programDeliveryCost)
                            <flux:select.option value="{{$programDeliveryCost->id}}">{{$programDeliveryCost->cost}}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="form.programDeliveryCostId" />
                </div>
                <div class="col-span-1">
                    <flux:label>Active</flux:label>
                    <flux:switch wire:model="form.isActive" />
                </div>
                <div class="col-span-1">
                    <flux:label>Food Cost</flux:label>
                    <flux:select wire:model="form.foodCostId" variant="combobox" placeholder="Choose food cost..."
                        clearable>
                        @foreach ($form->foodCosts as $foodCost)
                            <flux:select.option value="{{$foodCost->id}}">{{$foodCost->cost}}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="form.foodCostId" />
                </div>
                <div class="col-span-1">
                    <flux:label>Termination Reason</flux:label>
                    <flux:select class="col-span-2" wire:model="form.terminationReasonId" variant="combobox"
                        placeholder="Choose termination reason..." clearable>
                        @foreach ($form->terminationReasons as $terminationReason)
                            <flux:select.option value="{{$terminationReason->id}}">{{$terminationReason->name}}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="form.terminationReasonId" />
                </div>
                <div class="col-span-3">
                    <flux:label>Notes</flux:label>
                    <flux:textarea wire:model="form.notes" placeholder="Enter notes..." />
                    <flux:error name="form.notes" />
                </div>
            </flux:card>
        </div>
        <div class="flex justify-end mt-6">
            <flux:button.group class="buttons">
                <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
                <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
            </flux:button.group>
        </div>
    </form>

    <flux:modal name="search-client" wire:model='showClientModal' class="w-full h-[90vh] max-w-7xl overflow-y-auto">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Clients</flux:heading>
                <flux:text class="mt-2">Search and select client.</flux:text>
                <flux:separator />
            </div>
            <div class="space-y-4 w-full">
                <flux:heading>Clients</flux:heading>
                <div class="w-1/2">
                    <flux:input wire:model.live.debounce1000="searchClient" icon="magnifying-glass"
                        placeholder="Search ..." />
                </div>
                <flux:table :paginate="$this->resultClients">
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
                        <flux:table.column>Address</flux:table.column>
                        <flux:table.column>Zipcode</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @foreach ($this->resultClients as $result)
                            <flux:table.row :key="$result->id">
                                <flux:table.cell>
                                    <flux:button wire:click="selectClient({{ $result->id }})" variant="ghost"
                                        icon="user-plus">
                                        Select</flux:button>
                                </flux:table.cell>
                                <flux:table.cell>{{ $result->first_name }}</flux:table.cell>
                                <flux:table.cell>{{ $result->last_name }}</flux:table.cell>
                                <flux:table.cell>{{ $result->client_number }}</flux:table.cell>
                                <flux:table.cell>{{ $result->dob->format('m/d/Y') }}</flux:table.cell>
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
                                <flux:table.cell>{{ $result->address }}</flux:table.cell>
                                <flux:table.cell>{{ $result->zip_code }}</flux:table.cell>

                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </div>
        </div>
    </flux:modal>
</div>