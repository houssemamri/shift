<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Customer_migration_model extends CI_MODEL {
    public function __construct() {
        $this->load->database();
    }



    public function create_customer_group_mapping_table($table_name){
      $query = $this->db->query("CREATE TABLE IF NOT EXISTS `".$table_name."` (
                                 opencart_customer_group_id VARCHAR(250) PRIMARY KEY,
                                 magento_customer_group_id VARCHAR(250)
                                 )");
    }



    public function get_all_opencart_customer_group_details($opencart_db, $prefix){
      $query = $opencart_db->query("SELECT customer_group_id, name
                                    FROM `{$prefix}customer_group_description`
                                    ORDER BY customer_group_id ASC");
      return $query->result_array();
    }



    public function update_customer_group_mapping_table($table_name, $oc_customer_group_id, $mg_customer_group_id){
      $query = $this->db->query("INSERT INTO `".$table_name."` (opencart_customer_group_id, magento_customer_group_id)
                                 VALUES ('".$oc_customer_group_id."', '".$mg_customer_group_id."')
                                 ON DUPLICATE KEY UPDATE
                                 magento_customer_group_id='".$mg_customer_group_id."'");
    }



    public function create_customer_mapping_table($table_name){
      $query = $this->db->query("CREATE TABLE IF NOT EXISTS `".$table_name."` (
                                 opencart_customer_id VARCHAR(250) PRIMARY KEY,
                                 magento_customer_id VARCHAR(250)
                                 )");
    }



    public function get_all_opencart_customer_details($opencart_db, $prefix) {
      $query = $opencart_db->query("SELECT {$prefix}address.customer_id, {$prefix}address.firstname, {$prefix}address.lastname, {$prefix}address.address_1, {$prefix}address.address_2, {$prefix}address.city, {$prefix}customer.email, {$prefix}customer.customer_group_id
                                    FROM {$prefix}address
                                    JOIN {$prefix}customer
                                    USING (customer_id)");
      return $query->result_array();
    }

    public function get_magento_customer_group_id_of_customer($table_name, $oc_customer_group_id) {
      $query = $this->db->query("SELECT magento_customer_group_id
                                 FROM $table_name
                                 WHERE opencart_customer_group_id=$oc_customer_group_id");
      if ($query->num_rows() >= 1) {
        $query_result = $query->row();
        return $query_result->magento_customer_group_id;
      } else {
        return FALSE;
      }
    }

    public function update_customer_mapping_table($table_name, $oc_customer_id, $mg_customer_id) {
      $query = $this->db->query("INSERT INTO $table_name (opencart_customer_id, magento_customer_id)
                                 VALUES ($oc_customer_id, $mg_customer_id)
                                 ON DUPLICATE KEY UPDATE
                                 magento_customer_id=$mg_customer_id");
    }
}
