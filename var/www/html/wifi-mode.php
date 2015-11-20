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
 * File Name   : wifi-mode.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Choose wifi mode (Client vs hotspot)
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
include "include/header.php";

$settings=json_decode(file_get_contents("/etc/zorgbox/network.json"), true);
if ($settings["wlan0Mode"]=="hotspot"){
	$hotspot="true";
	$clientClass="";
	$hotspotClass="wifiModeSelected";
}else{
	$hotspotClass="";
	$clientClass="wifiModeSelected";
}

?>
				<div class="list-group">
					<div class="col-md-4 col-xs-12">
						<div class="panel panel-default <?php echo $clientClass?>">
							<a href="wifi-client.php" class="list-group-item">
								<div class="row menu-item">
									<div class="col-md-4 col-xs-4"><img src="images/wifi-client.png" ></div>
									<div class="col-md-8 col-xs-8 col-centered"><h3><?php echo Localization::getString("menu.wifi.client")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.wifi.client.desc")?>
									</div>
								</div>
							</a>
						</div>
					</div>
					<div class="col-md-4 col-xs-12">
						<div class="panel panel-default <?php echo $hotspotClass?>">
							<a href="wifi-hotspot.php" class="list-group-item">
								<div class="row menu-item">
									<div class="col-md-4 col-xs-4"><img src="images/wifi-hotspot.png" ></div>
									<div class="col-md-8 col-xs-8 col-centered"><h3><?php echo Localization::getString("menu.wifi.hotspot")?></h3></div>
									<div class="col-md-12">
										<hr>
										<?php echo Localization::getString("menu.wifi.hotspot.desc")?>
									</div>
</div>
							</a>
						</div>
					</div>
<?php
include "include/footer.php";
?>
