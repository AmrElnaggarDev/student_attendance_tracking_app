<?php

namespace App\Livewire\Teacher\Dashboard;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class AttendanceStats extends Component
{
    // Filters
    public ?int $grade_id = null;
    public $grades = [];

    // Cards
    public int $totalStudents = 0;
    public int $presentToday = 0;
    public int $absentToday = 0;
    public int $sickToday = 0;
    public float $weeklyAttendanceRate = 0;

    // Chart data
    public array $weeklyChart = []; // [{ label, date, present, total, percent }]

    public function mount(): void
    {
        $this->grades = Grade::select('id', 'name')->orderBy('name')->get();

        $this->buildStats();
        $this->buildWeeklyChart();

        $this->dispatch('weekly-chart-updated', weeklyChart: $this->weeklyChart);
    }

    public function updatedGradeId(): void
    {
        $this->buildStats();
        $this->buildWeeklyChart();

        $this->dispatch('weekly-chart-updated', weeklyChart: $this->weeklyChart);
    }

    private function buildStats(): void
    {
        $today = Carbon::today();

        $studentsQuery = Student::query();
        if ($this->grade_id) {
            $studentsQuery->where('grade_id', $this->grade_id);
        }

        $this->totalStudents = (int) $studentsQuery->count();

        // counts for today from DB (absent/sick)
        $attQueryToday = Attendance::query()->whereDate('date', $today);
        if ($this->grade_id) {
            $attQueryToday->where('grade_id', $this->grade_id);
        }

        $this->absentToday = (int) (clone $attQueryToday)->where('status', 'absent')->count();
        $this->sickToday   = (int) (clone $attQueryToday)->where('status', 'sick')->count();

        // default present logic:
        $nonPresentToday = $this->absentToday + $this->sickToday;

        $this->presentToday = max($this->totalStudents - $nonPresentToday, 0);


    }

    private function buildWeeklyChart(): void
    {
        $start = Carbon::today()->startOfWeek(Carbon::SATURDAY)->startOfDay();

        $this->weeklyChart = [];

        $percents = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $start->copy()->addDays($i);

            $studentsQuery = Student::query();
            if ($this->grade_id) {
                $studentsQuery->where('grade_id', $this->grade_id);
            }

            $totalStudents = (int) $studentsQuery->count();

            $attQuery = Attendance::query()->whereDate('date', $date);
            if ($this->grade_id) {
                $attQuery->where('grade_id', $this->grade_id);
            }

            $absent = (int) (clone $attQuery)->where('status', 'absent')->count();
            $sick   = (int) (clone $attQuery)->where('status', 'sick')->count();

            $nonPresent = $absent + $sick;
            $present = max($totalStudents - $nonPresent, 0);

            $percent = $totalStudents > 0 ? round(($present / $totalStudents) * 100, 0) : 0;

            $this->weeklyChart[] = [
                'label'   => $date->format('D'),         // Sat, Sun...
                'date'    => $date->format('Y-m-d'),
                'present' => $present,
                'total'   => $totalStudents,
                'percent' => $percent,
            ];

            $percents[] = $percent;
        }

        $this->weeklyAttendanceRate = count($percents) > 0 ? round(array_sum($percents) / count($percents), 0) : 0;
    }

    public function render(): View
    {
        return view('livewire.teacher.dashboard.attendance-stats');
    }
}
