<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClientFileRepositoryInterface as ClientFileRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientFileDownloadController extends Controller
{
    public ClientFileRepository $clientFileRepository;
    public function __construct(ClientFileRepository $clientFileRepository)
    {
        $this->clientFileRepository = $clientFileRepository;
    }

    public function __invoke(int $id): StreamedResponse
    {
        $clientFile = $this->clientFileRepository->findById($id);
        if ($clientFile) {
            return $this->clientFileRepository->downloadFile($id);
        }
        abort(404, 'Client File not found');
    }
}
