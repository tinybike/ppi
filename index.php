<?php
session_start();

// Set development and live server roots
include_once('setpath.php');

// Load controller
include_once('controller/Controller.php');

/**
* User navigation is always passed through index.php.  First, the controller is
* instantiated, then its invoke() method is called, which either does a full
* page load or an AJAX request.
*/
$controller = new Controller();
$controller->invoke();
