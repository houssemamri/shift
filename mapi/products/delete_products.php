<?php
  include("../magento_api_connection.php");

  for($i=28; $i<=1000; $i++){
    $response=$api->delete("products/".$i);
    print_r($response);
    echo "<br>";
  }
?>
