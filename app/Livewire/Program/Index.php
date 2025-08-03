<?php

namespace App\Livewire\Program;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\Program as ProgramForm;
use App\Models\Program;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Title('Programs')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public ProgramForm $form;
    public string $search = '';
    public ?int $idToDelete = null;
    public function render()
    {
        return view('livewire.program.index');
    }
    public function create()
    {
        return redirect()->route('programs.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('programs.edit', $id);
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
        return Program::with('branches')->search($this->search)
            ->paginate(pageName: 'programs-page');
    }
}
