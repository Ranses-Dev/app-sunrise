<x-layouts.statistics :title="'Client List'">
    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    @if (in_array('full_name', $columns))
                        <th>Full Name</th>
                    @endif
                    @if (in_array('dob', $columns))
                        <th>DOB</th>
                    @endif
                    @if (in_array('age', $columns))
                        <th>Age</th>
                    @endif
                    @if (in_array('ssn', $columns))
                        <th>SSN</th>
                    @endif
                    @if (in_array('client_number', $columns))
                        <th>Client #</th>
                    @endif
                    @if (in_array('howpa_client_number', $columns))
                        <th>HOPWA Client #</th>
                    @endif
                    @if (in_array('meal_client_number', $columns))
                        <th>MEALS Client #</th>
                    @endif
                    @if (in_array('effective_date', $columns))
                        <th>Effective Date</th>
                    @endif
                    @if (in_array('legal_status', $columns))
                        <th>Legal Status</th>
                    @endif
                    @if (in_array('identification_type', $columns))
                        <th>Identification Type</th>
                    @endif
                    @if (in_array('identification_number', $columns))
                        <th>Identification Number</th>
                    @endif
                    @if (in_array('identification_expiration_date', $columns))
                        <th>Identification Expiration Date</th>
                    @endif
                    @if (in_array('address_formatted', $columns))
                        <th>Address</th>
                    @endif
                    @if (in_array('city_district', $columns))
                        <th>City District</th>
                    @endif
                    @if (in_array('county_district', $columns))
                        <th>County District</th>
                    @endif
                    @if (in_array('city', $columns))
                        <th>City</th>
                    @endif
                    @if (in_array('email', $columns))
                        <th>Email</th>
                    @endif
                    @if (in_array('income', $columns))
                        <th>Income</th>
                    @endif
                    @if (in_array('gender', $columns))
                        <th>Gender</th>
                    @endif
                    @if (in_array('is_deceased', $columns))
                        <th>Is Deceased</th>
                    @endif
                    @if (in_array('ethnicity', $columns))
                        <th>Ethnicity</th>
                    @endif
                    @if (in_array('healthcare_provider', $columns))
                        <th>Healthcare Provider</th>
                    @endif
                    @if (in_array('healthcare_provider_plan', $columns))
                        <th>Healthcare Provider Plan</th>
                    @endif
                    @if (in_array('housing_status', $columns))
                        <th>Housing Status</th>
                    @endif
                    @if (in_array('income_category', $columns))
                        <th>Income Category</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                       @if (in_array('full_name', $columns))
                            <td>{{ $client->full_name }}</td>
                        @endif
                        @if (in_array('dob', $columns))
                            <td>{{ $client->dob_formatted }}</td>
                        @endif
                        @if (in_array('age', $columns))
                            <td>{{ $client->age }}</td>
                        @endif
                        @if (in_array('ssn', $columns))
                            <td>{{ $client->howpa_ssn }}</td>
                        @endif
                        @if (in_array('client_number', $columns))
                            <td>{{ $client->client_number }}</td>
                        @endif
                        @if (in_array('howpa_client_number', $columns))
                            <td>{{ $client->howpa_client_number }}</td>
                        @endif
                        @if (in_array('meal_client_number', $columns))
                            <td>{{ $client->meal_client_number }}</td>
                        @endif
                        @if (in_array('effective_date', $columns))
                            <td>{{ $client->effective_date_formatted }}</td>
                        @endif
                        @if (in_array('legal_status', $columns))
                            <td>{{ $client->legalStatus?->name }}</td>
                        @endif
                        @if (in_array('identification_type', $columns))
                            <td>{{ $client->identificationType?->name }}</td>
                        @endif
                        @if (in_array('identification_number', $columns))
                            <td>{{ $client->identification_number }}</td>
                        @endif
                        @if (in_array('identification_expiration_date', $columns))
                            <td>{{ $client->identification_expiration_date_formatted }}</td>
                        @endif
                        @if (in_array('address_formatted', $columns))
                            <td>{{ $client->address_formatted }}</td>
                        @endif
                        @if (in_array('city_district', $columns))
                            <td>{{ $client->cityDistrict?->name }}</td>
                        @endif
                        @if (in_array('county_district', $columns))
                            <td>{{ $client->countyDistrict?->name }}</td>
                        @endif
                        @if (in_array('city', $columns))
                            <td>{{ $client->city?->name }}</td>
                        @endif
                        @if (in_array('email', $columns))
                            <td>{{ $client->email }}</td>
                        @endif
                        @if (in_array('income', $columns))
                            <td>{{ $client->income_formatted }}</td>
                        @endif
                        @if (in_array('gender', $columns))
                            <td>{{ $client->gender?->name }}</td>
                        @endif
                        @if (in_array('is_deceased', $columns))
                            <td>{{ $client->is_deceased ? 'Yes' : 'No' }}</td>
                        @endif
                        @if (in_array('ethnicity', $columns))
                            <td>{{ $client->ethnicity?->name }}</td>
                        @endif
                        @if (in_array('healthcare_provider', $columns))
                            <td>{{ $client->healthcareProvider?->name }}</td>
                        @endif
                        @if (in_array('healthcare_provider_plan', $columns))
                            <td>{{ $client->healthcareProviderPlan?->name }}</td>
                        @endif
                        @if (in_array('housing_status', $columns))
                            <td>{{ $client->housingStatus?->name }}</td>
                        @endif

                            @if (in_array('income_category', $columns))
 <td>
                                @if ($client->income_category)
                                    <p style="color: green; background-color: lightgreen;">{{"$client->income_category" }}</p>
                                @else
                                    <p style="color: red; background-color: lightcoral;">N/A</p>
                                @endif
</td>
                            @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</x-layouts.statistics>
