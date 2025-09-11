<x-layouts.statistics :title="'Addresses'">
    <div class="table-container">
        <table class="table-custom">
            <thead>
                <tr>
                    @if (in_array('address', $columns))
                        <th>Address</th>
                    @endif
                    @if (in_array('program_branch', $columns))
                        <th>Branch</th>
                    @endif
                    @if (in_array('inspection_requested_date', $columns))
                        <th>Requested Date</th>
                    @endif
                    @if (in_array('inspection_requested_incomplete', $columns))
                        <th>Requested Incomplete</th>
                    @endif
                    @if (in_array('inspection_requested_incomplete_notes', $columns))
                        <th>Requested Incomplete Notes</th>
                    @endif
                    @if (in_array('inspection_requested_not_scheduled', $columns))
                        <th>Requested Not Scheduled</th>
                    @endif
                    @if (in_array('inspection_requested_not_scheduled_notes', $columns))
                        <th>Requested Not Scheduled Notes</th>
                    @endif
                    @if (in_array('inspection_requested_scheduled_date', $columns))
                        <th>Requested Scheduled Date</th>
                    @endif
                    @if (in_array('landlord_name', $columns))
                        <th>Landlord Name</th>
                    @endif
                    @if (in_array('landlord_contact_information', $columns))
                        <th>Landlord Contact Information</th>
                    @endif
                    @if (in_array('landlord_address', $columns))
                        <th>Landlord Address</th>
                    @endif
                    @if (in_array('landlord_howpa', $columns))
                        <th>Landlord HOWPA</th>
                    @endif
                    @if (in_array('tenant_name', $columns))
                        <th>Tenant Name</th>
                    @endif
                    @if (in_array('tenant_howpa', $columns))
                        <th>Tenant HOWPA</th>
                    @endif
                    @if (in_array('tenant_contact_information', $columns))
                        <th>Tenant Contact Information</th>
                    @endif
                    @if (in_array('tenant_address', $columns))
                        <th>Tenant Address</th>
                    @endif
                    @if (in_array('housing_type', $columns))
                        <th>Housing Type</th>
                    @endif
                    @if (in_array('number_of_bedrooms', $columns))
                        <th>Number of Bedrooms</th>
                    @endif
                    @if (in_array('housing_inspector', $columns))
                        <th>Housing Inspector</th>
                    @endif
                    @if (in_array('inspection_status', $columns))
                        <th>Inspection Status</th>
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach ($inspections as $inspection)
                    <tr>
                        @if (in_array('address', $columns))
                            <td>{{ $inspection->address?->address_formatted }}</td>
                        @endif
                        @if (in_array('program_branch', $columns))
                            <td>{{$inspection->programBranch?->name}}</td>
                        @endif
                        @if (in_array('inspection_requested_date', $columns))
                            <td>{{$inspection->inspection_requested_date_formatted}}</td>
                        @endif
                        @if (in_array('inspection_requested_incomplete', $columns))
                            <td>{{$inspection->inspection_requested_incomplete ? 'Yes' : 'No'}}</td>
                        @endif
                        @if (in_array('inspection_requested_incomplete_notes', $columns))
                            <td>{{$inspection->inspection_requested_incomplete_notes}}</td>
                        @endif
                        @if (in_array('inspection_requested_not_scheduled', $columns))
                            <td>{{$inspection->inspection_requested_not_scheduled ? 'Yes' : 'No'}}</td>
                        @endif
                        @if (in_array('inspection_requested_not_scheduled_notes', $columns))
                            <td>{{$inspection->inspection_requested_not_scheduled_notes}}</td>
                        @endif
                        @if (in_array('inspection_requested_scheduled_date', $columns))
                            <td>{{$inspection->inspection_requested_scheduled_date_formatted}}</td>
                        @endif
                        @if (in_array('landlord_name', $columns))
                            <td>{{ $inspection->landlord_name }}</td>
                        @endif
                        @if (in_array('landlord_contact_information', $columns))
                            <td>{{ $inspection->landlord_contact_information }}</td>
                        @endif
                        @if (in_array('landlord_address', $columns))
                            <td>{{ $inspection->landlordAddress?->address_formatted }}</td>
                        @endif
                        @if (in_array('landlord_howpa', $columns))
                            <td>{{ $inspection->landlordHowpa?->full_name }}</td>
                        @endif
                        @if (in_array('tenant_name', $columns))
                            <td>{{ $inspection->tenant_name }}</td>
                        @endif
                        @if (in_array('tenant_howpa', $columns))
                            <td>{{ $inspection->tenantHowpa?->full_name }}</td>
                        @endif
                        @if (in_array('tenant_contact_information', $columns))
                            <td>{{ $inspection->tenant_contact_information }}</td>
                        @endif
                        @if (in_array('tenant_address', $columns))
                            <td>{{ $inspection->tenantAddress?->address_formatted }}</td>
                        @endif
                        @if (in_array('housing_type', $columns))
                            <td>{{ $inspection->housingType?->name }}</td>
                        @endif
                        @if (in_array('number_of_bedrooms', $columns))
                            <td>{{ $inspection->number_of_bedrooms }}</td>
                        @endif
                        @if (in_array('housing_inspector', $columns))
                            <td>{{ $inspection->housingInspector?->name }}</td>
                        @endif
                        @if (in_array('inspection_status', $columns))
                            <td>{{ $inspection->inspection_status }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.statistics>
