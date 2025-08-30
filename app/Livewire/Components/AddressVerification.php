<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Repositories\SmartyApiRepositoryInterface;

class AddressVerification extends Component
{
    protected SmartyApiRepositoryInterface $smartyApiRepository;
    public string $street = '';
    public string $city = '';
    public string $state = '';
    public string $zip = '';
    public string $county = '';

    public function boot()
    {
        $this->smartyApiRepository = app(SmartyApiRepositoryInterface::class);
    }
    protected array $rules = [
        'street' => ['required', 'string', 'min:3'],
        'city'   => ['nullable', 'string'],
        'state'  => ['nullable', 'string', 'min:2', 'max:2'], // US
        'zip'    => ['nullable', 'string', 'min:5', 'max:10'],
    ];
    public function render()
    {
        return view('livewire.components.address-verification');
    }

    public function verifyAddress()
    {

        $result = $this->smartyApiRepository->verifyAddress($this->street, $this->city, $this->state, $this->zip);
        $this->reset();
        if ($result === false) {
            $this->addError('address', 'Address verification failed. Please check the address and try again.');
            return;
        }
        if (empty($result)) {
            $this->addError('address', 'Address not found. Please check the address and try again.');
            return;
        }

        // Assuming we take the first result

          // Assuming county is part of the response
        $this->dispatch('addressVerified', [
            'delivery_line_1' => $this->result['delivery_line_1'] ?? '',
            'last_line' => $this->result['last_line'] ?? '',
            'city' => $this->result['city_name'] ?? '',
            'state' => $this->result['state_abbreviation'] ?? '',
            'zip' => $this->result['zipcode'] ?? '',
            'county' => $this->result['county_name'] ?? '',
        ]);
        // Clear any previous errors
        $this->resetErrorBag('address');
    }
}
