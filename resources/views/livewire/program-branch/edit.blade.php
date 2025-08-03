<div class="flex  flex-col justify-center items-center">
    <form wire:submit.prevent="update" class="form">
        <flux:heading>Edit Program Branch</flux:heading>
        <flux:select label="Programs" wire:model="form.programId" variant="listbox" searchable clearable
            placeholder="Choose programs...">

            @foreach ($this->form->programs as $program)
                <flux:select.option value="{{$program->id}}">{{$program->name}}</flux:select.option>
            @endforeach

        </flux:select>
        <flux:input wire:model="form.name" type="text" label="Name" />
        <flux:textarea wire:model="form.description" label="Description" />
        <flux:button.group class="buttons">
            <flux:button wire:click="cancel" type="button" icon="x-mark">Cancel</flux:button>
            <flux:button type="submit" icon="plus" variant="primary">Save</flux:button>
        </flux:button.group>
    </form>
</div>
