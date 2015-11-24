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

systemctl stop mediacenter	
echo "$*" | grep -- "-nip" > /dev/null
if [ $? -ne 0 ] ; then
	echo "Installing required packages"
	#wget http://goo.gl/rsel0F -O /etc/apt/sources.list.d/rpimonitor.list
	#apt-key adv --recv-keys --keyserver keyserver.ubuntu.com 2C0D3C0F 

	#apt-get update
	#apt-get -y upgrade

	git &>/dev/null
	if [ $? -eq 127 ] ; then
		#git is not yet istalled
		apt-get install git-core
	fi

	apt-get -y --force-yes install net-tools ifupdown ppp rdnssd iproute2-doc isc-dhcp-client libatm1 resolvconf  ndisc6 perl-doc alsa-utils \
					   libterm-readline-gnu-perl libterm-readline-perl-perl make libb-lint-perl libcpanplus-dist-build-perl libcpanplus-perl libfile-checktree-perl \
					   liblog-message-simple-perl liblog-message-perl libobject-accessor-perl hostapd wvdial\
					   rename libarchive-extract-perl libmodule-pluggable-perl libpod-latex-perl  libterm-ui-perl libtext-soundex-perl libcgi-pm-perl libmodule-build-perl \
					   libpackage-constants-perl make-doc man-db groff libcgi-fast-perl libmodule-signature-perl libpod-readme-perl  libsoftware-license-perl \
					   libclass-c3-xs-perl syslog-ng syslog-ng-mod-smtp syslog-ng-mod-amqp syslog-ng-mod-geoip syslog-ng-mod-redis syslog-ng-mod-stomp \
					   build-essential dnsmasq dnsmasq-base libmnl0 libnetfilter-conntrack3 apache2 php5 wireless-tools ifmetric samba minidlna apt-transport-https ca-certificates rpimonitor
fi

if [ ! -d zorgbox -a ! -f install.sh ] ; then
	git clone https://github.com/zorglub42/zorgbox
	cd zorgbox
else
	git pull
fi

CUR_DIR=`pwd`
echo ".gitignore" >.gitignore
echo "install.log" >>.gitignore


NEW=true
if [ -f "install.log" ] ; then
	NEW=false
	echo "Removing previous files"
	cp -r /etc/zorgbox $CUR_DIR/zorgbox.sav
	update-rc.d checkkodi remove 
	update-rc.d buttons remove 
	update-rc.d leds remove 
	update-rc.d checkmount remove 
	update-rc.d wvdial remove 
	while read -r f ; do
		rm "$f"
	done < install.log
fi
[ -f /var/www/html/index.html ] && rm /var/www/html/index.html
./snapshot.sh

echo "Copying distrib"
cp -r etc /
cp -r home /
cp -r usr /
cp -r var /


aplay -l &> /tmp/$$.tmp
CARD_COUNT=`cat /tmp/$$.tmp| egrep "^[a-z]* [0-9]*:"| wc -l`
rm /tmp/$$.tmp

AUDIO_DEVICE="ALSA:@:CARD=Device,DEV=0"
if [ $CARD_COUNT -lt 1 ] ; then
        AUDIO_DEVICE="PI:BOTH"

fi
cat home/osmc/.kodi/userdata/guisettings.xml| sed "s/\(.*<audiodevice>\).*\(<\/audiodevice>\)/\1$AUDIO_DEVICE\2/"> /home/osmc/.kodi/userdata/guisettings.xml


uname -a | grep armv7l>/dev/null
if [ $? -ne 0 ] ; then
	
	cp boot/config.txt.PI /boot/config.txt
else
	cp boot/config.txt.PI2 /boot/config.txt
fi

echo "$*" | grep -- "-nc" > /dev/null
if [ $? -ne 0 ] ; then
	echo 'Making ARMV6 compliant wiringPI lib & tools'

	cd /usr/local/src/
	[ -d wiringPi ] && rm -rf wiringPi
	git clone git://git.drogon.net/wiringPi
	cd wiringPi
	./build
	cd $CUR_DIR

	echo 'Making ARMV6 compliant lcd utilites'
	cd /usr/local/src/lcd-sparkfun
	make clean; make install
	cd $CUR_DIR

	echo 'Making ARMV6 compliant REALTEK RTL8188CUS dongle'
	cd /usr/local/src/wpa_supplicant_hostapd-0.8_rtw_r7475.20130812/hostapd
	make clean
	make
	make install
	mv hostapd /usr/sbin/hostapd
	chown root.root /usr/sbin/hostapd
	chmod 755 /usr/sbin/hostapd	
	cd $CUR_DIR
fi

if [ -d "$CUR_DIR/zorgbox.sav" ] ; then
	[ -d /etc/zorgbox ]  && rm -rf /etc/zorgbox
	mv $CUR_DIR/zorgbox.sav /etc/zorgbox
fi
systemctl disable connman
update-rc.d buttons defaults
update-rc.d checkkodi defaults 
update-rc.d checkmount defaults 
update-rc.d leds defaults 
update-rc.d wvdial defaults 

echo samba user > $$.tmp
echo samba user >> $$.tmp
echo samba user >> $$.tmp
echo samba user >> $$.tmp
echo samba user >> $$.tmp
echo "" >> $$.tmp
  

adduser -q guest --home=/home/public --shell=/bin/false --disabled-password<$$.tmp
rm $$.tmp

chown -R osmc:osmc /home/osmc
chown -R guest:osmc "/home/osmc/Carte SD Interne"
chown www-data /etc/zorgbox/credentials.json

[ "$NEW" == "true" ] && passwd osmc
a2enmod rewrite proxy proxy_http


echo "$*" | grep -- "-nr" > /dev/null
if [ $? -ne 0 ] ; then
	echo "Setting default configuration"
	/usr/local/bin/zorgbox/reset.sh
else
	/usr/local/bin/zorgbox/configure-interfaces
	/usr/local/bin/zorgbox/configure-services
	service checkkodi stop
	systemctl start mediacenter
	(sleep 10 && service checkkodi start) &
fi
