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
	<div class="col-md-12">
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
				<div class="list-group">
					<hr>
					<div class="col-md-4 col-xs-12">
						<div class="panel panel-default">
							<a class="list-group-item" href="health.php">
								<div class="row  menu-item">
									<div class="col-md-4 col-xs-4"><img src="images/health.png" ></div>
									<div class="col-md-8 col-xs-8"><h3>&nbsp;&nbsp;<?php echo Localization::getString("menu.health")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.health.desc")?>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="panel panel-default">
							<a class="list-group-item" href="#"  onclick="displayTechData()">
								<div class="row  menu-item">
									<div class="col-md-4 col-xs-4"><img src="images/lcd-settings.png" ></div>
									<div class="col-md-8 col-xs-8"><h3>&nbsp;&nbsp;<?php echo Localization::getString("menu.lcd-settings")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.lcd-settings.desc")?>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="panel panel-default">
							<a href="#" onclick="chooseStop(this)" class="list-group-item">
								<div class="row menu-item">
									<div class="col-md-3 col-xs-4"><img src="images/power.png" ></div>
									<div class="col-md-8 col-xs-8"><h3>&nbsp;&nbsp;<?php echo Localization::getString("menu.start-stop")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.start-stop.desc")?>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
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


<div id="dialog" title="<?php echo Localization::getString("system.settings.stop-mode")?>" style="display:none">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="btn btn-default" onclick="shutdown()">
					<span><?php echo Localization::getString("system.settings.shutdown")?></span>
				</button>
				<button type="button" class="btn btn-default" onclick="reboot()">
					<span><?php echo Localization::getString("system.settings.reboot")?></span>
				</button>
				<button type="button" class="btn btn-info" onclick="$('#dialog').dialog('close')">
					<span><?php echo Localization::getString("button.cancel")?></span>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
	function displayTechData(){
		showWait();
		$.ajax({
			  url: "system/tech-data",  
			  dataType: 'json',
			  type:"POST",
			  success: function(status){
										hideWait();
						},
			  error: function(){
								hideWait();
					}
			});
	}
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
	function shutdown(){
		
			$.ajax({
				  url: "system/status",  
				  dataType: 'json',
				  type:"POST",
				  data: "mode=off"
				});
			$('#dialog').dialog('close');
	}
	function reboot(){
		
			$.ajax({
				  url: "system/status",  
				  dataType: 'json',
				  type:"POST",
				  data: "mode=restart",
				});
			$('#dialog').dialog('close');
	}
	
	function chooseStop(button){
			$("#dialog").dialog({
					modal: true,
					position: { my: "left top", at: "left top", of: button },
					minWidth: 350
				});
	}

</script>
<?php
include "include/footer.php";
?>
