<div>
    <flux:button variant="primary" wire:click="open" icon="adjustments-vertical">Columns</flux:button>
    <flux:modal :closable="false" wire:model='isOpen' name="select-columns-modal" class="md:w-96 h-1/2">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Columns</flux:heading>
                <flux:separator class="mt-2" />
            </div>

            <flux:checkbox.group wire:model="columnsSelected">
                @foreach ($columns as $column)
                    <flux:checkbox value="{{ $column['value'] }}" label="{{ $column['label'] }}" />
                @endforeach
            </flux:checkbox.group>

            <flux:button.group class="justify-end">
                <flux:button type="button" wire:click="close" variant="primary" color="red" icon="no-symbol">Close</flux:button>
                <flux:button type="button" wire:click="saveChanges" variant="primary" icon="check-circle">Save changes</flux:button>
            </flux:button.group>
        </div>
    </flux:modal>

</div>
