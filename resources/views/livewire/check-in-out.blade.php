<div>
    <x-slot:heading>checkInOut</x-slot:heading>
    <div class="w-full h-full p-5 space-y-5 bg-white rounded-lg ">
        <h1 class="text-xl font-bold text-center">Attendance for {{ $date }}</h1>
        @if ($dateinweek)



            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md dark:text-green-200 dark:bg-green-900">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session()->has('error'))
                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-md dark:text-red-200 dark:bg-red-900">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Attendance Table -->
            <div class="mt-4 overflow-x-auto bg-white rounded-lg shadow-md">
                <div class="overflow-x-auto">
                    <!-- Desktop View -->
                    <table class="hidden w-full text-left border-collapse md:table">
                        <thead class="text-gray-700 bg-gray-200">
                            <tr>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Check-In Time</th>
                                <th class="px-4 py-2 border">Check-Out Time</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendanceRecords as $record)
                                <tr id="record-id-{{ $record['id'] }}" class="hover:bg-gray-100">
                                    <td class="px-4 py-2 border">{{ $record['name'] }}</td>
                                    <td class="px-4 py-2 border">{{ $record['email'] }}</td>
                                    <td class="px-4 py-2 border">{{ $record['check_in'] }}</td>
                                    <td class="px-4 py-2 border">{{ $record['check_out'] }}</td>
                                    <td class="px-4 py-2 border">{{ ucfirst($record['status']) }}</td>
                                    <td class="px-4 py-2 text-center border">
                                        <button
                                            wire:click="openEditModal({{ $record['id'] ?? 'null' }}, {{ $record['user_id'] }})"
                                            class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-600">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-2 text-center border">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Mobile View -->
                    <div class="grid grid-cols-1 gap-4 md:hidden">
                        @forelse ($attendanceRecords as $record)
                            <div id="record-id-{{ $record['id'] }}"
                                class="p-4 bg-white rounded-lg shadow hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600">
                                <div class="mb-2">
                                    <span class="font-semibold">Name:</span> {{ $record['name'] }}
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold">Email:</span> {{ $record['email'] }}
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold">Check-In Time:</span> {{ $record['check_in'] }}
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold">Check-Out Time:</span> {{ $record['check_out'] }}
                                </div>
                                <div class="mb-2">
                                    <span class="font-semibold">Status:</span> {{ ucfirst($record['status']) }}
                                </div>
                                <div class="text-center">
                                    <button
                                        wire:click="openEditModal({{ $record['id'] ?? 'null' }}, {{ $record['user_id'] }})"
                                        class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-blue-600">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center bg-white rounded-lg shadow dark:bg-gray-700">
                                No records found.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            @if ($showEditModal)
                <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                    <div class="p-6 bg-white rounded shadow-md w-96">
                        <h2 class="mb-4 text-lg font-bold">Edit Attendance Record</h2>
                        @if (session()->has('message'))
                            <div
                                class="p-4 mb-4 text-green-700 bg-green-100 rounded-md dark:text-green-200 dark:bg-green-900">
                                {{ session('message') }}
                            </div>
                        @endif

                        <!-- Error Message -->
                        @if (session()->has('error'))
                            <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-md dark:text-red-200 dark:bg-red-900">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="check_in" class="block text-sm font-medium text-gray-700">Check-In Time</label>
                            <input type="time" id="check_in" wire:model="editRecord.check_in"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                        </div>

                        <div class="mb-4">
                            <label for="check_out" class="block text-sm font-medium text-gray-700">Check-Out
                                Time</label>
                            <input type="time" id="check_out" wire:model="editRecord.check_out"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                        </div>

                        <div class="mb-4">
                            <label for="Status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="Status" wire:model="editRecord.status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                            </select>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button wire:click="$set('showEditModal', false)"
                                class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                                Cancel
                            </button>
                            <button wire:click="updateRecord"
                                class="px-4 py-2 text-sm text-white bg-green-500 rounded hover:bg-green-600">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="text-xl font-bold text-center">chose a date in this week</div>
        @endif
    </div>
</div>
