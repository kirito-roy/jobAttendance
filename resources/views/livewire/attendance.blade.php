<div>
    <x-slot:heading>Attendance</x-slot:heading>

    <div class="flex items-center justify-center h-screen bg-transparent">
        <form wire:submit.prevent="submitForm" class="p-8 space-y-6 bg-white rounded-lg shadow-md w-96">
            <!-- Status Dropdown -->
            <div>
                <label for="status" class="block mb-1 text-sm font-semibold text-gray-700">Status:</label>
                <select id="status" wire:model="status" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Select status</option>
                    <option value="checkin">check in</option>
                    <option value="absent">Absent</option>
                    <option value="checkout">check out</option>
                </select>

            </div>

            <!-- Dynamic Blocks -->

            <div>
                <label for="time" class="block mb-1 text-sm font-semibold text-gray-700">time:</label>
                <input type="time" id="time" wire:model.defer="time"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

            </div>

            {{-- <div>
                    <label for="reason" class="block mb-1 text-sm font-semibold text-gray-700">Reason:</label>
                    <input type="text" id="reason" wire:model.defer="reason"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                </div>
                <div>
                    <label for="time_out" class="block mb-1 text-sm font-semibold text-gray-700">Time Out:</label>
                    <input type="time" id="time_out" wire:model.defer="time_out"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                </div>
         --}}

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="w-full px-4 py-2 font-semibold text-white transition duration-150 bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Submit
                </button>
            </div>

            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="mt-4 text-center text-green-500">{{ session('message') }}</div>
            @endif
        </form>
    </div>
</div>
