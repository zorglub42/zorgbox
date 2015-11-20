#!/bin/bash
 #--------------------------------------------------------
 # Module Name : Installer
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
 # File Name   : /usr/local/bin/zorgbox/configure-wifi-client
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Generate network configuration files to switch device a WIFI client
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #
echo ".gitignore" >.gitignore
echo "install.log" >>.gitignore
if [ -f "install.log" ] ; then
	echo "Removing previous install"
	update-rc.d buttons remove 
	update-rc.d checkkodi remove 
	update-rc.d checkmount remove 
	update-rc.d leds remove 
	update-rc.d wvdial remove 
	while read -r f ; do
		rm $f
	done < install.log
	cp -r /etc/zorgbox zorgbox.sav
fi

cp -r etc /
cp -r home /
cp -r usr /
cp -r var /


uname -a | grep armv7l>/dev/null
if [ $? -ne 0 ] ; then
fi

if [ -d "zorgbox.sav" ] ; then
	mv  zorgbox.sav /etc/zorgbox
fi
./snapshot.sh
update-rc.d buttons defaults
update-rc.d checkkodi defaults 
update-rc.d checkmount defaults 
update-rc.d leds defaults 
update-rc.d wvdial defaults 
