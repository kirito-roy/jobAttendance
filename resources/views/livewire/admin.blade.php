<div>
    <x-slot:heading>admin</x-slot:heading>
    <div>
        <div class="container px-4 mx-auto mt-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-700">Daily Summary</h2>
                    <p class="mt-2 text-lg font-bold text-green-600">Present: 95%</p>
                    <p class="text-lg font-bold text-red-500">Absent: 5%</p>
                </div>
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-700">Weekly Summary</h2>
                    <p class="mt-2 text-lg font-bold text-green-600">Present: 90%</p>
                    <p class="text-lg font-bold text-red-500">Absent: 10%</p>
                </div>
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-gray-700">Monthly Summary</h2>
                    <p class="mt-2 text-lg font-bold text-green-600">Present: 85%</p>
                    <p class="text-lg font-bold text-red-500">Absent: 15%</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end mt-6 space-x-4">
                <button class="px-4 py-2 font-bold text-white bg-green-600 rounded hover:bg-green-700">
                    Export Reports
                </button>
                <button class="px-4 py-2 font-bold text-white bg-green-600 rounded hover:bg-green-700">
                    Group Statistics
                </button>
            </div>

            <!-- Detailed Attendance Table -->
            <div class="p-6 mt-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-2xl font-semibold text-gray-700">Detailed Attendance</h2>
                <table class="w-full border border-collapse border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left border border-gray-300">Date</th>
                            <th class="px-4 py-2 text-left border border-gray-300">Present (%)</th>
                            <th class="px-4 py-2 text-left border border-gray-300">Absent (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 border border-gray-300">2025-05-01</td>
                            <td class="px-4 py-2 text-green-600 border border-gray-300">96%</td>
                            <td class="px-4 py-2 text-red-500 border border-gray-300">4%</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border border-gray-300">2025-05-02</td>
                            <td class="px-4 py-2 text-green-600 border border-gray-300">94%</td>
                            <td class="px-4 py-2 text-red-500 border border-gray-300">6%</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border border-gray-300">2025-05-03</td>
                            <td class="px-4 py-2 text-green-600 border border-gray-300">98%</td>
                            <td class="px-4 py-2 text-red-500 border border-gray-300">2%</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
