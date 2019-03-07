<?php
  include("../common_database_connection.php");

  $query="CREATE TABLE $magento_database.product_mapping (
      source_product_id VARCHAR(250),
      magento_product_id VARCHAR(250)
    )";
  if($connection->query($query)===TRUE){
    echo "Success: query.";
  } else{
    echo "Error: query.";
  }

?>
