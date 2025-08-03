<?php

namespace App\Livewire\Forms;


use Livewire\Form;
use App\Repositories\MonthlyAssistancePaymentRepositoryInterface;
use Illuminate\Validation\Rule;

class MonthlyAssistancePayment extends Form
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;

    protected MonthlyAssistancePaymentRepositoryInterface $monthlyAssistancePaymentRepository;
    public function boot(MonthlyAssistancePaymentRepositoryInterface $monthlyAssistancePaymentRepository)
    {
        $this->monthlyAssistancePaymentRepository = $monthlyAssistancePaymentRepository;
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('monthly_assistance_payments')->ignore($this->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->monthlyAssistancePaymentRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->name = $result->name;
                $this->description = $result->description;
            }
        }
    }
    public function save()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];
        if ($this->id) {
            $this->monthlyAssistancePaymentRepository->update($this->id, $data);
        } else {
            $this->monthlyAssistancePaymentRepository->create($data);
        }
        $this->reset(['id', 'name', 'description']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->monthlyAssistancePaymentRepository->delete($this->id);
        }
    }
}
