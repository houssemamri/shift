<?php
  include("../magento_api_connection.php");

  for($i=41; $i<=1000; $i++){
    $response=$api->delete("categories/".$i);
    print_r($response);
    echo "<br>";
  }
?>
