<x-layouts.statistics :title="'Clients Due Identifications'">
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
                        <td>{{ $client->legalStatus?->name }}</td>
                        <td>{{ $client->identification_data }}</td>
                        <td>
                            <strong>
                                {{ $client->identification_expiration_date?->format('m/d/Y') }}
                            </strong>
                        </td>
                        <td>{{ $client->address?->address_formatted }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>
