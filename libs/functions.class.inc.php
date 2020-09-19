<?php 

class functions {

	public static function get_log($db) {

		$sql = "SELECT * FROM posting_log ";
		$sql .= "ORDER by time_access DESC";
		return $result = $db->query($sql);	




	}






}



?>
