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
 * File Name   : wifi-client.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Define settings to set ZorgBox as Wifi and Ethernet Client
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/include "include/header.php";
?>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><b><?php echo Localization::getString("wifi.client.title")?></b></h3>
			</div>
			<div class="panel-body">
				<form accept-charset="UTF-8" role="form">
					<fieldset>
						<div class="form-group">
							<label><?php echo Localization::getString("wifi.client.ssid")?></label>
							<div class="list-group" id="data" >
								<div  id="rowTpl" style="display:none">
								<a class="list-group-item row" onclick="getSSIDKey('{ssidList[i].ssid}', this)">
									<div class="col-xs-2 col-md-2" title="{ssidList[i].ssid}"><img src="images/wifi-level-{ssidList[i].quality}.png" title="{ssidList[i].ssid}"></div>
									<div class="col-xs-4 col-md-4" title="{ssidList[i].ssid}">{ssidList[i].ssid}</div>
								</a>
								</div>
							</div>
						</div>
					</fieldset>

				</form>
			</div>
			<div class="panel-footer">
					<div class="row">
						<div class="col-md-2 col-md-offset-5 col-xs-6 col-xs-offset-3">
							<button type="button" class="btn btn-info" onclick="location='index.php'">
								<span><?php echo Localization::getString("button.cancel")?></span>
							</button>
						</div>
					</div>
			</div>
		</div>
	<div>
</div>



<div id="dialog" title="<?php echo Localization::getString("wifi.client.passphrase")?>" style="display:none">
	<div class="content">
		<div class="panel-body">
			<form accept-charset="UTF-8" role="form">
				<fieldset>
					<div class="form-group">
						<input type="password" id="passphrase" class="form-control">
					</div>
				</fieldset>
			</form>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-default" onclick="saveWifiClient()">
							<span><?php echo Localization::getString("button.test")?></span>
						</button>
						<button type="button" class="btn btn-info" onclick="$('#dialog').dialog('close')">
							<span><?php echo Localization::getString("button.cancel")?></span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
		var wifi_ssid;
		var wifi_pass;
		
		
		
		
		function saveWifiClient(){
				showWait();
				wifi_pass=document.getElementById("passphrase").value;

				params="ssid=" + encodeURI(wifi_ssid) + "&pass=" + encodeURI(wifi_pass	);
				$.ajax({
					  url: "/wifi/client",  
					  dataType: 'json',
					  type:"POST",
					  data: params,
					  success: function () {
											hideWait();
											location="index.php";
											},
					  error: function () {
											hideWait();
											alert('<?php echo Localization::getJSString("wifi.client.bad-creds")?>')
										}
					});
		}	
	    function getSSIDKey(ssid, button){
			$("#dialog").dialog({
					modal: true,
					position: { my: "left top", at: "left bottom", of: button }
				});
			wifi_ssid=ssid;

		}
		function startLoadSSIDs(){
			showWait();
			$.getJSON("wifi/ssid/", poplulateSSID).error(displayError);
		}
		
		function poplulateSSID(ssidList){
			hideWait();
			table=document.getElementById("data");
			rowPattern=document.getElementById("rowTpl");
			table.removeChild(rowPattern);

			for (i=0;i<ssidList.length;i++){

				
				newRow=rowPattern.cloneNode(true);
				newRow.removeAttribute('id');
				newRow.removeAttribute('style');
				newRow.innerHTML=newRow.innerHTML.replaceAll("{ssidList[i].ssid}", ssidList[i].ssid)
												 .replaceAll("{ssidList[i].quality}", ssidList[i].quality);
				table.appendChild(newRow);
			}
		}
		startLoadSSIDs();
</script>
<?php
include "include/footer.php";
?>
