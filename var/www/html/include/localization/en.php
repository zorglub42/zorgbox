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
 * File Name   : include/localization/fr.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Application strings (English)
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/

$strings["date.format"]="MM/dd/yyyy";
$strings["date.format.parseexact"]="mm/dd/yyyy";
$strings["locale"]="en";
/* Global app labels */
$strings["app.title"]=gethostname();
$strings["connexion.invalid.creds"]="Invalid credentials";
$strings["password.placeholder"]="Password";
$strings["username.placeholder"]="User";

$strings["button.login"]="OK";

$strings["menu.start-stop"]="Shutdown";
$strings["menu.start-stop.desc"]="Stop " . gethostname() . " before removing power supply";
$strings["menu.wifi"]="WIFI";
$strings["menu.wifi.desc"]="Define WIFI behaviour (Connect a network or create a hotspot)";
$strings["menu.settings"]="Advanced";
$strings["menu.settings.desc"]="Advance parameters (system name, password....)";
$strings["menu.logout"]="Logout";
$strings["menu.logout.desc"]="Disconnect " . gethostname() . " administration console";
$strings["menu.wifi.client"]="Client";
$strings["menu.wifi.client.desc"]="Define parameter to connect an existing WIFI network";
$strings["menu.wifi.hotspot"]="Hotspot";
$strings["menu.wifi.hotspot.desc"]="Define parameter to creat a WIFI hotspot with ". gethostname() ;


$strings["wifi.client.title"]="Connect WIFI";
$strings["wifi.client.ssid"]="Name (SSID)";
$strings["wifi.client.passphrase"]="Password";
$strings["wifi.client.bad-creds"]="Connection is not possible";

$strings["wifi.hotspot.title"]="Hotspot settings";
$strings["wifi.hotspot.passphrase"]="Key (password)";
$strings["wifi.hotspot.passphrase.placeholder"]="Enter a password to protect the WIFI network";
$strings["wifi.hotspot.if-gateway"]="Internet acces via";
$strings["wifi.hotspot.pin"]="SIM Card PIN code";
$strings["wifi.hotspot.if-gsm"]="GSM";
$strings["wifi.hotspot.if-ethernet"]="Ethernet (or no access)";
$strings["wifi.hotspot.ethernet"]="Extend to ethernet";
$strings["wifi.hotspot.apn"]="APN name";
$strings["wifi.hotspot.apn-user"]="APN username";
$strings["wifi.hotspot.apn-pass"]="APN password";



$strings["system.settings.title"]= gethostname() . " settings";
$strings["system.settings.hostname"]="System name";
$strings["system.settings.password"]="Password";



$strings["button.ok"]="OK";
$strings["button.cancel"]="Cancel";
$strings["button.test"]="OK";


$strings["confirm.shutdown"]="Shutdown " . gethostname() . " ?";
$strings["confirm.restart"]="Restart " . gethostname() . " ?";

$strings["index.shutdown"]="Shutdown in progress";
$strings["index.shutdown.error"]="Error during shutdown";


?>
