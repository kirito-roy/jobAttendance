<div>
    <x-slot:heading>schedule</x-slot:heading>

    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="w-full text-left border-collapse">
            <thead class="text-gray-700 bg-gray-200">
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
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <form wire:submit.prevent="schedule_form({{ $user->id }})">
                            <td class="px-4 py-2 border bg-gray-50">
                                <input type="time" wire:model.defer="times.{{ $user->id }}.monday"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <input type="time" wire:model.defer="times.{{ $user->id }}.tuesday"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <input type="time" wire:model.defer="times.{{ $user->id }}.wednesday"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <input type="time" wire:model.defer="times.{{ $user->id }}.thursday"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                            </td>
                            <td class="px-4 py-2 border bg-gray-50">
                                <input type="time" wire:model.defer="times.{{ $user->id }}.friday"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-400 focus:border-blue-400">
                            </td>
                            <td class="px-4 py-2 text-center border">
                                <button type="submit"
                                    class="px-3 py-1 text-white bg-green-600 rounded hover:bg-green-700">
                                    Save
                                </button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
