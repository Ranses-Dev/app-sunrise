<div>
    <x-dashboard.grid-cards :clientsAliveCount="$this->data()['clientsAliveCount']"
        :clientsIdentificationsDueCount="$this->data()['clientsIdentificationsDueCount']"
        :clientsIdentificationsOverdueCount="$this->data()['clientsIdentificationsOverdueCount']"
        :clientsCertificationsDueCount="$this->data()['clientsCertificationsDueCount']"
        :clientsCertificationsOverdueCount="$this->data()['clientsCertificationsOverdueCount']" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="col-span-1 md:col-span-2">
            <x-dashboard.chart-health-care-provider :dataset="$this->data()['clientsByHealthcareProviders']"
                class="mt-8" />
        </div>
        <livewire:dashboard.table-information-by-specialists />
    </div>
    <livewire:dashboard.table-information-by-ethnicity />
</div>
