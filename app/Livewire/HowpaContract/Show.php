<?php

namespace App\Livewire\HowpaContract;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HowpaContract as FormsHowpaContract;

#[Title('Details HOWPA Contract')]
class Show extends Component
{
    public FormsHowpaContract $form;
    public function render()
    {
        return view('livewire.howpa-contract.show');
    }
    public function mount(int|string $id)
    {
        $this->form->setData($id);
    }
    public function goBack()
    {
        $this->redirect(route('howpa.contracts.index'), true);
    }
}
