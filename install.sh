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
apt-get upgrade
apt-get install -y net-tools
apt-get install -y ifupdown
apt-get install -y ppp rdnssd iproute2-doc isc-dhcp-client libatm1
apt-get install -y resolvconf  ndisc6
apt-get install -y perl-doc libterm-readline-gnu-perl libterm-readline-perl-perl make libb-lint-perl libcpanplus-dist-build-perl libcpanplus-perl libfile-checktree-perl liblog-message-simple-perl liblog-message-perl libobject-accessor-perl
apt-get install -y rename libarchive-extract-perl libmodule-pluggable-perl libpod-latex-perl  libterm-ui-perl libtext-soundex-perl libcgi-pm-perl libmodule-build-perl libpackage-constants-perl
apt-get install -y make-doc man-db groff
apt-get install -y libcgi-fast-perl libmodule-signature-perl libpod-readme-perl  libsoftware-license-perl
apt-get install -y libclass-c3-xs-perl
apt-get install -y syslog-ng
apt-get install -y syslog-ng-mod-smtp syslog-ng-mod-amqp syslog-ng-mod-geoip syslog-ng-mod-redis syslog-ng-mod-stomp logrotatehostapd
apt-get install -y build-essential
apt-get install -y dnsmasq
apt-get install -y dnsmasq-base libmnl0 libnetfilter-conntrack3
apt-get install -y apache2 php5
apt-get install -y wireless-tools
apt-get install -y ifmetric
apt-get install -y samba


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

/usr/local/bin/zorgbox/reset.sh
