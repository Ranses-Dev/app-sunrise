<div class="col-span-1 md:col-span-3 lg:col-span-3 mt-4 border border-[var(--color-accent-content)]/40 rounded-md p-4">
    <flux:header class="text-[var(--color-accent-content)]   font-thin text-2xl mb-4 border-b"> Information By
        Specialists </flux:header>
    <flux:table :value="$this->specialists()" :paginate="$this->specialists()">
        <flux:table.columns>
            <flux:table.column>Specialist</flux:table.column>
            <flux:table.column>Contracts MEAL </flux:table.column>
            <flux:table.column>Contracts HOWPA</flux:table.column>
            <flux:table.column>Inspections</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @if($this->specialists()->isEmpty())
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center text-gray-500 py-4">
                        No specialists found.
                    </flux:table.cell>
                </flux:table.row>
            @else
                @foreach ($this->specialists() as $specialist)
                    <flux:table.row>
                        <flux:table.cell>{{$specialist->name}}</flux:table.cell>
                        <flux:table.cell>{{ $specialist->count_contract_meals }}</flux:table.cell>
                        <flux:table.cell>
                            {{ $specialist->count_contract_howpas }}
                        </flux:table.cell>
                        <flux:table.cell >{{$specialist->count_inspections}}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            @endif







        </flux:table.rows>
    </flux:table>
</div>
