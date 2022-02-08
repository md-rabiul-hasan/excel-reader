## About PHP SpreadSheet

$file        = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_url);
$reader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file);
$spreadsheet = $reader->load($file_url);
$file_data   = $spreadsheet->getActiveSheet()->toArray();

## About DOMPDF Style

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
