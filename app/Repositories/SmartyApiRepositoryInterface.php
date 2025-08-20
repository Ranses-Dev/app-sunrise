<?php

namespace App\Repositories;



interface SmartyApiRepositoryInterface
{

    public function verifyAddress(string $street, string $city, string $state, string $zipcode): array|bool;
}
