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
 # File Name   : /usr/local/bin/zorgbox/logs.sh
 #
 # Created     : 2015-11
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Compress logs
 #--------------------------------------------------------
 # History     :
 # 1.0.0 - 2015-11-18 : Release of the file
 #
exit 0
cd /var/log
find . -name "*gz" -print | xargs rm
find . -name "*log" -print | xargs gzip 
[ -f btmp ] && gzip btmp
[ -f debug ] && gzip debug
[ -f dmesg ] && gzip dmesg
[ -f error ] && gzip error
[ -f faillog ] && gzip faillog
[ -f lastlog ] && gzip lastlog
[ -f lircd ] && gzip lircd
[ -f messages ] && gzip messages
[ -f syslog ] && gzip syslog
[ -f toto ] && gzip toto
[ -f wtmp ] && gzip wtmp

