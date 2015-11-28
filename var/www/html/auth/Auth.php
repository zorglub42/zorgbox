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
 * File Name   : auth/Auth.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Auth API implem
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
require_once "../include/utils.php";
class Auth{


	
	/**
	 * 
	 * @url GET /logout
	 */
	 function logout(){
		session_destroy();
		setcookie("zorgbox-auth", "",0, "/");
	 }
	
	/**
	 * 
	 * @url POST /login
	 */
	 function login($username, $password){
		$found=false;
		$creds=json_decode(file_get_contents("/etc/zorgbox/credentials.json"),true);
		foreach ($creds as $user){
			$found=$found || ($user["username"]==$username && $user["password"]==$password);
		}
		if (!$found){
			throw new RestException(401, Localization::getString("connexion.invalid.creds"));
		}
		
		session_start();
		$authId=rand();
		setcookie("zorgbox-auth", $authId,0, "/");
		$_SESSION["zorgbox-auth"]=$authId;
		$_SESSION["zorgbox-auth.who"]=$username;
		return Array("OK");
	 }

	/**
	 * 
	 * @url GET /password/changed
	 */
	 function passwordChanged($password){
		restCheckAuth();
		if ($password != getCurPass()){
			return Array("changed"=>1);
		}else{
			return Array("changed"=>0);
		}
	 }
	/**
	 * 
	 * @url POST /password
	 */
	 function updatePassord($password){
		restCheckAuth();
		$creds=json_decode(file_get_contents("/etc/zorgbox/credentials.json"),true);
		for ($i=0;$i<count($creds);$i++){
			if ($creds[$i]["username"] == $_SESSION["zorgbox-auth.who"]){
				$usr=$creds[$i];
				$creds[$i]["password"]=$password;
			}
		}
		file_put_contents("/etc/zorgbox/credentials.json", json_encode($creds,JSON_PRETTY_PRINT));
		return $usr;
	 }
	
}
?>
