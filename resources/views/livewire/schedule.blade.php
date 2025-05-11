<div>
    <x-slot:heading>schedule</x-slot:heading>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="w-full text-left border-collapse">
            <thead class="text-gray-700 bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Email</th>
                    {{-- <th class="px-4 py-2 border">Role</th> --}}
                    <th class="px-4 py-2 border">Monday</th>
                    <th class="px-4 py-2 border">Tuesday</th>
                    <th class="px-4 py-2 border">Wednesday</th>
                    <th class="px-4 py-2 border">Thursday</th>
                    <th class="px-4 py-2 border">Friday</th>
                    <th class="px-4 py-2 border">Saturday</th>
                    <th class="px-4 py-2 border">Sunday</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example Row -->
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        {{-- <td class="px-4 py-2 border">Admin</td> --}}
                        <form wire:submit.prevent='schedule_form({{ $user->id }})'>

                            <td class="px-4 py-2 border bg-gray-50">
                                <div>
                                    <input type="time" id="monday-time" wire:model.defer="monday_time"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <div>
                                    <input type="time" id="tuesday-time" wire:model.defer="tuesday_time"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <div>
                                    <input type="time" id="wednesday-time" wire:model.defer="wednesday_time"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <div>
                                    <input type="time" id="thursday-time" wire:model.defer="thursday_time"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <div>
                                    <input type="time" id="friday-time" wire:model.defer="friday_time"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <div>

                                    <input type="time" id="saturday-time" wire:model.defer="saturday_time"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <div>

                                    <input type="time" id="sunday-time" wire:model.defer="sunday_time"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                                </div>
                            </td>
                            <td class="px-4 py-2 text-center border">
                                <button value="submit"
                                    class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700">
                                    Save
                                </button>
                            </td>
                        </form>
                    </tr>
                @endforeach

                <!-- Repeat the above row for each user -->
            </tbody>
        </table>
    </div>
</div>
