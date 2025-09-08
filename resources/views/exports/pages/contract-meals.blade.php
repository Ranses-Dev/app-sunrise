<x-layouts.statistics :title="'Contract Meals'">
    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Specialist Name</th>
                    <th>Code</th>
                    <th>Contract Type</th>
                    <th>Food Cost</th>
                    <th>Delivery Cost</th>
                    <th>Program Delivery Cost</th>
                    <th>Is Active</th>
                    <th>Re-Certification Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $contractMeal)
                    <tr>
                        <td>{{ $contractMeal->client?->full_name }}</td>
                        <td>{{ $contractMeal->clientServiceSpecialist?->name }}</td>
                        <td>{{ $contractMeal->code }}</td>
                        <td>{{ $contractMeal->mealContractType?->name }}</td>
                        <td>{{ $contractMeal->foodCost?->formatted_currency }}</td>
                        <td>{{ $contractMeal->deliveryCost?->formatted_currency }}</td>
                        <td>{{ $contractMeal->programDeliveryCost?->formatted_currency }}</td>
                        <td>{{ $contractMeal->is_active ? 'Yes' : 'No' }}</td>
                        <td>{{ $contractMeal->recertification_date?->format('m-d-Y') }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>


