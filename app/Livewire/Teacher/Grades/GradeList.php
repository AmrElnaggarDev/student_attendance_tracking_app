<?php

namespace App\Livewire\Teacher\Grades;

use App\Models\Grade;
use Illuminate\View\View;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class GradeList extends Component
{

    public function delete ($id)
    {
        Grade::find($id)->delete();
        Toaster::success('Grade deleted successfully');
        return redirect(route('grade.index'));
    }

    public function render():View
    {
        return view('livewire.teacher.grades.grade-list',[
        'grades' => Grade::all()]);
    }
}
