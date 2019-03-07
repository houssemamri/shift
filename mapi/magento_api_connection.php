<?php
  $source_url="http://localhost/website11/upload/";
  $magento_url="http://localhost/website1/";

  include("magento_api.php");
  $api=new maRest($magento_url);
  $api->connect("one","one1234");
?>
