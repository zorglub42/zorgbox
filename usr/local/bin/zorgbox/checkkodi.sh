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
 # File Name   : /usr/local/bin/f314/checkkodi.sh
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Daemon monitoring kodi activity
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #
PATH=/usr/local/bin:$PATH
Title=""
Album=""
Artist=""


MAX_LUM=50





function displayWait {
	(
		lcdprint 1 0 '----------------'
		DELAY=0.2
		PREV=1
		POS=0
		STEP='+'
		while [ 1 ] ; do
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
	) &
	DISP_PID=$!
}



function audioDisplayManager {
	if [ "$Artist" == "" ] ; then
		echo calling kodi for audio
		#We don't get any meta data from logs, try by calling kodi API
		JS=`curl -s 'http://127.0.0.1:88/jsonrpc?Player.GetProperties'  -H 'Content-Type: application/json' --data-binary '{"jsonrpc": "2.0", "method": "Player.GetItem", "params": { "properties": ["title", "album", "artist", "duration", "thumbnail", "file", "fanart", "streamdetails"], "playerid": 0 }, "id": "AudioGetItem"}'`
		Album=`echo $JS |awk -F 'album":"' '{print $2}' | awk -F '"' '{print $1}'`
		Artist=`echo $JS |awk -F 'artist":\["' '{print $2}' | awk -F '"' '{print $1}'`
		Title=`echo $JS |awk -F 'title":"' '{print $2}' | awk -F '"' '{print $1}'`
	fi
	if [ "$Artist" == "" ] ; then
		return
	fi

	(
		lcdbacklight $MAX_LUM
		while [ 1 ] ; do
			echo "Ar=$Artist Al=$Album Ti=$Title"
			lcdclear; lcdprint 0 0 "Artiste :";echo $Artist| cut -c1-16|lcdprint 1 0
			sleep 2
			if [ "$Album" != "" ] ; then
				lcdclear; lcdprint 0 0 "Album :";echo $Album| cut -c1-16|lcdprint 1 0
				sleep 2
			fi
			lcdclear; lcdprint 0 0 "Titre :";echo $Title| cut -c1-16|lcdprint 1 0
			sleep 2
		done
	)&
	DISP_PID=`echo $DISP_PID $!`
}

function videoDisplayTitleManager {

	LEN=`echo $Film| wc -c`
	if [ $LEN -le 16 ] ; then
		echo $Film $LEN
		lcdprint 0 0 $Film
	else

		(
			Film=`echo $Film"...*"|sed 's/ /\*/g'`
			while [ 1 ] ; do
				echo $Film|sed 's/\*/ /g'| cut -c1-16|lcdprint 0 0

				FL=`echo $Film| cut -c1-1`
				END=`echo $Film| cut -c2-600`
				Film=`echo $END$FL`
				sleep  1

			done
		) &
		DISP_PID=`echo $DISP_PID $!`
	fi
}
function videoDisplayManager {
	if [ "$Film" == "" ] ; then
		return
	fi

	lcdclear
	lcdbacklight $MAX_LUM
	echo "Film=$Film"

	videoDisplayTitleManager 
	(
		while [ 1 ] ; do
			FILM_DATA=`curl -s 'http://127.0.0.1:88/jsonrpc?Player.GetProperties'  -H 'Content-Type: application/json' --data-binary '{"jsonrpc":"2.0","method":"Player.GetProperties","id":1,"params":{"playerid":1,"properties":["playlistid","speed","position","totaltime","time"]}}'`
			CUR=`echo $FILM_DATA|awk -F ',"time":'  '{print $2}'| awk -F ',"totaltime"' '{print $1}'| sed 's/\,/:/g'| sed 's/}/:/'|awk -F ":" '{
				if ($6 <10) min="0"$6;
				else min=$6
				if ($8 <10) sec="0"$8;
				else sec=$8
				print $2":"min":"sec
			}'`
			TOT=`echo $FILM_DATA| awk -F ',"totaltime":' '{print $2}'| sed 's/,/:/g'| sed 's/\,/:/g'| sed 's/}/:/' |awk -F ":" '{
				if ($6 <10) min="0"$6;
				else min=$6
				if ($8 <10) sec="0"$8;
				else sec=$8
				print $2":"min":"sec
			}'`

			echo "$CUR/$TOT     "|cut -c1-16|lcdprint 1 0
			sleep 5
		done
	)&
	DISP_PID=`echo $DISP_PID $!`

}


function killDisplayManager {
	for pid in $DISP_PID ; do
		kill $pid
	done
	lcdclear; lcdbacklight 0

	DISP_PID=""
}


