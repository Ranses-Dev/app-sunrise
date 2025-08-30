<x-layouts.statistics :title="'HOWPA Contracts'">
    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Client Number</th>
                    <th>Program</th>
                    <th>City</th>
                    <th>Date</th>
                    <th>Re-Certification Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $contract)
                    <tr>
                        <td>{{ $contract->client?->full_name }}</td>
                        <td>{{ $contract->client?->howpa_client_number }}</td>
                        <td>{{ $contract->programBranch?->name }}</td>
                        <td>{{ $contract->city?->name  }}</td>
                        <td>{{ $contract->date?->format('m/d/Y') }}</td>
                        <td>{{ $contract->re_certification_date?->format('m/d/Y') }}</td>
                        <td>
                            <flux:badge size="sm" variant="solid" color="{{ $contract->is_active ? 'green' : 'red' }}">
                                {{ $contract->is_active ? 'Active' : 'Inactive' }}
                            </flux:badge>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>
