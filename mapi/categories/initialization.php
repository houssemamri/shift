<?php
  include("../common_database_connection.php");

  $query="CREATE TABLE $magento_database.product_category_mapping
    SELECT category_id AS source_category_id, parent_id AS source_category_parent
    FROM $source_database.oc_category_description JOIN $source_database.oc_category USING (category_id)
    ORDER BY source_category_parent ASC";
  if($connection->query($query)===TRUE){
    echo "Success: query.";
    echo "<br>";
  } else{
    echo "Error: query.";
    echo "<br>";
  }

  $query="ALTER TABLE $magento_database.product_category_mapping
    ADD magento_category_id VARCHAR(250),
    ADD magento_category_parent VARCHAR(250)";
  if($connection->query($query)===TRUE){
    echo "Success: query.";
  } else{
    echo "Error: query.";
  }
?>
