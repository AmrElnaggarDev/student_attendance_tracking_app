<?php

namespace App\Livewire\Teachers\Students;

use App\Models\Student;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class StudentList extends Component
{

    use WithPagination;

    public $search = '';
    public function delete ($id)
    {
        Student::findOrFail($id)->delete();
        Toaster::success('Student Deleted Successfully');
        return redirect()->route('student.index');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render() :View
    {
        $students = Student::with('grade')
                ->where(function ($query) {
                $query->where('first_name', 'like', "%{$this->search}%")
                ->orWhere('last_name', 'like', "%{$this->search}%");
        })->paginate(10);

        return view('livewire.teachers.students.student-list', [
            'students' => $students,
        ]);
    }

}
