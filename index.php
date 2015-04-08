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
$urlRedirected = 'https://guizmofbproject.herokuapp.com';
$helper = new FacebookRedirectLoginHelper($urlRedirected);
var_dump($_SESSION);
$loginUrl = $helper->getLoginUrl();
if(isset($_SESSION) && isset($_SESSION['fb_token'])){
    $session = new FacebookSession($_SESSION['fb_token']);
}else{
    try {
        $session = $helper->getSessionFromRedirect();
    } catch(FacebookRequestException $ex) {
        echo "facebook error : ".$ex->getMessage();
    } catch(\Exception $ex) {
        echo "validation fail : ".$ex->getMessage();
    }
    if ($session) {
        echo "logged";
    }else{
        echo "can't login";
    }
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '1631679237055563',
                xfbml      : true,
                version    : 'v2.3'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
</head>
<body>
<header><p>TEST FBPROJECT</p></header>
<div>
    <a href='<?php echo $loginUrl?>'>se connecter</a>
</div>
<div
    class="fb-like"
    data-share="true"
    data-width="450"
    data-show-faces="true">
</div>

</body>
</html>