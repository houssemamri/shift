<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Opencart_to_magento_order_migration_model extends CI_MODEL {
    public function __construct() {
        $this->load->database();
    }



    // Start order migration.
    public function get_all_opencart_order_details($opencart_db, $prefix) {
      $query = $opencart_db->query("SELECT {$prefix}order.order_id, {$prefix}order.customer_id, {$prefix}order.customer_group_id, {$prefix}order.firstname, {$prefix}order.lastname, {$prefix}order.email, {$prefix}order.payment_address_1, {$prefix}order.payment_address_2, {$prefix}order.payment_city,
                                    {$prefix}order.payment_country, {$prefix}order.total, {$prefix}order.payment_postcode, {$prefix}order.payment_method, {$prefix}order.telephone
                                    FROM {$prefix}order
                                    ORDER BY order_id ASC");
      return $query->result_array();
    }



    public function get_magento_customer_id_of_customer($table_name, $oc_customer_id) {
      $query = $this->db->query("SELECT magento_customer_id
                                 FROM $table_name
                                 WHERE opencart_customer_id=$oc_customer_id");
      return $query;
    }



    public function get_magento_customer_group_id_of_customer($table_name, $oc_customer_group_id) {
      $query = $this->db->query("SELECT magento_customer_group_id
                                 FROM $table_name
                                 WHERE opencart_customer_group_id=$oc_customer_group_id");
      return $query;
    }



    public function get_product_id_of_order($opencart_db, $prefix, $order_id) {
      $query = $opencart_db->query("SELECT product_id
                                    FROM {$prefix}order_product
                                    WHERE order_id=$order_id");
      return $query->result_array();
    }



    public function get_magento_product_id_of_product($table_name, $oc_product_id) {
      $query = $this->db->query("SELECT magento_product_id
                                 FROM $table_name
                                 WHERE opencart_product_id=$oc_product_id");
      return $query;
    }



    public function get_magento_product_sku($magento_db, $prefix, $mg_product_id) {
      $query = $magento_db->query("SELECT sku
                                   FROM {$prefix}inventory_stock_1
                                   WHERE product_id=$mg_product_id");
      return $query;
    }
}
