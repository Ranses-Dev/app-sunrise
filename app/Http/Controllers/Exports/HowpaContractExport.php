<?php

namespace App\Http\Controllers\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\HowpaContractRepositoryInterface as HowpaContractRepository;

use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\PdfBuilder;

class HowpaContractExport extends Controller
{
    public function __construct(private HowpaContractRepository $howpaContractRepository) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request):PdfBuilder
    {

        $data = $this->howpaContractRepository->getFiltered($request->input('filters')??[])->get();
        return Pdf::format(Format::Letter)
            ->orientation(Orientation::Landscape)
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot
                    ->setNodeBinary('/usr/bin/node')
                    ->setNpmBinary('/usr/bin/npm')
                    ->setChromePath('/usr/bin/chromium-browser')
                    ->setOption('args', ['--no-sandbox']);
            })
         ->margins(10, 10, 10, 10)
            ->download('howpa-contracts-list.pdf')
            ->view('exports.pages.howpa-contracts', compact('data'))
            ->footerView('exports.pages.footer');
    }
}
