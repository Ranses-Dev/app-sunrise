@props(['dataset'=>[]])
<div class="py-4 border border-[var(--color-accent-content)]/40 rounded-md w-full p-4 my-4">
     <flux:header class="text-[var(--color-accent-content)]   font-thin text-2xl mb-4 border-b">Clients By Health Care Provider </flux:header>
    <flux:chart :value="$dataset" class="aspect-3/2 w-full ">
        <flux:chart.svg>
            <flux:chart.line field="count_clients" class="text-[var(--color-accent-content)] dark:text-pink-400" curve="none" />
            <flux:chart.area field="count_clients" class="text-[var(--color-accent-content)]/50" curve="none" />
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
            <flux:chart.tooltip.heading field="name"/>
            <flux:chart.tooltip.value field="count_clients" label="Clients" />
        </flux:chart.tooltip>
    </flux:chart>
</div>
