<?php
$root = $_SERVER['DOCUMENT_ROOT'];
// COMPOSER AUTOLOAD
require_once($root."/vendor/autoload.php");
// THIRD PARTY LIBRARIES
require_once($root."/libs/db.class.php");
// CUSTOM UTILITY CLASSES
require_once($root."/utils/dbconnect.php");
require_once($root."/utils/security.class.php");
require_once($root."/utils/Session.php");
require_once($root."/libs/Inflector.php");
require_once($root."/utils/commons.php");