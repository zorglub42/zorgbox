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
 * File Name   : index.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Home page
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
include "include/header.php";
?>
				<div class="list-group">
					<div class="col-md-3 col-xs-12">
						<div class="panel panel-default">
							<a 	class="list-group-item" onclick="shutdown()">
								<div class="row  menu-item">
									<div class="col-md-4 col-xs-4"><img src="images/power.png" ></div>
									<div class="col-md-8 col-xs-8 col-centered"><h3><?php echo Localization::getString("menu.start-stop")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.start-stop.desc")?>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="panel panel-default">
							<a href="wifi-mode.php" class="list-group-item">
								<div class="row menu-item">
									<div class="col-md-4 col-xs-4"><img src="images/wifi.png" ></div>
									<div class="col-md-8 col-xs-8 col-centered"><h3><?php echo Localization::getString("menu.wifi")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.wifi.desc")?>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="panel panel-default">
							<a href="system-settings.php" class="list-group-item">
								<div class="row menu-item">
									<div class="col-md-4 col-xs-4"><img src="images/settings.png" ></div>
									<div class="col-md-8 col-xs-8 col-centered"><h3><?php echo Localization::getString("menu.settings")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.settings.desc")?>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-md-3 col-xs-12">
						<div class="panel panel-default">
							<a href="#" onclick="logout()" class="list-group-item">
								<div class="row menu-item">
									<div class="col-md-4 col-xs-4"><img src="images/logout.png" ></div>
									<div class="col-md-8 col-xs-8 col-centered"><h3><?php echo Localization::getString("menu.logout")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.logout.desc")?>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>




		</script>
				
				<script>
					function logout(){
						$.get("auth/logout", function(){
														location="index.php";
						});
						
					}
					function shutdown(){
						
						if (confirm('<?php echo Localization::getJSString("confirm.shutdown")?>')){
							$.ajax({
								  url: "system/status",  
								  dataType: 'json',
								  type:"POST",
								  data: "mode=off",
								});
						}
					}
				</script>
<?php
include "include/footer.php";
?>
