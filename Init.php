<?php

// Error Reporting

ini_set('display_errors', 'on');
error_reporting(E_ALL);

include 'admin/Connect.php';

$sessionUser = '';
if (isset($_SESSION['user'])) {
	$sessionUser = $_SESSION['user'];
}

// Routers 

$tpl    = 'includes/templates/';   // Template Directory
$lang   = 'Includes/Language/';    // Language Directory
$func   = 'Includes/function/';    // Function Directory
$css    = 'layout/css/';           // css Directory
$js     = 'layout/js/';            // js Directory




// Include The Important Files 

include $func .  'function.php';
include $lang .  'English.php';
include $tpl  .  'header.php';


