<?php

namespace App\Http\Controllers\Exports;

use App\Exports\Excel\AddressExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AddressRepositoryInterface as AddressRepository;
use Maatwebsite\Excel\Facades\Excel;

class AddressExcelExportController extends Controller
{
    public function __invoke(Request $request, AddressRepository $repo)
    {
        $filters = $request->input('filters', []);
        $columns = $request->input('columns', []);
        return Excel::download(
            new AddressExport($repo, $filters, $columns),
            'addresses.xlsx'
        );
    }
}
