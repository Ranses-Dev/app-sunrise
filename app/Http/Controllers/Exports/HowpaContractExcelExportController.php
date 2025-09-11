<?php

namespace App\Http\Controllers\Exports;

use App\Exports\Excel\HowpaContractExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\HowpaContractRepositoryInterface as HowpaContractRepository;
use Maatwebsite\Excel\Facades\Excel;

class HowpaContractExcelExportController extends Controller
{
    public function __invoke(Request $request, HowpaContractRepository $repo)
    {
        $filters = $request->input('filters', []);
        $columns = $request->input('columns', []);
        return Excel::download(
            new HowpaContractExport($repo, $filters, $columns),
            'howpa_contracts.xlsx'
        );
    }
}
