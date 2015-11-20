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
 // File Name   : lcdprint.c
 //
 // Created     : 2015-07
 // Authors     : Zorglub42 <contact(at)zorglub42.fr>
 //
 // Description :
 //     Display a text at specified line and col on LCD screen
 //--------------------------------------------------------
 #include <wiringSerial.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>



int lcd;   // This is required, to start an instance of an LCD

void setLCDCursor(unsigned char cursor_position)
{
  serialPutchar(lcd, 0xFE);  // send the special command
  serialPutchar(lcd, 0x80);  // send the set cursor command
  serialPutchar(lcd, cursor_position);  // send the cursor position
}

int main(int argc, char *argv[]){
        if (argc < 3 ){
                printf("Usage:\nlcdprint line col [text]\n");
                return 1;
        }else{
                int col=atoi(argv[2]);
                if (col<0 || col> 15){
                        printf("col must be between 0 and 15\n");
                        return 2;
                }
                int line=atoi(argv[1]);
                if (line<0 || line> 1){
                        printf("col must be between 0 and 1\n");
                        return 3;
                }
                lcd=serialOpen("/dev/ttyAMA0", 9600);
                setLCDCursor(line*16+col);
				if (argc>3){
					int i;
					for (i=3;i<argc;i++){
							serialPuts(lcd, argv[i]);
							if (i<argc-1){
									serialPuts(lcd, " ");
							}
					}
				}else{
					char c;
					while ((c=getchar()) !=255){
						serialPutchar(lcd, c); 
					}
				}
                serialClose(lcd);
                return 0;
        }
}
