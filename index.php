<?php

define("_LOGPATH_", "logs/");

define("PDOdriver", "mysql");
define("PDOhost", "fdb15.freehostingeu.com");
define("PDOuser", "2144003_wiki");
define("PDOpass", "H8l711t99a");
define("PDOdatabase", "2144003_wiki");


require_once("classes/class.debug.php");
include("classes/class.page_controller.php");
require_once("classes/class.pdo.php");

$myController = new FonController();

$myController->requestCheck();
