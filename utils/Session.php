<?php
class Session {

    public static function isSecure() {
        // TODO FORCE TO SECURE IN PRODUCTION
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
    }

    public static function getDomain(){
        return $_SERVER['HTTP_HOST'];
    }

    public static function create($response,$username,$name,$salt,$panel = true){
        $time = time()+86400;
        if($panel){
            $_username = "_panel_username";
            $_name = "_panel_name";
            $_ninjaPower = "_panel_ninja_power";
            $_hash = "_panel_hash";
            $_user_ref = "_panel_user_ref";
            $_user_session = "_panel_user_session";
        } else {
            $_username = "_openctf_username";
            $_name = "_openctf_name";
            $_ninjaPower = "_openctf_ninja_power";
            $_hash = "_openctf_hash";
            $_user_ref = "_openctf_user_ref";
            $_user_session = "_openctf_user_session";
        }
        $response->cookie($_username,$username, $time,"/",Session::getDomain(),Session::isSecure());
        $response->cookie($_name,$name, $time,"/",Session::getDomain(),Session::isSecure());
        $response->cookie($_ninjaPower,Security::encrypt($time,$salt), $time,"/",Session::getDomain(),Session::isSecure());
        $hash = hash("sha256",$salt.$username.$time);
        $response->cookie($_hash,$hash, $time,"/",Session::getDomain(),Session::isSecure());
        $response->cookie($_user_session,Security::getSalt(), $time,"/",Session::getDomain(),Session::isSecure());
        $response->cookie($_user_ref,$username,$time+(86400*30),"/",Session::getDomain(),Session::isSecure());
    }

    public static function destroy($response,$panel = true){
        $time = time()-86400;
        if($panel){
            $_username = "_panel_username";
            $_name = "_panel_name";
            $_ninjaPower = "_panel_ninja_power";
            $_hash = "_panel_hash";
        } else {
            $_username = "_openctf_username";
            $_name = "_openctf_name";
            $_ninjaPower = "_openctf_ninja_power";
            $_hash = "_openctf_hash";
        }
        $response->cookie($_username,null, $time,"/",Session::getDomain(),Session::isSecure());
        $response->cookie($_name,null, $time,"/",Session::getDomain(),Session::isSecure());
        $response->cookie($_ninjaPower,null, $time,"/",Session::getDomain(),Session::isSecure());
        $response->cookie($_hash,null,$time,"/",Session::getDomain(),Session::isSecure());
    }

    public static function getCurrentSiteUser(){
        return (isset($_COOKIE["_openctf_username"])?$_COOKIE["_openctf_username"]:null);
    }

    public static function getCurrentSiteUserName(){
        return (isset($_COOKIE["_openctf_name"])?$_COOKIE["_openctf_name"]:null);
    }

    public static function getCurrentPanelUser(){
        return (isset($_COOKIE["_panel_username"])?$_COOKIE["_panel_username"]:null);
    }

    public static function getCurrentPanelUserName(){
        return (isset($_COOKIE["_panel_name"])?$_COOKIE["_panel_name"]:null);
    }

    public static function isValid($response,$username = "",$salt = "",$panel = true){
        if($panel){
            $_username = "_panel_username";
            $_name = "_panel_name";
            $_ninjaPower = "_panel_ninja_power";
            $_hash = "_panel_hash";
            $_user_ref = "_panel_user_ref";
        } else {
            $_username = "_openctf_username";
            $_name = "_openctf_name";
            $_ninjaPower = "_openctf_ninja_power";
            $_hash = "_openctf_hash";
            $_user_ref = "_openctf_user_ref";
        }
        $response->cookie($_user_ref,$username,time()+(86400*30),"/",Session::getDomain(),Session::isSecure());
        if($username == "" && $salt == "") {
            if(isset($_COOKIE[$_username])&&isset($_COOKIE[$_name])&&isset($_COOKIE[$_ninjaPower])&&isset($_COOKIE[$_hash])) {
                return true;
            }
        }
        if(isset($_COOKIE[$_username])&&isset($_COOKIE[$_name])&&isset($_COOKIE[$_ninjaPower])&&isset($_COOKIE[$_hash])) {
            if($username == $_COOKIE[$_username]) {
                $time = Security::decrypt($_COOKIE[$_ninjaPower],$salt);
                $hash = hash("sha256", $salt . $username . $time);
                if($hash == $_COOKIE[$_hash]){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
} 