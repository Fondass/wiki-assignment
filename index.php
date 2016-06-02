<?php

define("_LOGPATH_", "logs/");

define("PDOdriver", "mysql");
define("PDOhost", "localhost");
define("PDOuser", "root");
define("PDOpass", "");
define("PDOdatabase", "wiki");

session_start();

require_once("classes/class.debug.php");
require_once("classes/class.pdo.php");
include("classes/class.page_controller.php");



//$database = new "";




$myController = new FonController();

$myController->fonRequestCheck();
