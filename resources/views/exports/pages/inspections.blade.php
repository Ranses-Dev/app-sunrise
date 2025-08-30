<x-layouts.statistics :title="'Inspections'">
    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Address</th>
                    <th>Requested Date</th>
                    <th>Requested Scheduled Date</th>
                    <th>Program Branch</th>
                    <th>Housing Type</th>
                    <th>Housing Inspector</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inspections as $inspection)
                    <tr>
                        <td>{{ $inspection->address?->address_formatted  }}</td>
                        <td>{{ $inspection->inspection_requested_date?->format('m-d-Y') }}</td>
                        <td>{{ $inspection->inspection_requested_scheduled_date?->format('m-d-Y') }}</td>
                        <td>{{ $inspection->programBranch?->name }}</td>
                        <td>{{ $inspection->housingType?->name }}</td>
                        <td>{{ $inspection->housingInspector?->name }}</td>
                        <td>
                            @if ($inspection->inspection_status === App\Enums\InspectionStatus::PASS)
                                <flux:badge  size="sm" color="green">{{ $inspection->inspection_status }}</flux:badge>
                            @elseif ($inspection->inspection_status === App\Enums\InspectionStatus::FAIL)
                                <flux:badge  size="sm" color="red">{{ $inspection->inspection_status }}</flux:badge>
                            @else
                                {{ $inspection->inspection_status }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>
