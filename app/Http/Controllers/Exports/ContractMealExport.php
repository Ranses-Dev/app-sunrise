<?php

namespace App\Http\Controllers\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ContractMealRepositoryInterface as ContractMealRepository;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;
use \Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\PdfBuilder;
use App\Repositories\MealContractStatisticsRepositoryInterface as MealContractStatisticsRepository;

class ContractMealExport extends Controller
{
    public function __construct(protected ContractMealRepository $repository, protected MealContractStatisticsRepository $statisticsRepository) {}
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): PdfBuilder
    {

        $data = $this->repository->getFiltered($request->input('filters', []))->get();
        $columns = $request->input('columns') ?? [];
        $stats = $this->statisticsRepository->getStatisticsForToday();
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
            ->download('contract_meals.pdf')
            ->view('exports.pages.contract-meals', compact('data', 'columns', 'stats'))
            ->footerView('exports.pages.footer');
    }
}
