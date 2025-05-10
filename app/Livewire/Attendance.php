<?php

namespace App\Livewire;

use Carbon\Traits\ToStringFormat;
use Livewire\Component;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\Auth;

class Attendance extends Component
{
    public $status;
    public $time;
    // public $reason;
    // public $time_out;


    // Validation rules
    protected $rules = [
        'status' => 'required|string|max:255',
        'time' => 'nullable|date_format:H:i',
        // 'reason' => 'nullable|string|max:255',
        // 'time_out' => 'nullable|date_format:H:i',
    ];

    public function mount()
    {
        $a = new AttendanceRecord();
        $id = Auth::user()->id;
        // Initialize default values
        $data = $a::where('user_id', $id)->latest()->first();
        $todate = date('Y-m-d');

        $now = now()->setTimezone('Asia/Kolkata');
        if ($data == Null || explode(" ", $data->created_at)[0] != $todate) {
            $this->status = "checkin";
        } else {
            $this->status = "checkout";
        }
        $this->time = $now->format('H:i');
        // $this->time_out = $now->format('H:i');
    }

    public function submitForm()
    {
        // Validate the form data
        $validatedData = $this->validate();
        $a = new AttendanceRecord();
        $id = Auth::user()->id;
        // For demonstration, log the submitted data
        logger('Attendance Submitted:', $validatedData);

        $todate = date('Y-m-d');
        if ($this->status == 'checkin') {
            $data = $a::where('user_id', $id)->latest()->first();
            if ($data === null || explode(" ", $data->created_at)[0] != $todate) {
                $a::create([
                    'user_id' => $id,
                    'status' => 'present',
                    'check_in' => $this->time,
                ]);
                session()->flash('message', 'Successfully Checked In');
            } else {
                session()->flash('message', 'Already Checked In');
            }
        } else if ($this->status == 'checkout') {
            // do
        }

        // Optionally, reset the form fields

        // Provide feedback to the user
        // session()->flash('message', json_encode($data->check_in));
        // return redirect("/");
    }

    public function render()
    {
        return view('livewire.attendance');
    }
}
