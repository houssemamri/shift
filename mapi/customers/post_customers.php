<?php
  include("../magento_api_connection.php");
  include("../common_database_connection.php");

  $query="SELECT customer_id, firstname, lastname, address_1, address_2, city
    FROM $source_database.oc_address";
  $query_result=$connection->query($query);
  $query_result_row=mysqli_fetch_all($query_result, MYSQLI_ASSOC);

  foreach ($query_result_row as $row) {
    foreach ($row as $key => $value) {
      switch ($key) {
        case 'customer_id':
          $source_customer_id=$value;
          break;
        case 'firstname':
          $magento_customer_firstname=$value;
          break;
        case 'lastname':
          $magento_customer_lastname=$value;
          break;
        case 'address_1':
          $magento_customer_address1=$value;
          break;
        case 'address_2':
          $magento_customer_address2=$value;
          break;
        case 'city':
          $magento_customer_address_city=$value;
          break;
      }
    }
    $query="SELECT customer_group_id, email
      FROM $source_database.oc_customer
      WHERE customer_id=$source_customer_id";
    $query_result=$connection->query($query);
    $query_result_row=mysqli_fetch_assoc($query_result);
    $source_customer_group_id=$query_result_row['customer_group_id'];
    $magento_customer_email=$query_result_row['email'];

    $query="SELECT magento_customer_group_id
      FROM $magento_database.customer_group_mapping
      WHERE source_customer_group_id=$source_customer_group_id";
    $query_result=$connection->query($query);
    $query_result_row=mysqli_fetch_assoc($query_result);
    $magento_customer_group_id=$query_result_row['magento_customer_group_id'];

    echo "Source customer id: ".$source_customer_id."<br>Source customer group id: ".$source_customer_group_id."<br>Magento customer firstname: ".$magento_customer_firstname."<br>Magento customer lastname: ".$magento_customer_lastname."<br>Magento customer email: ".$magento_customer_email."<br>Magento customer address 1: ".$magento_customer_address1."<br>Magento customer address 2: ".$magento_customer_address2."<br>Magento customer address city: ".$magento_customer_address_city."<br>Magento customer group id: ".$magento_customer_group_id."<br><br><br><br><br>";

    $data=array(
      "customer" => array(
        'group_id'          => $magento_customer_group_id,
        'default_billing'   => $magento_customer_address1." ".$magento_customer_address2." ".$magento_customer_address_city,
        'default_shipping'  => $magento_customer_address1." ".$magento_customer_address2." ".$magento_customer_address_city,
        'email'             => $magento_customer_email,
        'firstname'         => $magento_customer_firstname,
        'lastname'          => $magento_customer_lastname,
        //'password'          => 'password'
      )
    );

    $response = $api->post("customers", $data);
    print_r($response);
    echo "<br>";

    foreach ($response as $key=>$value) {
      if($key=='id'){
        $magento_customer_id=$value;
        echo "Magento customer ID: ".$magento_customer_id;
        echo "<br>";
      }
    }

    $query="UPDATE $magento_database.customer_mapping
      SET magento_customer_id=$magento_customer_id
      WHERE source_customer_id=$source_customer_id";
    if($connection->query($query)===TRUE){
      echo "Success: query.";
      echo "<br><br><br><br><br>";
    } else{
      echo "Error: query.";
      echo "<br><br><br><br><br>";
    }
  }
?>
