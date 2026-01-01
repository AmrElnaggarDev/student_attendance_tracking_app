<?php

namespace App\Livewire\Teachers\Students;

use App\Models\Student;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class StudentList extends Component
{

    use WithPagination;


    public $search = '';
    #[Url]
    public $grade_id = null;
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

    public function clearGradeFilter()
    {
        $this->grade_id = null;
        $this->resetPage();
    }


    public function render() :View
    {
        $students = Student::with('grade')
            // 1. Filter by Grade (if selected)
            ->when($this->grade_id, fn ($query) => $query->where('grade_id', $this->grade_id))
            // 2. Filter by Name (if searching)
            ->where(function ($query) {
                $query->where('first_name', 'like', "%{$this->search}%")
                    ->orWhere('last_name', 'like', "%{$this->search}%");
            })
            ->paginate(10);

        return view('livewire.teachers.students.student-list', [
            'students' => $students,
        ]);
    }


}
