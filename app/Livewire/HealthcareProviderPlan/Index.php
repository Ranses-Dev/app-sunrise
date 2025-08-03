<?php

namespace App\Livewire\HealthcareProviderPlan;

use App\Enums\CrudMessages;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Livewire\Forms\HealthcareProviderPlan as HealthcareProviderPlanForm;

use App\Models\HealthcareProviderPlan;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('Health Care Provider Plans')]
class Index extends Component
{
    use WithoutUrlPagination, WithPagination;
    public string $search = '';
    public ?int $idToDelete = null;
    public HealthcareProviderPlanForm $form;
    public function render()
    {
        return view('livewire.healthcare-provider-plan.index');
    }
    public function create()
    {
        return redirect()->route('healthcare-provider-plans.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('healthcare-provider-plans.edit', $id);
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
        return  HealthcareProviderPlan::search($this->search)

            ->paginate(pageName: 'healthcare-provider-plans-page');
    }
}
