<div>
    {{-- Be like water. --}}
    <x-slot:heading>admin</x-slot:heading>
    <div>
        <div class="container px-4 mx-auto mt-6">
            @if ($unScheduled != 0)
                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-md dark:text-red-200 dark:bg-red-900">
                    schedule not set for
                    {{ $unScheduled }} users
                </div>
            @endif
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="p-6 text-center bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h2 class="text-xl font-semibold">Daily Summary</h2>
                    <p class="mt-2 text-lg font-bold text-green-600">Present: {{ $dailySummary['present'] }}%</p>
                    <p class="text-lg font-bold text-red-500">Absent: {{ $dailySummary['absent'] }}%</p>
                </div>
                <div class="p-6 text-center bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h2 class="text-xl font-semibold">Weekly Summary</h2>
                    <p class="mt-2 text-lg font-bold text-green-600">Present: {{ $weeklySummary['present'] }}%</p>
                    <p class="text-lg font-bold text-red-500">Absent: {{ $weeklySummary['absent'] }}%</p>
                </div>
                <div class="p-6 text-center bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h2 class="text-xl font-semibold">Monthly Summary</h2>
                    <p class="mt-2 text-lg font-bold text-green-600">Present: {{ $monthlySummary['present'] }}%</p>
                    <p class="text-lg font-bold text-red-500">Absent: {{ $monthlySummary['absent'] }}%</p>
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-4">
                <button wire:click="exportReport" class="px-4 py-2 font-bold bg-green-600 rounded hover:bg-green-700">
                    Export Reports
                </button>
            </div>

            <div class="p-6 mt-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h2 class="mb-4 text-2xl font-semibold ">Detailed Attendance</h2>
                <table class="w-full border border-collapse border-gray-200">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800">
                            <th class="px-4 py-2 text-left border border-gray-300">Date</th>
                            <th class="px-4 py-2 text-left border border-gray-300">Present (%)</th>
                            <th class="px-4 py-2 text-left border border-gray-300">Absent (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detailedAttendance as $record)
                            <tr>
                                <td class="px-4 py-2 border border-gray-300">{{ $record['date'] }}</td>
                                <td class="px-4 py-2 text-green-600 border border-gray-300">
                                    {{ round(($record['present_count'] / $record['total']) * 100, 2) }}%
                                </td>
                                <td class="px-4 py-2 text-red-500 border border-gray-300">
                                    {{ round(($record['absent_count'] / $record['total']) * 100, 2) }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center border border-gray-300">
                                    No attendance data available for this week.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
