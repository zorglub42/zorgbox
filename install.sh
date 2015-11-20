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
echo "Installing required packages"
apt-get update
apt-get -y upgrade
apt-get -y install net-tools
apt-get -y install ifupdown
apt-get -y install ppp rdnssd iproute2-doc isc-dhcp-client libatm1
apt-get -y install resolvconf  ndisc6
apt-get -y install perl-doc libterm-readline-gnu-perl libterm-readline-perl-perl make libb-lint-perl libcpanplus-dist-build-perl libcpanplus-perl libfile-checktree-perl liblog-message-simple-perl liblog-message-perl libobject-accessor-perl
apt-get -y install rename libarchive-extract-perl libmodule-pluggable-perl libpod-latex-perl  libterm-ui-perl libtext-soundex-perl libcgi-pm-perl libmodule-build-perl libpackage-constants-perl
apt-get -y install make-doc man-db groff
apt-get -y install libcgi-fast-perl libmodule-signature-perl libpod-readme-perl  libsoftware-license-perl
apt-get -y install libclass-c3-xs-perl
apt-get -y install syslog-ng
apt-get -y install syslog-ng-mod-smtp syslog-ng-mod-amqp syslog-ng-mod-geoip syslog-ng-mod-redis syslog-ng-mod-stomp logrotatehostapd
apt-get -y install build-essential
apt-get -y install dnsmasq
apt-get -y install dnsmasq-base libmnl0 libnetfilter-conntrack3
apt-get -y install apache2 php5
apt-get -y install wireless-tools
apt-get -y install ifmetric
apt-get -y install samba minidlna


echo ".gitignore" >.gitignore
echo "install.log" >>.gitignore
if [ -f "install.log" ] ; then
	echo "Removing previous files"
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

echo "Copying distrib"
cp -r etc /
cp -r home /
cp -r usr /
cp -r var /


uname -a | grep armv7l>/dev/null
if [ $? -ne 0 ] ; then
	echo 'Making ARMV6 compliant wiringPI lib & tools'
	cd /usr/local/src/wiringPi
	./build

	echo 'Making ARMV6 compliant lcd utilites'
	cd /usr/local/src/lcd-sparkfun
	make clean; make install
	
	echo 'Making ARMV6 compliant REALTEK RTL8188CUS dongle'
	cd /usr/local/src/wpa_supplicant_hostapd-0.8_rtw_r7475.20130812/hostapd
	make
	make install
	mv hostapd /usr/sbin/hostapd
	chown root.root /usr/sbin/hostapd
	chmod 755 /usr/sbin/hostapd	
	
	cp /boot/config.txt.PI /boot/config.txt
else
	cp /boot/config.txt.PI2 /boot/config.txt
fi

if [ -d "zorgbox.sav" ] ; then
	mv  zorgbox.sav /etc/zorgbox
fi
./snapshot.sh
systemctl disable connman
update-rc.d buttons defaults
update-rc.d checkkodi defaults 
update-rc.d checkmount defaults 
update-rc.d leds defaults 
update-rc.d wvdial defaults 

chown osmc:osmc /home/osmc
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

echo "Setting default configuration"
/usr/local/bin/zorgbox/reset.sh
