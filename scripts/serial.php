<?php
//error_reporting(E_ALL);
$serial = shell_exec("cat /proc/cpuinfo | grep Serial | cut -d ' ' -f 2");
if ($serial) {
    echo $serial;
} else {
    echo "0";
}
?>