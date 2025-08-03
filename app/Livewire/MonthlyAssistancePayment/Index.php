<?php

namespace App\Livewire\MonthlyAssistancePayment;

use App\Enums\CrudMessages;
use App\Models\MonthlyAssistancePayment;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Livewire\Forms\MonthlyAssistancePayment as MonthlyAssistancePaymentForm;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
#[Title('Monthly Assistance Payments')]
class Index extends Component
{
    use WithPagination, WithoutUrlPagination;
    public MonthlyAssistancePaymentForm $form;
    public string $search = '';
    public ?int $idToDelete = null;
    public function render()
    {
        return view('livewire.monthly-assistance-payment.index');
    }
    public function create()
    {
        return redirect()->route('monthly-assistance-payments.create');
    }
    public function edit(int $id)
    {
        return redirect()->route('monthly-assistance-payments.edit', $id);
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
        return MonthlyAssistancePayment::search($this->search)
            ->paginate(pageName: 'monthly-assistance-payments-page');
    }


}
