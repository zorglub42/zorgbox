#!/bin/bash
##--------------------------------------------------------
 # Module Name : sparkfun LCD Display utilies
 # Version : 1.0.0
 #
 #
 # Copyright (c) 2015 zorglub42
 # This software is distributed under the Apache 2 license
 # <http://www.apache.org/licenses/LICENSE-2.0.html>
 #
 #--------------------------------------------------------
 # File Name   : example.sh
 #
 # Created     : 2015-07
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Display information about the PRI on LCD Display
 #    (sample script)
 #--------------------------------------------------------
##
PAGE=1
while [ 1 ] ; do
        vmstat -n 1 2 | tail -1 >/tmp/$$.cpu
        CPU=`cat /tmp/$$.cpu |tail -1|awk '{print 100 - $15}'`
        case $PAGE in
                1)
                        top -bn2 -d 1 |head >/tmp/$$.cpu
                        RAM=`cat /tmp/$$.cpu| grep "KiB Mem"|tail -1|awk '{print ($5/$3)*100}'|sed 's/\(.*\...\).*/\1/'`
                        SWAP=`cat /tmp/$$.cpu| grep "KiB Swap"|tail -1|awk '{print ($5/$3)*100}'|sed 's/\(.*\...\).*/\1/'`
                        TEMP=`/opt/vc/bin/vcgencmd measure_temp|awk -F= '{print $2}'|sed 's/.C//'`

                        lcdclear
                        lcdprint 0 0 "T="$TEMP"c"
                        lcdprint 0 9 "C="$CPU"%"
                        lcdprint 1 0 "R="$RAM"%"
                        lcdprint 1 9 "S="$SWAP"%"


                        PAGE=2
                ;;
                2) ## Add your custom 2nd page here
                    lcdclear
                    lcdprint 0 0 "2nd custom page"
                    PAGE=3
                ;;
                3) ## Add your custom 3rd page here
                    lcdclear
                    lcdprint 0 0 "3rd custom page"
                    PAGE=1
                ;;
                *)
                    PAGE=1
                ;;
        esac

        sleep 5
done
