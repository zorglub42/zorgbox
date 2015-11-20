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
 * File Name   : wifi/index.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *     WIFI management API listener
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
require_once '../include/restler/restler.php';
require_once '../include/restler/xmlformat.php';
require_once '../include/Localization.php';
require_once 'Wifi.php';

//CORS Compliancy
header("Access-Control-Allow-Credentials : true");
header("Access-Control-Allow-Headers: X-Requested-With, Depth, Authorization");
header("Access-Control-Allow-Methods: OPTIONS, GET, HEAD, DELETE, PROPFIND, PUT, PROPPATCH, COPY, MOVE, REPORT, LOCK, UNLOCK");
header("Access-Control-Allow-Origin: *");



$r = new Restler();
$r->setSupportedFormats('JsonFormat', 'XmlFormat' ,'UrlEncodedFormat');
$r->addAPIClass('Wifi','');
$r->handle();
?>
