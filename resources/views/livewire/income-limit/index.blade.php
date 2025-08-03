<div class="space-y-4">
    <flux:heading>Legal Status</flux:heading>
    <div class="flex justify-end">

        <flux:button wire:click="create" variant="primary" icon="plus">Create</flux:button>
    </div>
    <flux:table :paginate="$this->results">
        <flux:table.columns>
            <flux:table.column>
                <div>Percentage Category
                    <flux:select wire:model.live='filters.percentageCategory' variant="listbox" searchable clearable
                        placeholder="Filter">
                        @if (count($this->form->percentageCategories) > 0)
                            @foreach ($this->form->percentageCategories as $percentageCategory)
                                <flux:select.option value="{{ $percentageCategory }}">{{"$percentageCategory %"}}
                                </flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                </div>
            </flux:table.column>
            <flux:table.column>
                <div>
                    Household Size
                    <flux:select wire:model.live='filters.householdSize' variant="listbox" searchable clearable
                        placeholder="Filter">
                        @if (count($this->form->householdSizes) > 0)
                            @foreach ($this->form->householdSizes as $householdSize)
                                <flux:select.option value="{{ $householdSize }}">{{$householdSize }}</flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
                </div>
            </flux:table.column>
            <flux:table.column>
                <div>
                    Income Limit
                    <flux:select wire:model.live='filters.incomeLimit' variant="listbox" searchable clearable
                        placeholder="Filter">
                        @if (count($this->form->incomeLimits) > 0)
                            @foreach ($this->form->incomeLimits as $incomeLimit)
                                <flux:select.option value="{{ $incomeLimit }}">{{$incomeLimit }}</flux:select.option>
                            @endforeach
                        @endif
                    </flux:select>
            </flux:table.column>
        </flux:table.columns>

</div>
<flux:table.rows>
    @foreach ($this->results as $result)
        <flux:table.row :key="$result->id">
            <flux:table.cell>{{ "$result->percentage_category %" }}</flux:table.cell>
            <flux:table.cell>{{ $result->household_size }}</flux:table.cell>
            <flux:table.cell>{{ $result->income_limit }}</flux:table.cell>
            <flux:table.cell>
                <flux:dropdown>
                    <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                    <flux:menu>
                        <flux:menu.item icon="eye">Show</flux:menu.item>
                        <flux:menu.item wire:click="edit({{$result->id}})" icon="pencil-square">Edit
                        </flux:menu.item>
                        <flux:menu.item wire:click="delete({{$result->id}})" icon="trash" variant="danger">Delete
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </flux:table.cell>
        </flux:table.row>
    @endforeach
</flux:table.rows>
</flux:table>
<livewire:components.modal-delete />
</div>
