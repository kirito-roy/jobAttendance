<div>
    <x-slot:heading>Roles</x-slot:heading>

    <div class="flex items-center justify-center h-full">
        <div class="w-full h-full p-8 space-y-6 overflow-auto bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h1 class="text-xl font-bold text-center">Role Management</h1>

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

            <!-- Search Filter -->
            <div class="flex mb-4">
                <input type="text" wire:model="search"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600"
                    placeholder="Search by name or email">
                <x-primary-button wire:click="searchf" class="ml-2">
                    Search
                </x-primary-button>
            </div>

            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Current Role</th>
                        <th class="px-4 py-2 border">Current Dep</th>
                        <th class="px-4 py-2 border">Change</th>
                        <th class="px-4 py-2 border">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                            <td class="px-4 py-2 border">{{ $user->name }}</td>
                            <td class="px-4 py-2 border">{{ $user->role ?? 'No role assigned' }}</td>
                            <td class="px-4 py-2 border">{{ $user->dep ?? 'No dep assigned' }}</td>

                            <td class="px-4 py-2 border">
                                <form wire:submit.prevent="submit_role({{ $user->id }})" class="flex flex-col">
                                    <!-- Role Dropdown -->
                                    <select wire:model.defer="selectedRole.{{ $user->id }}" name="role_id"
                                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                        @endforeach
                                    </select>

                                    <!-- Department Dropdown -->
                                    <select wire:model.defer="selectedDep.{{ $user->id }}" name="dep"
                                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="">Select Dep</option>
                                        @foreach ($deps as $dep)
                                            <option value="{{ $dep }}">{{ ucfirst($dep) }}</option>
                                        @endforeach
                                    </select>

                                    <!-- Change Button -->
                                    <button
                                        class="px-4 py-2 mt-2 text-sm font-semibold text-white transition duration-150 bg-indigo-600 rounded-md hover:bg-indigo-700">
                                        Change
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-2 border">
                                <!-- Delete Button with Confirmation -->
                                <button onclick="confirmDelete({{ $user->id }})"
                                    class="w-full px-4 py-2 mt-2 text-sm font-semibold text-white transition duration-150 bg-red-600 rounded-md hover:bg-red-700">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center border">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript Confirmation -->
    <script>
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                @this.call('delete', userId); // Calls the Livewire delete method
            }
        }
    </script>
</div>
