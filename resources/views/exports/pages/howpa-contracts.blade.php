<x-layouts.statistics :title="'HOWPA Contracts'">
    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    @if (in_array('client_full_name', $columns))
                        <th>Client Name</th>
                    @endif
                    @if (in_array('client_address_formatted', $columns))
                        <th>Client Address</th>
                    @endif
                    @if (in_array('client_dob', $columns))
                        <th>Client Date of Birth</th>
                    @endif
                    @if (in_array('client_ssn', $columns))
                        <th>Client SSN</th>
                    @endif
                    @if (in_array('client_effective_date', $columns))
                        <th>Client Effective Date</th>
                    @endif
                    @if (in_array('client_howpa_number', $columns))
                        <th>Client HowPA Number</th>
                    @endif
                    @if (in_array('client_legal_status', $columns))
                        <th>Client Legal Status</th>
                    @endif
                    @if (in_array('client_identification_type', $columns))
                        <th>Client ID Type</th>
                    @endif
                    @if (in_array('client_identification_number', $columns))
                        <th>Client ID Number</th>
                    @endif
                    @if (in_array('client_identification_expiration_date', $columns))
                        <th>Client ID Expiration Date</th>
                    @endif
                    @if (in_array('client_city_district', $columns))
                        <th>Client City District</th>
                    @endif
                    @if (in_array('client_county_district', $columns))
                        <th>Client County District</th>
                    @endif
                    @if (in_array('client_city', $columns))
                        <th>Client City</th>
                    @endif
                    @if (in_array('client_email', $columns))
                        <th>Client Email</th>
                    @endif
                    @if (in_array('client_income_type', $columns))
                        <th>Client Income Type</th>
                    @endif
                    @if (in_array('client_income', $columns))
                        <th>Client Income</th>
                    @endif

                    @if (in_array('client_gender', $columns))
                        <th>Client Gender</th>
                    @endif
                    @if (in_array('client_is_deceased', $columns))
                        <th>Client Is Deceased</th>
                    @endif
                    @if (in_array('client_ethnicity', $columns))
                        <th>Client Ethnicity</th>
                    @endif
                    @if (in_array('client_healthcare_provider', $columns))
                        <th>Client Healthcare Provider</th>
                    @endif
                    @if (in_array('client_healthcare_provider_plan', $columns))
                        <th>Client Healthcare Provider Plan</th>
                    @endif
                    @if (in_array('client_housing_status', $columns))
                        <th>Client Housing Status</th>
                    @endif
                    @if (in_array('client_income_category', $columns))
                        <th>Client Income Category</th>
                    @endif
                    @if (in_array('client_service_specialist', $columns))
                        <th>Client Service Specialist</th>
                    @endif
                    @if (in_array('number_bedrooms_req', $columns))
                        <th>Bedrooms (Requested)</th>
                    @endif

                    @if (in_array('number_bedrooms_approved', $columns))
                        <th>Bedrooms (Approved)</th>
                    @endif

                    @if (in_array('recent_living_situation', $columns))
                        <th>Recent Living Situation</th>
                    @endif

                    @if (in_array('recent_living_situation_notes', $columns))
                        <th>Living Situation Notes</th>
                    @endif

                    @if (in_array('owns_real_estate', $columns))
                        <th>Owns Real Estate</th>
                    @endif

                    @if (in_array('own_any_stock_or_bonds', $columns))
                        <th>Owns Stocks/Bonds</th>
                    @endif

                    @if (in_array('has_savings', $columns))
                        <th>Has Savings</th>
                    @endif

                    @if (in_array('savings_balance', $columns))
                        <th>Savings Balance</th>
                    @endif

                    @if (in_array('has_checking_account', $columns))
                        <th>Has Checking Account</th>
                    @endif

                    @if (in_array('checking_avg_balance_six_months', $columns))
                        <th>Checking Avg Balance (6m)</th>
                    @endif

                    @if (in_array('assets_notes', $columns))
                        <th>Assets Notes</th>
                    @endif

                    @if (in_array('outside_support', $columns))
                        <th>Outside Support</th>
                    @endif

                    @if (in_array('outside_support_explanation', $columns))
                        <th>Outside Support Explanation</th>
                    @endif

                    @if (in_array('committed_fraud_or_asked_to_repay', $columns))
                        <th>Committed Fraud / Asked to Repay</th>
                    @endif

                    @if (in_array('fraud_explanation', $columns))
                        <th>Fraud Explanation</th>
                    @endif

                    @if (in_array('has_aids', $columns))
                        <th>Has AIDS</th>
                    @endif

                    @if (in_array('howpa_prior_to_2023', $columns))
                        <th>HOWPA Prior to 2023</th>
                    @endif

                    @if (in_array('currently_receiving_other_aid', $columns))
                        <th>Receiving Other Aid</th>
                    @endif

                    @if (in_array('agreed_statements', $columns))
                        <th>Agreed Statements</th>
                    @endif

                    @if (in_array('emergency_contact_one', $columns))
                        <th>Emergency Contact 1</th>
                    @endif

                    @if (in_array('emergency_contact_two', $columns))
                        <th>Emergency Contact 2</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $contract)
                    <tr>
                        @if (in_array('client_full_name', $columns))
                            <td>{{ $contract->client?->full_name }}</td>
                        @endif
                        @if (in_array('client_address_formatted', $columns))
                            <td>{{ $contract->client?->address_formatted }}</td>
                        @endif
                        @if (in_array('client_dob', $columns))
                            <td>{{ $contract->client?->dob_formatted }}</td>
                        @endif
                        @if (in_array('client_ssn', $columns))
                            <td>{{ $contract->client?->howpa_ssn }}</td>
                        @endif
                        @if (in_array('client_effective_date', $columns))
                            <td>{{ $contract->client?->effective_date_formatted }}</td>
                        @endif
                        @if (in_array('client_howpa_number', $columns))
                            <td>{{ $contract->client?->howpa_number }}</td>
                        @endif
                        @if (in_array('client_legal_status', $columns))
                            <td>{{ $contract->client?->legalStatus?->name }}</td>
                        @endif
                        @if (in_array('client_identification_type', $columns))
                            <td>{{ $contract->client?->identificationType?->name }}</td>
                        @endif
                        @if (in_array('client_identification_number', $columns))
                            <td>{{ $contract->client?->identification_number }}</td>
                        @endif
                        @if (in_array('client_identification_expiration_date', $columns))
                            <td>{{ $contract->client?->identification_expiration_date_formatted }}</td>
                        @endif
                        @if (in_array('client_city_district', $columns))
                            <td>{{ $contract->client?->cityDistrict?->name }}</td>
                        @endif
                        @if (in_array('client_county_district', $columns))
                            <td>{{ $contract->client?->countyDistrict?->name }}</td>
                        @endif
                        @if (in_array('client_city', $columns))
                            <td>{{ $contract->client?->city?->name }}</td>
                        @endif
                        @if (in_array('client_email', $columns))
                            <td>{{ $contract->client?->email }}</td>
                        @endif
                        @if (in_array('client_income_type', $columns))
                            <td>{{ $contract->client?->incomeType?->name }}</td>
                        @endif
                        @if (in_array('client_income', $columns))
                            <td>{{ $contract->client?->income_formatted }}</td>
                        @endif

                        @if (in_array('client_gender', $columns))
                            <td>{{ $contract->client?->gender?->name }}</td>
                        @endif
                        @if (in_array('client_is_deceased', $columns))
                            <td>{{ $contract->client?->is_deceased ? 'Yes' : 'No' }}</td>
                        @endif
                        @if (in_array('client_ethnicity', $columns))
                            <td>{{ $contract->client?->ethnicity?->name }}</td>
                        @endif
                        @if (in_array('client_healthcare_provider', $columns))
                            <td>{{ $contract->client?->healthcareProvider?->name }}</td>
                        @endif
                        @if (in_array('client_healthcare_provider_plan', $columns))
                            <td>{{ $contract->client?->healthcareProviderPlan?->name }}</td>
                        @endif
                        @if (in_array('client_housing_status', $columns))
                            <td>{{ $contract->client?->housingStatus?->name }}</td>
                        @endif
                        @if (in_array('client_income_category', $columns))
                            <td>
                                <span class="badge badge-success">{{ $contract->client?->incomeCategory }}</span>
                            </td>
                        @endif
                        @if (in_array('client_service_specialist', $columns))
                            <td>{{ $contract->clientServiceSpecialist?->name }}</td>
                        @endif
                        @if (in_array('number_bedrooms_req', $columns))
                            <td>{{ $contract->number_bedrooms_req }}</td>
                        @endif

                        @if (in_array('number_bedrooms_approved', $columns))
                            <td>{{ $contract->number_bedrooms_approved }}</td>
                        @endif

                        @if (in_array('recent_living_situation', $columns))
                            <td>{{ $contract->recent_living_situation_formatted }}</td>
                        @endif

                        @if (in_array('recent_living_situation_notes', $columns))
                            <td>{{ $contract->recent_living_situation_notes }}</td>
                        @endif

                        @if (in_array('owns_real_estate', $columns))
                            <td>{{ $contract->owns_real_estate ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('own_any_stock_or_bonds', $columns))
                            <td>{{ $contract->own_any_stock_or_bonds ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('has_savings', $columns))
                            <td>{{ $contract->has_savings ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('savings_balance', $columns))
                            <td>{{ $contract->savings_balance_formatted }}</td>
                        @endif

                        @if (in_array('has_checking_account', $columns))
                            <td>{{ $contract->has_checking_account ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('checking_avg_balance_six_months', $columns))
                            <td>{{ $contract->checking_avg_balance_six_months_formatted }}</td>
                        @endif

                        @if (in_array('assets_notes', $columns))
                            <td>{{ $contract->assets_notes }}</td>
                        @endif

                        @if (in_array('outside_support', $columns))
                            <td>{{ $contract->outside_support ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('outside_support_explanation', $columns))
                            <td>{{ $contract->outside_support_explanation }}</td>
                        @endif

                        @if (in_array('committed_fraud_or_asked_to_repay', $columns))
                            <td>{{ $contract->committed_fraud_or_asked_to_repay ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('fraud_explanation', $columns))
                            <td>{{ $contract->fraud_explanation }}</td>
                        @endif

                        @if (in_array('has_aids', $columns))
                            <td>{{ $contract->has_aids ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('howpa_prior_to_2023', $columns))
                            <td>{{ $contract->howpa_prior_to_2023 ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('currently_receiving_other_aid', $columns))
                            <td>{{ $contract->currently_receiving_other_aid ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('agreed_statements', $columns))
                            <td>{{ $contract->agreed_statements ? 'Yes' : 'No' }}</td>
                        @endif

                        @if (in_array('emergency_contact_one', $columns))
                            <td>
                                @if ($contract->emergencyContactOne)
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-medium">
                                            {{ $contract->emergencyContactOne->name ?? '—' }}
                                        </span>
                                        @php
                                            $phone = $contract->emergencyContactOne->phone_number ?? null;
                                            $address = $contract->emergencyContactOne->address ?? null;
                                        @endphp
                                        <span class="text-xs text-gray-500">
                                            {{ $address ?: '—' }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $phone ?: '—' }}
                                        </span>
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                        @endif

                        @if (in_array('emergency_contact_two', $columns))
                            <td>
                                @if ($contract->emergencyContactTwo)
                                    <div class="flex flex-col leading-tight">
                                        <span class="font-medium">
                                            {{ $contract->emergencyContactTwo->name ?? '—' }}
                                        </span>
                                        @php
                                            $phone = $contract->emergencyContactTwo->phone_number ?? null;
                                            $address = $contract->emergencyContactTwo->address ?? null;
                                        @endphp
                                        <span class="text-xs text-gray-500">
                                            {{ $address ?: '—' }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $phone ?: '—' }}
                                        </span>
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                        @endif
                    </tr>
                     
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>
