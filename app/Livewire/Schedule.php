<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use DateTime;
use App\Models\Schedule as ScheduleModel;

class Schedule extends Component
{
    public $allUsers = [];
    public $users = [];
    public $startOfWeek;
    public $endOfWeek;
    public $times = [];
    public $search = '';

    public function mount()
    {
        $today = new DateTime();
        if ($today->format('N') == 1) {
            $this->startOfWeek = $today->modify('monday')->format('Y-m-d');
        } else {
            $this->startOfWeek = $today->modify('last monday')->format('Y-m-d');
        }
        $this->endOfWeek = (clone $today)->modify('sunday')->format('Y-m-d');
        $this->allUsers = User::with(['schedule' => function ($query) {
            $query->where('startOfWeek', $this->startOfWeek);
        }])
            ->where('role', 'user')
            ->get();

        $this->users = $this->allUsers;
        $this->initializeTimes();
    }



    private function initializeTimes()
    {
        $this->times = [];
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
        $this->validate([
            "times.$userId.monday" => 'nullable|date_format:H:i',
            "times.$userId.tuesday" => 'nullable|date_format:H:i',
            "times.$userId.wednesday" => 'nullable|date_format:H:i',
            "times.$userId.thursday" => 'nullable|date_format:H:i',
            "times.$userId.friday" => 'nullable|date_format:H:i',
        ]);

        $user = collect($this->allUsers)->firstWhere('id', $userId);

        if ($user) {
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
