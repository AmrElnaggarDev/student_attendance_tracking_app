<?php

namespace App\Livewire\Teacher\Students;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class StudentProfile extends Component
{
    use WithPagination;
    public Student $student;

    public $fromDate = null;
    public $toDate = null;

    public function mount(Student $student) :void
    {
        $this->student = $student->load('grade');
    }

    public function updatedFromDate() :void
    {
        $this->resetPage();
    }

    public function updatedToDate() :void
    {
        $this->resetPage();
    }



    public function clearFilter() :void
    {
        $this->reset(['fromDate', 'toDate']);
        $this->resetPage();
    }

    public function render() : View
    {

        $query = $this->student->attendances();
        if ($this->fromDate) {
            $query->whereDate('date', '>=', $this->fromDate);
        }
        if ($this->toDate) {
            $query->whereDate('date', '<=', $this->toDate);
        }
        $attendances = $query->orderByDesc('date')->paginate(10);


        return view('livewire.teacher.students.student-profile',[
            'student' => $this->student,
            'attendances' => $attendances
        ]);
    }
}
