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
 * File Name   : include/header.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *     Pages header
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/

require_once "include/utils.php";
require_once "include/Localization.php";

checkAuth();
?>
<html lang="<?php echo Localization::getLanguage()?>">
	<head>
		<meta charset="utf-8">
		<title><?php echo Localization::getString("app.title")?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap-3.0.3.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="css/zorgbox.css" rel="stylesheet" id="ffbc8-css">
		<link href="css/jquery-ui.css" rel="stylesheet" id="jquery-ui-css">
		<script src="js/utils.js"></script>
		<script src="js/wait.js"></script>
		<script src="js/cookies.js"></script>
		<script src="js/jquery-1.8.2.js"></script>
		<script src="js/jquery-ui-1.9.0.custom.min.js"></script>
		<script src="js/bootstrap-3.0.0.min.js"></script>
		
	</head>
	<body>
		<div id="waitScreen" class="rounded-corners"  style="position: absolute; z-index:3; visibility: hidden; background-color:#000000;  "></div>
		<div class="container"  >
			<div class="row">
				<div class="col-md-12">
					<h2><a href="index.php"><img src="images/zorgbox-small.png" ></a>&nbsp;&nbsp;&nbsp;<?php echo Localization::getString("app.title")?></h2>
				</div>
			</div>
			<div class="row">
				<div col="col-md-12">
					<hr>
				</div>
			</div>
