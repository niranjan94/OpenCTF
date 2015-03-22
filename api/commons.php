<?php
function throwUnauth(){
    header('HTTP/1.1 401 Unauthorized');
    $result = array(
        "status" => "Unauthorized",
        "time" => time()
    );
    die(json_encode($result));
}
function throwErrorCode($code){
    $result = array(
        "status" => "Error Code: ".$code,
        "time" => time()
    );
    return json_encode($result);
}
function throw404(){
    header('HTTP/1.1 404 Not Found');
    $result = array(
        "status" => "Not Found",
        "time" => time()
    );
    die(json_encode($result));
}

function verifyHash($hash){
    return true;
}
