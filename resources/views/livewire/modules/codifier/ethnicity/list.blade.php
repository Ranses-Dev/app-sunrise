<?php
use src\Modules\Codifier\Services\EthnicityService;
use function Livewire\Volt\{computed, state, usesPagination, title};
use Flux\Flux;
title('Ethnicities');
$service = app(EthnicityService::class);
usesPagination();
state(['search'])->url();
$orders = computed(function () use ($service) {
    return $service->getAll($this->search)->paginate();
});
$create = fn() => redirect(route('codifiers.ethnicity.create'));
$edit = fn($id) => redirect(route('codifiers.ethnicity.edit', $id));
?>
<div class="space-y-4  mx-auto">
    <div wire:loading.delay>
        <livewire:ui.spinner />
    </div>
    <flux:heading>List Ethnicity</flux:heading>
    <div class="flex justify-between">
        <flux:input icon="magnifying-glass" wire:model.live='search' class="w-full md:w-1/4 lg:w-1/6"
            placeholder="Search..." />
        <flux:button icon="plus" wire:click='create'>Create</flux:button>
    </div>
    <flux:table :paginate="$this->orders">
        <flux:table.columns>
            <flux:table.column sortable>Name</flux:table.column>
            <flux:table.column sortable>Notes</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach ($this->orders as $order)
                <flux:table.row :key="$order->id">
                    <flux:table.cell>{{ $order->name }}</flux:table.cell>
                    <flux:table.cell>{{ $order->notes }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom">
                            </flux:button>
                            <flux:menu>
                                <flux:menu.item icon="pencil-square" wire:click="edit({{$order->id}})">Edit</flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger">Delete</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>
