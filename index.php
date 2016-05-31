<?php

define("_LOGPATH_", "logs/");

session_start();

require_once("class.debug.php");
include("class.page_controller.php");



$database = new "";




$myController = new FonController();

$myController->fonRequestCheck();
