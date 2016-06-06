<?php

define("_LOGPATH_", "logs/");

define("PDOdriver", "mysql");
define("PDOhost", "localhost");
define("PDOuser", "sybren");
define("PDOpass", "103225");
define("PDOdatabase", "wiki");


require_once("classes/class.debug.php");
include("classes/class.page_controller.php");
require_once("classes/class.pdo.php");

$myController = new FonController();

$myController->fonRequestCheck();
