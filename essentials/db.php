<?php
$config = parse_ini_file("{$_SERVER['DOCUMENT_ROOT']}/../db.ini");

$db = new PDO("{$config['driver']}:dbname={$config['dbname']};host={$config['host']};charset={$config['charset']}", $config['username'], $config['password']);

if (!$db) {
  die("<h1>Database connection failed</h1><br>Error:<br>" . mysql_error());
}

function runSQL($sql, $args) {
  /*
  * $sql  : Parametered statement. Parametes should be written as ":parameter_name"
  * $args : Associative array of parameters. Syntax: array(":parameter_name" => "value", ...)
  */
  global $db;
  $query = $db->prepare($sql);

  if(!$query -> execute($args)) {
    writeLOG("FAIL SQL Query: " . $sql . " Error: " . $db->errorCode());
  }
  else {
    writeLOG("SUCCESS SQL Query: " . $sql);
  }
  return $query;
  /*
  * For select statements, fetch or fetchAll functions should be called on $query
  */
}

function writeLOG($action) {
  global $db;
  if($_SESSION['type'] == 0) { //ADMINLOG --> username
    $logq = $db->prepare("INSERT INTO JSO_ADMINLOG VALUES(USERNAME = ':username', ACTION = ':action')");
    $logq->execute(array(':username' => $_SESSION['username'], ':action' => $action)); //Cannot handle error here
  }
  elseif($_SESSION['type'] == 1) { //STUDENTLOG --> id
    $logq = $db->prepare("INSERT INTO JSO_STUDENTLOG VALUES(ID = ':username', ACTION = ':action')");
    $logq->execute(array(':username' => $_SESSION['id'], ':action' => $action)); //Cannot handle error here
  }
  else {
    die("<h1>Invalid SQL Query</h1><br>Invalid type in runsql(" . $sql . ", " . $_SESSION['type'] . ")");
    /*
    * This cannot stay in production phase.
    * Printing out sql statment is not safe!
    */
  }
}

?>