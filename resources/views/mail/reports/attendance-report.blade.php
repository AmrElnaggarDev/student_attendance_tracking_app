<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report</title>
</head>
<body>
<h1>Attendance Report</h1>

<p>Hello,</p>
<p>Attached is the attendance report for <strong>{{ $period }}</strong>.</p>

<p>
    <a href="{{ $downloadUrl }}" style="
            display:inline-block;
            background-color:#3490dc;
            color:white;
            padding:10px 20px;
            text-decoration:none;
            border-radius:5px;
        ">
        Download Report
    </a>
</p>

<p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
