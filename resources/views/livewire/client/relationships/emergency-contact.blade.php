<div class="space-y-4">
    <div class="flex justify-between">
        <flux:input wire:model.live.debounce1000="search" class="input-search" icon="magnifying-glass"
            placeholder="Search ..." />
        <flux:button wire:click="openModal" variant="primary" icon="plus">Create</flux:button>
    </div>
    <flux:table :paginate="$this->form->records()">
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Address</flux:table.column>
            <flux:table.column>Phone Number</flux:table.column>
            <flux:table.column>Relationship</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->form->records() as $record)
                <flux:table.row :key="$record->id">
                    <flux:table.cell>{{ $record->name }}</flux:table.cell>
                    <flux:table.cell>{{ $record->address }}</flux:table.cell>
                    <flux:table.cell>{{ $record->phone_number }}</flux:table.cell>
                    <flux:table.cell>{{ $record->householdRelationType?->name }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                            <flux:menu>
                                <flux:menu.item wire:click="edit({{$record->id}})" icon="pencil-square">Edit
                                </flux:menu.item>
                                <flux:menu.item wire:click="delete({{$record->id}})" icon="trash" variant="danger">Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
    <flux:modal :closable="false" name='confirm-delete-emergency-contact'>

        <flux:heading size="lg">Confirm Delete</flux:heading>
        <p>Are you sure you want to delete this emergency contact?</p>

        <div class="flex justify-end">
            <flux:button.group>
                <flux:button wire:click='cancelDelete' icon="no-symbol">Cancel</flux:button>
                <flux:button wire:click='confirmDelete' icon="trash" variant="primary" color="red">Delete</flux:button>
            </flux:button.group>

        </div>
    </flux:modal>
    <flux:modal :closable="false" wire:model='showModal' class="w-full md:w-1/2 lg:w-1/3">
        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <flux:heading size="lg"> {{$this->form->id ? 'Edit ' : 'Create '}} Emergency Contact
                </flux:heading>
            </div>
            <div class="space-y-4 grid grid-cols-1 md:grid-cols-2  gap-4">

                <flux:input label="Name" wire:model='form.name' placeholder="Name" />
                <flux:input label="Phone Number" mask="(999) 999-9999" wire:model='form.phoneNumber'
                    placeholder="Phone Number" />
                <div class="col-span-2">
                    <flux:input label="Address" wire:model='form.address' placeholder="Address" />
                </div>
                <flux:select label="Relationship" variant="listbox" searchable clearable
                    wire:model='form.householdRelationTypeId'>
                    @if ($this->form->relationTypes)
                        @foreach ($this->form->relationTypes as $relationType)
                            <flux:select.option :value="$relationType->id">{{ $relationType->name }}</flux:select.option>
                        @endforeach
                    @endif
                </flux:select>

            </div>
            <div class="flex justify-end">
                <flux:button.group>

                    <flux:button wire:click='closeModal' icon="no-symbol">Cancel</flux:button>
                    <flux:button type="submit" variant="primary" icon="check">Save</flux:button>
                </flux:button.group>
            </div>
        </form>
    </flux:modal>
</div>
