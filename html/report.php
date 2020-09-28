<?php
require_once 'includes/main.inc.php';

if (isset($_POST['create_download_report'])) {

	$data = functions::get_download_log($db,$_POST['search']);
	foreach ($data as &$row) {
		unset($row['json']);
	}
	
	$type = $_POST['report_type'];
	$filename = "download_report." . $type; 

	switch ($type) {
		case 'csv':
			report::create_csv_report($data,$filename);
			break;
		case 'xlsx':
			report::create_excel_2007_report($data,$filename);
			break;
	}
}

elseif (isset($_POST['create_upload_report'])) {
        $data = functions::get_upload_log($db,$_POST['search']);
	foreach ($data as &$row) {
		unset($row['json']);
	}
	$type = $_POST['report_type']; 
        $filename = "upload_report." . $type;


        switch ($type) {
                case 'csv':
                        report::create_csv_report($data,$filename);
                        break;
                case 'xlsx':
                        report::create_excel_2007_report($data,$filename);
                        break;

        }




}


?>

