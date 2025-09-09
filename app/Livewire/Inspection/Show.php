<?php

namespace App\Livewire\Inspection;

use Livewire\Component;
use App\Livewire\Forms\Inspection as InspectionForm;
use Livewire\Attributes\Title;

#[Title('Inspection Details')]
class Show extends Component
{
    public InspectionForm $form;
    public function mount(int $id)
    {
        $this->form->id = $id;
        $this->form->setData();
    }
    public function render()
    {
        return view('livewire.inspection.show');
    }

    public function goBack()
    {
        $this->redirect(route('inspections.index', true));
    }
}
