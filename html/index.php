<?php
require_once 'includes/main.inc.php';
require_once 'includes/header.inc.php';


$logs = functions::get_log($db);

$log_html = "<table class='table table-sm table-striped table-bordered'>";
$log_html .= "<thead><td>Time</td><td>Remote IP</td><td>Email</td><td>Filename</td><td>Success</td></thead>";
$log_html .= "<tbody>";

foreach ($logs as $item) {
	$log_html .= "<tr>";
	$log_html .= "<td>" . $item['time_access'] . "</td>";
	$log_html .= "<td>" . $item['remote_ip'] . "</td>";
	$log_html .= "<td>" . $item['email'] . "</td>";
	$log_html .= "<td>" . $item['filename'] . "</td>";
	$log_html .= "<td>" . $item['success'] . "</td>";
	$log_html .= "</tr>";

}
$log_html .= "</tbody></table>";


echo $log_html;
?>
<?php


require_once 'includes/footer.inc.php';
?>
