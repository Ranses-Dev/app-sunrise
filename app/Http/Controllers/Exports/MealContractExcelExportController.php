<?php

namespace App\Http\Controllers\Exports;

use App\Exports\Excel\MealContractExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ContractMealRepositoryInterface as ContractMealRepository;
use Maatwebsite\Excel\Facades\Excel;

class MealContractExcelExportController extends Controller
{
    public function __invoke(Request $request, ContractMealRepository $repo)
    {
        $filters = $request->input('filters', []);
        $columns = $request->input('columns', []);
        return Excel::download(
            new MealContractExport($repo, $filters, $columns),
            'meal_contracts.xlsx'
        );
    }
}
