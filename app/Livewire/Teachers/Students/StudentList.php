<?php

namespace App\Livewire\Teachers\Students;

use App\Models\Student;
use Illuminate\View\View;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class StudentList extends Component
{
    public function delete ($id)
    {
        Student::find($id)->delete();
        Toaster::success('Student Deleted Successfully');
        return redirect()->route('student.index');
    }

    public function render() :View
    {
        return view('livewire.teachers.students.student-list',
        ['students' => Student::all()]);
    }
}
