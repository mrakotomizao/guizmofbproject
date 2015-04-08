<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require "facebook-php-sdk-v4-4.0-dev/autoload.php";
require "vendor/autoload.php";

const APPID =   "1631679237055563";
const APPSECRET = "0b4c58002161d29e819d3f22cba58c82";

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequestException;
session_start();
FacebookSession::setDefaultApplication(APPID,APPSECRET);
$urlRedirected = 'https://guizmofbproject.herokuapp.com/page2.php';
$helper = new FacebookRedirectLoginHelper($urlRedirected);
$loginUrl = $helper->getLoginUrl();
?>
