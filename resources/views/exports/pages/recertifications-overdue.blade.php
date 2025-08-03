<x-layouts.statistics :title="'Clients Overdue Re Certifications '">
  <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Client Number</th>
                    <th>Age</th>
                    <th>Income</th>
                    <th>Total Income</th>
                    <th>Households</th>
                    <th>Income Category (%)</th>
                    <th>Specialist</th>
                    <th>Recertification Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contracts as $contract)
                    <tr>
                        <td>{{ $contract->full_name }}</td>
                        <td>{{ $contract->client_number }}</td>
                        <td>{{ $contract->age }}</td>
                        <td>{{ $contract->income }}</td>
                        <td>{{ $contract->total_income }}</td>
                        <td>{{ $contract->household_total }}</td>
                        <td>
                            @if ($contract->income_category)
                                <flux:badge size="sm" color="green">{{ "$contract->income_category %" }}</flux:badge>
                            @endif
                        </td>
                        <td>{{ $contract->specialist_name }}</td>
                        <td>
                            @if ($contract->contract_meal_recertification_date && $contract->contract_meal_id)


                                <flux:badge type="info" size="sm" class="mr-1">
                                    Contract Meal:
                                    {{ \Carbon\Carbon::parse($contract->contract_meal_recertification_date)->format('m/d/Y') }}
                                </flux:badge>

                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>
