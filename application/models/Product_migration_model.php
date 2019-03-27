<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_migration_model extends CI_MODEL {
    public function __construct() {
        $this->load->database();
    }



    public function get_all_user_websites($user_session_id) {
      $query = $this->db->query("SELECT id, opencart_websiteurl, magento_websiteurl
                                 FROM `settings`
                                 WHERE user_id='".$user_session_id."'");
      return $query->result();
    }



    public function get_all_user_website_details($oc_website_id, $user_session_id) {
      $query = $this->db->query("SELECT *
                                 FROM `settings`
                                 WHERE id='".$oc_website_id."'
                                 AND user_id='".$user_session_id."'");
      return $query->row();
    }



    // Starting product category migration.
    public function create_product_category_mapping_table($table_name){
      $query = $this->db->query("CREATE TABLE IF NOT EXISTS `".$table_name."` (
                                 opencart_category_id VARCHAR(250) PRIMARY KEY,
                                 opencart_category_parent VARCHAR(250),
                                 magento_category_id VARCHAR(250),
                                 magento_category_parent VARCHAR(250)
                                 )");
    }



    public function get_all_opencart_category_details($opencart_db, $prefix){
      $query = $opencart_db->query("SELECT category_id, name, parent_id
                                    FROM `{$prefix}category_description`
                                    JOIN `{$prefix}category`
                                    USING (category_id)
                                    ORDER BY parent_id ASC");
      return $query->result_array();
    }



    public function update_product_category_mapping_table($table_name, $oc_category_id, $oc_category_parent, $mg_category_id, $mg_category_parent){
      $query = $this->db->query("INSERT INTO `".$table_name."` (opencart_category_id, opencart_category_parent, magento_category_id, magento_category_parent)
                                 VALUES ('".$oc_category_id."', '".$oc_category_parent."', '".$mg_category_id."', '".$mg_category_parent."')
                                 ON DUPLICATE KEY UPDATE
                                 opencart_category_parent='".$oc_category_parent."',
                                 magento_category_id='".$mg_category_id."',
                                 magento_category_parent='".$mg_category_parent."'");
    }



    public function get_new_product_category_id($table_name, $oc_category_parent){
      $query = $this->db->query("SELECT magento_category_id
                                 FROM `".$table_name."`
                                 WHERE opencart_category_id='".$oc_category_parent."'");
      if ($query->num_rows() >= 1) {
        $query_result = $query->row();
        return $query_result->magento_category_id;
      } else {
        return FALSE;
      }
    }



    // Starting product migration.
    public function create_product_mapping_table($table_name) {
      $query = $this->db->query("CREATE TABLE IF NOT EXISTS `".$table_name."` (
                                 opencart_product_id VARCHAR(250) PRIMARY KEY,
                                 magento_product_id VARCHAR(250)
                                 )");
    }



    public function get_all_opencart_product_details($opencart_db, $prefix) {
      $query = $opencart_db->query("SELECT product_id, name, description, quantity, price
                                    FROM `{$prefix}product_description`
                                    JOIN `{$prefix}product`
                                    USING (product_id)");
      return $query->result_array();
    }



    public function get_opencart_category_id_of_product($opencart_db, $prefix, $oc_product_id) {
      $query = $opencart_db->query("SELECT category_id
                                    FROM `{$prefix}product_to_category`
                                    WHERE product_id='".$oc_product_id."'");
      return $query->result_array();
    }



    public function get_magento_category_id_of_product($table_name, $oc_category_id) {
      $query = $this->db->query("SELECT magento_category_id
                                 FROM `".$table_name."`
                                 WHERE opencart_category_id='".$oc_category_id."'");
      if ($query->num_rows() >= 1) {
        $query_result = $query->row();
        return $query_result->magento_category_id;
      } else {
        return FALSE;
      }
    }



    public function update_product_mapping_table($table_name, $mg_product_id, $oc_product_id) {
      $query = $this->db->query("INSERT INTO `".$table_name."` (opencart_product_id, magento_product_id)
                                 VALUES ('".$oc_product_id."', '".$mg_product_id."')
                                 ON DUPLICATE KEY UPDATE
                                 magento_product_id='".$mg_product_id."'");
    }



    public function get_opencart_product_image_path($opencart_db, $prefix, $oc_product_id) {
      $query = $opencart_db->query("SELECT image
                                    FROM `{$prefix}product`
                                    WHERE product_id='".$oc_product_id."'");
      $query_result = $query->row();
      if (empty($query_result->image)) {
        return FALSE;
      } else {
        return $query_result->image;
      }
    }
}
