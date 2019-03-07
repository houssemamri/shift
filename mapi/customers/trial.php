<?php
  include("../magento_api_connection.php");

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
  //execute post
  $result1=curl_exec($curl);
  print_r($result1);
  echo "<br><br><br><br><br>";

  $result2=json_decode($result1);
  print_r($result2);
  echo "<br><br><br><br><br>";
  foreach($result2 as $key=>$value){
    if($key=='api_token'){
      $api_token=$value;
    }
  }

  curl_setopt_array($curl, array(
    CURLOPT_URL=>$url."/index.php?route=api/customer&api_token=".$api_token,
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
  if ($error) {
    echo "cURL Error #:" . $error;
    echo "<br>";
  } else{
      $array=json_decode($response);
      print_r($array);
      echo "<br><br><br><br><br>";
  }
?>
