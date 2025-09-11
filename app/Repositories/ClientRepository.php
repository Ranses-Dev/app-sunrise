<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionData;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientRepository implements ClientRepositoryInterface
{
    public function getAll(): Collection
    {
        return Client::all();
    }
    public function findById(int $id): ?Client
    {
        return Client::with('address')->find($id);
    }
    public function findBySsn(string $ssn): ?Client
    {
        return Client::ssn($ssn)->first();
    }
    public function getFiltered(array $filters): Builder
    {
        return Client::search($filters);
    }
    public function create(array $data): Client
    {
        return Client::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $client = $this->findById($id);
        if ($client) {
            return $client->update($data);
        }
        return false;
    }
    public function delete(int $id): bool
    {
        $client = $this->findById($id);
        if ($client) {
            return $client->delete();
        }
        return false;
    }

    public function getImageIdentificationCardBase64(int $id): ?string
    {
        $client = $this->findById($id);
        if ($client && $client->identification_picture) {
            return   $client->getIdentificationPictureAttribute();
        }
        return null;
    }

    public function existsFile(int $id): bool
    {
        $client = $this->findById($id);
        if ($client && $client->identification_picture) {
            return $client->verifyFileExist();
        }
        return false;
    }
    public function downloadFile(int $id): ?StreamedResponse
    {
        $client = $this->findById($id);
        if ($client) {
            return $client->downloadFileIfExists();
        }
        return null;
    }
    public function deleteIdentificationCardFile(int $id): void
    {
        $client = $this->findById($id);
        if ($client) {
            $client->deleteFileIfExists();
        }
    }

    public function getClientsByHealthCareProvider(): array
    {
        return DB::table('clients')
            ->join('healthcare_providers', 'clients.healthcare_provider_id', '=', 'healthcare_providers.id')
            ->select('healthcare_providers.name as provider', DB::raw('COUNT(clients.id) as total'))
            ->groupBy('healthcare_providers.name')
            ->orderByDesc('total')
            ->get()
            ->map(fn($row) => ['provider' => $row->provider, 'total' => $row->total])
            ->toArray();
    }
    public function getClientsByPrograms(): array
    {
        return Program::withCount([
            'contractMeals as clients_meals_count' => function ($query) {
                $query->select(DB::raw('count(distinct client_id)'));
            },
            'contractHowpas as clients_howpa_count' => function ($query) {
                $query->select(DB::raw('count(distinct client_id)'));
            },
        ])
            ->get()
            ->map(function ($program) {
                return [
                    'id' => $program->id,
                    'name' => $program->name,
                    'clients_meals_count' => $program->clients_meals_count,
                    'clients_howpa_count' => $program->clients_howpa_count,
                    'total_clients' => $program->clients_meals_count + $program->clients_howpa_count,
                ];
            })
            ->toArray();
    }
    public function certificationsOverdue(?array $filters): Builder
    {
        return Client::recertificationsOverdue($filters);
    }
    public function certificationsDue(?array $filters): Builder
    {
        return Client::recertificationsDue($filters);
    }
    public function identificationsDue(?array $filters): Builder
    {
        return Client::identificationsDue($filters);
    }
    public function identificationsOverdue(?array $filters): Builder
    {

        return Client::identificationsOverdue($filters);
    }
    public function totalCertificationsOverdue(): int
    {
        return Client::recertificationsOverdueCount();
    }
    public function totalCertificationsDue(): int
    {
        return Client::recertificationsDueCount();
    }
    public function totalIdentificationsDue(): int
    {
        return Client::identificationsDueCount();
    }
    public function totalIdentificationsOverdue(): int
    {
        return Client::identificationsOverdueCount();
    }
    public function totalClients(): int
    {
        return Client::count();
    }

    public function getClientServiceSpecialistsByProgram(?int $programId): CollectionData
    {

        return User::whereHas('programs', function ($q) use ($programId) {
            $q->where('programs.id', $programId);
        })->get();
    }
    public function getClientServiceSpecialistsByProgramBranch(?int $programBranchId): CollectionData
    {
        return DB::table('users')
            ->join('program_user', 'users.id', '=', 'program_user.user_id')
            ->join('programs', 'program_user.program_id', '=', 'programs.id')
            ->join('program_branches', 'programs.id', '=', 'program_branches.program_id')
            ->where('program_branches.id', '=', $programBranchId)
            ->select('users.id', 'users.name')
            ->distinct()
            ->get();
    }
    public function validateUniqueSSN(string $ssn,  ?int $id = null): bool
    {
        $hash = hash('sha256', $ssn);
        $query = Client::where('ssn_hash', $hash);
        if ($id) {
            $query->where('id', '!=', $id);
        }
        return $query->exists() ? false : true;
    }

    public function isValidHowpaSsn(string $ssn, int|null $clientId): bool
    {
        return Client::isAvailableHowpaSsn($ssn, $clientId);
    }
    public function hasHowpaContractActive(string $date, int $clientId): bool
    {
        return Client::clientHasHowpaContractActive($date, $clientId);
    }

    public function getHowpaClientsWithContractActive(): Collection
    {
        return Client::with('howpaContracts')
            ->whereHas('howpaContracts', function ($query) {
                $query->whereBeforeToday('date')
                    ->whereAfterToday('re_certification_date');
            })
            ->get();
    }
    public function getClientsHowpa(string|null $search = null): Builder
    {
        $filters = [
            'search' => $search
        ];
        return Client::whereHas('howpaContracts')
            ->search($filters);
    }

    public function existsHowpaClientNumber(string $howpaClientNumber, ?int $clientId = null): bool
    {
        return  Client::where('howpa_client_number', $howpaClientNumber)
            ->where('id', '!=', $clientId)->exists();
    }
    public function getClientsAliveCount(): int
    {
        return Client::where('is_deceased', false)->count();
    }
    public function getClientsIdentificationsDueCount(): int
    {
        return Client::whereBetween('identification_expiration_date', [now(), now()->addMonths(3)])
            ->whereHas('legalStatus', function ($query) {
                $query->whereRaw('LOWER(name) != ?', ['citizen']);
            })->count();
    }
    public function getClientsIdentificationsOverdueCount(): int
    {
        return Client::where('identification_expiration_date', '<', now())
            ->whereHas('legalStatus', function ($query) {
                $query->whereRaw('LOWER(name) != ?', ['citizen']);
            })->count();
    }
    public function getClientsCertificationsDueCount(): int
    {
        return Client::whereHas('contractMeals', function ($query) {
            $query->whereBetween('recertification_date', [now(), now()->addMonths(3)]);
        })->orWhereHas('howpaContracts', function ($query) {
            $query->whereBetween('re_certification_date', [now(), now()->addMonths(3)]);
        })->count();
    }
    public function getClientsCertificationsOverdueCount(): int
    {
        return Client::whereHas('contractMeals', function ($query) {
            $query->where('recertification_date', '<', now());
        })->orWhereHas('howpaContracts', function ($query) {
            $query->where('re_certification_date', '<', now());
        })->count();
    }
    public function clientExistsByIdentification(int $identificationTypeId, string $identificationNumber, int|null $ignoreId): bool
    {
        if (filled($identificationTypeId) && filled($identificationNumber)) {
            $query = Client::where('identification_type_id', $identificationTypeId)
                ->where('identification_number', $identificationNumber);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            return $query->exists();
        }
        return false;
    }
}
