<?php

  session_start();     // Start The Session
  
  session_unset();     // Uset The Data
  
  session_destroy();   // Destory The Session
  
  header('location: index.php');
  
  exit();