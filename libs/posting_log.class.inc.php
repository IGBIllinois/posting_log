<?php


class posting_log {

	private $db; 
	private $logfile;
	const query_identifier = "X-Amz-Algorithm=AWS4-HMAC-SHA256";
	const success_char = "+";
	const db_table = "posting_log";
	const email_variable = "x-email";

	////////////////Public Functions///////////

        public function __construct($db,$logfile) {
                $this->db = $db;
		$this->logfile = $logfile;

        }
        public function __destruct() {

        }


	public function readlog($dry_run = false) {

		if (!file_exists($this->logfile)) {
			return false;
		}
		$contents = file($this->logfile);
	
		foreach($contents as $line) {
			$json = json_decode($line);
			$data = array();
			if (strpos($json->query,self::query_identifier)) {
				$formatted_time = trim(trim($json->time,"["),"]");
				$time_access = strtotime($formatted_time . ' UTC');	
				$data['time_access'] = date('Y-m-d H:i:s',$time_access);
				$data['remote_ip'] = $json->remoteIP;
				$data['remote_hostname'] = gethostbyaddr($json->remoteIP);
				$data['filename'] = substr($json->request,strpos($json->request,"/",1));
				$data['useragent'] = $json->userAgent;
				$data['success'] = 0;
				if ($json->success == self::success_char) {
					$data['success'] = 1;
				}
				parse_str($json->query,$get_variables);
				if (isset($get_variables["?" . self::email_attribute])) {
					$data['email'] = $get_variables["?" . self::email_attribute];
				}
				$data['json'] = $line;
				
				if($dry_run && $this->insert($data)) {
					echo "Inserted: " . $data['email'] . "," . $data['time_access'] . "," . $data['remote_ip'] . "," . $data['filename'] . "\n";
				}
			}

		}
		return true;


	}

	private function insert($data) {
		try {
			return $this->db->build_insert(self::db_table,$data);	
		}
		catch(PDOException $e) {
			return 0;
		}


	}


}

?>
