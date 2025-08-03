<?php

namespace App\Livewire\City;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\City as CityForm;
use App\Models\City;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Title('Cities')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public CityForm $form;
    public function render()
    {
        return view('livewire.city.index');
    }
    public function create()
    {
        return redirect()->route('cities.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('cities.edit', $id);
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
        return City::search($this->search)
            ->paginate(pageName: 'cities-page');
    }
}
