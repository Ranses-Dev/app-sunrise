<?php

namespace App\Exports\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Repositories\ContractMealRepositoryInterface as MealContractRepository;

class MealContractExport implements FromView
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected MealContractRepository $mealContractRepository,
        protected array $filters = [],
        protected array $columns = [],

    ) {

    }
    public function view(): View
    {
        $data = $this->mealContractRepository->getFiltered($this->filters)->get();
        $columns = $this->columns;
        return view('exports.pages.contract-meals', compact('data', 'columns'));
    }
}
