<?php

namespace App\Exports\Excel;

use App\Repositories\InspectionRepositoryInterface;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InspectionsExport implements FromView
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected InspectionRepositoryInterface $inspectionRepository,
        protected array $filters = [],
        protected array $columns = [],
    ) {
        //
    }
    public function view(): View
    {
        $inspections = $this->inspectionRepository->getFiltered($this->filters)->get();
        $columns = $this->columns;
        return view('exports.pages.inspections', compact('inspections', 'columns'));
    }
}
