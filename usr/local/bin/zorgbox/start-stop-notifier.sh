#!/bin/bash
 #--------------------------------------------------------
 # Module Name : SysApps
 # Version : 1.0.0
 #
 # Software Name : F314 MediaCenter
 # Version : 1.0
 #
 # Copyright (c) 2015 Zorglub42
 # This software is distributed under the Apache 2 license
 # <http://www.apache.org/licenses/LICENSE-2.0.html>
 #
 #--------------------------------------------------------
 # File Name   : /usr/local/bin/f314/start-stop-notifier.sh
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Notifify start & stop on LCD
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #
PATH=/usr/local/bin:$PATH

MAX_LUM=50





function displayWait {
		lcdclear
		lcdbacklight $MAX_LUM
		lcdprint 0 0 "$1"
		lcdprint 1 0 '----------------'
		DELAY=0.2
		PREV=1
		POS=0
		STEP='+'
		while [ ! -f /var/run/stop-display ] ; do
			lcdbacklight $MAX_LUM
			lcdprint 1 $PREV '-'
			lcdprint 1 $POS '*'
			PREV=$POS
			if [ $POS -eq 15 ] ; then
				STEP='-'
			elif [ $POS -eq 0 ] ; then
				STEP='+'
			fi
			POS=`expr $POS $STEP 1`
			sleep $DELAY
		done
		lcdclear
		lcdbacklight 0
		[ -f /var/run/stop-display ] && rm /var/run/stop-display
}

function doStart(){
		displayWait `hostname`  &

		KODI=1
		:> /home/osmc/.kodi/temp/kodi.log
		
		while [ $KODI -ne 0 ] ; do
				
				sleep 1
				grep "OSMC ADDON MAIN daemon started" /home/osmc/.kodi/temp/kodi.log>/dev/null
				KODI=$?
				
		done
		echo Done >>/var/log/syslog
		touch /var/run/stop-display
		`dirname $0`/display-tech-data
		#sleep 1
		#echo Killing>>/var/log/syslog
		#ps aux | grep start-stop-notifier.sh | grep -v grep | awk '{print $2}' | xargs kill -9
}



function clearDisplay () {
	touch /var/run/stop-display
	lcdclear
	lcdbacklight 0
	exit 0
}
function doStop(){

trap clearDisplay 1 2 3 6 9 14 15
echo "stopping" >>/var/log/syslog
echo  "06:11:43 284.402283 T:1958564400   DEBUG: CAnnouncementManager - Announcement: OnStop from xbmc" >> /home/osmc/.kodi/temp/kodi.log
echo  "OSMC ADDON MAIN daemon started" >> /home/osmc/.kodi/temp/kodi.log
sleep 0.5
displayWait Arret....
}

:>/var/run/start-stop-notifier.log
[ -f /var/run/stop-display ] && rm /var/run/stop-display

doStart &


tail -f /var/run/start-stop-notifier.log | (while read r ; do   ps aux | grep "tail -f /var/run/start-stop-notifier.log" | grep -v grep|awk '{print $2}'|xargs kill; exit 0 ;done)
doStop &
