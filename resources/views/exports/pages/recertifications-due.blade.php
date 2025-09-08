<x-layouts.statistics :title="'Clients Due Re Certifications '">
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
                    <th>Contracts</th>
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
                                {{ "$contract->income_category %" }}
                            @endif
                        </td>
                        <td>
                            <div class="space-y-2">
                                @if (!$contract->howpaContracts?->isEmpty())
                                    <div class="border-1 border-gray-400 p-2 rounded-md">
                                        <p class="border-b mb-2">Howpa Contracts:</p>
                                        @foreach ($contract->howpaContracts as $howpaContract)

                                            <p class="mr-1">
                                                {{ \Carbon\Carbon::parse($howpaContract->re_certification_date)->format('m/d/Y') }}
                                            </p>

                                        @endforeach
                                    </div>
                                @endif
                                @if (!$contract->contractMeals?->isEmpty())
                                    <div class="border-1 border-gray-400 p-2 rounded-md">
                                        <p class="border-b mb-2">Contract Meals:</p>
                                        @foreach ($contract->contractMeals as $contractMeal)
                                            <p class="mr-1">
                                                {{ \Carbon\Carbon::parse($contractMeal->recertification_date)->format('m/d/Y') }}
                                            </p>

                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>
