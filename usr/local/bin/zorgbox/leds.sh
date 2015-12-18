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
 # File Name   : /usr/local/bin/zorgbox/leds.sh
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Daemon handling device leds
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #
HEART_BEAT_PIN=1
PING_PIN=7
MOUNT_PIN=0
WLAN_PIN=2


function scanning(){
	if [ -f /var/run/scan.run ] ; then
		echo "scan in progress"
	else
		echo start scanning
		touch /var/run/scan.run
		while [ -f /var/run/scan.run ] ; do
			gpio write $MOUNT_PIN 1
			sleep 0.1
			gpio write $MOUNT_PIN 0
			sleep 0.1
		done
		:>/var/log/minidlna.log
		echo scanning ends
	fi
}


function monitorMiniDLNA(){
	tail -f /var/log/minidlna.log | egrep --line-buffered "rescanning...|Finished parsing|scanner.c" | (
		while [ -f /var/run/leds.run ] ; do
			read l
			echo $l| egrep "rescanning|scanner.c">/dev/null
			if [ $? -eq 0 ] ; then
				scanning &
			else
				echo $l| grep "Finished">/dev/null
				if [ $? -eq 0 ] ; then
					[ -f /var/run/scan.run ] && rm /var/run/scan.run
				fi
			fi
		done
		ps aux | grep "tail -f /var/log/minidlna.log" | grep -v grep | awk '{print $2}' | xargs kill -9
)
echo monitordlna ends
}



function heartBeat(){
	uname -a | grep armv7l>/dev/null
	if [ $? -eq 0 ] ; then
		fade &
		FADE_PID=$!
		while [ -f /var/run/leds.run ] ; do
			sleep 1
		done
		kill $FADE_PIN
		gpio pwm $HEART_BIT_PIN 0
	else
		while [ -f /var/run/leds.run ] ; do
			gpio write $HEART_BEAT_PIN 1
			sleep 0.1
			gpio write $HEART_BEAT_PIN 0
			sleep 0.1
			gpio write $HEART_BEAT_PIN 1
			sleep 0.1
			gpio write $HEART_BEAT_PIN 0
			sleep 1
		done
		gpio write $HEART_BIT_PIN 0
	fi
	
	gpio write $PING_PIN 0
	gpio write $MOUNT_PIN 0
	gpio write $WLAN_PIN 0
	echo heartBeat ends
}
	

gpio mode $PING_PIN out
gpio mode $MOUNT_PIN out
gpio mode $WLAN_PIN out
gpio mode $HEART_BEAT_PIN out



touch  /var/run/leds.run

echo leds is starting
heartBeat &
monitorMiniDLNA &
while [ -f /var/run/leds.run ] ; do
	ping -c 1 www.google.fr>/dev/null 2>&1
	if [ $? -eq 0 ] ; then
		gpio write $PING_PIN 1
	else
		gpio write $PING_PIN 0
	fi
	mount | grep "/media"  >/dev/null 2>&1
	if [ $? -ne 0 ] ; then
		[ -f /var/run/scan.run ] && rm /var/run/scan.run && sleep 1
	else
		
		echo gpio write $MOUNT_PIN 1
		gpio write $MOUNT_PIN 1
	fi
	ifconfig wlan0 | grep "inet addr:" >/dev/null 2>&1
	if [ $? -eq 0 ] ; then
		gpio write $WLAN_PIN 1
	else
		gpio write $WLAN_PIN 0
	fi
		
	sleep 1
done
echo "Finished parsing">>/var/log/minidlna.log
[ -f /var/run/scan.run ] && rm /var/run/scan.run



echo "leds ends"
