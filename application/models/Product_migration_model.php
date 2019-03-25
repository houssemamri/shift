<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_migration_model extends CI_MODEL {
    public function __construct() {
        $this->load->database();
    }



    public function get_all_user_websites($user_session_id) {
      $query = $this->db->query("SELECT id,opencart_websiteurl, magento_websiteurl
                                FROM settings
                                WHERE user_id='".$user_session_id."'");
      return $query->result();
    }



    public function get_all_user_website_details($opencart_website_id, $userid) {
      $query = $this->db->query("SELECT *
                                FROM settings
                                WHERE id='".$opencart_website_id."'
                                AND user_id='".$userid."'");
      return $query->row();
    }



    public function create_product_category_mapping_table($table_name){
      $query = $this->db->query("CREATE TABLE IF NOT EXISTS `".$table_name."` (
                                opencart_category_id VARCHAR(250),
                                opencart_category_parent VARCHAR(250),
                                magento_category_id VARCHAR(250),
                                magento_category_parent VARCHAR(250)
                                )");
    }



    public function get_all_opencart_category_ids($opencart_db, $prefix){
        $query = $opencart_db->query("SELECT category_id AS opencart_category_id, parent_id AS opencart_category_parent
                                     FROM {$prefix}category_description JOIN {$prefix}category USING (category_id)
                                     ORDER BY opencart_category_parent ASC");
        return $query->result();
    }



    public function insert_all_opencart_id_into_mapping_table($table_name, $data) {
      $this->db->insert($table_name, $data);
      if ($this->db->affected_rows()) {
        return $this->db->insert_id();
      } else {
        return false;
      }
    }



    public function get_all_opencart_category_details($opencart_db, $prefix){
      $query = $opencart_db->query("SELECT category_id, name, parent_id
                            FROM {$prefix}category_description JOIN {$prefix}category USING (category_id)
                            ORDER BY parent_id ASC");
      return $query->result_array();
    }



    public function update_product_category_mapping_table($table_name, $mg_category_id, $mg_category_parent, $oc_category_id){
      $query = $this->db->query("UPDATE '".$table_name."'
                                SET magento_category_id='".$mg_category_id."',
                                    magento_category_parent='".$mg_category_parent."'
                                WHERE opencart_category_id='".$oc_category_id."'");
    }



    public function get_new_product_category_id($table_name, $oc_category_parent){
      $query = $this->db->query("SELECT magento_category_id
                            FROM '".$table_name."'
                            WHERE opencart_category_id='".$oc_category_parent."'");
      $query_result = $query->row();
      return $query_result->magento_category_id;
    }



    public function create_product_mapping_table($table_name) {
      $query = $this->db->query("CREATE TABLE IF NOT EXISTS `".$table_name."` (
                                opencart_product_id VARCHAR(250),
                                magento_product_id VARCHAR(250)
                                )");
    }



    public function get_all_opencart_product_details($opencart_db, $prefix) {
      $query = $opencart_db->query("SELECT product_id, name, description, quantity, price
                                    FROM {$prefix}product_description JOIN {$prefix}product USING (product_id)");
      return $query->result_array();
    }



    public function get_opencart_category_id_of_product($opencart_db, $prefix, $oc_product_id) {
      $query = $opencart_db->query("SELECT category_id
                                    FROM {$prefix}product_to_category
                                    WHERE product_id='".$oc_product_id."'");
      return $query->result_array();
    }



    public function get_magento_category_id_of_product($table_name, $oc_category_id) {
      $query = $this->db->query("SELECT magento_category_id
                                FROM '".$table_name."'
                                WHERE opencart_category_id='".$oc_category_id."'");
      $query_result = $query->row();
      return $query_result->magento_category_id;
    }



    public function update_product_mapping_table($table_name, $mg_product_id, $oc_product_id) {
      $query = $this->db->query("INSERT INTO '".$table_name."' (opencart_product_id, magento_product_id)
                                VALUES ('".$oc_product_id."', '".$mg_product_id."')");
    }



    public function get_opencart_product_image_path($opencart_db, $prefix, $oc_product_id) {
      $query = $opencart_db->query("SELECT image
                                    FROM {$prefix}product
                                    WHERE product_id='".$oc_product_id."'");
      $query_result = $query->row();
      return $query_result->image;
    }
}
