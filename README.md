# zorgbox
Portable WIFI Hotspot-router 3G-4G / NAS / Media center based on OSMC 


ZorgBox is distributed as Apache2 free software license


#Requirements
 * A raspberry (of course) with OMSC freshly installed (and not configured)
 * A WIFI USB dongle based on Realtek  RTL8188CUSB shipset
 * A 3G modem (Huawei E67) If you plan to use zorgbox as a 3G Internet Acces Point
 * SparkFun serial LCD (LCD-10097) If you plan to have a LCD display on the box
 * 3.3V LEDs If you plan to have status indicators on the control panel of the box
 * 1 ou 3 3.3V LEDs If you plan to have an eartbeat status indicators on the box
 * 1 relay (2 position) + 1 push button If you plan to have a start-stop button
 * 1 push button If you plan to have a reset factory settings button
 
#Installation

  - Connect your raspberry with SSH and "take the power" as root user

		sudo -s
  - Upate apt and install git
  
		apt-get update
		apt-get install git-core
  - Download zorgbox
  
		git clone https://github.com/zorglub42/zorgbox

  - And install
  
		cd zorgbox
		./install
By the end of the install process it will ask you for a brand new password for the user osmc (security reason) and it will reboot.

At this time UNPLUG THE ETHERNET CABLE




After reboot you may find a wifi hotspot named "zorgbox", connect it (default pass-phrase is 0123456789)

Then, with your browser go to http://zorgbox and connect with admin/zorgbox to configure it



Enjoy!

  
