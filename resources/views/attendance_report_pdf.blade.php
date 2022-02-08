<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <style>
        .text-center{
            text-align: center;
        }  
        table, td, th {    
            border: 1px solid black;
            text-align: left;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 5px;
            font-size: 12px;
        }
        .red{
            background: red;
        }
        .yellow{
            background: yellow
        }
        
    </style>
</head>
<body>
    <h1 class="text-center">{{ $header }}</h1>
    <table>
        <thead>
            <tr>
                <th class="tdborder">Month</th>
                <th class="tdborder">Date</th>
                <th class="tdborder">Day</th>
                <th class="tdborder">ID</th>
                <th class="tdborder">Employee</th>
                <th class="tdborder">Department</th>
                <th class="tdborder">In-Time</th>
                <th class="tdborder">Out-Time</th>
                <th class="tdborder">Hours Of Work</th>
           </tr>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $attendance)
                <tr>
                    <td>{{ $attendance['month'] }}</td>
                    <td>{{ $attendance['date'] }}</td>
                    <td>{{ $attendance['day'] }}</td>
                    <td>{{ $attendance['id'] }}</td>
                    <td>{{ $attendance['employee_name'] }}</td>
                    <td>{{ $attendance['department'] }}</td>
                    <td class="{{ $attendance['is_late_coming'] === true ? '' : 'red' }}">{{ $attendance['file_in_time'] }}</td>               
                    <td class="{{ $attendance['is_early_go'] === true ? '' : 'yellow' }}">{{ $attendance['file_out_time'] }}</td>
                    <td>{{ $attendance['hours_of_work'] }} Hours</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>