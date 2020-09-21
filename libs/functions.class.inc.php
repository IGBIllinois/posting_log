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
			$date_sql = "WHERE time_access BETWEEN CAST(" . $start_date . " AS DATE) AND CAST(" . $end_date . " AS DATE) ";
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
}



?>
