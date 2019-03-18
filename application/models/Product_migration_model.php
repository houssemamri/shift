<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_migration_model extends CI_Model {

    public function __construct() {
        //parent::__construct();

        $this->load->database();
    }

    public function get_all_user_websites($user_session_id) {
      $query=$this->db->query("SELECT opencart_websiteurl, magento_websiteurl
                            FROM settings
                            WHERE user_id=$user_session_id");
      return $query->result_array();
    }

    public function get_selected_magento_website_details($magento_website_url) {
      $query=$this->db->query("SELECT *
                            FROM settings
                            WHERE magento_websiteurl='$magento_website_url'");
      return $query->row();
    }

    /*public function get_selected_opencart_website_details($opencart_website_url) {
      $query=$this->db->query("SELECT opencart_database, opencart_dbusername, opencart_dbpassword, opencart_dbhost
                            FROM settings
                            WHERE opencart_websiteurl='$opencart_website_url'");
      return $query->row();
    } */



    public function create_product_category_mapping_table($oc_database_name){
      $query=$this->db->query("CREATE TABLE IF NOT EXISTS product_category_mapping (magento_category_id VARCHAR(250), magento_category_parent VARCHAR(250) ) ");

     // $query=$this->db->query("ALTER TABLE product_category_mapping ADD magento_category_id VARCHAR(250), ADD magento_category_parent VARCHAR(250)");
    }
    
    public function opencart_checkquery($opencart_dbusername,$opencart_dbpassword,$opencart_database){
        if($opencart_dbusername){

$db['mydb2']['username'] = $opencart_dbusername;
$db['mydb2']['password'] = $opencart_dbpassword;
$db['mydb2']['database'] = $opencart_database;


            $this->config->set_item('mydb2', $db);
            $this->db2 = $this->load->database('mydb2',true); 

        }
     
        $query = $this->db2->query("SELECT category_id AS opencart_category_id, parent_id AS opencart_category_parent
                            FROM $opencart_database.oclp_category_description JOIN $opencart_database.oclp_category USING (category_id)
                            ORDER BY opencart_category_parent ASC");
          return $query->result();                    
    }

    public function get_opencart_category_details($oc_database_name){
      $query=$this->db->query("SELECT category_id, name, parent_id
                              FROM $oc_database_name.oclp_category_description JOIN $oc_database_name.oc_category USING (category_id)
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
