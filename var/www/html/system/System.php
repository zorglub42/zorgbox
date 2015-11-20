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
 * File Name   : system/System.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *     System management API implem
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
require_once "../include/Localization.php";
class System{
	
	/**
	 * 
	 * @url POST /status
	 */
	 function setStatus($mode){
		if ($mode == "off"){
			shell_exec("sudo /usr/local/bin/zorgbox/shutdown");
		}elseif ($mode=="restart"){
			shell_exec("sudo /usr/local/bin/zorgbox/restart");
		}
		return Array("OK");
	 }
	/**
	 * 
	 * @url POST /hostname
	 */
	 function setHostname($hostname){
		shell_exec("sudo /usr/local/bin/zorgbox/set-hostname $hostname");
		return Array("OK");
	 }
	
}
?>
