<?php
  include("../magento_api_connection.php");

  $response=$api->get("products/24-WB04");
  print_r($response);
?>
