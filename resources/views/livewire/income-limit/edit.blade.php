<div class="flex  flex-col justify-center items-center">
    <form wire:submit.prevent="update" class="form">
        <flux:heading>Edit Income Limit</flux:heading>
        <flux:input wire:model="form.percentageCategory" type="number" label="Percentage Category" />
        <flux:input wire:model="form.householdSize" type="number" label="Household Size" />
        <flux:input wire:model="form.incomeLimit" type="text" label="Income Limit" />
        <flux:button.group class="buttons">
            <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
            <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
        </flux:button.group>
    </form>
</div>
