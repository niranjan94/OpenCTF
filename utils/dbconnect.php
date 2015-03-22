<?php
if(isset($isCron)&&$isCron==true){
    require_once("/data/anokha/config.php");
} else {
    require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
}
// DATABASE CONFIGURATION
DB::$user = MYSQL_USER;
DB::$password = MYSQL_PASSWORD;
DB::$host = MYSQL_HOST;
DB::$port = MYSQL_PORT;
DB::$encoding = MYSQL_ENCODING;
DB::$dbName = MYSQL_DB;