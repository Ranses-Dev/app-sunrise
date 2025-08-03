<div class="space-y-4">
    <div class="flex justify-between">
        <flux:input wire:model.live.debounce1000="search" class="input-search" icon="magnifying-glass"
            placeholder="Search ..." />
        <flux:button wire:click="openModal" variant="primary" icon="plus">Create</flux:button>
    </div>
    <flux:table :paginate="$this->results">
        <flux:table.columns>
            <flux:table.column>Phone Number</flux:table.column>
            <flux:table.column>Notes</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->results as $result)
                <flux:table.row :key="$result->id">
                    <flux:table.cell>{{ $result->phone_number }}</flux:table.cell>
                    <flux:table.cell>{{ $result->notes }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                            <flux:menu>
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
    <flux:modal :closable="false" name='confirm-delete-phone-number'>
        <flux:heading size="lg">Confirm Delete</flux:heading>
        <p>Are you sure you want to delete this phone number?</p>
        <div class="flex justify-end">
            <flux:button.group>
                <flux:button wire:click='cancelDelete' icon="no-symbol">Cancel</flux:button>
                <flux:button wire:click='confirmDelete' icon="trash" variant="primary" color="red">Delete</flux:button>
            </flux:button.group>
        </div>
    </flux:modal>
    <flux:modal name="edit-client-phone-number" wire:model='showModal' wire:close='hideModal' class="md:w-96">
        <form wire:submit.prevent="save">
            <div class="space-y-4">
                <div>
                    <flux:heading size="lg"> {{$this->clientPhoneNumberForm->id ? 'Edit ' : 'Create '}} Phone Number
                    </flux:heading>
                </div>
                <flux:input label="Phone Number" mask="(999) 999-9999" wire:model='clientPhoneNumberForm.phoneNumber'
                    placeholder="Phone Number" />
                <flux:textarea label="Notes" wire:model='clientPhoneNumberForm.notes' />
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
