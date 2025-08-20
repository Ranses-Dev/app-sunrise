<div class="space-y-4">
    <form wire:submit.prevent="verifyAddress" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <flux:input label="Street" placeholder="123 Main St" wire:model.defer="street" required />

            <flux:input label="City" placeholder="City" wire:model.defer="city" />

            <flux:input label="State" placeholder="NY" wire:model.defer="state" maxlength="2" />

            <flux:input label="ZIP" placeholder="10001" wire:model.defer="zip" />
        </div>

        {{-- Errores de campo básicos --}}
        @error('street') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        @error('state') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        @error('zip') <p class="text-sm text-red-600">{{ $message }}</p> @enderror

        {{-- Error de verificación (general) --}}
        @error('address')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                <span wire:loading.remove>Verify address</span>
                <span wire:loading>Verifying…</span>
            </flux:button>

            <span class="text-sm text-gray-500" wire:loading>Consulting Smarty…</span>
        </div>
    </form>

    <flux:separator />

    {{-- Dirección estandarizada (solo lectura) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="col-span-1 md:col-span-2">
            <h3 class="font-semibold">Standardized Address</h3>
        </div>

        <flux:input label="Delivery Line 1" readonly value="{{ $street }}" />

        <flux:input label="Last Line" readonly
            value="{{ trim(($city ? $city : '') . ($city && $state ? ', ' : '') . ($state ?: '') . ($zip ? ' ' . $zip : '')) }}" />
        <flux:input label="County" readonly value="{{ trim($county) }}" />
    </div>
</div>
