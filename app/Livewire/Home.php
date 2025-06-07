<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\Models\Schedule;
use App\Models\AttendanceRecord;

class Home extends Component
{
    public $startOfWeek;
    public $schedule;
    public $weeklyAttendance = [];

    public function getattendance()
    {
        $userId = Auth::id();

        $today = new DateTime();
        $startOfWeek = ($today->format('N') == 1)
            ? $today->format('Y-m-d')
            : $today->modify('last monday')->format('Y-m-d');

        $endOfWeek = (clone $today)->modify('sunday')->format('Y-m-d');

        $this->weeklyAttendance = AttendanceRecord::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public function findSchedule()
    {
        $today = new DateTime();
        $this->startOfWeek = ($today->format('N') == 1)
            ? $today->format('Y-m-d')
            : $today->modify('last monday')->format('Y-m-d');

        $this->schedule = Schedule::where('user_id', Auth::id())
            ->where('startOfWeek', $this->startOfWeek)
            ->first();
    }

    public function mount()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $roleNames = $user->roles->pluck('role')->toArray(); // ['admin', 'manager', ...]

        if (in_array('admin', $roleNames)) {
            return redirect('/admin');
        } elseif (in_array('manager', $roleNames)) {
            return redirect('/manager');
        }

        // If not admin or manager, continue
        $this->findSchedule();
        $this->getattendance();
    }

    public function render()
    {
        return view('livewire.home');
    }
}
