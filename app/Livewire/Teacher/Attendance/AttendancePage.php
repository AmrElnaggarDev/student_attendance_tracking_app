<?php

namespace App\Livewire\Teacher\Attendance;

use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Masmerise\Toaster\Toaster;

class AttendancePage extends Component
{
    public $year, $month, $grade;

    public array $students = [];
    public array $attendance = [];
    public $grades = [];

    // default note type used in markAll
    public string $note_type = 'general';

    // allowed values
    private array $allowedStatuses = ['present', 'absent', 'sick', 'other'];
    private array $allowedNoteTypes = ['general', 'medical', 'behavioral'];

    public function mount(): void
    {
        $this->grades = Grade::all();
    }

    public function fetchStudents(): void
    {
        if (!$this->year || !$this->month || !$this->grade) {
            return;
        }

        $this->students = Student::where('grade_id', $this->grade)->get()->all();

        $daysInMonth = Carbon::create($this->year, $this->month)->daysInMonth;

        foreach ($this->students as $student) {
            foreach (range(1, $daysInMonth) as $day) {
                $date = Carbon::create($this->year, $this->month, $day)->format('Y-m-d');

                $attRecord = Attendance::where('student_id', $student->id)
                    ->whereDate('date', $date)
                    ->first();

                $this->attendance[$student->id][$day] = [
                    'status'    => $attRecord->status ?? 'present',
                    'note_type' => $attRecord->note_type ?? 'general',
                ];
            }
        }
    }

    public function updateAttendance($studentId, $day, $status, $noteType = null): void
    {
        // Validate status
        $status = in_array($status, $this->allowedStatuses, true) ? $status : 'present';

        $date = Carbon::create($this->year, $this->month, $day)->format('Y-m-d');

        // keep old note_type if none sent
        $finalNoteType = $noteType ?? ($this->attendance[$studentId][$day]['note_type'] ?? 'general');

        // validate note type
        if (!in_array($finalNoteType, $this->allowedNoteTypes, true)) {
            $finalNoteType = 'general';
        }

        Attendance::updateOrCreate(
            [
                'student_id' => (int) $studentId,
                'date' => $date
            ],
            [
                'status'    => (string) $status,
                'note_type' => (string) $finalNoteType,
                'grade_id'  => (int) $this->grade,
            ]
        );

        // sync state
        $this->attendance[$studentId][$day] = [
            'status'    => $status,
            'note_type' => $finalNoteType,
        ];

        Toaster::success("Updated: {$date} | Student #{$studentId}");
    }

    public function updateNoteType($studentId, $day, $noteType): void
    {
        // Validate note type
        $noteType = in_array($noteType, $this->allowedNoteTypes, true) ? $noteType : 'general';

        $status = $this->attendance[$studentId][$day]['status'] ?? 'present';

        // Validate status
        $status = in_array($status, $this->allowedStatuses, true) ? $status : 'present';

        $this->updateAttendance($studentId, $day, $status, $noteType);
    }




    public function markAll($day, $status): void
    {
        // Validate status
        if (!in_array($status, $this->allowedStatuses, true)) {
            return;
        }

        $noteTypeForAll = $this->note_type ?? 'general';

        // Validate note type
        if (!in_array($noteTypeForAll, $this->allowedNoteTypes, true)) {
            $noteTypeForAll = 'general';
        }

        foreach ($this->students as $student) {
            $this->updateAttendance($student->id, $day, $status, $noteTypeForAll);
        }
    }

    public function exportToExcel()
    {
        return Excel::download(
            new AttendanceExport($this->year, $this->month, $this->grade),
            'attendance.xlsx'
        );
    }

    public function render(): View
    {
        $this->fetchStudents();

        return view('livewire.teacher.attendance.attendance-page', [
            'daysInMonth' => Carbon::create($this->year, $this->month)->daysInMonth,
        ]);
    }
}
