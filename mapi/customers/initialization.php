<?php
  include("../common_database_connection.php");

  $query="CREATE TABLE $magento_database.customer_group_mapping
    SELECT customer_group_id AS source_customer_group_id
    FROM $source_database.oc_customer_group_description
    ORDER BY source_customer_group_id ASC";
  if($connection->query($query)===TRUE){
    echo "Success: query.";
    echo "<br>";
  } else{
    echo "Error: query.";
    echo "<br>";
  }

  $query="ALTER TABLE $magento_database.customer_group_mapping
    ADD magento_customer_group_id VARCHAR(250)";
  if($connection->query($query)===TRUE){
    echo "Success: query.";
    echo "<br>";
  } else{
    echo "Error: query.";
    echo "<br>";
  }

  $query="CREATE TABLE $magento_database.customer_mapping
    SELECT customer_id AS source_customer_id
    FROM $source_database.oc_customer
    ORDER BY source_customer_id ASC";
  if($connection->query($query)===TRUE){
    echo "Success: query.";
    echo "<br>";
  } else{
    echo "Error: query.";
    echo "<br>";
  }

  $query="ALTER TABLE $magento_database.customer_mapping
    ADD magento_customer_id VARCHAR(250)";
  if($connection->query($query)===TRUE){
    echo "Success: query.";
    echo "<br>";
  } else{
    echo "Error: query.";
    echo "<br>";
  }
?>
