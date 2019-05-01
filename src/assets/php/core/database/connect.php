<?php
#region Create pdo connection
//* Define password

//* Try connecting...
try {
  //* Create PDO object
  $dfPDO = new PDO(
    'mysql:host=;dbname=;charset=',
    '',
    $_ENV['df_SQL_Password'],
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
  );

  //* Make it public
  global $dfPDO;

  //* If error, show it
  $dfPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOExeption $e) {
  //* Replace password if found
  $pdoError = str_replace($_ENV['df_SQL_Password'], "", getMessage());
  //* Output error
  echo $e . $pdoError;
}
#endregion
?>