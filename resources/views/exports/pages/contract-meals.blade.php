<x-layouts.statistics :title="'Contract Meals'">
    @if (isset($stats))

        <div class="stats-grid">
            {{-- DAILY --}}
            <div class="stat-card">
                <h4 class="stat-title">Daily</h4>
                <div class="stat-value">{{ $stats['daily_total'] ?? '$0.00' }}</div>
                <ul class="stat-breakdown">
                    <li><span class="muted">Delivery</span><strong>{{ $stats['delivery_cost'] ?? '$0.00' }}</strong></li>
                    <li><span class="muted">Food</span><strong>{{ $stats['food_cost'] ?? '$0.00' }}</strong></li>
                    <li><span class="muted">Program</span><strong>{{ $stats['program_delivery_cost'] ?? '$0.00' }}</strong>
                    </li>
                </ul>
            </div>

            {{-- WEEKLY --}}
            <div class="stat-card">
                <h4 class="stat-title">Weekly</h4>
                <div class="stat-value">{{ $stats['weekly_total'] ?? '$0.00' }}</div>
                <ul class="stat-breakdown">
                    <li><span class="muted">Delivery</span><strong>{{ $stats['weekly_delivery_cost'] ?? '$0.00' }}</strong>
                    </li>
                    <li><span class="muted">Food</span><strong>{{ $stats['weekly_food_cost'] ?? '$0.00' }}</strong></li>
                    <li><span
                            class="muted">Program</span><strong>{{ $stats['weekly_program_delivery_cost'] ?? '$0.00' }}</strong>
                    </li>
                </ul>
            </div>

            {{-- MONTHLY --}}
            <div class="stat-card">
                <h4 class="stat-title">Monthly</h4>
                <div class="stat-value">{{ $stats['monthly_total'] ?? '$0.00' }}</div>
                <ul class="stat-breakdown">
                    <li><span class="muted">Delivery</span><strong>{{ $stats['monthly_delivery_cost'] ?? '$0.00' }}</strong>
                    </li>
                    <li><span class="muted">Food</span><strong>{{ $stats['monthly_food_cost'] ?? '$0.00' }}</strong></li>
                    <li><span
                            class="muted">Program</span><strong>{{ $stats['monthly_program_delivery_cost'] ?? '$0.00' }}</strong>
                    </li>
                </ul>
            </div>

            {{-- YEARLY --}}
            <div class="stat-card">
                <h4 class="stat-title">Yearly</h4>
                <div class="stat-value">{{ $stats['yearly_total'] ?? '$0.00' }}</div>
                <ul class="stat-breakdown">
                    <li><span class="muted">Delivery</span><strong>{{ $stats['yearly_delivery_cost'] ?? '$0.00' }}</strong>
                    </li>
                    <li><span class="muted">Food</span><strong>{{ $stats['yearly_food_cost'] ?? '$0.00' }}</strong></li>
                    <li><span
                            class="muted">Program</span><strong>{{ $stats['yearly_program_delivery_cost'] ?? '$0.00' }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    @endif

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
                    @if (in_array('client_meal_number', $columns))
                        <th>Client Meal Number</th>
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
                    @if (in_array('code', $columns))
                        <th>Code</th>
                    @endif
                    @if (in_array('program_branch', $columns))
                        <th>Program Branch</th>
                    @endif
                    @if (in_array('delivery_cost', $columns))
                        <th>Delivery Cost</th>
                    @endif
                    @if (in_array('food_cost', $columns))
                        <th>Food Cost</th>
                    @endif
                    @if (in_array('program_delivery_cost', $columns))
                        <th>Program Delivery Cost</th>
                    @endif
                    @if (in_array('termination_reason', $columns))
                        <th>Termination Reason</th>
                    @endif
                    @if (in_array('is_active', $columns))
                        <th>Is Active</th>
                    @endif
                    @if (in_array('recertification_date', $columns))
                        <th>Re-Certification Date</th>
                    @endif
                    @if (in_array('notes', $columns))
                        <th>Notes</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $contractMeal)
                    <tr>
                        @if (in_array('client_full_name', $columns))
                            <td>{{ $contractMeal->client?->full_name }}</td>
                        @endif
                        @if (in_array('client_address_formatted', $columns))
                            <td>{{ $contractMeal->client?->address_formatted }}</td>
                        @endif
                        @if (in_array('client_dob', $columns))
                            <td>{{ $contractMeal->client?->dob_formatted }}</td>
                        @endif
                        @if (in_array('client_ssn', $columns))
                            <td>{{ $contractMeal->client?->howpa_ssn }}</td>
                        @endif
                        @if (in_array('client_effective_date', $columns))
                            <td>{{ $contractMeal->client?->effective_date_formatted }}</td>
                        @endif
                        @if (in_array('client_meal_number', $columns))
                            <td>{{ $contractMeal->client?->meal_client_number }}</td>
                        @endif
                        @if (in_array('client_legal_status', $columns))
                            <td>{{ $contractMeal->client?->legalStatus?->name }}</td>
                        @endif
                        @if (in_array('client_identification_type', $columns))
                            <td>{{ $contractMeal->client?->identificationType?->name }}</td>
                        @endif
                        @if (in_array('client_identification_number', $columns))
                            <td>{{ $contractMeal->client?->identification_number }}</td>
                        @endif
                        @if (in_array('client_identification_expiration_date', $columns))
                            <td>{{ $contractMeal->client?->identification_expiration_date_formatted }}</td>
                        @endif
                        @if (in_array('client_city_district', $columns))
                            <td>{{ $contractMeal->client?->cityDistrict?->name }}</td>
                        @endif
                        @if (in_array('client_county_district', $columns))
                            <td>{{ $contractMeal->client?->countyDistrict?->name }}</td>
                        @endif
                        @if (in_array('client_city', $columns))
                            <td>{{ $contractMeal->client?->city?->name }}</td>
                        @endif
                        @if (in_array('client_email', $columns))
                            <td>{{ $contractMeal->client?->email }}</td>
                        @endif
                        @if (in_array('client_income_type', $columns))
                            <td>{{ $contractMeal->client?->incomeType?->name }}</td>
                        @endif
                        @if (in_array('client_income', $columns))
                            <td>{{ $contractMeal->client?->income_formatted }}</td>
                        @endif

                        @if (in_array('client_gender', $columns))
                            <td>{{ $contractMeal->client?->gender?->name }}</td>
                        @endif
                        @if (in_array('client_is_deceased', $columns))
                            <td>{{ $contractMeal->client?->is_deceased ? 'Yes' : 'No' }}</td>
                        @endif
                        @if (in_array('client_ethnicity', $columns))
                            <td>{{ $contractMeal->client?->ethnicity?->name }}</td>
                        @endif
                        @if (in_array('client_healthcare_provider', $columns))
                            <td>{{ $contractMeal->client?->healthcareProvider?->name }}</td>
                        @endif
                        @if (in_array('client_healthcare_provider_plan', $columns))
                            <td>{{ $contractMeal->client?->healthcareProviderPlan?->name }}</td>
                        @endif
                        @if (in_array('client_housing_status', $columns))
                            <td>{{ $contractMeal->client?->housingStatus?->name }}</td>
                        @endif
                        @if (in_array('client_income_category', $columns))
                            <td>
                                <span class="badge badge-success">{{ $contractMeal->client?->incomeCategory }}</span>
                            </td>
                        @endif
                        @if (in_array('client_service_specialist', $columns))
                            <td>{{ $contractMeal->client_service_specialist_name ?? "" }}</td>
                        @endif
                        @if (in_array('code', $columns))
                            <td>{{ $contractMeal->code }}</td>
                        @endif
                        @if (in_array('program_branch', $columns))
                            <td>{{ $contractMeal->programBranch?->name }}</td>
                        @endif
                        @if (in_array('delivery_cost', $columns))
                            <td>{{ $contractMeal->deliveryCost?->formattedCurrency }}</td>
                        @endif
                        @if (in_array('food_cost', $columns))
                            <td>{{ $contractMeal->foodCost?->formattedCurrency }}</td>
                        @endif
                        @if (in_array('program_delivery_cost', $columns))
                            <td>{{ $contractMeal->programDeliveryCost?->formattedCurrency }}</td>
                        @endif
                        @if (in_array('termination_reason', $columns))
                            <td>{{ $contractMeal->terminationReason?->name }}</td>
                        @endif
                        @if (in_array('is_active', $columns))
                            <td>{{ $contractMeal->is_active ? 'Yes' : 'No' }}</td>
                        @endif
                        @if (in_array('recertification_date', $columns))
                            <td>{{ $contractMeal->recertification_date_formatted }}</td>
                        @endif
                        @if (in_array('notes', $columns))
                            <td>{{ $contractMeal->notes }}</td>
                        @endif
                    </tr>
                @endforeach
                @if (in_array('delivery_cost', $columns) || in_array('food_cost', $columns) || in_array('program_delivery_cost', $columns))
                    <tr>
                        <td><strong>Totals:</strong></td>
                        @if (in_array('client_address_formatted', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_dob', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_ssn', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_effective_date', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_meal_number', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_legal_status', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_identification_type', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_identification_number', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_identification_expiration_date', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_city_district', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_county_district', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_city', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_email', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_income_type', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_income', $columns))
                            <td></td>
                        @endif

                        @if (in_array('client_gender', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_is_deceased', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_ethnicity', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_healthcare_provider', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_healthcare_provider_plan', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_housing_status', $columns))
                            <td></td>
                        @endif
                        @if (in_array('client_income_category', $columns))
                            <td>

                            </td>
                        @endif
                        @if (in_array('client_service_specialist', $columns))
                            <td></td>
                        @endif
                        @if (in_array('code', $columns))
                            <td></td>
                        @endif
                        @if (in_array('program_branch', $columns))
                            <td></td>
                        @endif
                        @if (in_array('delivery_cost', $columns))
                            <td> <strong>{{ Number::currency($contractMeal->total_delivery_cost) }}</strong> </td>
                        @endif
                        @if (in_array('food_cost', $columns))
                            <td> <strong>{{ Number::currency($contractMeal->total_food_cost) }}</strong> </td>
                        @endif
                        @if (in_array('program_delivery_cost', $columns))
                            <td> <strong>{{ Number::currency($contractMeal->total_program_delivery_cost) }}</strong> </td>
                        @endif
                        @if (in_array('termination_reason', $columns))
                            <td></td>
                        @endif
                        @if (in_array('is_active', $columns))
                            <td></td>
                        @endif
                        @if (in_array('recertification_date', $columns))
                            <td></td>
                        @endif
                        @if (in_array('notes', $columns))
                            <td></td>
                        @endif
                    </tr>
                @endif

            </tbody>
        </table>
    </div>
</x-layouts.statistics>
