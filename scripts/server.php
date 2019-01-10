<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);
ini_set('display_errors', true);
//master server
define('MASTER_SERVER',''); // set database host
define('MASTER_USER',''); // set database user
define('MASTER_PASS',''); // set database password
define('MASTER_DB',''); // set database name
//con
$master = new mysqli(MASTER_SERVER,MASTER_USER,MASTER_PASS,MASTER_DB);
//time
$now = date("Y-m-d H:i:s");
//app name important part
$app = "Vegas";
//app version
$version = "1.1";
//revision 
$revision = "r3";
//status Online|Offline|Deactivated|Dead
$status = "Active";
//ip addr
//real ip
$ipaddr = shell_exec("curl https://ka-ex.net/ip.php");
if (empty($ipaddr)) {
    $ipaddr = "::1";
}
//ethernet
$eth0 = shell_exec("/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'");
if (empty($eth0)) {
    $eth0 = "::1";
}
//wireless
$wlan0 = shell_exec("/sbin/ifconfig wlan0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'");
if (empty($eth0)) {
    $wlan = "::1";
}
//serial
$serial = shell_exec("cat /proc/cpuinfo | grep Serial | cut -d ' ' -f 2");
if (!$serial) {
    $serial = "0";
}
//get cpu temperature
$cpu = shell_exec("cat /sys/class/thermal/thermal_zone0/temp");
$cpufix = 0;
$cpu_temp = number_format($cpu/1000,1);
$cpu_temp = number_format($cpu_temp-$cpufix,1);
//build sql string
$sql="INSERT INTO `raspi_status` (datetime,ipaddr,eth,wlan,serial,cpu_temp,app,version,revision,status) 
      VALUES ('".$now."','".$ipaddr."','".$eth0."','".$wlan0."','".$serial."','".$cpu_temp."','".$app."','".$version."','".$revision."','".$status."')";
echo $sql;

//sql query
if($master->query($sql) === false) {
    trigger_error('Wrong SQL: '.$sql.' Error: '.$master->error,E_USER_ERROR);
} else {
    echo "Resource id #".$master->insert_id. " inserted.";
}
//end

?>
