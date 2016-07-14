<?php


//================================================
//          Session start and defines
//================================================

session_start();

define("_LOGPATH_", "logs/");

define("PDOdriver", "mysql");
define("PDOhost", "fdb15.freehostingeu.com");
define("PDOuser", "2144003_wiki");
define("PDOpass", "H8l711t99a");
define("PDOdatabase", "2144003_wiki");

//================================================
//   Files Required for the controller to work
//================================================

require_once("classes/class.page_controller.php");
require_once("classes/class.pdo.php");
require_once("classes/class.db.php");

//================================================
//   Controller objects creation and start-up
//================================================

$myController = new FonController();

$myController->checkRequest();