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
                $this->date = Carbon::parse($date)->format('Y-m-d'); // Ensure the date is in 'Y-m-d' format
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
        $users = User::where('role', 'user')->get();

        $attendanceRecords = AttendanceRecord::whereDate('date', $this->date) // Filter by the specific date
            ->get()
            ->keyBy('user_id'); // Use user_id as the key for easy lookup

        $this->attendanceRecords = $users->map(function ($user) use ($attendanceRecords) {
            $attendance = $attendanceRecords->get($user->id);

            return [
                'id' => $attendance ? $attendance->id : null,
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'check_in' => $attendance && $attendance->check_in ? Carbon::parse($attendance->check_in)->format('H:i') : null,
                'check_out' => $attendance && $attendance->check_out ? Carbon::parse($attendance->check_out)->format('H:i') : null,
                'status' => $attendance ? $attendance->status : 'Absent', // Default status is 'Absent'
            ];
        })->toArray();
    }

    public function openEditModal($recordId = null, $userId = null)
    {
        $record = $recordId ? AttendanceRecord::find($recordId) : null;

        $this->editRecord = [
            'id' => $record ? $record->id : null,
            'user_id' => $userId,
            'check_in' => $record ? $record->check_in : null,
            'check_out' => $record ? $record->check_out : null,
            'status' => $record ? $record->status : null,
        ];

        $this->showEditModal = true; // Show the edit modal
    }

    public function updateRecord()
    {
        $this->editRecord['check_in'] = $this->editRecord['check_in'] ?? null;
        $this->editRecord['check_out'] = $this->editRecord['check_out'] ?? null;
        $this->editRecord['status'] = $this->editRecord['status'] ?? 'present';

        if ($this->editRecord['check_in']) {
            $this->editRecord['check_in'] = $this->date . ' ' . $this->editRecord['check_in'];
        }
        if ($this->editRecord['check_out']) {
            $this->editRecord['check_out'] = $this->date . ' ' . $this->editRecord['check_out'];
        }

        if (!$this->editRecord['check_in'] || !$this->editRecord['check_out']) {
            session()->flash('error', 'Please fill in all inputs before saving.');
            return;
        }
        AttendanceRecord::updateOrCreate(
            ['id' => $this->editRecord['id']],
            [
                'user_id' => $this->editRecord['user_id'],
                'check_in' => $this->editRecord['check_in'],
                'check_out' => $this->editRecord['check_out'],
                'date' => $this->date,
                'status' => $this->editRecord['status'],
                // Set the date field to the selected date
            ]
        );

        session()->flash('message', 'Attendance record updated successfully.');
        $this->loadAttendanceRecords();

        $this->showEditModal = false; // Close the modal
    }

    public function render()
    {
        return view('livewire.check-in-out', [
            'attendanceRecords' => $this->attendanceRecords,
        ]);
    }
}
