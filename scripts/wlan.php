<?php
error_reporting(0);
$ip = shell_exec("/var/www/html/scripts/wlan.sh");
if (empty($ip)) {
    $ip = "::1";
}
$data = array("IP" => preg_replace('/\s+/','',$ip));
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>
