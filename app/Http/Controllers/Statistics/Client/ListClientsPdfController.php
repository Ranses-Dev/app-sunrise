<?php

namespace App\Http\Controllers\Statistics\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\PdfBuilder;
use App\Repositories\ClientRepositoryInterface as ClientRepository;

class ListClientsPdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __construct(private ClientRepository $clientRepository) {}
    public function __invoke(Request $request): PdfBuilder
    {

        $clients = $this->clientRepository->getFiltered($request->input('filters', []))->get();
        $columns = $request->input('columns', []);
        return Pdf::footerView('statistics.common.footer')
            ->format(Format::Letter)
            ->orientation(Orientation::Landscape)
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot
                    ->setNodeBinary('/usr/bin/node')
                    ->setNpmBinary('/usr/bin/npm')
                    ->setChromePath('/usr/bin/chromium-browser')
                    ->setOption('args', ['--no-sandbox']);
            })
            ->margins(10, 10, 10, 10)
            ->download('clients-list.pdf')
            ->view('statistics.clients.pdfs.list', compact('clients', 'columns'))
            ->footerView('exports.pages.footer');
    }
}
