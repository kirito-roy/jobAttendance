<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use DateTime;
use App\Models\Schedule as ScheduleModel;

class Schedule extends Component
{
    public $users;
    public $startOfWeek;
    public $endOfWeek;

    // Individual user time inputs
    public $times = [];

    public function mount()
    {
        $today = new DateTime();

        // Calculate start and end of the week
        $this->startOfWeek = (clone $today)->modify('last monday')->format('Y-m-d');
        $this->endOfWeek = (clone $today)->modify('last sunday')->format('Y-m-d');

        // Fetch users and their schedules for the current week
        $this->users = User::with(['schedule' => function ($query) {
            $query->where('startOfWeek', $this->startOfWeek);
        }])->where('role', 'user')->get();

        // Initialize times array for each user
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
        // $this->validate([
        //     "times.$userId.monday" => 'date_format:H:i',
        //     "times.$userId.tuesday" => 'date_format:H:i',
        //     "times.$userId.wednesday" => 'date_format:H:i',
        //     "times.$userId.thursday" => 'date_format:H:i',
        //     "times.$userId.friday" => 'date_format:H:i',
        // ]);

        // Fetch the user
        $user = User::find($userId);

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

            session()->flash('success', "Schedule saved for {$user->name}!");
        } else {
            session()->flash('error', "User not found!");
        }
    }

    public function render()
    {
        return view('livewire.schedule', ["users" => $this->users]);
    }
}
