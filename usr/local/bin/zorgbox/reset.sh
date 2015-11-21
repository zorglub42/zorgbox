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
 # File Name   : /usr/local/bin/zorgbox/reset.sh
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Restore factory settings
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #


MAX_LUM=126
 
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

/usr/local/bin/lcdclear
/usr/local/bin/lcdprint 0 0 "Reinitialisation....."
/usr/local/bin/lcdbacklight $MAX_LUM
cat <<EOF > /etc/zorgbox/credentials.json
[
    {
        "username": "admin",
        "password": "f314"
    }
]
EOF


cd /usr/local/bin/zorgbox
service checkkodi stop
sleep 3
/usr/local/bin/lcdbacklight $MAX_LUM
displayWait &
PID=$!
./set-hostname zorgbox
./configure-hotspot "0123456789" "lo" "0000" "inconnu"  "inconnu"  "inconnu" 
kill -9 $PID
/usr/local/bin/lcdclear
/usr/local/bin/lcdprint 0 0 "Redemarrage....."
/usr/local/bin/lcdbacklight $MAX_LUM

init 6
