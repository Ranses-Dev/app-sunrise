<div class="space-y-4 w-full">

    <div class="flex justify-end">
        <flux:button wire:click="showModal" variant="primary" icon="plus">Assign Plans</flux:button>
    </div>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Description</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->results as $result)
                <flux:table.row :key="$result->id">
                    <flux:table.cell>{{$result->name}}</flux:table.cell>
                    <flux:table.cell>{{$result->description}}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="sm" wire:click='unlinkPlan({{ $result->id }})' variant="danger">Remove Plan
                        </flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
    <flux:modal wire:model='showModalPlan' wire:close='hideModal' class="md:w-96">
        <div class="space-y-6">
            <form wire:submit.prevent='linkPlan' class="space-y-4">
                <div>
                    <flux:heading size="lg">Select Plan</flux:heading>
                </div>
                <flux:select wire:model='planId' variant="listbox" searchable placeholder="Choose plans...">
                    @foreach ($this->unlinkPlans as $plan)
                        <flux:select.option value="{{$plan->id}}">{{$plan->name}}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name='planId' />
                <div class="flex">
                    <flux:spacer />
                    <flux:button size="sm" type="submit" variant="primary">Save changes</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
