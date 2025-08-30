<x-layouts.statistics :title="'Client List'">
    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>DOB</th>
                    <th>Legal Status</th>
                    <th>Identification</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Client Number</th>
                    <th>Health Care</th>
                    <th>Monthly Payment</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->full_name }}</td>
                        <td>{{ $client->dob->format('m/d/Y') }}</td>
                        <td>{{ $client->legalStatus?->name }}</td>
                        <td>{{ $client->full_identification_data }}</td>
                        <td>{{ $client->age }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->client_number }}</td>
                        <td>{{ $client->full_healthcare_provider }}</td>
                        <td>{{ $client->monthly_client_payment_portion }}</td>
                        <td>{{ $client->address?->address_formatted }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</x-layouts.statistics>