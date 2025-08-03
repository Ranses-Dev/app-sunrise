<?php

namespace App\Livewire\AttachmentType;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\AttachmentType as AttachmentTypeForm;
use Flux\Flux;

#[Title('Create Attachment Type')]
class Create extends Component
{
    public AttachmentTypeForm $form;
    public function render()
    {
        return view('livewire.attachment-type.create');
    }
    public function store()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
        return redirect()->route('attachment-types.index');
    }
    public function storeAndNew()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: CrudMessages::CREATE_SUCCESS->value);
    }
    public function cancel()
    {
        return redirect()->route('attachment-types.index');
    }
}
