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
 * File Name   : include/localization/fr.php
 *
 * Created     : 2015-11
 * Authors     : Zorglub42 <contact(at)zorglub42.fr>
 *
 * Description :
 *      Application strings (French)
 *--------------------------------------------------------
 * History     :
 * 1.0.0 - 2015-11-18 : Release of the file
*/

$strings["date.format"]="dd/MM/yyyy";
$strings["date.format.parseexact"]="dd/mm/yyyy";
$strings["locale"]="fr";
/* Global app labels */
$strings["app.title"]=gethostname();
$strings["connexion.invalid.creds"]="Mot de passe ou utilisateur non valides";
$strings["password.placeholder"]="Mot de passe";
$strings["username.placeholder"]="Utilisateur";

$strings["button.login"]="OK";

$strings["menu.start-stop"]="Arrêter";
$strings["menu.start-stop.desc"]="Arrêter proprement Framoise314 avant de le debrancher";
$strings["menu.health"]="Santé";
$strings["menu.health.desc"]="Etat de santé de " . gethostname() . " (anglais)"	;
$strings["menu.wifi"]="WIFI";
$strings["menu.wifi.desc"]="Définir le comportement WIFI (se raccorder a un réseau ou point d'accès)";
$strings["menu.settings"]="Avancés";
$strings["menu.settings.desc"]="Paramètres avancés (nom du dispositif, mot de passe....)";
$strings["menu.logout"]="Sortir";
$strings["menu.logout.desc"]="Se deconnecter de l'adminstration de " . gethostname();
$strings["menu.wifi.client"]="Client";
$strings["menu.wifi.client.desc"]="Définir les paramètres pour se raccorder à un réseau WIFI";
$strings["menu.wifi.hotspot"]="Point d'accès";
$strings["menu.wifi.hotspot.desc"]="Définir les paramètres pour transformer ". gethostname() . " en point d'accès WIFI";


$strings["wifi.client.title"]="Se raccorder au WIFI";
$strings["wifi.client.ssid"]="Nom (SSID)";
$strings["wifi.client.passphrase"]="Mot de passe";
$strings["wifi.client.bad-creds"]="Impossible de ce connecter a ce réseau";

$strings["wifi.hotspot.title"]="Caractéristiques du point d'accès";
$strings["wifi.hotspot.passphrase"]="Clef (mot de passe)";
$strings["wifi.hotspot.passphrase.placeholder"]="Saisir le mot de passe de protection du WIFI";
$strings["wifi.hotspot.if-gateway"]="Accès à internet via";
$strings["wifi.hotspot.pin"]="Code PIN de la carte SIM";
$strings["wifi.hotspot.if-gsm"]="GSM";
$strings["wifi.hotspot.if-ethernet"]="Ethernet (ou pas d'accès)";
$strings["wifi.hotspot.ethernet"]="Etendre sur ethernet";
$strings["wifi.hotspot.apn"]="Nom de l'APN";
$strings["wifi.hotspot.apn-user"]="Nom d'utilisateur de l'APN";
$strings["wifi.hotspot.apn-pass"]="Mot de passe";



$strings["system.settings.title"]="Paramètres de " . gethostname();
$strings["system.settings.hostname"]="Nom du dispositif";
$strings["system.settings.password"]="Mot de passe";



$strings["button.ok"]="OK";
$strings["button.cancel"]="Annuler";
$strings["button.test"]="OK";


$strings["confirm.shutdown"]="Eteindre " . gethostname() . " ?";
$strings["confirm.restart"]="Redemarrer " . gethostname() . " ?";

$strings["index.shutdown"]="Arrêt en cours";
$strings["index.shutdown.error"]="Erreur lors de la demande d'arrêt";


?>
