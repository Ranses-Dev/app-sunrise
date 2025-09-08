<div>
 <x-page-heading title="New Meal Contract" />
<div class="form">
    <form wire:submit.prevent="store" >
                 <x-common.form-header title="Client Details" />
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
                        <x-common.summary-item label="Address" value="{{ $client->address?->address_formatted }}" />
                        <x-common.summary-item label="Postal Code" value="{{ $client->address?->postal_code }}" />
                    </div>
                @else
                    <p class="text-gray-500 italic p-4">No client selected.</p>
                @endif
               <x-common.form-header title="Contract Information" />
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

        <div class="flex justify-end mt-6">
            <flux:button.group class="buttons">
                <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
                <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
                <flux:button wire:click="storeAndNew" type="button" icon="squares-plus" variant="filled">Save & New
                </flux:button>
            </flux:button.group>
        </div>
    </form>


</div>
</div>

