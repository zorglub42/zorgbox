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
 * File Name   : system-settings.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Define system settings (password, hostname....)
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
include "include/header.php";

$creds=json_decode(file_get_contents("/etc/zorgbox/credentials.json"), true);
$pass=getCurPass();

?>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><b><?php echo Localization::getString("system.settings.title")?></b></h3>
			</div>
			<div class="panel-body">
				<form accept-charset="UTF-8" role="form">
					<fieldset>
						
						<div class="form-group">
							<div class="col-md-12">	
								<label><?php echo Localization::getString("system.settings.hostname")?></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="hostname" class="form-control" value="<?php echo gethostname()?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12">	
								<label><?php echo Localization::getString("system.settings.password")?> (<?php echo $_SESSION["zorgbox-auth.who"]?>)</label>
							</div>
							<div class="col-md-12">
								<input type="password" id="pass" class="form-control" value="<?php echo $pass?>">
							</div>
						</div>
					</fieldset>

				</form>
			</div>
			<div class="panel-footer">
					<div class="row">
						<div class="col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3">
							<button type="button" class="btn btn-default" id="setHotspot" onclick="changeSettings()">
								<span><?php echo Localization::getString("button.ok")?></span>
							</button>
							<button type="button" class="btn btn-info" onclick="location='index.php'">
								<span><?php echo Localization::getString("button.cancel")?></span>
							</button>
						</div>
					</div>
			</div>
		</div>
	<div>
</div>



<script>
	function changeSettings(){
		showWait();
		params="hostname=" + encodeURI($("#hostname").val());
		$.ajax({
			  url: "system/hostname",  
			  dataType: 'json',
			  type:"POST",
			  data: params,
			  success: function(){
									hideWait();
									startUpdatePassword()
						},
			  error: function(){
								hideWait();
								alert("Update hostname error");
					}
			});
		
	}
	function startUpdatePassword(){
		showWait();
		params="password=" + encodeURI($("#pass").val());
		$.ajax({
			  url: "auth/password/changed",  
			  dataType: 'json',
			  type:"GET",
			  data: params,
			  success: function(status){
									if (status.changed==1){
										updatePassword();
									}else{
										hideWait();
										location="index.php";
									}
						},
			  error: function(){
								hideWait();
								alert("Check password changed error ");
					}
			});
	}
	
	function updatePassword(){
		params="password=" + encodeURI($("#pass").val());
		$.ajax({
			  url: "auth/password",  
			  dataType: 'json',
			  type:"POST",
			  data: params,
			  success: function(){
									hideWait();
									location="index.php";
						},
			  error: function(){
								hideWait();
								alert("Update password error");
					}
			});
	}

</script>
<?php
include "include/footer.php";
?>
