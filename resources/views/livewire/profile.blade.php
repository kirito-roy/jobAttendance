<div>
    <x-slot:heading>Profile</x-slot:heading>

    <div class="flex items-center justify-center h-full">
        <div class="w-full max-w-4xl p-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200">User Profile</h1>
            <form wire:submit.prevent='submit_profile' class="mt-6 space-y-4">
                <!-- Name -->
                <div>
                    <label for="name"
                        class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Name:</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                </div>

                <!-- Email -->
                <div>
                    <label for="email"
                        class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Email:</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" readonly
                        class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md shadow-sm cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone"
                        class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Phone:</label>
                    <input type="text" id="phone" name="phone" pattern="[6-9][0-9]{9}"
                        value="{{ $user->phone }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600"
                        title="Please enter a valid Indian phone number (10 digits starting with 6, 7, 8, or 9)">
                </div>

                <!-- Address -->
                <div>
                    <label for="address"
                        class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Address:</label>
                    <input type="text" id="address" name="address" value="{{ $user->address }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                </div>

                <!-- Department -->
                <div>
                    <label for="department"
                        class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Department:</label>

                    <input type="text" id="department" name="department" value="{{ $user->dep }}" readonly
                        class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md shadow-sm cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                </div>

                <!-- Role (Read-Only) -->
                <div>
                    <label for="role"
                        class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Role:</label>
                    <input type="text" id="role" name="role" value="{{ $user->role }}" readonly
                        class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md shadow-sm cursor-not-allowed focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                        class="w-full px-4 py-2 font-semibold text-white transition duration-150 bg-indigo-600 rounded-md hover:bg-indigo-700">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
