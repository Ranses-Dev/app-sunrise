<?php

namespace App\Http\Controllers\Exports;

use App\Exports\Excel\InspectionsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\InspectionRepositoryInterface as InspectionRepository;
use Maatwebsite\Excel\Facades\Excel;

class InspectionToExcel  extends Controller
{


    public function __invoke(Request $request, InspectionRepository $repo)
    {
        $filters = $request->input('filters', []);
        $columns = $request->input('columns', []);
        return Excel::download(
            new InspectionsExport($repo, $filters, $columns),
            'inspections.xlsx'
        );
    }

}
