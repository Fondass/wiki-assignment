<?php

define("_LOGPATH_", "logs/");

session_start();

require_once("classes/class.debug.php");
require_once("classes/class.pdo.php");
include("classes/class.page_controller.php");



//$database = new "";




$myController = new FonController();

$myController->fonRequestCheck();
