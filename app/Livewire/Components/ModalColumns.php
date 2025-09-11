<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ModalColumns extends Component
{
    public bool $isOpen = false;
    public array $columnsSelected = [];
    public array $columns = [];
    public function mount(array $columnsSelected, array $columns)
    {
        $this->columnsSelected = $columnsSelected;
        $this->columns = $columns;
    }
    public function render()
    {
        return view('livewire.components.modal-columns');
    }

    public function open()
    {
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function saveChanges()
    {
        $this->dispatch('columns-updated', $this->columnsSelected);
        $this->close();
    }
}
