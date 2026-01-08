<?php

namespace App\Livewire\Teachers\Students;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class EditStudent extends Component
{

    use WithFileUploads ;

    public $grades = [];

    public bool $is_active = true;
    public string $gender = '';
    public string $first_name = '';
    public string $last_name = '';
    public ?int $age = null;
    public ?int $grade_id = null;
    public $photo;

    public Student $student_details;

    public function mount(int $id): void
    {
        $this->student_details = Student::findOrFail($id);

        $this->fill([
            'first_name' => $this->student_details->first_name,
            'last_name' => $this->student_details->last_name,
            'age' => (int) $this->student_details->age,
            'grade_id' => (int) $this->student_details->grade_id,
            'gender' => (string) $this->student_details->gender,
            'is_active' => (bool) $this->student_details->is_active,
        ]);

        $this->grades = Grade::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }

    public function update()
    {
        $this->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'grade_id' => ['required', 'integer', 'exists:grades,id'],
            'gender' => ['required', 'in:male,female'],
            'is_active' => ['boolean'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        $photo_path = $this->student_details->photo_path;
        if ($this->photo) {
            if ($photo_path && Storage::disk('public')->exists($photo_path)) {
                Storage::disk('public')->delete($photo_path);
            }
            $photo_path = $this->photo->store('students', 'public');
        }

        $this->student_details->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => $this->age,
            'grade_id' => $this->grade_id,
            'gender' => $this->gender,
            'is_active' => $this->is_active,
            'photo_path' => $photo_path,
        ]);

        Toaster::success('Student Updated Successfully');

        return redirect()->route('student.index');
    }

    public function render(): View
    {
        return view('livewire.teachers.students.edit-student');
    }

}
