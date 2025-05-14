<div>
    <x-slot:heading>Notifications</x-slot:heading>

    <div class="w-full h-full p-5 bg-gray-100 dark:bg-gray-600">
        <!-- Page Heading -->
        <h1 class="mb-5 text-2xl font-bold text-center">Notifications and Alerts</h1>
        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')

            <!-- Notification Creation Form -->
            <div class="p-4 mb-5 rounded-lg shadow-md dark:bg-gray-800">
                <h2 class="mb-4 text-lg font-semibold">Create a New Notification</h2>
                <form wire:submit.prevent="createNotification">
                    <div class="mb-3">
                        <label for="email" class="block text-sm font-medium">User Email</label>
                        <input type="email" id="email" wire:model="email"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter user email">
                        @error('email')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type" class="block text-sm font-medium">Notification Type</label>
                        <select id="type" wire:model="type"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Type</option>
                            <option value="late_checkin">Late Check-In</option>
                            <option value="early_checkout">Early Check-Out</option>
                            <option value="missed_registration">Missed Registration</option>
                            <option value="special_case_request">Special Attendance Case</option>
                            <option value="schedule_update">Schedule Update</option>
                            <option value="overtime_alert">Overtime Alert</option>
                        </select>
                        @error('type')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="message" class="block text-sm font-medium">Message</label>
                        <textarea id="message" wire:model="message"
                            class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:bg-gray-800 focus:ring-blue-500 focus:border-blue-500"
                            rows="3" placeholder="Enter notification message"></textarea>
                        @error('message')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Create
                        Notification</button>
                </form>
                @if (session()->has('notification_message'))
                    <div class="mt-3 text-green-500">
                        {{ session('notification_message') }}
                    </div>
                @endif
            </div>
        @endif

        <!-- Notification Filters -->
        <div class="flex items-center justify-between mb-5">
            <div>
                <button class="px-4 py-2 text-black bg-gray-200 rounded hover:bg-gray-300"
                    wire:click="filterNotifications('all')">All</button>
                <button class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
                    wire:click="filterNotifications('late_checkin')">Late Check-Ins</button>
                <button class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-600"
                    wire:click="filterNotifications('early_checkout')">Early Check-Outs</button>
                <button class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                    wire:click="filterNotifications('missed_registration')">Missed Registrations</button>
            </div>
            <button class="px-4 py-2 text-white bg-gray-800 rounded hover:bg-gray-900" wire:click="markAllAsRead">Mark
                All as Read</button>
        </div>

        <!-- Notifications List -->
        <div id="notifications" class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            @forelse ($notifications as $notification)
                <div class="mb-4 p-4 border rounded @if (!$notification->read_at) bg-gray-100 @endif">
                    <p class="text-lg font-medium">{{ $notification->message }}</p>
                    <p class="text-sm text-gray-500">Type: {{ ucfirst(str_replace('_', ' ', $notification->type)) }}</p>
                    <p class="text-sm text-gray-500">Received: {{ $notification->created_at->diffForHumans() }}</p>
                    <div class="flex items-center mt-2 space-x-2">
                        <!-- Mark as Read Button -->
                        @if (!$notification->read_at)
                            <button class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600"
                                wire:click="markAsRead({{ $notification->id }})">Mark as Read</button>
                        @endif

                        <!-- Delete Button (Admins and Managers Only) -->
                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                            <button class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600"
                                wire:click="deleteNotification({{ $notification->id }})">Delete</button>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">No notifications available.</p>
            @endforelse
        </div>
    </div>
</div>
