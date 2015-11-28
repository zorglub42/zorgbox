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
 * File Name   : kodi/Kodi.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Kodi API implem
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
require_once "../include/utils.php";
class Kodi{


	
	/**
	 * 
	 * @url GET /status
	 */
	 function status(){
		restCheckAuth();
		$visibility=trim(shell_exec("sudo /usr/local/bin/zorgbox/kodi-mngr visibility-status"));
		$player=trim(shell_exec("sudo /usr/local/bin/zorgbox/kodi-mngr player"));
		return (array("visible"=>$visibility, "player" => $player));
	 }
	/**
	 * 
	 * @url POST /visibility/toggle
	 */
	 function toggleVisibility(){
		restCheckAuth();
		$visibility=$this->status();
		if ($visibility["visible"]==1){
		$rc=shell_exec("sudo /usr/local/bin/zorgbox/kodi-mngr hide");
		}else{
		$rc=shell_exec("sudo /usr/local/bin/zorgbox/kodi-mngr show");
		}
		return ($this->status());
	 }
	
}
?>
