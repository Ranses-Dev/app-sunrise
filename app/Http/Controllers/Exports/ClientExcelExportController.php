<?php

namespace App\Http\Controllers\Exports;

use App\Exports\Excel\ClientExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use Maatwebsite\Excel\Facades\Excel;

class ClientExcelExportController extends Controller
{
    public function __invoke(Request $request, ClientRepository $repo)
    {
        $filters = $request->input('filters', []);
        $columns = $request->input('columns', []);
        return Excel::download(
            new ClientExport($repo, $filters, $columns),
            'clients.xlsx'
        );
    }
}
