<?php
/*--------------------------------------------------------
 * Module Name : AdminWebApp
 * Version : 1.0.0
 *
 * Software Name : ZorgBox
 * Version : 1.0
 *
 * Copyright (c) 2015 Zorglub42
 * This software is distributed under the Apache 2 license
 * <http://www.apache.org/licenses/LICENSE-2.0.html>
 *
 *--------------------------------------------------------
 * File Name   : wifi/Wifi.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *     WIFI Management API implem
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
require_once "../include/Localization.php";
class Wifi{
	
	/**
	 * 
	 * @url GET /ssid
	 */
	 function getSSID(){
		 $ssids=json_decode( shell_exec("sudo /usr/local/bin/zorgbox/wifi-ssid-list"));
		 return $ssids;
	 }
	/**
	 * 
	 * @url POST /client
	 */
	 function setClientParameters($ssid, $pass, $mode=""){
		 $res=json_decode( shell_exec("sudo /usr/local/bin/zorgbox/configure-wifi-client \"$ssid\" \"$pass\" \"$mode\""), true);
		 if ($res["connected"] == 0){
			 throw new RestException(400,  Localization::getJSString("wifi.client.bad-creds"));
		 }
		 return $res;
	 }
	/**
	 * 
	 * @url POST /hotspot
	 * @url GET /hotspot
	 */
	 function setHotspotParameters($pass, $gw, $ethMode, $pin, $apn, $apnUser, $apnPass){
		 if ($gw == "ppp0" && $ethMode=="hotspot"){
			 $if2="eth0";
		 }else{
			 $if2="";
		 }
		 $res=shell_exec("sudo /usr/local/bin/zorgbox/configure-hotspot \"$pass\" \"$gw\" \"$pin\" \"$apn\"  \"$apnUser\"  \"$apnPass\" \"$if2\"");
		 return Array("rc"=>"$res");
	 }
	
}
?>
