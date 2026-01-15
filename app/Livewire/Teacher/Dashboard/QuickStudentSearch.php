<?php

namespace App\Livewire\Teacher\Dashboard;

use App\Models\Student;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class QuickStudentSearch extends Component
{

    public string $q = '';
    public array $results = [];
    public bool $showDropdown = false;

    public function updatedQ() :void
    {
        $q = trim($this->q);

        if ($q == '') {
            $this->results = [];
            $this->showDropdown = false;
            return;
        }

        $parts = preg_split('/\s+/', $q );

        $this->results = Student::query()
            ->with('grade:id,name')
            ->where(function ($query) use ($q, $parts) {
                if (count($parts) >= 2) {
                    $query->where('first_name', 'like', '%' . $parts[0] . '%')
                        ->Where('last_name', 'like', '%' . $parts[1] . '%');
                }else {
                    $query->where('first_name', 'like', '%' . $q . '%')
                        ->orWhere('last_name', 'like', '%' . $q . '%');
                }

            })
            ->orderBy('first_name')
            ->limit(8)
            ->get()
            ->map(fn($s) => [
                'id' => $s->id,
                'first_name' => $s->first_name,
                'last_name' => $s->last_name,
                'grade_name' => $s->grade?->name,
            ])
            ->toArray();

        $this->showDropdown = count($this->results) > 0;
    }


    public function selectStudent (int $studentId)
    {
        $this->showDropdown = false;
        $this->results = [];
        $this->q = '';


        return redirect()->route('student.profile', $studentId);
    }

    public function search()
    {
        $q = trim($this->q);

        if ($q == '') {
            Toaster::warning('Please enter a search term');
            return;
        }

        $parts = preg_split('/\s+/', $q);

        if (count($parts) >= 2) {
            $student = Student::where ('first_name', 'like', '%' . $parts[0] . '%')
                ->where ('last_name', 'like', '%' . $parts[1] . '%')
                ->first();
        } else {
            $student = Student::query()
                ->where('first_name', 'like', "%{$q}%")
                ->orWhere('last_name', 'like', "%{$q}%")
                ->first();
        }


        if (!$student) {
            Toaster::error('Student not found');
            return;
        }

        return redirect()->route('student.profile', $student->id);
    }

    public function hideDropdown () :void
    {
        $this->showDropdown = false;
    }

    public function render()
    {
        return view('livewire.teacher.dashboard.quick-student-search');
    }
}
