<?php
  include("../magento_api_connection.php");

  for($i=0; $i<=1000; $i++){
    $response=$api->get("orders/".$i);
    print_r($response);
  }
?>
