<div>
    <x-slot:heading>schedule</x-slot:heading>
    <div class="w-full h-full p-5 space-y-5 bg-white rounded-lg dark:bg-gray-800">
        <h1 class="text-xl font-bold text-center">Manage schedule</h1>

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

        <div class="flex items-center space-x-4">
            <input type="text" id="searchInput"
                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:ring-indigo-600 dark:focus:border-indigo-600"
                placeholder="Search by name or email">

            <x-primary-button onclick="searchUser()">
                Search
            </x-primary-button>
        </div>

        <div class="mt-4 overflow-x-auto bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="overflow-x-auto">
                <table class="hidden w-full text-left border-collapse md:table">
                    <thead class="bg-gray-200 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Monday</th>
                            <th class="px-4 py-2 border">Tuesday</th>
                            <th class="px-4 py-2 border">Wednesday</th>
                            <th class="px-4 py-2 border">Thursday</th>
                            <th class="px-4 py-2 border">Friday</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        @foreach ($users as $index => $user)
                            <tr id="user-id-{{ $user->id }}" class="">
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <form wire:submit.prevent="schedule_form({{ $user->id }})">
                                    <td class="px-4 py-2 border bg-gray-50 dark:bg-gray-800">
                                        <input type="time" wire:model.defer="times.{{ $user->id }}.monday"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                    </td>
                                    <td class="px-4 py-2 border bg-gray-50 dark:bg-gray-800">
                                        <input type="time" wire:model.defer="times.{{ $user->id }}.tuesday"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                    </td>
                                    <td class="px-4 py-2 border bg-gray-50 dark:bg-gray-800">
                                        <input type="time" wire:model.defer="times.{{ $user->id }}.wednesday"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                    </td>
                                    <td class="px-4 py-2 border bg-gray-50 dark:bg-gray-800">
                                        <input type="time" wire:model.defer="times.{{ $user->id }}.thursday"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                    </td>
                                    <td class="px-4 py-2 border bg-gray-50 dark:bg-gray-800">
                                        <input type="time" wire:model.defer="times.{{ $user->id }}.friday"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                    </td>
                                    <td class="px-4 py-2 text-center border">
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-600 rounded hover:bg-green-700">
                                            Save
                                        </button>
                                    </td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="grid grid-cols-1 gap-4 md:hidden">
                    @foreach ($users as $index => $user)
                        <div id="user-id-{{ $user->id }}"
                            class="p-4 bg-white rounded-lg shadow dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="mb-2">
                                <span class="font-semibold">Name:</span> {{ $user->name }}
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold">Email:</span> {{ $user->email }}
                            </div>
                            <form wire:submit.prevent="schedule_form({{ $user->id }})" class="space-y-2">
                                <div>
                                    <span class="font-semibold">Monday:</span>
                                    <input type="time" wire:model.defer="times.{{ $user->id }}.monday"
                                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                </div>
                                <div>
                                    <span class="font-semibold">Tuesday:</span>
                                    <input type="time" wire:model.defer="times.{{ $user->id }}.tuesday"
                                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                </div>
                                <div>
                                    <span class="font-semibold">Wednesday:</span>
                                    <input type="time" wire:model.defer="times.{{ $user->id }}.wednesday"
                                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                </div>
                                <div>
                                    <span class="font-semibold">Thursday:</span>
                                    <input type="time" wire:model.defer="times.{{ $user->id }}.thursday"
                                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                </div>
                                <div>
                                    <span class="font-semibold">Friday:</span>
                                    <input type="time" wire:model.defer="times.{{ $user->id }}.friday"
                                        class="w-full px-3 py-2 mt-1 text-sm border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-400 focus:border-blue-400">
                                </div>
                                <div>
                                    <button type="submit"
                                        class="w-full px-3 py-1 bg-green-600 rounded hover:bg-green-700">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const users = @json($users);

    function searchUser() {
        const searchInput = document.getElementById("searchInput").value.toLowerCase();

        const matchingUser = users.find(user =>
            user.name.toLowerCase().includes(searchInput) ||
            user.email.toLowerCase().includes(searchInput)
        );

        if (matchingUser) {
            const row = document.getElementById(`user-id-${matchingUser.id}`);
            if (row) {
                row.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
                row.style.backgroundColor = "#ffffcc"; // Highlight the row temporarily
                setTimeout(() => row.style.backgroundColor = "", 2000); // Remove highlight after 2 seconds
            }
        } else {
            alert("No matching user found.");
        }
    }
</script>
