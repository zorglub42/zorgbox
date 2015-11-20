Command line utilities to control spark-fun LCD https://www.sparkfun.com/products/10097 in command line from a raspberry PI

It creates 3 commands in /usr/local/bin:
  - lcdclear: to clear LCD screen
  - lcdbacklight 0-255: change backlight luminosity
  - lcdprint 0-1 0-16 text....: display a text at specfified line and col
  
INSTALL
---------
  * install wiringPI library http://wiringpi.com/download-and-install/
  * install lcdutility
     * git clone https://github.com/zorglub42/tools/
     * cd  tools/rpi/lcd-sparkfun/
     * make clean;make install
  * plug LCD wire on RPI cap
     * RED wire (+5V) on Pin #4
     * BLCAK wire (GND) on Pin #6
     * YELLOW wire (TX) on Pin #8


USAGE
-------
  * lcdclear
    * clear LCD display
    * example: lcdclear   
  * lcdprint
    * display a text at specified line and col, line in 0-1, col in 0-16. Text can be received as parameter or read stdin
    * example 1: lcdprint 0 0 hello world;lcdprint 1 0 RPI Powaaaaa!
    * example 2: echo "Hello world" |lcdprint 0 0 
  * lcdbacklight
    * clange LCD display backlight luminosity. Luminosity in 0-255
    * example: lcdbacklight 42
