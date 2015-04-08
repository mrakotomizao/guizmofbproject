<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);



    session_start();

    require "facebook-php-sdk-v4-4.0/autoload.php";

    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;




    const APPID = "1631679237055563";
    const APPSECRET = "81ec70f0f0c5c3671b1cb22acc15c091";

    FacebookSession::setDefaultApplication(APPID, APPSECRET);

    $helper = new FacebookRedirectLoginHelper('https://guizmofbproject.herokuapp.com/');

    if( isset($_SESSION) &&  isset($_SESSION['fb_token']))
    {
      $session  = new FacebookSession($_SESSION['fb_token']);
    }else
    {
      $session = $helper->getSessionFromRedirect();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Titre de ma page</title>
        <meta name="description" content="description de ma page">

    </head>
    <body>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                  appId      : '<?php echo APPID;?>',
                  xfbml      : true,
                  version    : 'v2.3'
                });
            };

            (function(d, s, id){
                 var js, fjs = d.getElementsByTagName(s)[0];
                 if (d.getElementById(id)) {return;}
                 js = d.createElement(s); js.id = id;
                 js.src = "//connect.facebook.net/fr_FR/sdk.js";
                 fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <h1>Mon application facebook</h1>

        <div
          class="fb-like"
          data-share="true"
          data-width="450"
          data-show-faces="true">
        </div>
        <br>
        <div class="fb-comments" data-href="https://guizmofbproject.herokuapp.com/" data-numposts="5" data-colorscheme="light"></div>
        <br>

        <?php

        if($session)
        {

            $token = (string) $session->getAccessToken();
            $_SESSION['fb_token'] = $token;

            //Prepare
            $request = new FacebookRequest($session, 'GET', '/me');
            //execute
            $response = $request->execute();
            //transform la data graphObject
            $user = $response->getGraphObject("Facebook\GraphUser");


        }else{
            $loginUrl = $helper->getLoginUrl(["email"]);
            echo "<a href='".$loginUrl."'>Se connecter</a>";
        }

        ?>
    </body>
</html>



