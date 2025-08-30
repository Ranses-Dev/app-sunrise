<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Repositories\SmartyApiRepositoryInterface;
use App\Repositories\AddressRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;

class Address extends Form
{
    public int|null $id = null;
    public string $deliveryLine1 = '';
    public string $lastLine = '';
    public string $streetName = '';
    public string $city = '';
    public string $stateAbbreviation = '';
    public string $postalCode = '';
    public string $countyName = '';
    public array $filters = [
        'deliveryLine1' => null,
        'lastLine' => null,
        'streetName' => null,
        'city' => null,
        'stateAbbreviation' => null,
        'postalCode' => null,
        'countyName' => null,
    ];

    public Collection|null $cities = null;
    public Collection|null $states = null;
    public Collection|null $counties = null;
    protected SmartyApiRepositoryInterface $smartyApiRepository;
    protected AddressRepositoryInterface $addressRepository;


    public function boot()
    {
        $this->smartyApiRepository = app(SmartyApiRepositoryInterface::class);
        $this->addressRepository = app(AddressRepositoryInterface::class);
    }
    public function setAddress(int $id)
    {
        if ($id) {
            $address = $this->addressRepository->findById($id);
            if ($address) {
                $this->id = $address->id;
                $this->deliveryLine1 = $address->delivery_line_1;
                $this->lastLine = $address->last_line;
                $this->streetName = $address->street_name;
                $this->city = $address->city;
                $this->stateAbbreviation = $address->state_abbreviation;
                $this->postalCode = $address->postal_code;
                $this->countyName = $address->county_name;
            }
        }
    }
    public function rules(): array
    {
        return [
            'deliveryLine1' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                if ($this->addressRepository->addressExists([
                    'deliveryLine1' => $value,
                    'lastLine' => $this->lastLine,
                    'streetName' => $this->streetName,
                    'city' => $this->city,
                    'stateAbbreviation' => $this->stateAbbreviation,
                    'postalCode' => $this->postalCode,
                    'countyName' => $this->countyName,
                ], $this->id)) {
                    $fail('This address already exists.');
                }
            }],
            'lastLine' => ['nullable', 'string', 'max:255'],
            'streetName' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'stateAbbreviation' => ['required', 'string'],
            'postalCode' => ['nullable', 'string', 'max:20'],
            'countyName' => ['nullable', 'string', 'max:100'],
        ];
    }
    public function messages()
    {
        return [
            'deliveryLine1.required' => 'The delivery line 1 is required.',
            'streetName.required' => 'The street name is required.',
            'city.required' => 'The city is required.',
            'stateAbbreviation.required' => 'The state abbreviation is required.',
            'postalCode.required' => 'The postal code is required.',

        ];
    }
    public function save(): bool
    {
        $this->validate($this->rules(), $this->messages());
        $data = $this->verifyAddress();
        if (!$data || $this->addressRepository->addressExists($data, $this->id)) {
            $this->addError('deliveryLine1', 'The address is invalid or already exists.');

            return false;
        }
        if ($this->id) {
            $this->addressRepository->update($this->id, $data);
        } else {
            $this->addressRepository->create($data);
        }
        $this->reset();
        return true;
    }

    public function verifyAddress(): array|bool
    {
        $this->validate($this->rules(), $this->messages());
        return $this->smartyApiRepository->verifyAddress(
            $this->deliveryLine1,
            $this->city,
            $this->stateAbbreviation,
            $this->postalCode,
        );
    }

    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->addressRepository->getFiltered(filters: $this->filters)->paginate(pageName: 'addresses-page');
    }

    public function delete(int $id)
    {
        $this->addressRepository->delete($id);
    }

    public function getStatesRegistered()
    {
        $this->states = $this->addressRepository->getStatesRegistered();
    }

    public function getCitiesRegistered()
    {
        $this->cities = $this->addressRepository->getCitiesRegistered();
    }

    public function getCountiesRegistered()
    {
        $this->counties = $this->addressRepository->getCountiesRegistered();
    }
}
