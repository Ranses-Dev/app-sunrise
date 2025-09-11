<?php

namespace App\Http\Controllers\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;
use \Spatie\LaravelPdf\Enums\Orientation;
use App\Repositories\InspectionRepositoryInterface as InspectionRepository;
use Spatie\LaravelPdf\PdfBuilder;

class InspectionExport extends Controller
{
    public function __construct(protected InspectionRepository $inspectionRepository) {}
    public function __invoke(Request $request): PdfBuilder
    {

        $queryParameters = $request->input('filters');
        $inspections = $this->inspectionRepository->getFiltered($queryParameters)->get();
        $columns = $request->input('columns', []);
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
            ->download('inspections.pdf')
            ->view('exports.pages.inspections', compact('inspections', 'columns'))
            ->footerView('exports.pages.footer');
    }
}
