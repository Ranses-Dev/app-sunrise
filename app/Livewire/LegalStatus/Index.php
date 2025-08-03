<?php

namespace App\Livewire\LegalStatus;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\LegalStatus as LegalStatusForm;
use App\Models\LegalStatus;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Title('Legal Status')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public LegalStatusForm $form;
    public string $search = '';
    public ?int $idToDelete = null;
    public function render()
    {
        return view('livewire.legal-status.index');
    }
    public function create()
    {
        return redirect()->route('legal-statuses.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('legal-statuses.edit', $id);
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
        return LegalStatus::search($this->search)
            ->paginate(pageName: 'legal-statuses-page');
    }
}
