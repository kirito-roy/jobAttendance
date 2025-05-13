<div class="h-full ">
    <x-slot:heading>home</x-slot:heading>
    <div class="w-full max-w-4xl p-8 mx-auto mt-4 overflow-x-auto bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200">Weekly Schedule</h1>

        @if ($schedule)
            <table class="w-full mt-6 border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2 border">Day</th>
                        <th class="px-4 py-2 border">Check-in Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                        <td class="px-4 py-2 border">Monday</td>
                        <td class="px-4 py-2 border">
                            {{ $schedule->monday == '' ? 'No Schedule' : $schedule->monday }}
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                        <td class="px-4 py-2 border">Tuesday</td>
                        <td class="px-4 py-2 border">
                            {{ $schedule->tuesday == '' ? 'No Schedule' : $schedule->tuesday }}
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                        <td class="px-4 py-2 border">Wednesday</td>
                        <td class="px-4 py-2 border">
                            {{ $schedule->wednesday == '' ? 'No Schedule' : $schedule->wednesday }}
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                        <td class="px-4 py-2 border">Thursday</td>
                        <td class="px-4 py-2 border">
                            {{ $schedule->thursday == '' ? 'No Schedule' : $schedule->thursday }}
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                        <td class="px-4 py-2 border">Friday</td>
                        <td class="px-4 py-2 border">
                            {{ $schedule->friday == '' ? 'No Schedule' : $schedule->friday }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="mt-6 text-center text-gray-600 dark:text-gray-300">No schedule found for this week.</p>
        @endif
        <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200">Weekly Attendance</h1>


        <table class="w-full mt-6 border-collapse table-auto">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Check-in Time</th>
                    <th class="px-4 py-2 border">Check-out Time</th>
                    <th class="px-4 py-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($weeklyAttendance as $record)
                    <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                        <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($record['created_at'])->format('Y-m-d') }}
                        </td>
                        <td class="px-4 py-2 border">{{ $record['check_in'] ?? 'Not Checked In' }}</td>
                        <td class="px-4 py-2 border">{{ $record['check_out'] ?? 'Not Checked Out' }}</td>
                        <td class="px-4 py-2 border">{{ ucfirst($record['status']) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center border">No attendance records found for this
                            week.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>



</div>
