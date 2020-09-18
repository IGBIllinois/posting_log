<?php


class posting_log {

	private $db; 
	private $logfile;
	const query_identifier = "X-Amz-Algorithm=AWS4-HMAC-SHA256";
	const success_char = "+";
	const db_table = "posting_log";

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
			$data = array();
			if (strpos($json->query,self::query_identifier)) {
				$formatted_time = trim(trim($json->time,"["),"]");
				$time_access = strtotime($formatted_time);	
				$data['time_access'] = date('Y-m-d H:i:s',$time_access);
				$data['remote_ip'] = $json->remoteIP;
				$data['filename'] = substr($json->request,strpos($json->request,"/",1));
				$data['useragent'] = $json->userAgent;
				$data['success'] = false;
				if ($json->success == self::success_char) {
					$data['success'] = true;
				}
				parse_str($json->query,$get_variables);
				if (isset($get_variables['?x-email'])) {
					$data['email'] = $get_variables['?x-email'];
				}
				$data['json'] = $line;
				$this->insert($data);
			}

		}



	}

	private function insert($data) {
		$this->db->build_insert(self::db_table,$data);	


	}


}

?>
