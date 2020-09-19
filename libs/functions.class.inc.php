<?php 

class functions {

	public static function get_log($db,$start=0,$count=0) {

		$sql = "SELECT * FROM posting_log ";
		$sql .= "ORDER by time_access DESC ";
		if ($count != 0) {
        	        $sql .= "LIMIT " . $start . "," . $count;
	        }

		return $result = $db->query($sql);	




	}






}



?>
