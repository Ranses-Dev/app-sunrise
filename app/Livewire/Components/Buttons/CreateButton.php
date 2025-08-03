<?php

namespace App\Livewire\Components\Buttons;

use Livewire\Component;

class CreateButton extends Component
{
    public function render()
    {
        return view('livewire.components.buttons.create-button');
    }

    public function create()
    {
        $this->dispatch('create');
    }
}
