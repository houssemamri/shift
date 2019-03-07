<?php
  include("../magento_api_connection.php");
  include("../common_database_connection.php");

  $curl=curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL=>$source_url."index.php?route=api/product",
    CURLOPT_RETURNTRANSFER=>true,
    CURLOPT_ENCODING=>"",
    CURLOPT_MAXREDIRS=>10,
    CURLOPT_TIMEOUT=>30,
    CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST=>"GET",
    CURLOPT_HTTPHEADER=>array(
        "cache-control: no-cache",
    ),
  ));
  $response=curl_exec($curl);
  $error=curl_error($curl);
  curl_close($curl);
  if($error){
    echo "cURL error: ".$error;
    echo "<br>";
  } else{
      $array=json_decode($response);
      print_r($array);
      echo "<br><br><br><br><br>";

      foreach($array->products as $row){
        foreach($row as $key=>$value){
          switch($key){
            case "product_id":
              $source_product_id=$value;
              break;
            case "name":
              $magento_product_name=$value;
              break;
            case "description":
              $magento_product_description=$value;
              break;
            case "price":
              $magento_product_price=$value;
              $magento_product_price=str_replace("$","",$magento_product_price);
              $magento_product_price=str_replace(",","",$magento_product_price);
              break;
          }
        }

        $query="SELECT image
          FROM $source_database.oc_product
          WHERE product_id=$source_product_id";
        $query_result=$connection->query($query);
        $query_result_row=mysqli_fetch_assoc($query_result);
        $source_product_image_url="../../website11/upload/image/".$query_result_row['image'];

        $source_product_image_url_length=strlen($source_product_image_url);
        $source_product_image_name=substr($source_product_image_url, 42, $source_product_image_url_length-42+1);

        echo "Product image URL: ".$source_product_image_url."<br>";
        echo "Product image name: ".$source_product_image_name."<br>";
        echo "Product id: ".$source_product_id."<br>";
        echo "Product name: ".$magento_product_name."<br>";
        echo "Product description: ".$magento_product_description."<br>";
        echo "Product price: ".$magento_product_price."<br>";

        $query="SELECT category_id
          FROM $source_database.oc_product_to_category
          WHERE product_id=$source_product_id";
        $query_result=$connection->query($query);
        $source_product_category=mysqli_fetch_all($query_result);
        print_r($source_product_category);
        echo "<br>";

        $magento_product_category=array();
        foreach($source_product_category as $row){
          foreach($row as $key=>$value){
            $query="SELECT magento_category_id
              FROM $magento_database.product_category_mapping
              WHERE source_category_id=$value";
            $query_result=$connection->query($query);
            $query_result_row=mysqli_fetch_assoc($query_result);
            $magento_product_category_input=$query_result_row['magento_category_id'];
            echo "Magento product category id: ".$magento_product_category_input;
            echo "<br>";

            array_push($magento_product_category, $magento_product_category_input);
          }
        }
        print_r($magento_product_category);
        echo "<br>";

        $data = array(
          "product" => array(
            "sku"               => $source_product_id,
            'name'              => $magento_product_name,
            'visibility'        => 4,
            'type_id'           => 'simple',
            'price'             => $magento_product_price,
            'status'            => 1,
            'attribute_set_id'  => 4,
            'weight'            => 1,
            'custom_attributes' => array(
              array( 'attribute_code' => 'category_ids',      'value' => $magento_product_category ),
              array( 'attribute_code' => 'description',       'value' => $magento_product_description ),
              array( 'attribute_code' => 'short_description', 'value' => $magento_product_description )
            ),
            'extension_attributes'    => array(
              'website_ids'           => array(
                1
              ),
              'stock_item'            => array(
                'qty'                 => 100,
                'is_in_stock'         => true
              )
            )
          )
        );
        $response=$api->post("products", $data);
        print_r($response);
        echo "<br><br><br><br><br>";

        foreach($response as $key=>$value){
          if($key=='id'){
            $magento_product_id=$value;
          }
        }

        $query="INSERT INTO $magento_database.product_mapping (source_product_id, magento_product_id)
          VALUES ($source_product_id, $magento_product_id)";
        if($connection->query($query)===TRUE){
          echo "Success: query.";
          echo "<br><br><br><br><br>";
        } else{
          echo "Error: query.";
          echo "<br><br><br><br><br>";
        }

        $data = array(
          "entry" => array(
            'media_type'=> 'image',
            'label'     => 'Image',
            'position'  => 1,
            'disabled'  => FALSE,
            'types'     => array(
              'image',
              'small_image',
              'thumbnail'
            ),
            'content'   => array(
              'base64_encoded_data'=> base64_encode(file_get_contents($source_product_image_url)),
              'type'    => 'image/jpeg',
              'name'    => $source_product_image_name
            )
          )
        );
        $response=$api->post("products/"."$source_product_id"."/media", $data);
        print_r($response);
        echo "<br><br><br><br><br><br>";
      }
  }
?>
