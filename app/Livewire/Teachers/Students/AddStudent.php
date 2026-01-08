<?php

namespace App\Livewire\Teachers\Students;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

#[Title('Student Attendance | Add Student')]

class AddStudent extends Component
{

    use WithFileUploads;

    public $grades = [];
    public $is_active = true;
    public $gender = '';

    public $first_name = '';
    public $last_name = '';
    public $age = '';
    public $grade = '';
    public $photo = null;

    public function mount (): void
    {
        $this->grades = Grade::all();
    }

    public function save ()
    {
        $this->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required|integer',
            'grade' => 'required',
            'gender' => 'required|string|in:male,female',
            'is_active' => 'sometimes|-boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $photo_path = null;
        if ($this->photo) {
            // store inside storage/app/public/students
            $photo_path = $this->photo->store('students', 'public');
        }

        Student::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => $this->age,
            'grade_id' => $this->grade,
            'gender' => $this->gender,
            'is_active' => $this->is_active,
            'photo_path' => $photo_path,
        ]);

        $this->reset();

        Toaster::success("Student added successfully");

        return redirect()->route('student.index');
    }


    public function render() :View
    {
        return view('livewire.teachers.students.add-student');
    }
}
