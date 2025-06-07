<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\Role;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Admin extends Component
{
    public $dailySummary = [];
    public $weeklySummary = [];
    public $monthlySummary = [];
    public $detailedAttendance = [];
    public $unScheduled = 0;
    public $users = [];

    public function mount()
    {
        $this->users = $this->fetchUsersWithRole('user');

        $this->detailedAttendance = $this->fetchWeeklyDetailedAttendance();
        $this->dailySummary = $this->calculateDailySummary();
        $this->weeklySummary = $this->calculateWeeklySummary();
        $this->monthlySummary = $this->calculateMonthlySummary();

        $this->hasSchedule();
    }

    private function fetchUsersWithRole(string $roleName): Collection
    {
        $role = Role::where('role', $roleName)->first();
        return $role ? $role->users : collect(); // assuming roles() in Role model
    }

    private function calculateDailySummary()
    {
        $today = Carbon::now()->format('Y-m-d');
        return $this->calculateSummary($this->getAttendanceWithScheduleLogic([$today]));
    }

    private function calculateWeeklySummary()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $dates = $this->generateDateRange($startOfWeek, $endOfWeek);

        return $this->calculateSummary($this->getAttendanceWithScheduleLogic($dates));
    }

    private function calculateMonthlySummary()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $dates = $this->generateDateRange($startOfMonth, $endOfMonth);

        return $this->calculateSummary($this->getAttendanceWithScheduleLogic($dates));
    }

    private function generateDateRange($start, $end): array
    {
        $dates = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }
        return $dates;
    }

    private function getAttendanceWithScheduleLogic(array $dates)
    {
        $attendanceData = [];

        foreach ($this->users as $user) {
            foreach ($dates as $date) {
                $schedule = Schedule::where('user_id', $user->id)
                    ->where('startOfWeek', '<=', $date)
                    ->where('endOfWeek', '>=', $date)
                    ->first();

                $scheduledTime = $schedule ? $schedule->{strtolower(Carbon::parse($date)->format('l'))} : null;

                $attendance = AttendanceRecord::where('user_id', $user->id)
                    ->whereDate('created_at', $date)
                    ->first();

                if (!$scheduledTime) {
                    $status = 'Not Scheduled';
                } elseif (!$attendance || Carbon::parse($attendance->check_in)->gt(Carbon::parse($scheduledTime))) {
                    $status = 'Absent';
                } else {
                    $status = 'Present';
                }

                $attendanceData[] = [
                    'user_id' => $user->id,
                    'date' => $date,
                    'status' => $status,
                ];
            }
        }

        return collect($attendanceData);
    }

    private function fetchWeeklyDetailedAttendance()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $dates = $this->generateDateRange($startOfWeek, $endOfWeek);

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

        foreach ($this->users as $user) {
            $hasSchedule = Schedule::where('user_id', $user->id)
                ->where('startOfWeek', $startOfWeek)
                ->exists();

            if (!$hasSchedule) {
                $this->unScheduled += 1;
            }
        }
    }

    public function exportReport()
    {
        $filename = 'attendance_report_' . Carbon::now()->format('Ymd_His') . '.csv';

        return new StreamedResponse(function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Total', 'Present (%)', 'Absent (%)']);

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

    public function render()
    {
        return view('livewire.admin', [
            'dailySummary' => $this->dailySummary,
            'weeklySummary' => $this->weeklySummary,
            'monthlySummary' => $this->monthlySummary,
            'detailedAttendance' => $this->detailedAttendance,
        ]);
    }
}
