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


echo $log_html;
?>
<?php


require_once 'includes/footer.inc.php';
?>
