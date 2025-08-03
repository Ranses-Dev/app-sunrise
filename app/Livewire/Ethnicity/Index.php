<?php

namespace App\Livewire\Ethnicity;

use App\Enums\CrudMessages;

use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\Ethnicity as EthnicityForm;
use App\Models\Ethnicity;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Title('Ethnicities')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public EthnicityForm $form;
    public function render()
    {
        return view('livewire.ethnicity.index');
    }
    public function create()
    {
        return redirect()->route('ethnicities.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('ethnicities.edit', $id);
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
        return Ethnicity::search($this->search)
            ->paginate(pageName: 'ethnicities-page');
    }
}
