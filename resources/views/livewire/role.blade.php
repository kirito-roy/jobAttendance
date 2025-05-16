<div>
    <x-slot:heading>Roles</x-slot:heading>

    <div class="flex items-center justify-center h-full">
        <div class="w-full h-full p-8 space-y-6 overflow-auto bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h1 class="text-xl font-bold text-center">Role Management</h1>

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

            <div class="mb-4 text-right">
                <x-primary-button onclick="openCreateUserModal()">
                    Add New User
                </x-primary-button>
            </div>

            <div class="flex mb-4">
                <input type="text" id="searchInput"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600"
                    placeholder="Search by name or email">
                <x-primary-button onclick="searchUser()" class="ml-2">
                    Search
                </x-primary-button>
            </div>

            <div class="overflow-x-auto">
                <table class="hidden w-full text-sm text-left border-collapse rounded-lg table-auto md:table">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Current Role</th>
                            <th class="px-4 py-2 border">Current Dep</th>
                            <th class="px-4 py-2 border">Change</th>
                            <th class="px-4 py-2 border">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach ($users as $user)
                            <tr id="user-id-{{ $user->id }}" class="hover:bg-gray-200 dark:hover:bg-gray-600">
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->role ?? 'No role assigned' }}</td>
                                <td class="px-4 py-2 border">{{ $user->dep ?? 'No dep assigned' }}</td>
                                <td class="px-4 py-2 border">
                                    <form wire:submit.prevent="submit_role({{ $user->id }})" class="flex flex-col">
                                        <select wire:model.defer="selectedRole.{{ $user->id }}" name="role_id"
                                            class="w-full px-3 py-2 mt-1 text-sm rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                            <option value="">Select Role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                            @endforeach
                                        </select>
                                        <select wire:model.defer="selectedDep.{{ $user->id }}" name="dep"
                                            class="w-full px-3 py-2 mt-1 text-sm rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                            <option value="">Select Dep</option>
                                            @foreach ($deps as $dep)
                                                <option value="{{ $dep }}">{{ ucfirst($dep) }}</option>
                                            @endforeach
                                        </select>
                                        <button
                                            class="px-4 py-2 mt-2 text-sm font-semibold text-white transition duration-150 bg-indigo-600 rounded-md hover:bg-indigo-700">
                                            Change
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-2 border">
                                    <button onclick="confirmDelete({{ $user->id }})"
                                        class="w-full px-4 py-2 mt-2 text-sm font-semibold text-white transition duration-150 bg-red-600 rounded-md hover:bg-red-700">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="grid grid-cols-1 gap-4 md:hidden">
                    @foreach ($users as $user)
                        <div id="user-id-{{ $user->id }}"
                            class="p-4 bg-white rounded-lg shadow dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="mb-2">
                                <span class="font-semibold">Name:</span> {{ $user->name }}
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold">Role:</span> {{ $user->role ?? 'No role assigned' }}
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold">Department:</span> {{ $user->dep ?? 'No dep assigned' }}
                            </div>
                            <div class="mb-2">
                                <form wire:submit.prevent="submit_role({{ $user->id }})"
                                    class="flex flex-col space-y-2">
                                    <select wire:model.defer="selectedRole.{{ $user->id }}" name="role_id"
                                        class="w-full px-3 py-2 mt-1 text-sm rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                        @endforeach
                                    </select>
                                    <select wire:model.defer="selectedDep.{{ $user->id }}" name="dep"
                                        class="w-full px-3 py-2 mt-1 text-sm rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="">Select Dep</option>
                                        @foreach ($deps as $dep)
                                            <option value="{{ $dep }}">{{ ucfirst($dep) }}</option>
                                        @endforeach
                                    </select>
                                    <button
                                        class="px-4 py-2 mt-2 text-sm font-semibold text-white transition duration-150 bg-indigo-600 rounded-md hover:bg-indigo-700">
                                        Change
                                    </button>
                                </form>
                            </div>
                            <div>
                                <button onclick="confirmDelete({{ $user->id }})"
                                    class="w-full px-4 py-2 mt-2 text-sm font-semibold text-white transition duration-150 bg-red-600 rounded-md hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div id="createUserModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="w-full max-w-lg p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                <h2 class="text-xl font-bold text-center">Create New User</h2>
                <form wire:submit.prevent="createUser" class="mt-4 space-y-4">
                    <div>
                        <label for="name" class="block mb-1 text-sm font-semibold">Name:</label>
                        <input type="text" wire:model.defer="newUser.name" id="name"
                            class="w-full px-3 py-2 border rounded-md dark:bg-gray-800">
                    </div>
                    <div>
                        <label for="email" class="block mb-1 text-sm font-semibold">Email:</label>
                        <input type="email" wire:model.defer="newUser.email" id="email"
                            class="w-full px-3 py-2 border rounded-md dark:bg-gray-800">
                    </div>
                    <div>
                        <label for="password" class="block mb-1 text-sm font-semibold">Password:</label>
                        <input type="password" wire:model.defer="newUser.password" id="password"
                            class="w-full px-3 py-2 border rounded-md dark:bg-gray-800">
                    </div>
                    <div>
                        <label for="role" class="block mb-1 text-sm font-semibold">Role:</label>
                        <select wire:model.defer="newUser.role" id="role"
                            class="w-full px-3 py-2 border rounded-md dark:bg-gray-800">
                            <option value="" disabled>select option</option>
                            <option value="user">User</option>
                            <option value="manager">Manager</option>

                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label for="role" class="block mb-1 text-sm font-semibold">Role:</label>
                        <select wire:model.defer="newUser.dep" id="role"
                            class="w-full px-3 py-2 border rounded-md dark:bg-gray-800">
                            <option value="" disabled>select option</option>

                            <option value="It">It</option>
                            <option value="Finance">Finance</option>

                            <option value="Hr">Hr</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-md">Create</button>
                        <button type="button" onclick="closeCreateUserModal()"
                            class="px-4 py-2 text-white bg-gray-600 rounded-md">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const users = @json($users);

        function searchUser() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase().trim();

            if (!searchInput) return;

            // Clear previous highlights
            document.querySelectorAll("[id^='user-id-']").forEach(row => {
                row.style.backgroundColor = "";
            });

            const matchedUsers = users.filter(user =>
                (user.name && user.name.toLowerCase().includes(searchInput))
            );

            if (matchedUsers.length > 0) {
                matchedUsers.forEach(user => {
                    const row = document.getElementById(`user-id-${user.id}`);
                    if (row) {
                        row.scrollIntoView({
                            behavior: "smooth",
                            block: "center"
                        });
                        row.style.backgroundColor = "#ffffcc";
                        setTimeout(() => {
                            row.style.transition = "background-color 0.5s ease";
                            row.style.backgroundColor = "";
                        }, 2000);
                    }
                });
            } else {
                alert("No matching user found.");
            }
        }


        function openCreateUserModal() {
            document.getElementById('createUserModal').classList.remove('hidden');
        }

        function closeCreateUserModal() {
            document.getElementById('createUserModal').classList.add('hidden');
        }

        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                @this.call('delete', userId);
            }
        }
    </script>
</div>
