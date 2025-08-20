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
        $address = $result[0];
        $this->street = $address['delivery_line_1'] ?? '';
        $this->city = $address['components']['city_name'] ?? '';
        $this->state = $address['components']['state_abbreviation'] ?? '';
        $this->zip = $address['components']['zipcode'] ?? '';
        $this->county = $address['metadata']['county_name'] ?? ''; // Assuming county is part of the response

        // Clear any previous errors
        $this->resetErrorBag('address');
    }
}
