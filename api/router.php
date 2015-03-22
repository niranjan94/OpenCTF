<?php
// COMPOSER AUTOLOAD
require_once($_SERVER['DOCUMENT_ROOT']."/includes.php");
require_once("commons.php");

header('Content-Type: application/json');

$base  = dirname($_SERVER['PHP_SELF']);
if(ltrim($base, '/')){
    $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($base));
}

if(empty($_GET['hash'])) {
    //throwUnauth());
} else {
    if(!verifyHash($_GET['hash'])){
        //throwUnauth());
    }
}

function respond($result){
    return json_encode($result);
}

function verifyAuth($response) {
    if(!Session::isValid($response)){
        throwUnauth();
    }
}

$klein = new \Klein\Klein();

$requestType = array("POST");

$klein->respond('POST', '/', function () {
    sleep(1);
    $result = array(
        "status" => "ok",
        "time" => time()
    );
    return json_encode($result);
});

$klein->onHttpError(function ($code, $router) {
    if ($code >= 400 && $code < 500) {
        $router->response()->body(throwErrorCode($code));
    } elseif ($code >= 500 && $code <= 599) {
        $router->response()->body(throwErrorCode($code));
    }
});

$klein->dispatch();