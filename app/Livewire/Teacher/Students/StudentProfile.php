<?php

namespace App\Livewire\Teacher\Students;

use App\Models\Student;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class StudentProfile extends Component
{

    use withPagination;
    public Student $student;

    public function mount(Student $student) :void
    {
        $this->student = $student->load('grade');
    }

    public function render() : View
    {

        $attendances = $this->student->attendances()
            ->orderByDesc('date')
            ->paginate(10);
        return view('livewire.teacher.students.student-profile',[
            'student' => $this->student,
            'attendances' => $attendances
        ]);
    }
}
