<?php

namespace App\Livewire\HealthCareProvider;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\HealthCareProvider as HealthCareProviderForm;
use App\Models\HealthCareProvider;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Health Care Providers')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public HealthCareProviderForm $form;

    public function render()
    {
        return view('livewire.health-care-provider.index');
    }
    public function create()
    {
        return redirect()->route('health-care-providers.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('health-care-providers.edit', $id);
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
        return HealthCareProvider::with('plans')->search($this->search)
            ->paginate(pageName: 'health-care-providers-page');
    }
}
