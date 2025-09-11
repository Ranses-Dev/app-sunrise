<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Repositories\ClientRepositoryInterface as ClientRepository;

class ClientExport implements FromView
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ClientRepository $clientRepository,
        protected array $filters = [],
        protected array $columns = [],
    ) {
        //
    }
    public function view(): View
    {
        $clients = $this->clientRepository->getFiltered($this->filters)->get();
        $columns = $this->columns;
        return view('statistics.clients.pdfs.list', compact('clients', 'columns'));
    }
}
