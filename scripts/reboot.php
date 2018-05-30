<?php
//sudo chmod u+s /sbin/reboot
$val=shell_exec("/var/www/html/vegas/scripts/reboot.sh 2>&1");
header('Content-Type: application/json; charset=utf-8');
echo json_encode($val);
?>
