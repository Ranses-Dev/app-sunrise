<div>
    <x-page-heading title="Show Address" />
    <div class="show-information">
        <div class="detail-information">
            <flux:input disabled wire:model="form.deliveryLine1" type="text" label="Address" />
            <flux:input disabled wire:model="form.city" type="text" label="City" />
            <flux:input disabled wire:model="form.stateAbbreviation" type="text" label="State" />
            <flux:input disabled wire:model="form.postalCode" type="text" label="Postal Code" />
            <div class="justify-end flex">
                <flux:button wire:click="goBack" type="button" variant="primary" icon="arrow-uturn-left">Go Back</flux:button>
            </div>
        </div>

    </div>
</div>
