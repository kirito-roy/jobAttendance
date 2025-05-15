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
    protected $rules = [
        'status' => 'required|string|max:255',
        'time' => 'nullable|date_format:H:i',
    ];

    public function mount()
    {
        $a = new AttendanceRecord();
        $id = Auth::user()->id;
        $data = $a::where('user_id', $id)->latest()->first();
        $todate = date('Y-m-d');

        $now = now()->setTimezone('Asia/Kolkata');
        if ($data == Null || explode(" ", $data->created_at)[0] != $todate) {
            $this->status = "checkin";
        } else {
            $this->status = "checkout";
        }
        $this->time = $now->format('H:i');
    }

    public function submitForm()
    {
        $validatedData = $this->validate();
        $a = new AttendanceRecord();
        $id = Auth::user()->id;
        logger('Attendance Submitted:', $validatedData);

        $todate = date('Y-m-d');
        $data = $a::where('user_id', operator: $id)->latest()->first();

        if ($this->status == 'checkin') {
            if ($data === null || explode(" ", $data->created_at)[0] != $todate) {
                $a::create([
                    'user_id' => $id,
                    'status' => 'present',
                    'check_in' => $todate . ' ' . $this->time . ':00',
                    'date' => $todate,
                ]);
                session()->flash('message', 'Successfully Checked In');
            } else {
                if ($data->status == "present") {
                    session()->flash('message', 'Already Checked In');
                } else {
                    session()->flash('message', 'You are absent Today');
                }
            }
        } else if ($this->status == 'checkout') {
            if (explode(" ", $data->created_at)[0] == $todate && $data !== null) {
                if ($data->status == 'present') {
                    if ($data->check_out == null) {
                        $a::where('user_id', $id)->update(['check_out' =>  $todate . ' ' . $this->time . ':00']);
                        session()->flash('message', 'Successfully Checked Out');
                    } else {
                        session()->flash('message', 'Already Checked out');
                    }
                } else if ($data->status == 'absent') {
                    session()->flash('message', 'You are Absent Today   ');
                }
            } else if (explode(" ", $data->created_at)[0] != $todate && $data !== null) {
                session()->flash('message', 'Did not Check in today');
            }
        } else if ($this->status == 'absent') {
            if (explode(" ", $data->created_at)[0] != $todate || $data === null) {
                $a::create(['status' => "absent", 'date' => $todate,]);
            } else if (explode(" ", $data->created_at)[0] == $todate && $data !== null) {
                if ($data->status == 'present') {
                    session()->flash('message', 'You Are Present Today');
                } else {
                    session()->flash('message', 'You Are Already Absent');
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.attendance');
    }
}
