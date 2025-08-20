<?php

namespace App\Livewire\Client;


use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\CityDistrictRepositoryInterface as CityDistrictRepository;
use App\Repositories\CountyDistrictRepositoryInterface as CountyDistrictRepository;
use App\Repositories\CityRepositoryInterface as CityRepository;
use App\Repositories\UserRepositoryInterface as UserRepository;
use App\Repositories\ClientRepositoryInterface;
use Illuminate\Support\Facades\Log;

#[Title('Certification Due List')]
class CertificationsDue extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected ClientRepositoryInterface $clientRepository;
    protected CityDistrictRepository $cityDistrictRepository;
    protected CountyDistrictRepository $countyDistrictRepository;
    protected CityRepository $cityRepository;
    protected UserRepository $userRepository;
    public Collection $districts;
    public Collection $counties;
    public Collection  $cities;
    public Collection $users;
    public mixed $range = null;
    public array $filters = [];
    public function render()
    {
        return view('livewire.client.certifications-due');
    }
    public function __construct()
    {
        $this->clientRepository = app(ClientRepositoryInterface::class);
        $this->cityDistrictRepository = app(CityDistrictRepository::class);
        $this->countyDistrictRepository = app(CountyDistrictRepository::class);
        $this->cityRepository = app(CityRepository::class);
        $this->userRepository = app(UserRepository::class);
    }
    public function mount()
    {
        $this->filters = [
            'city_district_id' => null,
            'county_district_id' => null,
            'city_id' => null,
            'user_id' => null,
            'date_range' => []
        ];
        $this->fetchDistricts();
        $this->fetchCounties();
        $this->fetchCities();
        $this->fetchUsers();
    }

    #[Computed]
    public function results(): LengthAwarePaginator
    {
        return $this->clientRepository->certificationsDue($this->filters)->paginate(pageName: 'certification-due-list-page');
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
    public function fetchUsers()
    {
        $this->users = $this->userRepository->getAllUsers();
    }

    public function updatedFiltersCountyDistrictId()
    {

        $this->fetchCities();
        $this->filters['city_id'] = null;
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
        return redirect(route('exports.clients.recertifications-due', ['filters' => $this->filters]));
    }

    
}
