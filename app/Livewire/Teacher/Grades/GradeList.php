<?php

namespace App\Livewire\Teacher\Grades;

use App\Models\Grade;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class GradeList extends Component
{

    use WithPagination;

    public function delete ($id)
    {
        Grade::findOrFail($id)->delete();
        Toaster::success('Grade deleted successfully');
        return redirect(route('grade.index'));
    }

    public function render():View
    {
        return view('livewire.teacher.grades.grade-list',[
        'grades' => Grade::withCount('students')->paginate(10)]);
    }
}
