<div class="space-y-4 w-full">

    <div class="flex justify-end">
        <flux:button wire:click="showModal" variant="primary" icon="plus">Assign Cities</flux:button>
    </div>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->results as $result)
                <flux:table.row :key="$result->id">
                    <flux:table.cell>{{$result->name}}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="sm" wire:click='unlinkCity({{ $result->id }})' variant="danger">Remove City
                        </flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
    <flux:modal wire:model='showModalCity' wire:close='hideModal' class="md:w-96">
        <div class="space-y-6">
            <form wire:submit.prevent='linkCity' class="space-y-4">
                <div>
                    <flux:heading size="lg">Select Plan</flux:heading>
                </div>
                <flux:select wire:model='cityId' variant="listbox" searchable placeholder="Choose cities...">
                    @foreach ($this->unlinkCities as $city)
                        <flux:select.option value="{{$city->id}}">{{$city->name}}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name='cityId' />
                <div class="flex">
                    <flux:spacer />
                    <flux:button size="sm" type="submit" variant="primary">Save changes</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
