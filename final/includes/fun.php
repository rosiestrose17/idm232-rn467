<?php
consoleMsg("fun.php file LOADED!");

// DEFINE ALL GLOBAL VARS HERE
global $APP_CONFIG;

function consoleMsg($msg) {
  echo '<script type="text/javascript">console.log("'. $msg .'");</script>';
}
?>