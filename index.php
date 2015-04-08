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

    FacebookSession::setDefaultApplication(APPID,APPSECRET);
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
    <?php
        $helper = new FacebookRedirectLoginHelper('https://guizmofbproject.herokuapp.com');
        $loginUrl = $helper->getLoginUrl(['email','user_birthday']);
        session_start();
    ?>
        <a href='<?php echo $loginUrl?>'>se connecter</a>
    <?php
    var_dump( $helper->getSessionFromRedirect());
    if(isset($_SESSION) && isset($_SESSION['fb_token'])){
        $session = new FacebookSession($_SESSION['fb_token']);
        echo "here";
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
    if ( isset( $session ) ) {

        // save the session
        $_SESSION['fb_token'] = $session->getToken();
        // create a session using saved token or the new one we generated at login
        $session = new FacebookSession( $session->getToken() );

        // graph api request for user data
        $request = new FacebookRequest( $session, 'GET', '/me' );
        $response = $request->execute();
        // get response
        $graphObject = $response->getGraphObject()->asArray();

        // print profile data
        echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';

        // print logout url using session and redirect_uri (logout.php page should destroy the session)
        echo '<a href="' . $helper->getLogoutUrl( $session, 'logout.php' ) . '">Logout</a>';

    } else {
        // show login url
        echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_birthday' ) ) . '">Login</a>';
    }

    ?>
        <p><a href='logout.php'>Log Out</a></p>
    </div>
    <div
        class="fb-like"
        data-share="true"
        data-width="450"
        data-show-faces="true">
    </div>

    </body>
</html>