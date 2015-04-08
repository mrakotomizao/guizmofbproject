<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    require_once( 'Facebook/FacebookHttpable.php' );
    require_once( 'Facebook/FacebookCurl.php' );
    require_once( 'Facebook/FacebookCurlHttpClient.php' );
    require_once( 'Facebook/FacebookSession.php' );
    require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
    require_once( 'Facebook/FacebookRequest.php' );
    require_once( 'Facebook/FacebookResponse.php' );
    require_once( 'Facebook/FacebookSDKException.php' );
    require_once( 'Facebook/FacebookRequestException.php' );
    require_once( 'Facebook/FacebookOtherException.php' );
    require_once( 'Facebook/FacebookAuthorizationException.php' );
    require_once( 'Facebook/GraphObject.php' );
    require_once( 'Facebook/GraphSessionInfo.php' );
    // added in v4.0.5
    use Facebook\FacebookHttpable;
    use Facebook\FacebookCurl;
    use Facebook\FacebookCurlHttpClient;

    // added in v4.0.0
    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    use Facebook\FacebookResponse;
    use Facebook\FacebookSDKException;
    use Facebook\FacebookRequestException;
    use Facebook\FacebookOtherException;
    use Facebook\FacebookAuthorizationException;
    use Facebook\GraphObject;
    use Facebook\GraphSessionInfo;

    const APPID =   "1631679237055563";
    const APPSECRET = "0b4c58002161d29e819d3f22cba58c82";
    session_start();

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