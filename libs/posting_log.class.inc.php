<?php


class posting_log {

	private $db; 
	private $logfile;
	const query_identifier = "X-Amz-Algorithm=AWS4-HMAC-SHA256";

	////////////////Public Functions///////////

        public function __construct($db,$logfile) {
                $this->db = $db;
		$this->logfile = $logfile;

        }
        public function __destruct() {

        }


	public function readlog() {

		$contents = file($this->logfile);
	
		foreach($contents as $line) {
			$json = json_decode($line);
			if (strpos($json->query,self::query_identifier)) {
				var_dump($json);
			}

		}



	}

	private function insert($data) {
		


	}


}

?>
