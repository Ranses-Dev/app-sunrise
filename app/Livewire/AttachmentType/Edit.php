<?php

namespace App\Livewire\AttachmentType;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\AttachmentType as AttachmentTypeForm;
use Flux\Flux;

#[Title('Edit Attachment Type')]
class Edit extends Component
{
    public AttachmentTypeForm $form;

    public function mount(int $id)
    {
        $this->form->setData($id);
        }
    public function render()
    {
        return view('livewire.attachment-type.edit');
    }
    public function update()
    {
        $this->form->save();
        Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::UPDATE_SUCCESS->value));
        return redirect()->route('attachment-types.index');
    }
    public function cancel()
    {
        return redirect()->route('attachment-types.index');
    }
}
