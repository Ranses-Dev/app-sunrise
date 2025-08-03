<x-layouts.statistics :title="'Clients Overdue Identifications'">
    
    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>DOB</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Client Number</th>
                    <th>Legal Status</th>
                    <th>Identification</th>
                    <th>ID. Expiration Date</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->full_name }}</td>
                        <td>{{ $client->dob?->format('m/d/Y') }}</td>
                        <td>{{ $client->age }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->client_number }}</td>
                        <td>{{ $client->legal_status_name }}</td>
                        <td>{{ $client->identification_data }}</td>
                        <td>
                            <flux:badge variant="solid" size="sm" color="red">
                                {{ $client->identification_expiration_date?->format('m/d/Y') }}
                            </flux:badge>
                        </td>
                        <td>{{ $client->full_address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>
