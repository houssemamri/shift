<?php
  $host='localhost';
  $username='root';
  $password='';
  $connection=new mysqli($host,$username,$password);
  if($connection->connect_error){
    die("Error: connection: ".$connection->connect_error);
    echo "<br>";
  } else{
    echo "Success: connection.";
    echo "<br>";
  }

  $source_database="eleven";
  $magento_database="one";
?>
