<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use DateTime;
use App\Models\Schedule as ScheduleModel;

class Schedule extends Component
{
    public $allUsers = []; // Preload all users
    public $users = []; // Filtered users
    public $startOfWeek;
    public $endOfWeek;

    // Individual user time inputs
    public $times = [];
    public $search = ''; // Search term

    public function mount()
    {
        $today = new DateTime();

        // Calculate start and end of the week
        $this->startOfWeek = (clone $today)->modify('monday')->format('Y-m-d');
        $this->endOfWeek = (clone $today)->modify('sunday')->format('Y-m-d');

        // Preload all users with schedules
        $this->allUsers = User::with(['schedule' => function ($query) {
            $query->where('startOfWeek', $this->startOfWeek);
        }])
            ->where('role', 'user')
            ->get();

        // Initialize the filtered user list and times
        $this->users = $this->allUsers;
        $this->initializeTimes();
    }



    private function initializeTimes()
    {
        $this->times = []; // Reset the times array
        foreach ($this->users as $user) {
            $this->times[$user->id] = [
                'monday' => $user->schedule->monday ?? '',
                'tuesday' => $user->schedule->tuesday ?? '',
                'wednesday' => $user->schedule->wednesday ?? '',
                'thursday' => $user->schedule->thursday ?? '',
                'friday' => $user->schedule->friday ?? '',
            ];
        }
    }

    public function schedule_form($userId)
    {
        // Validate time inputs for the specific user
        $this->validate([
            "times.$userId.monday" => 'nullable|date_format:H:i',
            "times.$userId.tuesday" => 'nullable|date_format:H:i',
            "times.$userId.wednesday" => 'nullable|date_format:H:i',
            "times.$userId.thursday" => 'nullable|date_format:H:i',
            "times.$userId.friday" => 'nullable|date_format:H:i',
        ]);

        // Find the user in the preloaded data
        $user = collect($this->allUsers)->firstWhere('id', $userId);

        if ($user) {
            // Save or update the schedule
            ScheduleModel::updateOrCreate(
                ['user_id' => $userId, 'startOfWeek' => $this->startOfWeek],
                [
                    'monday' => $this->times[$userId]['monday'],
                    'tuesday' => $this->times[$userId]['tuesday'],
                    'wednesday' => $this->times[$userId]['wednesday'],
                    'thursday' => $this->times[$userId]['thursday'],
                    'friday' => $this->times[$userId]['friday'],
                    'endOfWeek' => $this->endOfWeek,
                ]
            );

            session()->flash('message', "Schedule saved for {$user->name}!");
        } else {
            session()->flash('error', "User not found!");
        }
    }

    public function render()
    {
        return view('livewire.schedule', ["users" => $this->users]);
    }
}
