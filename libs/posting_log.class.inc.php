<?php


class posting_log {

	private $db; 
	private $logfile;
	const download_identifier = "X-Amz-Algorithm=AWS4-HMAC-SHA256";
	const upload_identifier = "uploadId";
	const success_char = "+";
	const download_table = "downloads";
	const upload_table = "uploads";
	const email_variable = "x-email";
	const http_success_status = "200";

	////////////////Public Functions///////////

        public function __construct($db,$logfile) {
                $this->db = $db;
		$this->logfile = $logfile;
		if ($this->logfile == "") {
			throw new Exception("Apache log is not set");
		}
		elseif (!file_exists($this->logfile)) {
                        throw new Exception("Apache Log does not exist");
                }


        }
        public function __destruct() {

        }


	public function readlog($dry_run = false) {

		$handle = fopen($this->logfile,"r");
		if ($handle) {
			$count = 0;
			while (($line = fgets($handle)) !== FALSE) {
				$json = json_decode($line);
				$data = array();
				//If downloaded
				if (($json->status == self::http_success_status) && ($json->method == 'GET') && (strpos($json->query,self::download_identifier))) {
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
					parse_str(substr($json->query,1),$get_variables);
					if (isset($get_variables[self::email_variable])) {
						$data['email'] = $get_variables[self::email_variable];
					}
					$data['json'] = $line;
					if(!$dry_run && $this->insert_downloads($data)) {
						echo "Inserted Downloads: " . $data['email'] . "," . $data['time_access'] . "," . $data['remote_ip'] . "," . $data['filename'] . "\n";
						$count++;
					}
				}
				//Elseif uploaded data
				elseif (($json->status == self::http_success_status) && ($json->method == 'POST') && (strpos($json->query,self::upload_identifier))) {
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
	                                $data['json'] = $line;
        	                        if (!$dry_run && self::upload_needs_updating($data['time_access'],$data['filename']) && self::insert_uploads($data)) {
							
                	                        echo "Inserted Uploads: " . $data['time_access'] . "," . $data['remote_ip'] . "," . $data['filename'] . "\n";
                        	                $count++;
                                	}



				}
			}
			fclose($handle);
		}
		return $count;


	}

	private function insert_downloads($data) {
		try {
			return $this->db->build_insert(self::download_table,$data);	
		}
		catch(PDOException $e) {
			return 0;
		}


	}

        private function insert_uploads($data) {
		try {
                        return $this->db->build_insert(self::upload_table,$data);
                }
                catch(PDOException $e) {
                        return 0;
                }
        }

	private function upload_needs_updating($time_access,$filename) {
		$sql = "SELECT count(1) as success from uploads WHERE filename=:filename and time_access<=:time_access";
		$args = array(':filename'=>$filename,
			':time_access'=>$time_access,
		);
		try {
			$result = $this->db->query($sql,$args);
			return !$result[0]['success'];
		}
		catch(PDOException $e) {
			return 0;
		}

	}
}

?>
