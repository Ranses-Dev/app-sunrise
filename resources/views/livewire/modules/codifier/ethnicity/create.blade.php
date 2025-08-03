 
<div class="space-y-4 max-w-xl mx-auto">
    <flux:heading>Create Ethnicity</flux:heading>
    <div class="space-y-2">
        <flux:input label="Name" wire:model.defer="form.name" />
        <flux:textarea label="Notes" wire:model.defer="form.notes" />
    </div>
    <div class="flex justify-end gap-2">
        <flux:button wire:click="save" icon="check" variant="primary">Save</flux:button>
        <flux:button tag="a" href="{{ route('codifiers.ethnicity.index') }}">Cancel</flux:button>
    </div>
</div>
