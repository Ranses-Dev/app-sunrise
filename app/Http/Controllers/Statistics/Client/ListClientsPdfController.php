<?php

namespace App\Http\Controllers\Statistics\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\Browsershot\Browsershot;


class ListClientsPdfController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $clients = Client::all();
        return Pdf::footerView('statistics.common.footer')
            ->format(Format::Letter)
            ->orientation(Orientation::Landscape)
            /*->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot
                    ->setNodeBinary('/usr/bin/node')
                    ->setNpmBinary('/usr/bin/npm')
                    ->setChromePath('/usr/bin/chromium-browser')
                    ->setOption('args', ['--no-sandbox']);
            })*/
            ->margins(10, 10, 10, 10)
            ->download('clients-list.pdf')
            ->view('statistics.clients.pdfs.list', compact('clients'));
    }
}
