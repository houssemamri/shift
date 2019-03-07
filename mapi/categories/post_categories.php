<?php
  include("../magento_api_connection.php");
  include("../common_database_connection.php");

  $query="SELECT category_id, name, parent_id
    FROM $source_database.oc_category_description JOIN $source_database.oc_category USING (category_id)
    ORDER BY parent_id ASC";
  $query_result=$connection->query($query);
  $query_result_rows=mysqli_fetch_all($query_result, MYSQLI_ASSOC);

  foreach ($query_result_rows as $row) {
    foreach ($row as $key => $value) {
      switch ($key) {
        case 'category_id':
          $source_category_id=$value;
          break;
        case 'name':
          $magento_category_name=$value;
          break;
        case 'parent_id':
          $source_category_parent=$value;
          break;
      }
    }
    echo "Source category id: ".$source_category_id."<br>Magento category name: ".$magento_category_name."<br>Source category parent: ".$source_category_parent."<br>";

    if($source_category_parent==0){
      $magento_category_parent=2;

      $data=array(
        "category" => array(
          'name'              => $magento_category_name,
          'parent_id'         => $magento_category_parent,
          'is_active'         => TRUE
        )
      );

      $response = $api->post("categories", $data);
      print_r($response);
      echo "<br>";
      foreach ($response as $key => $value) {
        if($key=='id'){
          $magento_category_id=$value;
          echo "Magento category id: ".$magento_category_id."<br>Magento category name: ".$magento_category_name."<br>Magento category parent: ".$magento_category_parent."<br>";
        }
      }

      $query="UPDATE $magento_database.product_category_mapping
        SET magento_category_id=$magento_category_id,
            magento_category_parent=$magento_category_parent
        WHERE source_category_id=$source_category_id";
      if($connection->query($query)===TRUE){
        echo "Success: query.";
        echo "<br><br><br><br><br>";
      } else{
        echo "Error: query.";
        echo "<br><br><br><br><br>";
      }
    } else{
      $query="SELECT magento_category_id
        FROM $magento_database.product_category_mapping
        WHERE source_category_id=$source_category_parent";
      $query_result=$connection->query($query);
      $query_result_row=mysqli_fetch_assoc($query_result);
      $magento_category_parent=$query_result_row['magento_category_id'];

      $data=array(
        "category" => array(
          'name'              => $magento_category_name,
          'parent_id'         => $magento_category_parent,
          'is_active'         => TRUE
        )
      );

      $response = $api->post("categories", $data);
      print_r($response);
      echo "<br>";
      foreach ($response as $key => $value) {
        if($key=='id'){
          $magento_category_id=$value;
          echo "Magento category id: ".$magento_category_id."<br>Magento category name: ".$magento_category_name."<br>Magento category parent: ".$magento_category_parent."<br>";
        }
      }

      $query="UPDATE $magento_database.product_category_mapping
        SET magento_category_id=$magento_category_id,
            magento_category_parent=$magento_category_parent
        WHERE source_category_id=$source_category_id";
      if($connection->query($query)===TRUE){
        echo "Success: query.";
        echo "<br><br><br><br><br>";
      } else{
        echo "Error: query.";
        echo "<br><br><br><br><br>";
      }
    }
  }
?>
