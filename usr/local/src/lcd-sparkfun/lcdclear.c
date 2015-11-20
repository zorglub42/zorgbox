//--------------------------------------------------------
 // Module Name : sparkfun LCD Display utilies
 // Version : 1.0.0
 //
 //
 // Copyright (c) 2015 zorglub42
 // This software is distributed under the Apache 2 license
 // <http://www.apache.org/licenses/LICENSE-2.0.html>
 //
 //--------------------------------------------------------
 // File Name   : lcdclear.c
 //
 // Created     : 2015-07
 // Authors     : Zorglub42 <contact(at)zorglub42.fr>
 //
 // Description :
 //     Clear LCD display
 //--------------------------------------------------------
#include <wiringSerial.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>



int lcd;   // This is required, to start an instance of an LCD


void clearDisplay()
{
  serialPutchar(lcd, 0xFE);  // send the special command
  serialPutchar(lcd, 0x01);  // send the clear screen command
}


int main(){
        lcd=serialOpen("/dev/ttyAMA0", 9600);
        clearDisplay();
        serialClose(lcd);
        return 0;
}
