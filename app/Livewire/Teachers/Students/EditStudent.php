<?php

namespace App\Livewire\Teachers\Students;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditStudent extends Component
{

    public $grades = [];

    public $is_active = true ;
    public $gender = '';
    public $first_name = '';
    public $last_name = '';
    public $age = '';
    public $grade = '';

    public $student_details ;

    public function mount($id) :void
    {
        $this->student_details = Student::findOrFail($id);

        $this->fill([
            'first_name' => $this->student_details->first_name,
            'last_name' => $this->student_details->last_name,
            'age' => $this->student_details->age,
            'grade' => $this->student_details->grade_id,
            'gender' => $this->student_details->gender,
            'is_active' => $this->student_details->is_active,
        ]);

        $this->grades = Grade::all();
    }

    public function update()
    {
        $this->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required|integer',
            'grade' => 'required',
            'gender' => 'required|string|in:male,female',
            'is_active' => 'sometimes|boolean',
        ]);

         Student::findOrFail($this->student_details->id)->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => $this->age,
            'grade_id' => $this->grade,
             'gender' => $this->gender,
             'is_active' => $this->is_active,
        ]);

         Toaster::success('Student Updated Successfully');
         return redirect()->route('student.index');

    }

    public function render() :View
    {
        return view('livewire.teachers.students.edit-student');
    }
}
