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
 * File Name   : include/utils.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *     Various utilites
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/

function checkAuth($redirect=true){
	session_start();
	$validSession=false;
	$validSession=isset($_COOKIE["zorgbox-auth"]) && isset($_SESSION["zorgbox-auth"]) && ($_SESSION["zorgbox-auth"]==$_COOKIE["zorgbox-auth"]);
	
	if (!$validSession){
		if ($redirect){
			header("Location: loginFom.php", 301);
		}else{
			throw new Execption("Invalid creds");
		}
		
	}
}



function getcurPass(){
	$creds=json_decode(file_get_contents("/etc/zorgbox/credentials.json"),true);
	$pass="";
	foreach ($creds as $user){
		if ($user["username"]==$_SESSION["zorgbox-auth.who"]){
			$pass=$user["password"];
		}
	}
	return $pass;
}
