<div class="space-y-4">
       <div class="flex justify-between">
        <flux:input wire:model.live.debounce1000="search" class="input-search" icon="magnifying-glass"
            placeholder="Search ..." />
        <flux:button wire:click="openModal" variant="primary" icon="arrow-up-tray">Upload</flux:button>
    </div>
    <flux:table :paginate="$this->results">
        <flux:table.columns>
            <flux:table.column>Name</flux:table.column>
            <flux:table.column>Document Type</flux:table.column>
            <flux:table.column>Notes</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->results as $result)
                <flux:table.row :key="$result->id">
                    <flux:table.cell>{{ $result->file_name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->attachmentType?->name }}</flux:table.cell>
                    <flux:table.cell>{{ $result->notes }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button icon:trailing="ellipsis-vertical"></flux:button>
                            <flux:menu>
                                <flux:menu.item wire:click='downloadFile({{ $result->id }})' icon="arrow-down-tray">Download
                                </flux:menu.item>
                                <flux:menu.item wire:click="edit({{$result->id}})" icon="pencil-square">Edit
                                </flux:menu.item>
                                <flux:menu.item wire:click="confirmDelete({{$result->id}})" icon="trash" variant="danger">Delete
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

    <flux:modal name="edit-client-file" wire:model='showModal' wire:close='hideModal' class="md:w-96">
        <form wire:submit.prevent="save">
            <div class="space-y-4">
                <div>
                    <flux:heading size="lg"> {{$this->clientFileForm->id ? 'Edit ' : 'Upload '}} File</flux:heading>
                </div>
                <flux:select wire:model='clientFileForm.attachmentTypeId' variant="listbox" label="Attachment Type" clearable
                    placeholder="Choose document tye ...">
                    @if ($this->clientFileForm->attachmentTypes)
                        @foreach ($this->clientFileForm->attachmentTypes as $attachmentType)
                            <flux:select.option value="{{ $attachmentType->id }}">{{$attachmentType->name}}</flux:select.option>
                        @endforeach
                    @endif
                </flux:select>
                <flux:error name="clientFileForm.attachmentTypeId" />
                <flux:input name="clientFileForm.file" type="file" wire:model="clientFileForm.file" label="Attachment" />
                <flux:input label="Name" wire:model='clientFileForm.fileName' placeholder="File name" />
                <flux:textarea label="Notes" wire:model='clientFileForm.notes' placeholder="Notes" />
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Save</flux:button>
                </div>
            </div>
        </form>
    </flux:modal>
    <livewire:components.modal-delete />
</div>
