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
echo "Installing required packages"
wget http://goo.gl/rsel0F -O /etc/apt/sources.list.d/rpimonitor.list
apt-key adv --recv-keys --keyserver keyserver.ubuntu.com 2C0D3C0F 

apt-get update
apt-get -y upgrade
apt-get -y --force-yes install net-tools ifupdown ppp rdnssd iproute2-doc isc-dhcp-client libatm1 resolvconf  ndisc6 perl-doc \
				   libterm-readline-gnu-perl libterm-readline-perl-perl make libb-lint-perl libcpanplus-dist-build-perl libcpanplus-perl libfile-checktree-perl \
				   liblog-message-simple-perl liblog-message-perl libobject-accessor-perl hostapd wvdial\
				   rename libarchive-extract-perl libmodule-pluggable-perl libpod-latex-perl  libterm-ui-perl libtext-soundex-perl libcgi-pm-perl libmodule-build-perl \
				   libpackage-constants-perl make-doc man-db groff libcgi-fast-perl libmodule-signature-perl libpod-readme-perl  libsoftware-license-perl \
				   libclass-c3-xs-perl syslog-ng syslog-ng-mod-smtp syslog-ng-mod-amqp syslog-ng-mod-geoip syslog-ng-mod-redis syslog-ng-mod-stomp \
				   build-essential dnsmasq dnsmasq-base libmnl0 libnetfilter-conntrack3 apache2 php5 wireless-tools ifmetric samba minidlna apt-transport-https ca-certificates rpimonitor


echo ".gitignore" >.gitignore
echo "install.log" >>.gitignore
if [ -f "install.log" ] ; then
	echo "Removing previous files"
	update-rc.d checkkodi remove 
	update-rc.d buttons remove 
	update-rc.d leds remove 
	update-rc.d checkmount remove 
	update-rc.d wvdial remove 
	while read -r f ; do
		rm "$f"
	done < install.log
	cp -r /etc/zorgbox zorgbox.sav
fi

echo "Copying distrib"
cp -r etc /
cp -r home /
cp -r usr /
cp -r var /


echo 'Making ARMV6 compliant wiringPI lib & tools'

cd /usr/local/src/
[ -d wiringPi ] && rm -rf wiringPi
git clone git://git.drogon.net/wiringPi
cd wiringPi
./build
cd -

echo 'Making ARMV6 compliant lcd utilites'
cd /usr/local/src/lcd-sparkfun
make clean; make install
cd -

echo 'Making ARMV6 compliant REALTEK RTL8188CUS dongle'
cd /usr/local/src/wpa_supplicant_hostapd-0.8_rtw_r7475.20130812/hostapd
make
make install
mv hostapd /usr/sbin/hostapd
chown root.root /usr/sbin/hostapd
chmod 755 /usr/sbin/hostapd	
cd -

uname -a | grep armv7l>/dev/null
if [ $? -ne 0 ] ; then
	
	cp boot/config.txt.PI /boot/config.txt
else
	cp boot/config.txt.PI2 /boot/config.txt
fi

if [ -d "zorgbox.sav" ] ; then
	mv  zorgbox.sav /etc/zorgbox
fi
./snapshot.sh
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

a2enmod rewrite proxy proxy_http

echo "Setting default configuration"
/usr/local/bin/zorgbox/reset.sh
