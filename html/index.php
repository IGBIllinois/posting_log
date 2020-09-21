<?php
require_once 'includes/main.inc.php';
require_once 'includes/header.inc.php';


$logs = functions::get_log($db);

$log_html = "<table class='table table-sm table-striped table-bordered'>";
$log_html .= "<thead>";
$log_html .= "<th>Time</th><th>Remote IP</th><th>Remote Hostname</th><th>Email</th><th>Filename</th><th>Success</th></thead>";
$log_html .= "<tbody>";

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
$log_html .= "</tbody></table>";

?>
<div class='row'>
<div class='col-sm-4 col-md-4 col-lg-4 col-xl-4'>
<form class='form-inline' method='get' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
	<div class='input-group'>	
		<input type='text' class='form-control' id='search' placeholder='Search'>
		<div class='input-group-append'>
			<button class='btn btn-primary'>Search</button>
		</div>
	</div>



</form>
</div>
</div>
<br>
<?php
echo $log_html;


require_once 'includes/footer.inc.php';
?>
