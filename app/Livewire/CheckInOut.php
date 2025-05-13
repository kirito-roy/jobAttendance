<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AttendanceRecord;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class CheckInOut extends Component
{
    public $date;
    public $attendanceRecords = [];
    public $editRecord = [];
    public $showEditModal = false;
    public $dateinweek;

    public function mount($date)
    {
        try {
            if (Carbon::parse($date)->between(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek())) {
                $this->date = $date;
                $this->loadAttendanceRecords();
                $this->dateinweek = true;
            } else {
                $this->dateinweek = false;
            }
        } catch (Exception $e) {
            $this->dateinweek = false;
        }
    }

    public function loadAttendanceRecords()
    {
        // Fetch all users with the "user" role
        $users = User::where('role', 'user')->get();

        // Fetch attendance records for the given date
        $attendanceRecords = AttendanceRecord::whereDate('created_at', $this->date)
            ->get()
            ->keyBy('user_id'); // Use user_id as key for easy lookup

        // Map all users with attendance data
        $this->attendanceRecords = $users->map(function ($user) use ($attendanceRecords) {
            $attendance = $attendanceRecords->get($user->id);

            return [
                'id' => $attendance ? $attendance->id : null,
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'check_in' => $attendance && $attendance->check_in ? $attendance->check_in : null,
                'check_out' => $attendance && $attendance->check_out ? $attendance->check_out : null,
                'status' => $attendance ? $attendance->status : '', // Default status
            ];
        })->toArray();

        // Debugging: Output attendance records as JSON
        // echo json_encode($this->attendanceRecords);
    }

    public function openEditModal($recordId = null, $userId = null)
    {
        // Handle the case where $recordId is null
        $record = $recordId ? AttendanceRecord::find($recordId) : null;

        $this->editRecord = [
            'id' => $record ? $record->id : null,
            'user_id' => $userId,
            'check_in' => $record ? $record->check_in : null,
            'check_out' => $record ? $record->check_out : null,
            'status' => $record ? $record->status : null,
        ];

        $this->showEditModal = true;
    }

    public function updateRecord()
    {
        // Ensure default values for check_in, check_out, and status
        $this->editRecord['check_in'] = $this->editRecord['check_in'] ?? null;
        $this->editRecord['check_out'] = $this->editRecord['check_out'] ?? null;
        $this->editRecord['status'] = $this->editRecord['status'] ?? 'present';

        // Validation to ensure required fields are filled
        // if (!$this->editRecord['check_in'] || !$this->editRecord['check_out']) {
        //     session()->flash('error', 'Please fill in all inputs before saving.');
        //     return;
        // }

        // Create or update the attendance record
        AttendanceRecord::updateOrCreate(
            ['id' => $this->editRecord['id']],
            [
                'user_id' => $this->editRecord['user_id'],
                'check_in' => $this->editRecord['check_in'],
                'check_out' => $this->editRecord['check_out'],
                'status' => $this->editRecord['status'],
                'created_at' => $this->date, // Ensure the record is tied to the given date
            ]
        );

        session()->flash('message', 'Attendance record updated successfully.');
        $this->showEditModal = false;
        $this->loadAttendanceRecords(); // Refresh table data
    }
    public function render()
    {
        return view('livewire.check-in-out', [
            'attendanceRecords' => $this->attendanceRecords,
        ]);
    }
}
