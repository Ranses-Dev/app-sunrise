<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Repositories\ClientRepositoryInterface as ClientRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\CityDistrictRepositoryInterface as CityDistrictRepository;
use App\Repositories\CountyDistrictRepositoryInterface as CountyDistrictRepository;
use App\Repositories\CityRepositoryInterface as CityRepository;
use Illuminate\Support\Facades\Log;

#[Title('Identifications Overdue List')]
class IdentificationsOverdue extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected ClientRepository  $clientRepository;
    protected CityDistrictRepository $cityDistrictRepository;
    protected CountyDistrictRepository $countyDistrictRepository;
    protected CityRepository $cityRepository;
    public Collection $districts;
    public Collection $counties;
    public Collection  $cities;
    public Collection $users;
    public mixed $range = null;
    public array $filters = [];
    public function __construct()
    {
        $this->clientRepository = app(ClientRepository::class);
        $this->cityDistrictRepository = app(CityDistrictRepository::class);
        $this->countyDistrictRepository = app(CountyDistrictRepository::class);
        $this->cityRepository = app(CityRepository::class);
    }
    public function mount()
    {
        $this->filters = [
            'city_district_id' => null,
            'county_district_id' => null,
            'city_id' => null,
            'date_range' => [],
        ];
        $this->fetchDistricts();
        $this->fetchCounties();
        $this->fetchCities();
    }
    public function render()
    {
        return view('livewire.client.identifications-overdue');
    }
    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->clientRepository->identificationsOverdue($this->filters)->paginate(pageName: 'identifications-overdue');
    }
    public function fetchDistricts()
    {
        $this->districts = $this->cityDistrictRepository->getAll();
    }

    public function fetchCounties()
    {
        $this->counties = $this->countyDistrictRepository->getAll();
    }
    public function fetchCities()
    {
        $this->cities = $this->cityRepository->getCityByDistrictId($this->filters['county_district_id']);
    }

    public function updatedFiltersCountyDistrictId()
    {

        $this->fetchCities();
        $this->filters['cityId'] = null;
    }
    public function updatedRange($value)
    {

        if (isset($value['start'], $value['end'])) {
            $start = $value['start'];
            $end = $value['end'];
            $this->filters['date_range'] =  "$start - $end";
        } else {
            $this->filters['date_range'] = null;
        }
    }

    public function export()
    {
        return redirect(route('exports.clients.identifications-overdue', ['filters' => $this->filters]));
    }
}
