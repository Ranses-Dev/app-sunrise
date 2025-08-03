<?php

namespace App\Livewire\Components\Buttons;

use Livewire\Component;

class ExportButton extends Component
{
    public function render()
    {
        return view('livewire.components.buttons.export-button');
    }

    public function export()
    {
        $this->dispatch('export');
    }
}
