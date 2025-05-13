<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\Schedule;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;


class ManagerPanel extends Component
{
    public $dailySummary = [];
    public $weeklySummary = [];
    public $monthlySummary = [];
    public $detailedAttendance = [];
    public $unScheduled = 0;

    public function mount()
    {
        // Calculate attendance summaries
        $this->detailedAttendance = $this->fetchWeeklyDetailedAttendance();
        $this->dailySummary = $this->calculateDailySummary($this->detailedAttendance);
        $this->weeklySummary = $this->calculateWeeklySummary();
        $this->monthlySummary = $this->calculateMonthlySummary();

        // Fetch detailed attendance for the current week
        $this->hasSchedule();
    }
    public function exportReport()
    {
        $filename = 'attendance_report_' . Carbon::now()->format('Ymd_His') . '.csv';

        // Create a streamed response
        return new StreamedResponse(function () {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, ['Date', 'Total', 'Present (%)', 'Absent (%)']);

            // Add detailed attendance records
            foreach ($this->detailedAttendance as $record) {
                $presentPercentage = $record['total'] > 0
                    ? round(($record['present_count'] / $record['total']) * 100, 2)
                    : 0;
                $absentPercentage = $record['total'] > 0
                    ? round(($record['absent_count'] / $record['total']) * 100, 2)
                    : 0;

                fputcsv($file, [
                    $record['date'],
                    $record['total'],
                    $presentPercentage . '%',
                    $absentPercentage . '%',
                ]);
            }

            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    private function calculateDailySummary($dataw)
    {
        $today = Carbon::now()->format('Y-m-d');
        return $this->calculateSummary($this->getAttendanceWithScheduleLogic([$today]));
    }

    private function calculateWeeklySummary()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
        $dates = Carbon::parse($startOfWeek)->toPeriod($endOfWeek);

        return $this->calculateSummary($this->getAttendanceWithScheduleLogic($dates));
    }

    private function calculateMonthlySummary()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        $dates = Carbon::parse($startOfMonth)->toPeriod($endOfMonth);

        return $this->calculateSummary($this->getAttendanceWithScheduleLogic($dates));
    }

    private function getAttendanceWithScheduleLogic($dates)
    {
        $users = User::where('role', 'user')->get();
        $attendanceData = [];

        foreach ($users as $user) {
            foreach ($dates as $date) {
                $date = Carbon::parse($date)->format('Y-m-d');

                // Fetch user's schedule for the week containing the date
                $schedule = Schedule::where('user_id', $user->id)
                    ->where('startOfWeek', '<=', $date)
                    ->where('endOfWeek', '>=', $date)
                    ->first();

                $scheduledTime = $schedule ? $schedule->{strtolower(Carbon::parse($date)->format('l'))} : null;

                // Fetch attendance for the day
                $attendance = AttendanceRecord::where('user_id', $user->id)
                    ->whereDate('created_at', $date)
                    ->first();

                // Determine attendance status based on schedule
                if (!$scheduledTime) {
                    // No schedule for the day, assume "Not Scheduled"
                    $attendanceData[] = [
                        'user_id' => $user->id,
                        'date' => $date,
                        'status' => 'Not Scheduled',
                    ];
                } elseif (!$attendance || Carbon::parse($attendance->check_in)->greaterThan(Carbon::parse($scheduledTime))) {
                    // No check-in or late check-in -> Absent
                    $attendanceData[] = [
                        'user_id' => $user->id,
                        'date' => $date,
                        'status' => 'Absent',
                    ];
                } else {
                    // On-time check-in -> Present
                    $attendanceData[] = [
                        'user_id' => $user->id,
                        'date' => $date,
                        'status' => 'Present',
                    ];
                }
            }
        }

        return collect($attendanceData);
    }

    private function fetchWeeklyDetailedAttendance()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
        $dates = Carbon::parse($startOfWeek)->toPeriod($endOfWeek);

        return $this->getAttendanceWithScheduleLogic($dates)
            ->groupBy('date')
            ->map(function ($records, $date) {
                $total = $records->count();
                $present = $records->where('status', 'Present')->count();
                $absent = $records->where('status', 'Absent')->count();

                return [
                    'date' => $date,
                    'total' => $total,
                    'present_count' => $present,
                    'absent_count' => $absent,
                ];
            })
            ->values()
            ->toArray();
    }

    private function calculateSummary($records)
    {
        $total = $records->count();
        $present = $records->where('status', 'Present')->count();
        $absent = $records->where('status', 'Absent')->count();

        return [
            'present' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            'absent' => $total > 0 ? round(($absent / $total) * 100, 2) : 0,
        ];
    }
    private function hasSchedule()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $idlist = User::where('role', 'user')->pluck('id');

        foreach ($idlist as $id) {
            $data = Schedule::where('user_id', $id)->where('startOfWeek', $startOfWeek)->get()->toArray();
            if ($data == null) {
                $this->unScheduled += 1;
            }
        }
    }


    public function render()
    {
        return view('livewire.manager-panel', [
            'dailySummary' => $this->dailySummary,
            'weeklySummary' => $this->weeklySummary,
            'monthlySummary' => $this->monthlySummary,
            'detailedAttendance' => $this->detailedAttendance,
        ]);
    }
}
