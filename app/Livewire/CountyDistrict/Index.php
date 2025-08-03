<?php

namespace App\Livewire\CountyDistrict;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\CountyDistrict as CountyDistrictForm;
use App\Models\CountyDistrict;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

#[Title('County Districts')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public CountyDistrictForm $form;
    public function render()
    {
        return view('livewire.county-district.index');
    }

    public function create()
    {
        return redirect()->route('county-districts.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('county-districts.edit', $id);
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
        return CountyDistrict::with('cities')->search($this->search)
            ->paginate(pageName: 'county-districts-page');
    }
}
