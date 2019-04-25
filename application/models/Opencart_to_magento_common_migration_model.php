<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Opencart_to_magento_common_migration_model extends CI_MODEL {
  public function __construct() {
    $this->load->database();
  }





  public function get_all_user_opencart_websites($user_session_id) {
    $query = $this->db->query("SELECT id, opencart_website_url
      FROM settings
      WHERE user_id = $user_session_id");
      return $query->result();
    }





    public function get_all_user_selected_website_details($oc_website_id, $user_session_id) {
      $query = $this->db->query("SELECT *
        FROM settings
        WHERE id = $oc_website_id
        AND user_id = $user_session_id");
        return $query->row();
      }
    }
