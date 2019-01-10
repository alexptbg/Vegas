#!/bin/bash

if ping -q -c 1 -w 1 8.8.8.8 >> /dev/null 2>&1; then
    echo "1"
else
    echo "0"
fi

