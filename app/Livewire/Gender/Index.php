<?php

namespace App\Livewire\Gender;

use App\Enums\CrudMessages;
use App\Models\Gender;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\Gender as GenderForm;

#[Title('Genders')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public GenderForm $form;

    public function render()
    {
        return view('livewire.gender.index');
    }
    public function create()
    {
        return redirect()->route('genders.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('genders.edit', $id);
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
        return Gender::search($this->search)
            ->paginate(pageName: 'genders-page');
    }
}
