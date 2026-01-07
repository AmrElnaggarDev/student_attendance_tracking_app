<?php

namespace App\Livewire\Teacher\Reports;

use App\Models\Grade;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class MonthlyAttendanceReport extends Component

{
    public ?int $year = null;
    public ?int $month = null;

    // FK now
    public ?int $grade_id = null;

    public $grades = [];

    public function mount(): void
    {
        $now = now();
        $this->year = (int) $now->year;
        $this->month = (int) $now->month;

        // from grades table (id + name)
        $this->grades = Grade::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    private function reportRows()
    {
        if (!$this->year || !$this->month || !$this->grade_id) {
        return collect();
    }

        $start = Carbon::create($this->year, $this->month, 1)->startOfDay();
        $end   = Carbon::create($this->year, $this->month, 1)->endOfMonth()->endOfDay();

        return Student::query()
            ->where('grade_id', $this->grade_id)
            ->with('grade') // show grade name
            ->withCount([
                'attendances as present_count' => fn ($q) =>
                $q->whereBetween('date', [$start, $end])->where('status', 'present'),

                'attendances as absent_count' => fn ($q) =>
                $q->whereBetween('date', [$start, $end])->where('status', 'absent'),

                // you confirmed sick not late
                'attendances as sick_count' => fn ($q) =>
                $q->whereBetween('date', [$start, $end])->where('status', 'sick'),

                'attendances as total_records' => fn ($q) =>
                $q->whereBetween('date', [$start, $end]),
            ])
            ->orderBy('first_name')
            ->get()
            ->map(function ($student) {
                $total   = (int) $student->total_records;
                $present = (int) $student->present_count;

                // sick counts as non-present (absence-like)
                $student->attendance_percent = $total > 0 ? round(($present / $total) * 100, 1) : null;

                return $student;
            });
    }

    protected function rules(): array
    {
        return [
            'year' => ['required','integer','min:2000','max:2100'],
            'month' => ['required','integer','min:1','max:12'],
            'grade_id' => ['required','integer','exists:grades,id'],
        ];
    }

    public function updated($property): void
    {
        $this->validateOnly($property);
    }

    public function resetFilters () :void
    {
        $now = now();
        $this->year = (int) $now->year;
        $this->month = (int) $now->month;
        $this->grade_id = null;
    }

    public function render(): View
    {
        return view('livewire.teacher.reports.monthly-attendance-report', [
            'rows' => $this->reportRows(),
        ]);
    }
}
