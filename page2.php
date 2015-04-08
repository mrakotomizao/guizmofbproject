<?php
/**
 * Created by PhpStorm.
 * User: Guizmo
 * Date: 07/04/2015
 * Time: 11:55
 */
var_dump($_SESSION);
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