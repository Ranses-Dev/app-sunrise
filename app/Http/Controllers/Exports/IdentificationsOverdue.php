<?php

namespace App\Http\Controllers\Exports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;
use \Spatie\LaravelPdf\Enums\Orientation;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\PdfBuilder;

class IdentificationsOverdue extends Controller
{
    public function __construct(protected ClientRepository  $clientRepository)
    {
        $this->clientRepository = app(ClientRepository::class);
    }

    public function __invoke(Request $request):PdfBuilder
    {
        $clients = $this->clientRepository->identificationsOverdue($request->input('filters'))->get();
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
            ->download('clients-list.pdf')
            ->view('exports.pages.identifications-overdue', compact('clients'))
            ->footerView('exports.pages.footer');
    }
}
