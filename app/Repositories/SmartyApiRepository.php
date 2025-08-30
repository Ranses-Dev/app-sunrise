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
            'candidates' => 1,
        ], fn($value) => !is_null($value) && $value !== '');


        try {
            $response = $client->get('', ['query' => $query]);
            $status = $response->getStatusCode();
            if ($status > 400) {
                return false;
            }
            $data = json_decode($response->getBody()->getContents(), true) ?? [];
            return [
                'delivery_line_1' => $data[0]['delivery_line_1'],
                'last_line' => $data[0]['last_line'],
                'city' => $data[0]['components']['city_name'] ?? null,
                'state' => $data[0]['components']['state_abbreviation'] ?? null,
                'county_name' => $data[0]['metadata']['county_name'] ?? null,
                'state_abbreviation' => $data[0]['components']['state_abbreviation'] ?? null,
                'postal_code' => $data[0]['components']['zipcode'] ?? null,
                'street_name' => $data[0]['components']['street_name'] ?? null,
            ];
        } catch (GuzzleException $e) {
            Log::error('Smarty API request failed: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('Smarty API request failed: ' . $e->getMessage());
            return false;
        }
    }
}
