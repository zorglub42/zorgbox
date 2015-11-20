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
 // File Name   : lcdbacklight.c
 //
 // Created     : 2015-07
 // Authors     : Zorglub42 <contact(at)zorglub42.fr>
 //
 // Description :
 //     Change LCD backlight luminosity
 //--------------------------------------------------------
#include <wiringSerial.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

int lcd;

void setBacklight(unsigned char brightness)
{
  serialPutchar(lcd, 0x80);  // send the backlight command
  serialPutchar(lcd, brightness);  // send the brightness value
}

int main(int argc, char *argv[]){
        if (argc != 2 ){
                printf("Usage:\nlcdbacklight brightness\n");
                return 1;
        }else{
                int bckl=atoi(argv[1]);
                if (bckl<0 || bckl> 255){
                        printf("backlight must be between 0 and 255\n");
                        return 2;
                }
                lcd=serialOpen("/dev/ttyAMA0", 9600);
                setBacklight(atoi(argv[1]));
                serialClose(lcd);
        return 0;
        }
}
