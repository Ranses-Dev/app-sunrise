<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\CountyDistrict;
use Illuminate\Database\Eloquent\Collection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class SmartyApiRepository implements SmartyApiRepositoryInterface
{
    public function verifyAddress(string $street = "", string $city = "", string $state = "", string $zipcode = ""): array|bool
    {
        $client = new Client([
            'base_uri' => config('services.smarty.base_url'),
            'timeout' => config('services.smarty.timeout'),
            'http_errors' => false,
            'headers' => ['Accept' => 'application/json'],
            'verify' => false
        ]);
        $query = array_filter([
            'street'  => $street,
            'city'    => $city,
            'state'   => $state,
            'zipcode' => $zipcode,
            'auth-id'    => config('services.smarty.auth_id'),
            'auth-token' => config('services.smarty.auth_token'),
        ], fn($value) => !is_null($value) && $value !== '');


        try {
            Log::info('Sending request to Smarty API with query: ' . json_encode($query));
            $response = $client->get('', ['query' => $query]);
            $status = $response->getStatusCode();
            Log::info('Smarty API response status: ' . $status);
            if ($status > 400) {
                return false;
            }
            return json_decode($response->getBody()->getContents(), true)??[];
        } catch (GuzzleException $e) {
            Log::error('Smarty API request failed: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('Smarty API request failed: ' . $e->getMessage());
            return false;
        }
    }
}
