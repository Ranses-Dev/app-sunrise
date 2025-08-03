<?php

namespace App\Livewire\IncomeLimit;

use App\Enums\CrudMessages;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\IncomeLimit as IncomeLimitForm;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Income Limits')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public string $percentageCategory = '';
    public string $householdSize = '';
    public string $incomeLimit = '';
    public array $filters = [
        'percentageCategory' => '',
        'householdSize' => '',
        'incomeLimit' => '',
    ];
    public ?int $idToDelete = null;
    public IncomeLimitForm $form;
    public function mount()
    {
        $this->form->getIncomeLimits();
        $this->form->getHouseholdSizes();
        $this->form->percentageCategories();
    }
    public function render()
    {
        return view('livewire.income-limit.index');
    }
    public function create()
    {
        return redirect()->route('income-limits.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('income-limits.edit', $id);
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
        return $this->form->getFiltered([
            'percentage_category' => $this->filters['percentageCategory'],
            'household_size' => $this->filters['householdSize'],
            'income_limit' => $this->filters['incomeLimit']
        ]);

    }
}
