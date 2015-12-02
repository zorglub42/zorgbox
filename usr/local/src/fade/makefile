##--------------------------------------------------------
 # Module Name : Zorgbox
 # Version : 1.0.0
 #
 #
 # Copyright (c) 2015 zorglub42
 # This software is distributed under the Apache 2 license
 # <http://www.apache.org/licenses/LICENSE-2.0.html>
 #
 #--------------------------------------------------------
 # File Name   : makefile
 #
 # Created     : 2015-12
 # Authors     : Zorglub42 <contact(at)zorglub42.fr>
 #
 # Description :
 #     Infinite fade in fade ou on pin 1
 #--------------------------------------------------------
##
all: fade

fade: fade.c
	gcc -Wall  -lwiringPi fade.c -o fade

clean:
	([ -f fade ] && rm fade) || echo "fade does not exist"


uninstall: clean
	([ -f /usr/local/bin/fade ] && rm /usr/local/bin/fade) || echo "/usr/local/bin/fade does not exist"


install: all
	cp fade /usr/local/bin
