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
