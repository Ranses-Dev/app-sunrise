<?php

namespace App\Livewire\IdentificationType;

use App\Enums\CrudMessages;
use App\Models\IdentificationType;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\IdentificationType as IdentificationTypeForm;
#[Title('Identification Types')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public IdentificationTypeForm $form;
    public string $search = '';
    public ?int $idToDelete = null;
    public function render()
    {
        return view('livewire.identification-type.index');
    }
    public function create()
    {
        return redirect()->route('identification-types.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('identification-types.edit', $id);
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return IdentificationType::search($this->search)
            ->paginate(pageName: 'identification-types-page');
    }

    public function delete($id)
    {
        $this->idToDelete = $id;
        $this->dispatch('open-modal-delete');
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
    #[On('cancel-delete')]
    public function cancelDelete()
    {
        $this->reset('idToDelete');
    }
}
