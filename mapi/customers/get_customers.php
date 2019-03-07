<?php
  include("../magento_api_connection.php");

  // TODO: Not working.
  for($i=1; $i<=1000; $i++){
    $response=$api->get("customers/".$i);
    print_r($response);
    echo "<br>";
  }
?>
