<?php
$cpu = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
$cpu_temp = number_format($cpu/1000,1);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($cpu_temp);
?>
