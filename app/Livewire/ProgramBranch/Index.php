<?php

namespace App\Livewire\ProgramBranch;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\ProgramBranch as ProgramBranchForm;
use App\Models\ProgramBranch;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Title('List Program Branch')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public ProgramBranchForm $form;
    public string $search = '';
    public ?int $idToDelete = null;
    public function render()
    {
        return view('livewire.program-branch.index');
    }
    public function create()
    {
        return redirect()->route('program-branches.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('program-branches.edit', $id);
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
        return ProgramBranch::with('program')->search($this->search)
            ->paginate(pageName: 'program-branches-page');
    }
}
