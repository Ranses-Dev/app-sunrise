<div class="flex  flex-col justify-center items-center">
    <form wire:submit.prevent="update" class="form">
        <flux:heading>Update Identification Type</flux:heading>
        <flux:input wire:model="form.name" type="text" label="Name" />
        <flux:textarea wire:model="form.description" label="Description" />
        <flux:button.group class="buttons">
            <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
            <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
           </flux:button.group>
    </form>
</div>
