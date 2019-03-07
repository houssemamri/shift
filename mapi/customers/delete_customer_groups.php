<?php
  include("../magento_api_connection.php");
  include("../common_database_connection.php");

  for($i=16; $i<=1000; $i++){
    $response=$api->delete("customerGroups/".$i);
    print_r($response);
  }
?>
