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
 * File Name   : wifi-hotspot.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Define settings to set ZorgBox as Wifi and Ethernet Hotspot
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/
include "include/header.php";

$settings=json_decode(file_get_contents("/etc/zorgbox/network.json"), true);
if ($settings["eth0Mode"]=="hotspot"){
	$ethHotspot="true";
}else{
	$ethHotspot="false";
}
?>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><b><?php echo Localization::getString("wifi.hotspot.title")?></b></h3>
			</div>
			<div class="panel-body">
				<form accept-charset="UTF-8" role="form">
					<fieldset>
						
						<div class="form-group">
							<div class="col-md-12">	
								<label><?php echo Localization::getString("wifi.hotspot.passphrase")?></label>
							</div>
							<div class="col-md-12">
								<input type="password" id="pass" class="form-control" value="<?php echo $settings["hotspotPASS"]?>">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-12"><label><?php echo Localization::getString("wifi.hotspot.if-gateway")?></label></div>
							<div class="col-md-6">
								<div class="input-group">
									  <span class="input-group-addon">
										<input type="radio" name="if-gateway" id="ppp0" value="ppp0" onclick="additionalSettings()">
									  </span>
									  <label for="ppp0" class="form-control"><?php echo Localization::getString("wifi.hotspot.if-gsm")?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-group">
									  <span class="input-group-addon">
										<input type="radio" name="if-gateway" id="eth0" value="eth0" onclick="additionalSettings()">
									  </span>
									  <label for="eth0" class="form-control"><?php echo Localization::getString("wifi.hotspot.if-ethernet")?></label>
								</div>
							</div>
						</div>
						<div id="additionalSettings" style="display: none">
							<div class="col-md-12">
								<hr>
							</div>
							<div class="form-group">
								<div class="col-md-12">
									<div class="input-group">
										  <span class="input-group-addon">
											<input type="checkbox" id="cbEth">
										  </span>
										  <label for="cbEth" class="form-control"><?php echo Localization::getString("wifi.hotspot.ethernet")?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">	
									<hr>
									<label><?php echo Localization::getString("wifi.hotspot.pin")?></label>
								</div>
								<div class="col-md-12">
									<input type="password" id="pin" class="form-control" value="<?php echo $settings["pin"]?>">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">	
									<label><?php echo Localization::getString("wifi.hotspot.apn")?></label>
								</div>
								<div class="col-md-12">
									<input type="text" id="apn" class="form-control" value="<?php echo $settings["APN"]?>">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">	
									<label><?php echo Localization::getString("wifi.hotspot.apn-user")?></label>
								</div>
								<div class="col-md-12">
									<input type="text" id="apn-user" class="form-control" value="<?php echo $settings["APNUser"]?>">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12">	
									<label><?php echo Localization::getString("wifi.hotspot.apn-pass")?></label>
								</div>
								<div class="col-md-12">
									<input type="password" id="apn-pass" class="form-control" value="<?php echo $settings["APNPass"]?>">
								</div>
							</div>
						</div>
					</fieldset>

				</form>
			</div>
			<div class="panel-footer">
					<div class="row">
						<div class="col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3">
							<button type="button" class="btn btn-default" id="setHotspot" onclick="setHotspot()">
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
	function setHotspot(){
		showWait();
		params="pass=" + encodeURI($("#pass").val()) 
		     + "&gw=" + encodeURI($('input[name=if-gateway]:checked').val()	) 
		     + "&pin=" + encodeURI($("#pin").val()) 
		     + "&apn=" + encodeURI($("#apn").val()) 
		     + "&apnUser=" + encodeURI($("#apn-user").val()) 
		     + "&apnPass=" + encodeURI($("#apn-pass").val());
		if ($('#cbEth').prop('checked')){
			params=params+ "&ethMode=hotspot";
		}
		$.ajax({
			  url: "/wifi/hotspot",  
			  dataType: 'json',
			  type:"POST",
			  data: params,
			  success: function () {
									hideWait();
									location="index.php";
									},
			  error: function () {
									hideWait();
									alert('KBoom');
								}
			});
	}
	function additionalSettings(){
		if ($('input[name=if-gateway]:checked').val()=="ppp0"){
			$("#additionalSettings").show();
		}else{
			$("#additionalSettings").hide();
		}
	}

	$("input[name=if-gateway][value=<?php echo $settings["ifGw"]?>]").prop('checked', true);
	$('#cbEth').prop('checked', <?php echo $ethHotspot ?>);
	additionalSettings();
</script>
<?php
include "include/footer.php";
?>
