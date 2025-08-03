<div class="flex  flex-col justify-center items-center">
    <form wire:submit.prevent="update" class="form">
        <flux:heading>Update Health Care Provider</flux:heading>
        <flux:input wire:model="form.name" type="text" label="Name" />
        <flux:textarea wire:model="form.description" label="Description" />
        <flux:button.group class="buttons">
            <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
            <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
        </flux:button.group>
    </form>
    <flux:tab.group class="w-full">
        <flux:tabs wire:model="tab">
            <flux:tab name="plans">Plans</flux:tab>
        </flux:tabs>
        <flux:tab.panel name="plans">
            @livewire('health-care-provider.relationships.plans', ['id' => $this->form->id])
        </flux:tab.panel>
    </flux:tab.group>
</div>
