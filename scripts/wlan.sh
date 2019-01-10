#!/bin/bash
/sbin/ifconfig wlan0 | grep 'inet '| awk '{print $2}'
