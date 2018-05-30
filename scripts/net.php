<?php
error_reporting(0);
$net = shell_exec("/var/www/html/scripts/net.sh");
//$ping = shell_exec("ping -c 1 -w 1 $masterServer | awk 'FNR == 2 { print $(NF-1) }' | cut -d'=' -f2");
$ping = shell_exec("ping -c 1 -w 1 192.168.0.168 | awk 'FNR == 2 { print $(NF-1) }' | cut -d'=' -f2");
if (empty($ping)) {
    $ping = 0;
}
$data = array("NET" => preg_replace('/\s+/','',$net), "SERVER" => preg_replace('/\s+/','',$ping));
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
?>
