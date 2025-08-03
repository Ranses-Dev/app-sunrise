<?php

namespace App\Livewire\Client\Relationships;

use App\Enums\CrudMessages;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Livewire\Forms\ClientFile as ClientFileForm;
use App\Models\ClientFile;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ClientFiles extends Component
{
    use WithFileUploads, WithoutUrlPagination, WithPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public ClientFileForm $clientFileForm;
    public bool $showModal = false;

    public function mount(int $clientId)
    {
        $this->clientFileForm->clientId = $clientId;
    }
    public function render()
    {
        return view('livewire.client.relationships.client-files');
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
    public function confirmDelete($id)
    {
        $this->idToDelete = $id;
        if ($this->idToDelete) {
            $this->clientFileForm->id = $this->idToDelete;
            $this->clientFileForm->delete();
            Flux::toast(variant: 'success', position: 'top-right', text: __(CrudMessages::DELETE_SUCCESS->value));
        }
        $this->reset('idToDelete');
    }

    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return ClientFile::with('attachmentType')
            ->search($this->search)
            ->where('client_id', $this->clientFileForm->clientId)
            ->latest()
            ->paginate(pageName: 'client-files-page');
    }
    public function openModal()
    {
        $this->clientFileForm->getAttachmentTypes();
        if ($this->clientFileForm->id) {
            $this->clientFileForm->setData($this->clientFileForm->id);
        }
        $this->showModal = true;
    }
    public function hideModal()
    {
        $this->showModal = false;
        $this->clientFileForm->reset(['id', 'attachmentTypeId', 'fileName', 'file', 'notes']);
        $this->clientFileForm->resetValidation();
    }
    public function save(): void
    {
        $this->clientFileForm->save();
        $this->hideModal();
        $message = $this->clientFileForm->id ? CrudMessages::UPDATE_SUCCESS->value : CrudMessages::CREATE_SUCCESS->value;
        $this->clientFileForm->reset(['id']);
        Flux::toast(variant: 'success', position: 'top-right', text: __($message));
        $this->dispatch('saved-file');
    }
    public function downloadFile(int $id)
    {
        return $this->redirect(route('client.files.download', ['id' => $id]));
    }
    public function edit($id)
    {
        $this->clientFileForm->id = $id;
        $this->openModal();
    }
}
