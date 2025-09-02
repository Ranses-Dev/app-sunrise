@php
    $data = [
        ['program_name' => 'HOPA', 'clients_count' => 120],
        ['program_name' => 'MEALS', 'clients_count' => 85],
        ['program_name' => 'INSPECTIONS', 'clients_count' => 60],
        ['program_name' => 'RENTAL', 'clients_count' => 45],
    ];
@endphp

<div class="bg-white rounded-xl shadow p-4  w-full">
    <div class="mb-3 flex justify-between items-center">
        <h2 class="text-sm font-semibold text-gray-700">Total Clients by Program</h2>
    </div>

    @if (count($this->clientsByProgram()) > 0)
        <table class="min-w-full text-xs text-gray-800">
            <thead class="bg-yellow-100 text-yellow-800 uppercase tracking-wide">
                <tr>
                    <th class="py-1 px-2 text-left font-semibold">Program</th>
                    <th class="py-1 px-2 text-right font-semibold">Clients</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->clientsByProgram() as $index => $item)
                    <tr
                        class="{{ $index % 2 === 0 ? 'bg-blue-50' : 'bg-white' }} hover:bg-yellow-50 transition-colors duration-150">
                        <td class="py-1.5 px-2 font-medium">{{ $item['name'] }}</td>
                         @if ($item['name'] === 'HOWPA')
                            <td class="py-1.5 px-2 text-right">{{ $item['clients_howpa_count'] }}</td>
                         @elseif ($item['name'] === 'MEALS')
                            <td class="py-1.5 px-2 text-right">{{ $item['clients_meals_count'] }}</td>
                         @else
                        <td></td>
                         @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center items-center text-gray-500 mt-4">
            <flux:icon name="exclamation-circle" class="inline-block ml-2" /> Not enough data to render the chart.
        </div>
    @endif


</div>
