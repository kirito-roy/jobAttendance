<div>
    <x-slot:heading>Manage User</x-slot:heading>

    <div class="w-full max-w-4xl p-6 mx-auto bg-white rounded shadow dark:bg-gray-800">
        <h1 class="mb-4 text-2xl font-bold text-center text-gray-900 dark:text-gray-100">User Profile</h1>

        @if (session()->has('message'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded dark:text-green-200 dark:bg-green-900">
                {{ session('message') }}
            </div>
        @endif

        <!-- Basic Info -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name:</label>
            <input type="text" wire:model.defer="user.name"
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-100" readonly>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email:</label>
            <input type="email" wire:model.defer="user.email"
                class="w-full px-3 py-2 border rounded dark:bg-gray-700 dark:text-gray-100" readonly>
        </div>

        <!-- Assigned Roles -->
        <div class="mb-4">
            <h2 class="mb-2 text-lg font-semibold text-gray-800 dark:text-gray-100">Assigned Roles:</h2>
            <ul class="list-disc list-inside">
                @foreach ($userrole as $role)
                    <li class="flex items-center justify-between">
                        <span>{{ $role }}</span>
                        <button wire:click="deleteRole('{{ $role }}')"
                            class="text-red-500 hover:underline">Remove</button>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Add Role Modal -->
        @if ($showAddModal)
            <div class="p-4 mb-4 bg-gray-100 border rounded dark:bg-gray-700">
                <label class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-100">Select Roles:</label>
                <select multiple wire:model="selectedRoles"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:text-white">
                    @foreach ($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end mt-2">
                    <button wire:click="assignRole" class="px-4 py-2 text-white bg-blue-500 rounded">Assign</button>
                    <button wire:click="closeModal" class="ml-2 text-gray-700 dark:text-gray-300">Cancel</button>
                </div>
            </div>
        @else
            <button wire:click="openModal" class="px-4 py-2 mt-4 text-white bg-green-500 rounded">Assign New
                Role</button>
        @endif
    </div>
</div>
