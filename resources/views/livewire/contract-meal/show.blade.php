<div>
    <x-page-heading title="Show Meal Contract" />
    <div class="show-information">
        <div class="detail-information">
            <x-common.form-header title="Client Details" />
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
                <flux:select disabled wire:model.live="form.programBranchId" variant="combobox"
                    placeholder="Choose contract type...">
                    @isset($form->programBranches)
                        @foreach ($form->programBranches as $programBranch)
                            <flux:select.option value="{{$programBranch->id}}">{{$programBranch->name}}
                            </flux:select.option>
                        @endforeach
                    @endisset

                </flux:select>
                <flux:error name="form.programBranchId" />
            </div>
            <div class="col-span-1">
                <flux:label>Client Service Specialists</flux:label>
                <flux:select wire:model="form.clientServiceSpecialistId" variant="combobox"
                    placeholder="Choose contract type..." disabled>
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
                <flux:date-picker disabled wire:model="form.recertificationDate" selectable-header with-today />
                <flux:error name="form.recertificationDate" />
            </div>
            <div class="col-span-1">
                <flux:label>Code</flux:label>
                <flux:input disabled type="text" wire:model="form.code" placeholder="Enter code..." />
            </div>

            <div class="col-span-1">
                <flux:label>Delivery Cost</flux:label>
                <flux:select disabled wire:model="form.deliveryCostId" variant="combobox"
                    placeholder="Choose delivery cost...">
                    @isset($form->deliveryCosts)
                        @foreach ($form->deliveryCosts as $deliveryCost)
                            <flux:select.option value="{{$deliveryCost->id}}">{{$deliveryCost->cost}}</flux:select.option>
                        @endforeach
                    @endisset

                </flux:select>
                <flux:error name="form.deliveryCostId" />
            </div>
            <div class="col-span-1">
                <flux:label>Program Delivery Cost</flux:label>
                <flux:select wire:model="form.programDeliveryCostId" variant="combobox"
                    placeholder="Choose program delivery cost..." disabled>
                    @if (!empty($form->programDeliveryCosts))
                        @foreach ($form->programDeliveryCosts as $programDeliveryCost)
                            <flux:select.option value="{{$programDeliveryCost->id}}">{{$programDeliveryCost->cost}}
                            </flux:select.option>
                        @endforeach
                    @endif

                </flux:select>
                <flux:error name="form.programDeliveryCostId" />
            </div>
            <div class="col-span-1">
                <flux:label>Active</flux:label>
                <flux:switch disabled wire:model="form.isActive" />
            </div>
            <div class="col-span-1">
                <flux:label>Food Cost</flux:label>
                <flux:select wire:model="form.foodCostId" variant="combobox" placeholder="Choose food cost..." disabled>
                    @isset($form->foodCosts)
                        @foreach ($form->foodCosts as $foodCost)
                            <flux:select.option value="{{$foodCost->id}}">{{$foodCost->cost}}</flux:select.option>
                        @endforeach
                    @endisset

                </flux:select>
                <flux:error name="form.foodCostId" />
            </div>
            <div class="col-span-1">
                <flux:label>Termination Reason</flux:label>
                <flux:select class="col-span-2" wire:model="form.terminationReasonId" variant="combobox"
                    placeholder="Choose termination reason..." disabled>
                    @if (!empty($form->terminationReasons))
                        @foreach ($form->terminationReasons as $terminationReason)
                            <flux:select.option value="{{$terminationReason->id}}">{{$terminationReason->name}}
                            </flux:select.option>
                        @endforeach
                    @endif

                </flux:select>
                <flux:error name="form.terminationReasonId" />
            </div>
            <div class="col-span-3">
                <flux:label>Notes</flux:label>
                <flux:textarea disabled wire:model="form.notes" placeholder="Enter notes..." />
                <flux:error name="form.notes" />
            </div>
            <div class="flex justify-end mt-6">
                <flux:button.group class="buttons">
                    <flux:button wire:click="goBack" variant="primary" type="button" icon="arrow-uturn-left">Go Back</flux:button>
                </flux:button.group>
            </div>
        </div>
    </div>



</div>
