<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_migration_model extends CI_Model {

    public function __construct() {
      $this->load->database();
    }

    public function get_all_user_websites($user_session_id) {
      $query=$this->db->query("SELECT opencart_websiteurl, magento_websiteurl
                            FROM settings
                            WHERE user_id=$user_session_id");
      return $query->result_array();
    }

    public function get_selected_magento_website_details($magento_website_url) {
      $query=$this->db->query("SELECT magento_database, magentodbusername, magento_dbpassword, magento_dbhost, magento_admin, magento_admin_password
                            FROM settings
                            WHERE magento_websiteurl='$magento_website_url'");
      return $query->row();
    }

    public function get_selected_opencart_website_details($opencart_website_url) {
      $query=$this->db->query("SELECT opencart_database, opencart_dbusername, opencart_dbpassword, opencart_dbhost
                            FROM settings
                            WHERE opencart_websiteurl='$opencart_website_url'");
      return $query->row();
    }



    public function create_product_category_mapping_table($oc_database_name){
      $query=$this->db->query("CREATE TABLE product_category_mapping
                            SELECT category_id AS opencart_category_id, parent_id AS opencart_category_parent
                            FROM $oc_database_name.oc_category_description JOIN $oc_database_name.oc_category USING (category_id)
                            ORDER BY opencart_category_parent ASC");

      $query=$this->db->query("ALTER TABLE product_category_mapping
                              ADD magento_category_id VARCHAR(250),
                              ADD magento_category_parent VARCHAR(250)");
    }

    public function get_opencart_category_details($oc_database_name){
      $query=$this->db->query("SELECT category_id, name, parent_id
                              FROM $oc_database_name.oc_category_description JOIN $oc_database_name.oc_category USING (category_id)
                              ORDER BY parent_id ASC");
      return $query->result_array();
    }

    public function update_product_category_mapping_table($mg_category_id, $mg_category_parent, $oc_category_id){
      $query=$this->db->query("UPDATE product_category_mapping
                              SET magento_category_id=$mg_category_id,
                              magento_category_parent=$mg_category_parent
                              WHERE opencart_category_id=$oc_category_id");
    }

    public function get_new_product_category_id($oc_category_parent){
      $query=$this->db->query("SELECT magento_category_id
                              FROM product_category_mapping
                              WHERE opencart_category_id=$oc_category_parent");
      return $query->row();
    }
}
