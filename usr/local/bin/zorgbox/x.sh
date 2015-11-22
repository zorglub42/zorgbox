        top -bn3 -d 1 >/tmp/$$.tmp
        CPU=`cat /tmp/$$.tmp|grep Cpu|tail -1|sed 's/,[0-9]//g'|awk '{print  100 - $8}'`
        RAM=`cat /tmp/$$.tmp| grep "KiB Mem"|tail -1|awk '{print ($5/$3)*100}'|sed 's/\(.*\...\).*/\1/'`
echo CPU=$CPU RAM=$RAM
