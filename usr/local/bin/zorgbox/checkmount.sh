#!/bin/bash
 #--------------------------------------------------------
 # Module Name : SysApps
 # Version : 1.0.0
 #
 # Software Name : ZorgBox
 # Version : 1.0
 #
 # Copyright (c) 2015 Zorglub42
 # This software is distributed under the Apache 2 license
 # <http://www.apache.org/licenses/LICENSE-2.0.html>
 #
 #--------------------------------------------------------
 # File Name   : /usr/local/bin/zorgbox/chechmount.sh
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Daemon monitoring drives mount and unmount
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #

tail -f /var/log/syslog|grep --line-buffered  "Device file"|(
	while [ 1 ] ; do
		read l
		echo $l| egrep "Device file .* mounted">/dev/null
		if [ $? -eq 0 ] ; then
			DEV=`echo $l | awk '{print $8}'`
			MOUNT_POINT=`echo $l | awk '{print $11}'`
			echo "$DEV mounted on $MOUNT_POINT"
			for s in /etc/checkmount/mount.d/*; do
				if [ -x $s ] ; then
					echo "Executing $s $DEV $MOUNT_POINT"
					$s $DEV $MOUNT_POINT
				fi
			done
		fi
		echo $l| egrep "Device file .* unmounted">/dev/null
		if [ $? -eq 0 ] ; then
			DEV=`echo $l | awk '{print $8}'`
			MOUNT_POINT=`echo $l | awk '{print $11}'`
			echo "$DEV unmounted from $MOUNT_POINT"
			for s in /etc/checkmount/unmount.d/* ; do
				if [ -x $s ] ; then
					echo "Executing $s $DEV $MOUNT_POINT"
					$s $DEV $MOUNT_POINT
				fi
			done
		fi
	done
)  >>/var/log/checkmount.log
