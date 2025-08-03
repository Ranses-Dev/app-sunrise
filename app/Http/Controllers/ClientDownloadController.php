<?php

namespace App\Http\Controllers;


use App\Repositories\ClientRepository;

class ClientDownloadController extends Controller
{
    public $clientRepository;
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    public function __invoke(int $id)
    {
        $client = $this->clientRepository->findById($id);
        if ($client) {
            return $this->clientRepository->downloadFile($id);
        }
        abort(404, 'Client not found');
    }
}
