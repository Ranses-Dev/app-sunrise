<div class="bg-white dark:bg-gray-900 rounded-xl shadow p-4 w-full overflow-x-auto">
    <h2 class="text-sm font-semibold text-gray-700">
        Clients Recertification Overdue by User
    </h2>
    <table class="min-w-full table-auto border-separate border-spacing-y-2">
        <thead>
            <tr class="text-sm text-left text-gray-500 dark:text-gray-400">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2 text-center">Due Clients</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($this->results as $index => $user)
                <tr class="bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                    <td class="px-4 py-2 text-center">
                        <flux:badge size="sm" type="danger">
                            {{ $user->total }}
                        </flux:badge>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-4 py-4 text-center text-gray-400 dark:text-gray-500">
                        <flux:icon name="x-circle" class="inline-block mr-1" />
                        No users with certifications due.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $this->results->links() }}
    </div>
</div>
