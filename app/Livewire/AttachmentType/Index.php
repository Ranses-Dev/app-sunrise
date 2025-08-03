<?php

namespace App\Livewire\AttachmentType;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\AttachmentType as AttachmentTypeForm;
use App\Models\AttachmentType;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Title('Attachment Types')]
class Index extends Component
{
    public string $search = '';
    public ?int $idToDelete = null;
    public AttachmentTypeForm $form;
    public function render()
    {
        return view('livewire.attachment-type.index');
    }
    public function create()
    {
        return redirect()->route('attachment-types.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('attachment-types.edit', $id);
    }
    public function delete($id)
    {
        $this->idToDelete = $id;
        $this->dispatch('open-modal-delete');
    }
    #[On('cancel-delete')]
    public function cancelDelete()
    {
        $this->reset('idToDelete');
    }
    #[On('confirm-delete')]
    public function confirmDelete()
    {
        if ($this->idToDelete) {
            $this->form->id = $this->idToDelete;
            $this->form->delete();
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->reset('idToDelete');
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return AttachmentType::search($this->search)
            ->paginate(pageName: 'clients-page');
    }
}
