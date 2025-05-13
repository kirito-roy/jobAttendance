<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\Models\Schedule;
use App\Models\AttendanceRecord; // Import the AttendanceRecord model

class Home extends Component
{
    public $startOfWeek;
    public $schedule;
    public $weeklyAttendance = [];

    public function getattendance()
    {
        $userId = Auth::user()->id;

        // Calculate the start and end of the current week
        $today = new DateTime();
        if ($today->format('N') == 1) { // If today is Monday
            $startOfWeek = $today->format('Y-m-d');
        } else {
            $startOfWeek = $today->modify('last monday')->format('Y-m-d');
        }
        $endOfWeek = (clone $today)->modify('sunday')->format('Y-m-d');

        // Fetch attendance records for the current week
        $this->weeklyAttendance = AttendanceRecord::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    /**
     * Calculate the start of the week and fetch the user's weekly schedule
     */
    public function findSchedule()
    {
        $today = new DateTime();

        // Calculate start of the week
        if ($today->format('N') == 1) { // If today is Monday
            $this->startOfWeek = $today->format('Y-m-d');
        } else {
            $this->startOfWeek = $today->modify('last monday')->format('Y-m-d');
        }

        // Fetch the user's schedule for the current week
        $this->schedule = Schedule::where('user_id', Auth::user()->id)
            ->where('startOfWeek', $this->startOfWeek)
            ->first(); // Get a single record
    }

    /**
     * Mount function is executed when the Livewire component is initialized
     */
    public function mount()
    {
        if (!Auth::check()) {
            return redirect('/login'); // Redirect to login if user is not authenticated
        }

        if (Auth::user()->role === 'admin') {
            return redirect('/admin'); // Redirect admin to the admin page
        } else if (Auth::user()->role === 'manager') {
            return redirect('/manager'); // Redirect manager to the manager page
        }

        // Find the user's schedule
        $this->findSchedule();
        $this->getattendance();
    }

    /**
     * Render the Livewire component view
     */
    public function render()
    {
        return view('livewire.home');
    }
}
