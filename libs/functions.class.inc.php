<?php 

class functions {

	public static function get_log($db) {

		$sql = "SELECT * FROM posting_log ";
		return $result = $db->query($sql);	




	}






}



?>
