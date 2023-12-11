<?php
  consoleMsg("database.php file LOADED!");

  // Step 1: Create a Database Connection
  $db_host = $APP_CONFIG['database_host'];
  $db_user = $APP_CONFIG['database_user'];
  $db_pass = $APP_CONFIG['database_pass'];
  $db_name = $APP_CONFIG['database_name'];
  $db_connection = @new mysqli($db_host, $db_user, $db_pass, $db_name);

  // Check the connection to make sure it is good
  if ($db_connection->connect_error) {
    echo 'Errno: '.$db_connection->connect_errno;
    echo '<br>';
    echo 'Error: '.$db_connection->connect_error;
    exit();
  }
  consoleMsg("Success: A proper connection to MySQL was made.");
  consoleMsg("Host Information: $db_connection->host_info");
  consoleMsg("Host Information: $db_connection->protocol_version");

  // $db_connection->close();
?>