#!/bin/bash

if ping -q -c 1 -w 1 192.168.0.168 >> /dev/null 2>&1; then
    echo "1"
else
    echo "0"
fi

