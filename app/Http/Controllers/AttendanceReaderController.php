<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PDF;

class AttendanceReaderController extends Controller
{
    /**
     * Redirect to the attendance file uploader page
     *
     */
    public function upload(){
        return view('upload');
    }

    /**
     * Generate PDF Report
     *
     */
    public function pdfGenerate(Request $request){
        $response = [];

        $in_time  = date('H:i', strtotime($request->input('in_time')));
        $out_time = date('H:i', strtotime($request->input('out_time')));
        $emp_id   = $request->input('emp_id');

        $file_url = 'C:\Users\rabiu\Music\Attendance.xlsx';

        $file        = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_url);
        $reader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file);
        $spreadsheet = $reader->load($file_url);
        $file_data   = $spreadsheet->getActiveSheet()->toArray();

        // fetching all column position data
        $columnPosition = $this->columnPosition();

        // all file data and looping
        $data = $file_data;
        for($i=1; $i < count($data); $i++){
            // formatting attendance data
            $attenadance = $this->attendanceFormat($columnPosition, $data[$i], $in_time, $out_time, $emp_id);           
            
            if(is_array($attenadance)){
                array_push($response, $attenadance);
            }
            
        }

        $data = [
            "header" => "Attendance Sheet Report",
            "data" => $response
        ];

        $pdf = PDF::loadView('attendance_report_pdf', $data);    
        return $pdf->stream('attendance_report.pdf');

    }


    
    /**
     * This method return attendance data with condition checking
     *
     */
    protected function attendanceFormat($columnPosition, $data, $in_time, $out_time, $emp_id){
        if(!empty($emp_id) && ($data[$columnPosition['id']] != $emp_id)){
            return false;
        }
        $file_in_time  = $data[$columnPosition['file_in_time']];
        $file_out_time = $data[$columnPosition['file_out_time']];
        return [
            "month"          => $data[$columnPosition['month']],
            "date"           => $data[$columnPosition['date']],
            "day"            => $data[$columnPosition['day']],
            "id"             => $data[$columnPosition['id']],
            "employee_name"  => $data[$columnPosition['employee_name']],
            "department"     => $data[$columnPosition['department']],
            "in_time"        => $in_time,
            "out_time"       => $out_time,
            "hours_of_work"  => $data[$columnPosition['hours_of_work']],
            "file_in_time"   => $data[$columnPosition['file_in_time']],
            "file_out_time"  => $data[$columnPosition['file_out_time']],
            "is_late_coming" => date('H:i',strtotime($file_in_time)) <=  $in_time ? true : false,
            "is_early_go"    => $out_time >= date('H:i',strtotime($file_out_time)) ? true : false,
        ];
    }


    /**
     * This method return file column position
     *
     */
    protected function columnPosition(){
       return [
        "month"          => 0,
        "date"           => 1,
        "day"            => 2,
        "id"             => 3,
        "employee_name"  => 4,
        "department"     => 5,
        "in_time"        => 6,
        "out_time"       => 7,
        "hours_of_work"  => 8,
        "file_in_time"   => 6,
        "file_out_time"  => 7
       ];
    }
}
