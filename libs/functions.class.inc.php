<?php 

class functions {

	public static function get_log($db,$start=0,$count=0,$start_date=0,$end_date=0) {

		$sql = "SELECT * FROM posting_log ";
		if (($start_date != 0) && ($end_date != 0 )) {
			$sql .= "WHERE time_access BETWEEN CAST(" . $start_date . " AS DATE) AND CAST(" . $end_date . " AS DATE) ";
		}
		$sql .= "ORDER by time_access DESC ";
		if ($count != 0) {
        	        $sql .= "LIMIT " . $start . "," . $count;
	        }

		return $result = $db->query($sql);	




	}


}



?>
