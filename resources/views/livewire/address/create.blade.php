<div>
<x-page-heading title="New Address" />
<div class="flex  flex-col justify-center items-center w-full">
    <form wire:submit.prevent="create" class="form">

        <flux:input wire:model="form.deliveryLine1" type="text" label="Address" />
        <flux:input wire:model="form.city" type="text" label="City" />
        <flux:input wire:model="form.stateAbbreviation" type="text" label="State" />
        <flux:input wire:model="form.postalCode" type="text" label="Postal Code" />
        <flux:button.group class="buttons">
            <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
            <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
            <flux:button wire:click="createAndNew" type="button" icon="squares-plus" variant="filled">Save & New
            </flux:button>
        </flux:button.group>
    </form>
</div>
</div>

