<?php

namespace App\Exports\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Repositories\AddressRepositoryInterface;

class AddressExport implements FromView
{

    public function __construct(
        protected AddressRepositoryInterface $addressRepository,
        protected array $filters = [],
        protected array $columns = [],
    ) {}
    public function view(): View
    {
        $addresses = $this->addressRepository->getFiltered($this->filters)->get();
        $columns = $this->columns;
        return view('exports.pages.addresses', compact('addresses', 'columns'));
    }
}
