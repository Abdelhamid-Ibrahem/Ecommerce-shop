<?php

include 'Connect.php';

// Routers 

$tpl    = 'includes/templates/';   // Template Directory
$lang   = 'Includes/Language/';    // Language Directory
$func   = 'Includes/function/';    // Function Directory
$css    = 'layout/css/';           // css Directory
$js     = 'layout/js/';            // js Directory




// Include The Important Files 

include $func . 'function.php';
include $lang . 'English.php';
include $tpl  . 'header.php';

// Include Navbar On All Page Expect The One With $noNavbar Vairable 

//if (!isset($noNavbar)) { include $tpl ; }
   