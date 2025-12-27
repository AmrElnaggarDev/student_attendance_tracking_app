<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AutomatedAttendanceReportExporter;
use App\Mail\SendAttendanceReportMail;
use App\Models\Attendance;

class SendAttendanceReportCommand extends Command
{
    protected $signature = 'attendance:send-report {type}';
    protected $description = 'Send daily or weekly attendance report via email';

    public function handle()
    {
        $type = $this->argument('type');

        if ($type == 'daily') {
            $lastAttendance = Attendance::orderBy('date', 'desc')->first();

            if (!$lastAttendance) {
                $this->info("No attendance data available for daily report.");
                return;
            }


            $startDate = $lastAttendance->date;
            $endDate   = $lastAttendance->date;

        } elseif ($type == 'weekly') {
            $today = Carbon::today();

            $firstAttendance = Attendance::whereBetween('date', [
                $today->copy()->startOfWeek()->toDateString(),
                $today->copy()->endOfWeek()->toDateString()
            ])->orderBy('date')->first();

            $lastAttendance = Attendance::whereBetween('date', [
                $today->copy()->startOfWeek()->toDateString(),
                $today->copy()->endOfWeek()->toDateString()
            ])->orderBy('date', 'desc')->first();

            if (!$firstAttendance || !$lastAttendance) {
                $this->info("No attendance data available for weekly report.");
                return;
            }


            $startDate = $firstAttendance->date;
            $endDate   = $lastAttendance->date;

        } else {
            $this->error('Invalid type of report. Use daily or weekly.');
            return;
        }


        $fileName = "attendance_report_{$type}.xlsx";
        $filePath = "attendance_reports/{$fileName}";


        Excel::store(new AutomatedAttendanceReportExporter($startDate, $endDate), $filePath, 'public');


        Mail::to('amre90666@gmail.com')->send(new SendAttendanceReportMail($type, $filePath));

        $this->info("{$type} attendance report has been sent successfully!");
    }
}
