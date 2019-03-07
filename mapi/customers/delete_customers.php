<?php
  include("../magento_api_connection.php");

  for($i=2; $i<=1000; $i++){
    $response=$api->delete("customers/".$i);
    print_r($response);
  }
?>
