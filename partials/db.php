<?php
  $dbAddress="localhost"
  $dbUsername="";
  $dbPassword="";
  $dbName="test";
  $conn = mysql_connect($dbAddress, $dbUsername, $dbPassword, $dbName);
  if (!$conn) {
    die("<h1>Database connection failed</h1><br>Error:<br>" . mysql_error());
  }
  //mysql_select_db($dbName) or die(mysql_error());
  //mysql_set_charset('utf8');


  function runSQL($sql) {
    if($_SESSION['type'] == 0) {
      $logTable = "JSO_ADMINLOG";
    }
    elseif($_SESSION['type'] == 1) {
      $logTable = "JSO_ADMINLOG";
    }
    else {
      die("<h1>Invalid SQL Query</h1><br>Invalid type in runsql(" . $sql . ", " . $_SESSION['type'] . ")");
      return false;
    }

    $query = mysql_query($sql);

    if(!$query) {
      log("FAIL SQL Query: " . $sql . " Error: " . mysql_error());
    }
    else {
      log("SUCCESS SQL Query: " . $sql);
    }
    return $query;
  }

  function log($action) {
    if($_SESSION['type']== 0) { //ADMINLOG --> username
      $sql = "INSERT INTO JSO_ADMINLOG VALUES(USERNAME = '" . $_SESSION['username'] ."', ACTION = '" . $action . "')";
      mysql_query($sql); //Cannot handle error here
    }
    elseif($_SESSION['type'] == 1) { //STUDENTLOG --> id
      $sql = "INSERT INTO JSO_STUDENTLOG VALUES(ID = '" . $_SESSION['id'] ."', ACTION = '" . $action . "')";
      mysql_query($sql); //Cannot handle error here
    }
    else {
      die("<h1>Invalid SQL Query</h1><br>Invalid type in runsql(" . $sql . ", " . $_SESSION['type'] . ")");
      return 0;
    }




  }
?>
