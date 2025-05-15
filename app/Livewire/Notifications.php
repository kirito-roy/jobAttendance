<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public $notifications = [];
    public $filterType = 'all';
    public $email, $type, $message;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification');
    }

    public function loadNotifications()
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager') {
            $query = Notification::query();
        } else {
            $query = Notification::where('user_id', Auth::user()->id);
        }

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        $this->notifications = $query->orderBy('created_at', 'desc')->get();
    }

    public function filterNotifications($type)
    {
        $this->filterType = $type;
        $this->loadNotifications();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);

        if ($notification && ($notification->user_id === Auth::id() || Auth::user()->role === 'admin' || Auth::user()->role === 'manager')) {
            if (!$notification->read_at) {
                $notification->update(['read_at' => now()]);
            }
        }

        $this->loadNotifications();
    }

    public function markAllAsRead()
    {
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'manager') {
            Notification::whereNull('read_at')->update(['read_at' => now()]);
        } else {
            Notification::where('user_id', Auth::id())->whereNull('read_at')->update(['read_at' => now()]);
        }

        $this->loadNotifications();
    }

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

        $user = User::where('email', $this->email)->first();

        Notification::create([
            'user_id' => $user->id, // Save user ID internally
            'type' => $this->type,
            'message' => $this->message,
            'read_at' => null,
        ]);

        session()->flash('notification_message', 'Notification created successfully!');

        $this->reset(['email', 'type', 'message']);
        $this->loadNotifications();
    }

    public function deleteNotification($notificationId)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {
            abort(403, 'Unauthorized action.');
        }

        $notification = Notification::find($notificationId);

        if ($notification) {
            $notification->delete();
        }
        return redirect('/notification');
    }
}
