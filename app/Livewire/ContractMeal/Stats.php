<?php

namespace App\Livewire\ContractMeal;

use Livewire\Component;
use App\Repositories\MealContractStatisticsRepositoryInterface  as ContractMealRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;

class Stats extends Component
{
    protected ContractMealRepository $contractMealRepository;
    public function mount()
    {
        $this->contractMealRepository = app(ContractMealRepository::class);
    }

    public function render()
    {
        return view('livewire.contract-meal.stats');
    }

    #[Computed]
    public function stats(): Collection
    {
        $data = $this->contractMealRepository->getStatisticsForToday();
        return collect($data);
    }
}
