<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalDelete extends Component
{
    public $showModal = false;
    public function render()
    {
        return view('livewire.components.modal-delete');
    }
    #[On('open-modal-delete')]
    public function openModal()
    {
        $this->showModal = true;
    }

    public function cancelDelete()
    {
        $this->dispatch('cancel-delete');
        $this->showModal = false;
    }

    public function confirmDelete()
    {    Log::info('enter here');
        $this->dispatch('confirm-delete');
        $this->showModal = false;
    }

}
