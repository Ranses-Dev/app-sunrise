<?php

namespace App\Livewire\Modules\Codifier\Ethnicity;

use App\Livewire\Forms\Modules\Codifier\EthnicityForm;
use Flux\Flux;
use Livewire\Component;

class Create extends Component
{
    public EthnicityForm $form;
    public function render()
    {
        return view('livewire.modules.codifier.ethnicity.create');
    }

    public function save()
    {
        $this->form->store();
        Flux::toast('Your changes have been saved.', position: 'top right');
        redirect()->route('codifiers.ethnicity.index');
    }
}
