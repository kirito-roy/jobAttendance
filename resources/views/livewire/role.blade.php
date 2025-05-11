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

            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2 border ">Name</th>
                        <th class="px-4 py-2 border ">Current Role</th>
                        <th class="px-4 py-2 border ">Change Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-200 dark:hover:bg-gray-600">
                            <td class="px-4 py-2 border ">{{ $user->name }}</td>
                            <td class="px-4 py-2 border">
                                {{ $user->role ?? 'No role assigned' }}</td>
                            <td class="px-4 py-2 border">
                                <form wire:submit.prevent="submit_role({{ $user->id }})" class="flex flex-col">
                                    <select wire:model.defer="selectedRole.{{ $user->id }}" name="role_id"
                                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600">
                                        <option value="" class="dark:text-gray-400">Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}" class="dark:text-gray-400">
                                                {{ ucfirst($role) }}</option>
                                        @endforeach
                                    </select>
                                    <button
                                        class="px-4 py-2 mt-2 text-sm font-semibold text-white transition duration-150 bg-indigo-600 rounded-md hover:bg-indigo-700">
                                        Change
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
