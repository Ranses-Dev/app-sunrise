<div class="col-span-1 md:col-span-3 lg:col-span-3 mt-4 border border-[var(--color-accent-content)]/40 rounded-md p-4">
    <flux:header class="text-[var(--color-accent-content)]   font-thin text-2xl mb-4 border-b"> Clients By Ethnicity
    </flux:header>
    <flux:table :value="$this->ethnicities()" :paginate="$this->ethnicities()">
        <flux:table.columns>
            <flux:table.column></flux:table.column>
            <flux:table.column> </flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @if($this->ethnicities()->isEmpty())
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center text-gray-500 py-4">
                        No specialists found.
                    </flux:table.cell>
                </flux:table.row>
            @else
                @foreach ($this->ethnicities() as $ethnicity)
                    <flux:table.row>
                        <flux:table.cell>
                            <x-dashboard.progress-bar title="{{ $ethnicity->name }}" :progress="$ethnicity->percent" :value="$ethnicity->count_clients" />
                        </flux:table.cell>
                        <flux:table.cell>{{$ethnicity->count_clients}}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            @endif







        </flux:table.rows>
    </flux:table>
</div>
