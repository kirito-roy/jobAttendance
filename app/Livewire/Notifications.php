<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Import Auth for role checking
use Livewire\Component;

class Notifications extends Component
{
    public $notifications = [];
    public $filterType = 'all'; // Default filter type
    public $email, $type, $message; // Fields for creating a notification

    /**
     * Mount the component and load all notifications initially.
     */
    public function mount()
    {
        $this->loadNotifications();
    }

    /**
     * Render the Livewire component.
     */
    public function render()
    {
        return view('livewire.notification');
    }

    /**
     * Load notifications based on the filter type and user role.
     */
    public function loadNotifications()
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager') {
            // Admins and managers can see all notifications
            $query = Notification::query();
        } else {
            // Users can only see their own notifications
            $query = Notification::where('user_id', Auth::user()->id);
        }

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        $this->notifications = $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Filter notifications by type.
     *
     * @param string $type
     */
    public function filterNotifications($type)
    {
        $this->filterType = $type;
        $this->loadNotifications();
    }

    /**
     * Mark a single notification as read.
     *
     * @param int $notificationId
     */
    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);

        // Allow marking as read only if the user owns the notification or is an admin/manager
        if ($notification && ($notification->user_id === Auth::id() || Auth::user()->role === 'admin' || Auth::user()->role === 'manager')) {
            if (!$notification->read_at) {
                $notification->update(['read_at' => now()]);
            }
        }

        $this->loadNotifications();
    }

    /**
     * Mark all unread notifications as read.
     */
    public function markAllAsRead()
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager') {
            // Admins and managers can mark all notifications as read
            Notification::whereNull('read_at')->update(['read_at' => now()]);
        } else {
            // Users can only mark their own notifications as read
            Notification::where('user_id', Auth::id())->whereNull('read_at')->update(['read_at' => now()]);
        }

        $this->loadNotifications();
    }

    /**
     * Create a new notification (Admins and managers only).
     */
    public function createNotification()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403, 'Unauthorized action.');
        }

        $this->validate([
            'email' => 'required|email|exists:users,email',
            'type' => 'required|string',
            'message' => 'required|string',
        ]);

        $user = User::where('email', $this->email)->first(); // Lookup user by email

        Notification::create([
            'user_id' => $user->id, // Save user ID internally
            'type' => $this->type,
            'message' => $this->message,
            'read_at' => null,
        ]);

        session()->flash('notification_message', 'Notification created successfully!');

        // Clear the form
        $this->reset(['email', 'type', 'message']);
        $this->loadNotifications();
    }

    /**
     * Delete a notification (Admins and managers only).
     *
     * @param int $notificationId
     */
    public function deleteNotification($notificationId)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403, 'Unauthorized action.');
        }

        $notification = Notification::find($notificationId);

        if ($notification) {
            $notification->delete();
        }

        $this->loadNotifications();
    }
}
