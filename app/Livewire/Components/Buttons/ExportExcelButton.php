<?php

namespace App\Livewire\Components\Buttons;

use Livewire\Component;

class ExportExcelButton extends Component
{
    public function render()
    {
        return view('livewire.components.buttons.export-excel-button');
    }
    public function export()
    {
        $this->dispatch('export');
    }
}
