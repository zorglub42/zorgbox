<!DOCTYPE html>
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
 * File Name   : loginForm.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Login form to connect the application
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/require_once "include/Localization.php"
?>
<html lang="<?php echo Localization::getLanguage()?>">
<head>
    <meta charset="utf-8">
    <title><?php echo Localization::getString("app.title")?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap-3.0.3.min.css" rel="stylesheet" id="bootstrap-css">
	<link href="css/zorgbox.css" rel="stylesheet" id="ffbc8-css">
    <script src="js/wait.js"></script>
    <script src="js/cookies.js"></script>
    <script src="js/jquery-1.8.2.js"></script>
    <script src="js/bootstrap-3.0.0.min.js"></script>
	<script>

		
		function handleKey(e) {
			if (e.keyCode == 13) {
				doLogin();
				return false;
			}
		}
		
		

		function doLogin(){
			showWait();
			params="username=" + encodeURI($("#username").val()) + "&password=" + encodeURI($("#password").val());
			$.ajax({
				  url: "/auth/login",  
				  dataType: 'json',
				  type:"POST",
				  data: params,
				  success: loggedIn,
				  error: displayError
				});
		}

		function loggedIn(generatedToken){
			hideWait();
			window.location='/';
		}	
		function displayError(jqXHR, textStatus, errorThrown){
			hideWait();
			$("#form").show();
			eval("err =" + jqXHR.responseText);
			if (err.error.code==401){
				showError("<?php echo Localization::getJSString("connexion.invalid.creds")?>");
			}else{
				showError(err.error.message);
			}
		} 

	</script>
</head>
<body>
	<div id="waitScreen" class="rounded-corners"  style="position: absolute; z-index:3; visibility: hidden; background-color:#000000;  "></div>
	<div class="container"  >
		<div class="row vertical-offset-100">
			<div class="col-md-4 col-md-offset-4">
				<div  class="panel panel-default" style="display: none" id="form">
					<div class="panel-heading">
						<h3 class="panel-title ellipsis"><b><?php echo Localization::getString("app.title")?></b></h3>
					</div>
					<div class="panel-body">
						<form accept-charset="UTF-8" role="form" onkeypress="return handleKey(event)">
						<img src="images/zorgbox-small.png" class="img-responsive login-logo"><br>
						<div id="error" class="errorMessage"></div>
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="<?php echo Localization::getString("username.placeholder")?>" id="username" type="text">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="<?php echo Localization::getString("password.placeholder")?>" name="password" type="password" id="password" value="">
							</div>
							<input class="btn btn-lg btn-info btn-block" type="button" value="<?php echo Localization::getString("button.login")?>" id="loginBtn">

						</fieldset>
						</form>
					</div>
					<div class="panel-footer">
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
			$('#loginBtn').click(doLogin);
			$('#username').focus();
			C=getCookie("ffbc8");
			if (C != ""){
				C=Base64.decode(C);
				C=C.split(":");
				if (C.length==2){
					$("#username").val(C[0]);
					$("#password").val(C[1]);
					doLogin();
				}else{
					setCookie("ffbc8","",-300);
					$("#form").show();
				}
			}else{
				$("#form").show();
			}

	
		</script>

</body>
</html>
