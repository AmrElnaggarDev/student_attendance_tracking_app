<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Attendance Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { margin-bottom: 12px; }
        .title { font-size: 18px; font-weight: 700; margin: 0 0 6px; }
        .meta { font-size: 12px; color: #444; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f3f4f6; text-align: left; font-weight: 700; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 11px; }
        .ok { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .warn { background: #fffbeb; color: #92400e; border: 1px solid #fcd34d; }
        .bad { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .muted { color: #666; }
    </style>
</head>
<body>

<div class="header">
    <p class="title">Monthly Attendance Report</p>
    <p class="meta">
        Year: <b>{{ $year }}</b> |
        Month: <b>{{ $monthName }}</b> |
        Grade: <b>{{ $gradeName }}</b>
    </p>
    <p class="meta muted">Generated at: {{ now()->format('Y-m-d H:i') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th style="width: 28%;">Student</th>
        <th style="width: 16%;">Grade</th>
        <th style="width: 10%;">Present</th>
        <th style="width: 10%;">Absent</th>
        <th style="width: 10%;">Sick</th>
        <th style="width: 10%;">Total</th>
        <th style="width: 16%;">Attendance %</th>
    </tr>
    </thead>
    <tbody>
    @forelse($rows as $row)
        @php
            $p = $row->attendance_percent;
            $cls = $p === null ? 'warn' : ($p >= 90 ? 'ok' : ($p >= 75 ? 'warn' : 'bad'));
        @endphp
        <tr>
            <td><b>{{ $row->first_name }} {{ $row->last_name }}</b></td>
            <td>{{ $row->grade?->name ?? '-' }}</td>
            <td>{{ (int)$row->present_count }}</td>
            <td>{{ (int)$row->absent_count }}</td>
            <td>{{ (int)$row->sick_count }}</td>
            <td>{{ (int)$row->total_records }}</td>
            <td>
                @if($p === null)
                    <span class="badge warn">—</span>
                @else
                    <span class="badge {{ $cls }}">{{ $p }}%</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="muted">No data for selected filters.</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
