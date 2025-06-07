<div>
    <x-slot:heading>Manage User</x-slot:heading>

    <div class="flex items-center justify-center h-full">
        <div class="w-full max-w-4xl p-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200">Profile</h1>

            @if (session()->has('message'))
                <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-md dark:text-green-200 dark:bg-green-900">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded-md dark:text-red-200 dark:bg-red-900">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4">
                <label for="name"
                    class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Name:</label>
                <input type="text" id="name" wire:model.defer="user.name" name="name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600">
            </div>

            <div class="mb-4">
                <label for="email"
                    class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Email:</label>
                <input type="email" id="email" wire:model.defer="user.email" name="email" readonly
                    class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md shadow-sm cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            </div>

            <div class="mb-4">
                <label for="department"
                    class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Department:</label>
                <input type="text" id="department" wire:model.defer="user.dep" name="department" readonly
                    class="w-full px-3 py-2 bg-gray-200 border border-gray-300 rounded-md shadow-sm cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            </div>

            <div class="mb-4">
                <label class="flex justify-between mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">
                    <span>Role</span>
                    <x-primary-button wire:click="openModal">Add</x-primary-button>
                </label>

                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-200 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-2 border">Role</th>
                            <th class="px-4 py-2 border">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userrole as $role)
                            <tr>
                                <td class="px-4 py-2 border">{{ $role }}</td>
                                <td class="px-4 py-2 border">
                                    <x-primary-button
                                        wire:click="deleteRole('{{ $role }}')">Delete</x-primary-button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @if ($showAddModal)
        <div class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50">
            <div class="flex items-center justify-center min-h-screen">
                <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h2 class="text-xl font-bold text-center text-gray-800 dark:text-gray-200">Assign Roles</h2>

                    <form wire:submit.prevent="assignRole" class="mt-4 space-y-4">
                        <div class="space-y-2">
                            @foreach ($roles as $role)
                                <label class="flex items-center space-x-2 text-gray-700 dark:text-gray-200">
                                    <input type="checkbox" value="{{ $role }}" wire:model="selectedRoles"
                                        class="text-indigo-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                    <span>{{ ucfirst($role) }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div class="flex justify-center pt-4 space-x-4">
                            <button type="submit"
                                class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Assign</button>
                            <button type="button" wire:click="closeModal"
                                class="px-4 py-2 text-white bg-gray-600 rounded-md hover:bg-gray-700">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
