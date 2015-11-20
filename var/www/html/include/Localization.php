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
 * File Name   : include/Localization.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *     Application strings localization management
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/


class Localization{
	private static $languages = Array();
	private static $strings =null;
	public static $debug=false;
	public static $language=false;
	
	private static function getLanguages(){
		if (count(self::$languages) == 0){
			//Initialize the requested languages array
			$hdrs=getallheaders();
			if (isset($hdrs["ACCEPT_LANGUAGE"])){
				$lng=split(",",$hdrs["ACCEPT_LANGUAGE"]);
				foreach ($lng as $l){
					$tmp=split(";", $l);
					$tmp=split("-",$tmp[0]);
					self::$languages[$tmp[0]]= $tmp[0];
				}
			}elseif (isset($hdrs["Accept-Language"])){
				$lng=split(",",$hdrs["Accept-Language"]);
				foreach ($lng as $l){
					$tmp=split(";", $l);
					$tmp=split("-",$tmp[0]);
					self::$languages[$tmp[0]]= $tmp[0];
				}
			}else{
				$languages[0]="fr";
			}
		}
		return self::$languages;	
	}
	
	public static function getString($string){

		$rc="*** $string ***";
		if (self::$strings==null|| self::$debug){
			$langList=self::getLanguages();
			foreach ($langList as $language){
				unset($strings);
				@include "localization/$language.php";
				if (isset($strings) && isset($strings[$string])){
					self::$strings=$strings;
					self::$language=$language;
					return $strings[$string];
				}
			}
			unset($strings);
			include "localization/default.php";
			self::$strings=$strings;
		}
		if (isset(self::$strings[$string])){
			return self::$strings[$string];
		}
		return $rc;
	}
	public static function getJSString($string){

		return str_replace("'","\'",str_replace("\n","\\n",self::getString($string)));;
	}
	
	public static function getLanguage(){
		self::getString("app.title");
		return self::$language;

	}

}

?>
