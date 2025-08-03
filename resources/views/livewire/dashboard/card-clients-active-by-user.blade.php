<div class="bg-transparent rounded-xl shadow p-4 w-full   mx-auto">
    @if(count($this->clientsActiveByUser()) > 0)
        <div class="mb-3 flex justify-between items-center">
            <h2 class="text-sm font-semibold text-gray-700">Clients Active by User</h2>
        </div>
        <flux:chart :value="$this->clientsActiveByUser" class="aspect-3/1">
            <flux:chart.svg>
                <flux:chart.line field="total" class="text-blue-500 dark:text-blue-400" />
                <flux:chart.axis axis="x" field="name">
                    <flux:chart.axis.line />
                    <flux:chart.axis.tick />
                </flux:chart.axis>
                <flux:chart.axis axis="y">
                    <flux:chart.axis.grid />
                    <flux:chart.axis.tick />
                </flux:chart.axis>
                <flux:chart.cursor />
            </flux:chart.svg>
            <flux:chart.tooltip>
                <flux:chart.tooltip.heading field="name" />
                <flux:chart.tooltip.value field="total" label="Total" />
            </flux:chart.tooltip>
        </flux:chart>
    @else
        <div class="text-center items-center text-gray-500 mt-4">
            <flux:icon name="exclamation-circle" class="inline-block ml-2" /> Not enough data to render the chart.
        </div>
    @endif
</div>
