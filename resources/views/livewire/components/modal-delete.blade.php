<div>
    <flux:modal wire:model.live="showModal" name="delete-profile" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete Confirmation</flux:heading>
                <flux:separator></flux:separator>
                <flux:text class="mt-2">
                    <p>You are about to delete this data.</p>
                    <p>This action cannot be undone.</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button wire:click="cancelDelete" icon="x-mark" variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button wire:click="confirmDelete" icon="trash" type="submit" variant="danger">Confirm Delete</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
