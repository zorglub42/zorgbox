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
 # File Name   : /usr/local/bin/zorgbox/buttons.sh
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Daemon handling device buttons
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #


RELAY_PIN=5
UP_PIN=4
RST_PIN=1

PATH=/usr/local/bin/:$PATH


MAX_LUM=126


displayTechData (){
	getIP
	top -bn2 -d 1 |head >/tmp/$$.cpu
	RAM=`cat /tmp/$$.cpu| grep "KiB Mem"|tail -1|awk '{print ($5/$3)*100}'|sed 's/\(.*\...\).*/\1/'`
	TEMP=`/opt/vc/bin/vcgencmd measure_temp|awk -F= '{print $2}'|sed 's/.C//'`

	lcdclear
	lcdbacklight $MAX_LUM
	lcdprint 0 0 "T="$TEMP"c"
	lcdprint 0 9 "C="$CPU"%"
	lcdprint 1 0 "R="$RAM"%"
	sleep 5
	lcdclear
	lcdbacklight 0

}


function displayIP () {
        if [ "$2" != "" ] ; then
                lcdclear
                lcdprint 0 0 $1
                lcdprint 1 0 $2
                lcdbacklight $MAX_LUM
                sleep 5
                lcdclear
                lcdbacklight 0
        fi
}

function getIP (){
        ifconfig | (
while read l ; do
        echo $l| grep "Link encap:">/dev/null
        if [ $? -eq 0 ] ; then
                IF=`echo $l| awk '{print $1'}`
        fi
        echo $l| grep "inet adr:">/dev/null
        if [ $? -eq 0 ] ; then
                IP=`echo $l| awk -F ":" '{print $2'}|awk '{print $1}'`
        fi
        echo $l| grep "Metric:">/dev/null
        if [ $? -eq 0 ] ; then
                case $IF in
                        eth0)
                                displayIP Ethernet $IP
                        ;;
                        wlan0)
                                displayIP WIFI $IP
                        ;;
                esac
        fi
done)


}

function displayWait {
        lcdprint 1 0 '----------------'
        DELAY=0.2
        PREV=1
        POS=0
        STEP='+'
        while [ 1 ] ; do
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
}

/usr/local/bin/gpio mode $RELAY_PIN out
/usr/local/bin/gpio mode $UP_PIN in
/usr/local/bin/gpio mode $RST_PIN in
/usr/local/bin/gpio write $RELAY_PIN 1


SHUTDOWN=0

lcdclear
lcdclear
lcdprint 0 0 Demarrage.....
lcdbacklight $MAX_LUM

while [ 1 ] ; do
	BUTT=`/usr/local/bin/gpio read $UP_PIN`
	if [ $BUTT -eq 1 ] ; then
		D1=`date +%s`
		BUTT=`/usr/local/bin/gpio read $UP_PIN`
		while [ $BUTT -eq 1 ] ; do
			sleep 0.2
			BUTT=`/usr/local/bin/gpio read $UP_PIN`
		done
		D2=`date +%s`
		DIFF=`expr $D2 - $D1`
		if [ $DIFF -ge 2 ] ; then	
			displayTechData
		elif [ $SHUTDOWN -eq 0 ] ; then
			lcdclear
			lcdprint 0 0 "Arret...."
			lcdbacklight $MAX_LUM
			displayWait &
			SHUTDONW=1
			init 0
		fi
		
	fi
	BUTT=`/usr/local/bin/gpio read $RST_PIN`
	if [ $BUTT -eq 1  ] ; then
		lcdclear
		lcdprint 0 0 "Reset...."
		lcdbacklight $MAX_LUM
		I=10
		while [ $BUTT -eq 1 -a $I -gt 0 ] ; do
			lcdprint 1 0 "$I "
			sleep 1
			I=`expr $I - 1`
			BUTT=`/usr/local/bin/gpio read $RST_PIN`
		done
		if [ $I -eq 0 ] ; then
			lcdclear
			/usr/local/bin/zorgbox/reset.sh
		else
			lcdclear
			lcdbacklight 0
		fi
		
	fi
	sleep 0.2
	
done
