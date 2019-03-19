<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Customer_migration_model extends CI_Model {

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
      $query=$this->db->query("SELECT *
                            FROM settings
                            WHERE magento_websiteurl='$magento_website_url'");
      return $query->row();
    }







    public function create_customer_group_mapping_table() {
      $query=$this->db->query("CREATE TABLE customer_group_mapping (
                              opencart_customer_group_id VARCHAR(255),
                              magento_customer_group_id VARCHAR(255)
                              )");
    }

    public function get_opencart_customer_group_id($opencart_db){
        $query = $opencart_db->query("SELECT customer_group_id, name
                                      FROM oc_customer_group_description
                                      ORDER BY customer_group_id ASC");
        return $query->result_array();
    }

    public function insert_into_customer_group_mapping_table( $data ) {
        // Save data
        $this->db->insert("customer_group_mapping", $data);
        // Verify if data was saved
        if ( $this->db->affected_rows() ) {
            // Return inserted id
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function update_customer_group_mapping_table( $mg_customer_group_id, $oc_customer_group_id) {
        $query = $this->db->query("UPDATE customer_group_mapping
                                  SET magento_customer_group_id=$mg_customer_group_id
                                  WHERE opencart_customer_group_id=$oc_customer_group_id");
    }
}
