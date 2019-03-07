<?php
  include("../magento_api_connection.php");

  $response=$api->get("categories");
  print_r($response);
?>
