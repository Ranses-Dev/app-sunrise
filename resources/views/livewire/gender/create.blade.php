<div class="flex  flex-col justify-center items-center">
    <form wire:submit.prevent="store" class="form">
        <flux:heading>Create Gender</flux:heading>
        <flux:input wire:model="form.name" type="text" label="Name" />
        <flux:button.group class="buttons">
            <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
            <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
            <flux:button wire:click="storeAndNew" type="button" icon="squares-plus" variant="filled">Save & New
            </flux:button>
        </flux:button.group>
    </form>
</div>
