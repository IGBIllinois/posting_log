<?php
require_once 'includes/main.inc.php';
require_once 'includes/header.inc.php';


$count = COUNT;
$start = 0;
if (isset($_GET['start']) && is_numeric($_GET['start'])) {
        $start = $_GET['start'];
}
$search = "";
if (isset($_GET['search'])) {
        $search = $_GET['search'];
}



$logs = functions::get_download_log($db,$search,$start,$count);
$num_entries = functions::get_num_download_log_entries($db,$search);
$pages_url = $_SERVER['PHP_SELF'] . "?search=" . $search;
$pages_html = functions::get_pages_html($pages_url,$num_entries,$start,$count);

$log_html = "";

foreach ($logs as $item) {
	$log_html .= "<tr>";
	$log_html .= "<td>" . $item['time_access'] . "</td>";
	$log_html .= "<td>" . $item['remote_ip'] . "</td>";
	$log_html .= "<td>" . $item['remote_hostname'] . "</td>";
	$log_html .= "<td>" . $item['email'] . "</td>";
	$log_html .= "<td>" . $item['filename'] . "</td>";
	if ($item['success']) {
		$log_html .= "<td><span class='badge badge-pill badge-success'>Success</span></td>";
	}
	else {
		$log_html .= "<td><span class='badge badge-pill badge-danger'>Failure</span></td>";
	}
	$log_html .= "</tr>";

}

?>
<h3>Downloads</h3>
<div class='row'>
<div class='col-sm-4 col-md-4 col-lg-4 col-xl-4'>
<form class='form-inline' method='get' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
	<input type='hidden' name='count' value='<?php echo $count; ?>'>
	<input type='hidden' name='start' value='<?php echo $start; ?>'>
	<div class='input-group'>	
		<input type='text' name='search' class='form-control' id='search' placeholder='Search'>
		<div class='input-group-append'>
			<button type='submit' class='btn btn-primary'>Search</button>
		</div>
	</div>



</form>
</div>
</div>
<br>
<table class='table table-sm table-striped table-bordered'>
	<thead>
		<th>Time</th>
		<th>Remote IP</th>
		<th>Remote Hostname</th>
		<th>Email</th>
		<th>Filename</th>
		<th>Success</th>
	</thead>
<tbody>

<?php echo $log_html; ?>

</tbody></table>
<?php echo $pages_html; ?>
<form class='form-inline' action='report.php' method='post'>
        <input type='hidden' name='search' value='<?php echo $search; ?>'> 

	<select name='report_type' class='form-control'>
                <option value='xlsx'>Excel 2007 (.xlsx)</option>
                <option value='csv'>CSV (.csv)</option>
		
        </select> &nbsp;
<input class='btn btn-primary' type='submit' name='create_download_report' value='Download Full Report'>&nbsp;

<?php 



require_once 'includes/footer.inc.php';
?>
