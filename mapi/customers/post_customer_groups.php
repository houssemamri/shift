<?php
  include("../magento_api_connection.php");
  include("../common_database_connection.php");

  $query="SELECT customer_group_id, name
    FROM $source_database.oc_customer_group_description
    ORDER BY customer_group_id ASC";
  $query_result=$connection->query($query);
  $query_result_row=mysqli_fetch_all($query_result, MYSQLI_ASSOC);

  foreach ($query_result_row as $row) {
    foreach ($row as $key => $value) {
      switch ($key) {
        case 'customer_group_id':
          $source_customer_group_id=$value;
          break;
        case 'name':
          $magento_customer_group_name=$value;
          break;
      }
    }
    echo "Source customer group id: ".$source_customer_group_id."<br>Magento customer group name: ".$magento_customer_group_name."<br>";

    $data=array(
      "group" => array(
        'code'              => $magento_customer_group_name
      )
    );

    $response=$api->post("customerGroups", $data);
    print_r($response);
    echo "<br>";
    foreach ($response as $key=>$value) {
      if($key=='id'){
        $magento_customer_group_id=$value;
        echo "Magento customer group ID: ".$magento_customer_group_id;
        echo "<br>";
      }
    }
    $query="UPDATE $magento_database.customer_group_mapping
      SET magento_customer_group_id=$magento_customer_group_id
      WHERE source_customer_group_id=$source_customer_group_id";
    if($connection->query($query)===TRUE){
      echo "Success: query.";
      echo "<br><br><br><br><br>";
    } else{
      echo "Error: query.";
      echo "<br><br><br><br><br>";
    }
  }
?>