function checkIfVideo {
	#disable screen saver (if eventually running)
	curl -s 'http://127.0.0.1:88/jsonrpc?Player.GetProperties'  -H 'Content-Type: application/json' --data-binary '{ "jsonrpc": "2.0", "method": "GUI.ActivateWindow", "params": { "window": "fullscreenvideo" },"id": 1 }'
	if [ "$Film" == "" ] ; then
		curl -s --header 'Content-Type: application/json' --data-binary '{ "id": 1, "jsonrpc": "2.0", "method": "Player.GetActivePlayers" }' 'http://127.0.0.1:88/jsonrpc'| grep '"type":"video"'>/dev/null
		if [ $? -eq 0 ] ; then
			Film=`curl -s --header 'Content-Type: application/json' --data-binary '{"jsonrpc": "2.0", "method": "Player.GetItem", "params": { "properties": ["title", "album", "artist", "season", "episode", "duration", "showtitle", "tvshowid", "thumbnail", "file", "fanart", "streamdetails"], "playerid": 1 }, "id": "VideoGetItem"}' 'http://127.0.0.1:88/jsonrpc'| awk -F '"label":"' '{print $2}'|awk -F '"' '{print $1}'`
		fi
	fi
	if [ "$Film" != "" ] ; then
		echo "It a film"
		videoDisplayManager 
	fi
}


function displayMode {
	killDisplayManager
	
	if [ "$1" == "on" ] ; then
		player=`curl -s 'http://127.0.0.1:88/jsonrpc?Player.GetProperties'  -H 'Content-Type: application/json' --data-binary '{"jsonrpc": "2.0", "method": "Player.GetActivePlayers", "id": 1}'| awk -F '"' '{print $14}'`
		case $player in
			video)
				checkIfVideo
			;;
			audio)
				audioDisplayManager 
			;;
			picture)
				curl -s 'http://127.0.0.1:88/jsonrpc?Player.GetProperties'  -H 'Content-Type: application/json' --data-binary '{ "jsonrpc": "2.0", "method": "GUI.ActivateWindow", "params": { "window": "slideshow" },"id": 1 }'
			;;
		esac
	fi
} 


(
	DISP_PID=""
	killDisplayManager
	lcdbacklight $MAX_LUM
	lcdprint 0 0 `hostname`
	displayWait 
	
	echo "Check kodi playing checker starts"
	date
	echo "Waitting for kodi"
	ps aux | grep "/usr/lib/kodi/kodi.bin"| grep -v grep >/dev/null
	while [ $? -ne 0 ] ; do
		ps aux | grep "/usr/lib/kodi/kodi.bin"| grep -v grep >/dev/null
		sleep 5
	done
	date
	killDisplayManager
) >/var/log/checkkodi.log

curl -s 'http://127.0.0.1:88/jsonrpc?Player.GetProperties'  -H 'Content-Type: application/json' --data-binary '{ "jsonrpc": "2.0", "method": "GUI.ActivateWindow", "params": { "window": "screensaver" },"id": 1 }'
systemctl stop connman
touch /var/run/checkkodi.run

tail -f /home/osmc/.kodi/temp/kodi.log|egrep --line-buffered  "Announcement:|INFO: ffmpeg|icy-name" |(
	while [ -f /var/run/checkkodi.run ] ; do
		read l
		echo $l| grep "Announcement:">/dev/null
		if [ $? -eq 0 ] ; then
			ACTION=`echo $l|awk '{print $8}'`
			echo "Got action $ACTION"
			case $ACTION in
				"OnAdd")
				;;
				"OnPlay")
					displayMode "on"
				;;
				"OnStop")
					Title=""
					Album=""
					Artist=""
					Film=""
					curl -s 'http://127.0.0.1:88/jsonrpc?Player.GetProperties'  -H 'Content-Type: application/json' --data-binary '{ "jsonrpc": "2.0", "method": "GUI.ActivateWindow", "params": { "window": "screensaver" },"id": 1 }'
					displayMode "off"
				;;
			esac
				
		fi
		echo $l| grep "INFO: ffmpeg"| egrep "artist|album|title">/dev/null
		if [ $? -eq 0 ] ; then
			DATA_TYPE=`echo $l|awk -F ':' '{print $6}'|sed 's/ \([^ ]*\) /\1/'`
			DATA_VALUE=`echo $l|awk -F ':' '{print $7}'|sed 's/ \(.*\)$/\1/'`
			echo "Got data >$DATA_TYPE=$DATA_VALUE<"
			case $DATA_TYPE in
				"artist")
					Artist=$DATA_VALUE
				;;
				"album")
					Album=$DATA_VALUE
				;;
				"title")
					if [ "$DATA_VALUE" != "" ] ; then
						Title=$DATA_VALUE
					fi
				;;
			esac
		fi
		echo $l | grep icy-name 
		if [ $? -eq 0 ] ; then
			Artist="Radio"
			Album=""
			Title=`echo $l | awk -F 'icy-name:' '{print $2}'|awk -F '-' '{print $1}'`
		fi
	done
	#displayMode "off"	
	curl -s 'http://127.0.0.1:88/jsonrpc?Player.GetProperties'  -H 'Content-Type: application/json' --data-binary '{ "jsonrpc": "2.0", "method": "GUI.ActivateWindow", "params": { "window": "home" },"id": 1 }'
	echo end
	ps aux | grep checkkodi.sh| grep -v grep | awk '{print $1}' |xargs kill 
) >>/var/log/checkkodi.log
