<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Repositories\HowpaContractRepositoryInterface as HowpaContractRepository;

class HowpaContractExport implements FromView
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected HowpaContractRepository $howpaContractRepository,
        protected array $filters = [],
        protected array $columns = [],
    ) {
        //
    }

    public function view(): View
    {
        $data = $this->howpaContractRepository->getFiltered($this->filters)->get();
        $columns = $this->columns;
        return view('exports.pages.howpa-contracts', compact('data', 'columns'));
    }
}
