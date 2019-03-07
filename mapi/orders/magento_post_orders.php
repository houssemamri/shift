<?php
  include("../magento_api_connection.php");
  include("../common_database_connection.php");

  $url="http://localhost/website11/upload/";
  $curl=curl_init();

  $params=array(
    'key=FrKH05CgxdPUMwAlDkdoY9IZpBdKN56jdSb8VEDQZupfaUqY6AhoiGWdk531GcfRlOHLbVVD7XZTJh0HjT8c7gBHJ8JBQiRHOSKusjXB2HSKj2pvFZGqrfcqvsNXuFfqjkeX07Cm1GoSCMoHsidQxKHJlN9YXjaOhIvMDnZTmwlZOaobRNPlgM9QlPEPIAKSMyWB6LcfUo0ubK0fn4VwGls8Ul9q0Ro8PcHibPqKOCuTi5d39GS5i3Lxi6UYwRC7'
  );
  $parameters=implode('&', $params);

  $curl=curl_init();
  curl_setopt($curl,CURLOPT_URL, $url."index.php?route=api/login");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl,CURLOPT_POSTFIELDS, $parameters);
  $response=curl_exec($curl);

  $response=json_decode($response);
  print_r($response);
  echo "<br><br>";
  foreach($response as $key=>$value){
    if($key=='api_token'){
      $api_token=$value;
    }
  }
  print_r($api_token);
  echo "<br><br>";

  $query="SELECT COUNT(order_id) AS order_id
    FROM $source_database.oc_order";
  $query_result=$connection->query($query);
  $query_result_row=mysqli_fetch_assoc($query_result);
  $magento_order_total_source_orders=$query_result_row['order_id'];
  print_r($magento_order_total_source_orders);
  echo "<br><br>";

  for($i=1; $i<=$magento_order_total_source_orders; $i++){
    curl_setopt_array($curl, array(
      CURLOPT_URL=>$url."/index.php?route=api/order/info&order_id=".$i."&api_token=".$api_token,
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
    if ($error) {
      echo "cURL Error #:" . $error;
      echo "<br>";
    } else{
      $array=json_decode($response);
      print_r($array);
      echo "<br><br>";
      /*
      foreach($array as $order){
        foreach($order as $key=>$value){
          switch($key){
            case 'customer_id':
              $source_customer_id=$value;
              break;
            case 'firstname':
              $magento_customer_firstname=$value;
              break;
            case 'lastname':
              $magento_customer_lastname=$value;
              break;
            case 'email':
              $magento_customer_email=$value;
              break;
            case 'total':
              $magento_order_total=$value;
              break;
            case 'customer_id':
              $source_customer_id=$value;
              break;
          }
        }

        $query="SELECT magento_customer_id
          FROM two.customer_mapping
          WHERE source_customer_id=$source_customer_id";
        $query_result=$connection->query($query);
        $query_result_row=mysqli_fetch_assoc($query_result);
        $magento_customer_id=$query_result_row['magento_customer_id'];
        echo "Magento customer id: ";
        print_r($magento_customer_id);

        $data=array(
          "entity"=> array(
            'base_currency_code'=> 'USD',
            'base_discount_amount'=> -4.5,
            'base_grand_total'=> 45.5,
            'base_shipping_amount'=> 5,
            'base_subtotal'=> 45,
            'base_tax_amount'=> 0,
            'customer_email'=> $magento_customer_email,
            'customer_firstname'=> $magento_customer_firstname,
            'customer_group_id'=> 1,
            'customer_id'=> 2,
            'customer_is_guest'=> 0,
            'customer_lastname'=> $magento_customer_lastname,
            'customer_note_notify'=> 1,
            'discount_amount'=> -4.5,
            'email_sent'=> 1,
            'coupon_code'=> 'Test1',
            'discount_description'=> 'Test1',
            'grand_total'=> 45.5,
            'is_virtual'=> 0,
            'order_currency_code'=> 'USD',
            'shipping_amount'=> 5,
            'shipping_description'=> 'Flat Rate - Fixed',
            'state'=> 'new',
            'status'=> 'pending',
            'store_currency_code'=> 'USD',
            'store_id'=> 1,
            'store_name'=> 'Main Website\nMain Website Store\n',
            'subtotal'=> 45,
            'subtotal_incl_tax'=> 45,
            'tax_amount'=> 0,
            'total_item_count'=> 1,
            'total_qty_ordered'=> 1,
            'weight'=> 1,
            'items'=> array(
                'base_discount_amount'=> 4.5,
                'base_original_price'=> 45,
                'base_price'=> 45,
                'base_price_incl_tax'=> 45,
                'base_row_invoiced'=> 0,
                'base_row_total'=> 45,
                'base_tax_amount'=> 0,
                'base_tax_invoiced'=> 0,
                'discount_amount'=> 4.5,
                'discount_percent'=> 10,
                'free_shipping'=> 0,
                'is_virtual'=> 0,
                'name'=> 'Push It Messenger Bag',
                'original_price'=> 45,
                'price'=> 45,
                'price_incl_tax'=> 45,
                'product_id'=> 14,
                'product_type'=> 'simple',
                'qty_ordered'=> 1,
                'row_total'=> 45,
                'row_total_incl_tax'=> 45,
                'sku'=> '24-WB04',
                'store_id'=> 1
            ),
          'billing_address'=> array(
            'address_type'=> 'billing',
            'city'=> 'Ahmedabad',
            'company'=> 'Rbj',
            'country_id'=> 'US',
            'email'=> $magento_customer_email,
            'firstname'=> $magento_customer_firstname,
            'lastname'=> $magento_customer_lastname,
            'postcode'=> '30332',
            'region'=> 'Georgia',
            'region_code'=> 'GA',
            'region_id'=> 19,
            'street'=> array(
              'Street 1',
              'Street 2'
            ),
            'telephone'=> '123456'
          ),
          'payment'=> array(
            'method'=> 'cashondelivery'
          ),
          'extension_attributes'=> array(
            'shipping_assignments'=> array(
                'shipping'=> array(
                  'address'=> array(
                    'address_type'=> 'shipping',
                    'city'=> 'Ahmedabad',
                    'company'=> 'Rbj',
                    'country_id'=> 'US',
                    'customer_address_id'=> 2,
                    'email'=> $magento_customer_email,
                    'firstname'=> $magento_customer_firstname,
                    'lastname'=> $magento_customer_lastname,
                    'postcode'=> '30332',
                    'region'=> 'Georgia',
                    'region_code'=> 'GA',
                    'region_id'=> 19,
                    'street'=> array(
                      'Street 1',
                      'Street 2'
                    ),
                    'telephone'=> '123456'
                  ),
                  'method'=> 'flatrate_flatrate'
                )
            )
          )
        )
      );
        print_r($data);
        echo "<br><br>";

        $response=$api->post("orders",$data);
        print_r($response);

        echo "<br><br><br><br><br><br><br><br>";
      }
      */
    }
  }
  curl_close($curl);
?>
