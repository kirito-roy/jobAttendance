<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Schedule extends Component
{
    public $users;
    public $monday_time;
    public $tuesday_time;
    public $wednesday_time;
    public $thursday_time;
    public $friday_time;
    public $saturday_time;
    public $sunday_time;

    public function mount()
    {
        // Fetch all users (replace the query if you need to filter users)
        $this->users = User::where('role', 'user')->get();
    }

    public function schedule_form($userId)
    {
        // Validate the input times
        $this->validate([
            'monday_time' => 'required|date_format:H:i',
            'tuesday_time' => 'required|date_format:H:i',
            'wednesday_time' => 'required|date_format:H:i',
            'thursday_time' => 'required|date_format:H:i',
            'friday_time' => 'required|date_format:H:i',
            'saturday_time' => 'required|date_format:H:i',
            'sunday_time' => 'required|date_format:H:i',
        ]);

        // Fetch the user by ID
        $user = User::find($userId);

        if ($user) {
            // Save the schedule (update the user or a related schedule model)
            $user->schedule()->updateOrCreate(
                ['user_id' => $userId], // Condition to find the record
                [
                    'monday' => $this->monday_time,
                    'tuesday' => $this->tuesday_time,
                    'wednesday' => $this->wednesday_time,
                    'thursday' => $this->thursday_time,
                    'friday' => $this->friday_time,
                    'saturday' => $this->saturday_time,
                    'sunday' => $this->sunday_time,
                ]
            );

            // Optional: Flash a success message
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
