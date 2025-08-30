<?php

namespace App\Repositories;


use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as CollectionData;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface ClientRepositoryInterface
{

    public function getAll(): Collection;
    public function findById(int $id): ?Client;
    public function findBySsn(string $ssn): ?Client;
    public function getFiltered(array $filters): Builder;
    public function create(array $data): Client;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function getImageIdentificationCardBase64(int $id): ?string;
    public function existsFile(int $id): bool;
    public function downloadFile(int $id): ?StreamedResponse;
    public function deleteIdentificationCardFile(int $id): void;
    public function getClientsByHealthCareProvider(): array;
    public function getClientsByPrograms(): array;
    public function certificationsOverdue(?array $filters): Builder;
    public function identificationsDue(?array $filters): Builder;
    public function identificationsOverdue(?array $filters): Builder;
    public function totalIdentificationsDue(): int;
    public function totalIdentificationsOverdue(): int;
    public function certificationsDue(?array $filters): Builder;
    public function totalCertificationsOverdue(): int;
    public function totalCertificationsDue(): int;
    public function totalClients(): int;
    public function getClientServiceSpecialistsByProgram(?int $programId): CollectionData;
    public function getClientServiceSpecialistsByProgramBranch(?int $programBranchId): CollectionData;

    public function isValidHowpaSsn(string $ssn, int|null $clientId): bool;

    public function hasHowpaContractActive(string $date, int $clientId): bool;

    public function getHowpaClientsWithContractActive(): Collection;

    public function getClientsHowpa(string|null $search = null): Builder;
}
