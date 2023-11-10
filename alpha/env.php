<?php
  consoleMsg("env.php file LOADED!");

  // Specific to the current environment you're on.
  $APP_CONFIG = [
    'environment' => 'local',
    'site_url' => 'http://localhost:8888/',
    'database_host' => 'localhost',
    'database_user' => 'root',
    'database_pass' => 'root',
    'database_name' => 'idm232',
  ];
?>