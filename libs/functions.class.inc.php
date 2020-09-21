<?php 

class functions {

	public static function get_log($db,$search= "",$start=0,$count=0,$start_date=0,$end_date=0) {

		$search = strtolower(trim(rtrim($search)));
		$where_sql = array();
		$sql = "SELECT * FROM posting_log ";

		if ($search != "") {
			$terms = explode(" ",$search);
			foreach ($terms as $term) {
				$search_sql = "(remote_ip LIKE '%" . $term . "%' OR ";
				$search_sql .= "remote_hostname LIKE '%" . $term . "%' OR ";
				$search_sql .= "email LIKE '%" . $term . "%' OR ";
				$search_sql .= "LOWER(filename) LIKE '%" . $term . "%')";
				array_push($where_sql,$search_sql);
			}



		}
		if (($start_date != 0) && ($end_date != 0 )) {
			$date_sql = "time_access BETWEEN CAST('" . $start_date . "' AS DATE) AND CAST('" . $end_date . "' AS DATE) ";
			array_push($where_sql,$date_sql);
		}


		$num_where = count($where_sql);
		if ($num_where) {
			$sql .= "WHERE ";
			$i = 0;
			foreach ($where_sql as $where) {
				$sql .= $where;
				if ($i<$num_where-1) {
					$sql .= "AND ";
				}
				$i++;	
			}

		}

		$sql .= "ORDER by time_access DESC ";
		if ($count != 0) {
        	        $sql .= "LIMIT " . $start . "," . $count;
	        }
		return $result = $db->query($sql);	




	}


	public static function get_num_log_entries($db,$search) {
		return count(self::get_log($db,$search));


	}



        //get_pages_html()
        //$url - url of page
        //$num_records - number of items
        //$start - start index of items
        //$count - number of items per page
        //returns pagenation to navigate between pages of devices
        public static function get_pages_html($url,$num_records,$start,$count) {

                $num_pages = ceil($num_records/$count);
                $current_page = $start / $count + 1;
                if (strpos($url,"?")) {
                        $url .= "&start=";
                }
                else {
                        $url .= "?start=";

                }

                $pages_html = "<nav><ul class='pagination justify-content-center flex-wrap'>";
                if ($current_page > 1) {
                        $start_record = $start - $count;
                        $pages_html .= "<li class='page-item'><a class='page-link' href='" . $url . $start_record . "'>&laquo;</a></li> ";
                }
                else {
                        $pages_html .= "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
                }

                for ($i=0; $i<$num_pages; $i++) {
                        $start_record = $count * $i;
                        if ($i == $current_page - 1) {
                                $pages_html .= "<li class='page-item disabled'>";
                        }
                        else {
                                $pages_html .= "<li class='page-item'>";
                        }
                        $page_number = $i + 1;
                        $pages_html .= "<a class='page-link' href='" . $url . $start_record . "'>" . $page_number . "</a></li>";
                }

                if ($current_page < $num_pages) {
                        $start_record = $start + $count;
                        $pages_html .= "<li class='page-item'><a class='page-link' href='" . $url . $start_record . "'>&raquo;</a></li> ";
                }
                else {
                        $pages_html .= "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
                }
                $pages_html .= "</ul></nav>";
                return $pages_html;

        }



	public static function send_email_digest($db,$inDate) {
		$start_date = $inDate;
		$short_date = date('Y-m-d',strtotime($inDate));
		$end_date = date('Y-m-d H:i:s',strtotime('-1 second',strtotime('+1 day',strtotime($inDate))));

		$subject = "Posting Log - " . $short_date;
		$to = settings::get_emails();
		$twig_variables = array(
			'css'=> settings::get_email_css_contents(), 
			'date_downloaded' => $short_date,
               	        'website_url' => settings::get_website_url(),
                       	'log_table' => self::get_log($db,"",0,0,$start_date,$end_date),
                );

		$loader = new \Twig\Loader\FilesystemLoader(settings::get_twig_dir());
		$twig = new \Twig\Environment($loader);
		$html_message = $twig->render("email.html",$twig_variables);
		$txt_message = $twig->render("email.txt",$twig_variables);
		

		$from = settings::get_from_email();	
		$extraheaders = array("From"=>$from,
				"Subject"=>$subject
		);
		$message = new Mail_mime();
		$message->setHTMLBody($html_message);
		$message->setTxtBody($txt_message);

		$headers= $message->headers($extraheaders);
		$body = $message->get();
		$mail_params = array('host'=>settings::get_smtp_host(),
				'port'=>settings::get_smtp_port()
			);
		$mail = Mail::factory("mail","-f " . $from,$mail_params);
		$result = $mail->send($to,$headers,$body);
		if (PEAR::isError($result)) {
			$result = false;
			print "Error " . $mail->getMessage();
			return false;
		}
		return true;


	}

	public static function verify_date($inDate) {
		$format = "Y-m-d";
		$date = DateTime::createFromFormat($format,$inDate);
		return $date && ($date->format($format) === $inDate);
		
	}
}



?>
