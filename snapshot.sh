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
 # File Name   : snapshot.sh
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Take a snapshot of current distrib
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #

find . | sed 's/^\.//' \
	   | sed 's/\/[^\/]*sh/EXCLUDE/' \
	   | sed 's/\/\.git*/EXCLUDE/' \
	   | sed 's/\/install.log/EXCLUDE/' \
	   | sed 's/\/README.*/EXCLUDE/' \
	   | sed 's/\/LICENSE/EXCLUDE/' \
       | grep -v "EXCLUDE" \
       >/tmp/$$.tmp
while read -r l ; do
	if [ -f ".$l" ] ; then
		echo $l
	fi
done < /tmp/$$.tmp >install.log
rm /tmp/$$.tmp
	   
