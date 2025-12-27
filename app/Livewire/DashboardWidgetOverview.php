<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class DashboardWidgetOverview extends Component
{

    public $totalStudents;
    public $totalUsers;
    public $totalTeachers;
    public $presentToday ;
    public $absentToday;
    public $weeklyAttendanceRate ;
    public $attendanceToday ;
    public $monthlyTrends = [];

    public function mount ()
    {
        $today = Carbon::today();
        $startWeek = Carbon::today()->startOfWeek();
        $endWeek = Carbon::today()->endOfWeek();
        $startMonth = Carbon::today()->startOfMonth();
        $endMonth = Carbon::today()->endOfMonth();

        // fetch data
        $this->totalStudents = Student::count();
        $this->totalUsers = User::count();
        $this->totalTeachers = User::where ('role', 'teacher')->count();
        $this->presentToday = Attendance::whereDate ('date', $today)->where ('status', 'present')->count();
        $this->attendanceToday = Attendance::whereDate ('date', $today)->where ('status', 'present')->count();
        $this->absentToday = Attendance::whereDate ('date', $today)->where ('status', 'absent')->count();

        // weekly attendance rate
        $totalClasses = Attendance::whereBetween ('date', [$startWeek, $endWeek])->count();
        $presentCount = Attendance::whereBetween ('date', [$startMonth, $endMonth])->where('status', 'present')->count();
        $this->weeklyAttendanceRate = $totalClasses > 0 ? round($presentCount / $totalClasses * 100, 2) : 0;

        for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {
            $date = Carbon::createFromDate(
                Carbon::now()->year,
                Carbon::now()->month,
                $i
            );
            $this->monthlyTrends [] = [
                'day' => $i,
                'count' => Attendance::whereDate ('date', $date)->where ('status' , 'present')->count(),
            ];
        }
    }

    public function render() :View
    {
        return view('livewire.dashboard-widget-overview');
    }
}
