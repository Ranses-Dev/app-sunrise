<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Repositories\IncomeLimitRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;

class IncomeLimit extends Form
{
    public ?int $id = null;
    public float $percentageCategory = 0;
    public int $householdSize = 0;
    public float $incomeLimit = 0;
    public array $householdSizes = [];
    public array $percentageCategories = [];
    public array $incomeLimits = [];

    protected IncomeLimitRepositoryInterface $incomeLimitRepository;
    public function boot(IncomeLimitRepositoryInterface $incomeLimitRepository)
    {
        $this->incomeLimitRepository = $incomeLimitRepository;
    }
    public function rules(): array
    {
        return [
            'percentageCategory' => ['required', 'numeric', 'min:1'],
            'householdSize' => ['required', 'integer', Rule::unique('income_limits')->where('income_limit', $this->incomeLimit)->ignore($this->id)],
            'incomeLimit' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function setData(?int $id = null): void
    {
        if ($id) {
            $result = $this->incomeLimitRepository->findById($id);
            if ($result) {
                $this->id = $result->id;
                $this->percentageCategory = $result->percentage_category;
                $this->householdSize = $result->household_size;
                $this->incomeLimit = $result->income_limit;
            }
        }
    }
    public function save()
    {
        $this->validate();
        $data = [
            'percentage_category' => $this->percentageCategory,
            'household_size' => $this->householdSize,
            'income_limit' => $this->incomeLimit,
        ];
        if ($this->id) {
            $this->incomeLimitRepository->update($this->id, $data);
        } else {
            $this->incomeLimitRepository->create($data);
        }
        $this->reset(['id', 'percentageCategory', 'householdSize', 'incomeLimit']);
    }
    public function delete()
    {
        if ($this->id) {
            $this->incomeLimitRepository->delete($this->id);
        }
    }
    public function getFiltered(array $filters): LengthAwarePaginator
    {
        return $this->incomeLimitRepository->getFiltered($filters)
            ->paginate(pageName: 'income-limit-page');
    }
    public function getHouseholdSizes()
    {
        $this->householdSizes = $this->incomeLimitRepository->getHouseholdSizes();
    }
    public function percentageCategories()
    {
        $this->percentageCategories = $this->incomeLimitRepository->percentageCategories();
    }
    public function getIncomeLimits()
    {
        $this->incomeLimits = $this->incomeLimitRepository->getIncomeLimits();
    }
}
