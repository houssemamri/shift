<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Customer_migration_controller extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->model('user');
      $this->load->model('Customer_migration_model');
      $this->load->helper(array('db_dinamic_helper'));
    }

    public function get_customer_migration_view_one() {
      $data['session_id'] = $this->user->get_user_id_by_username($this->session->userdata['username']);

      // Fetching all website information related to current user to display in the dropdown menu.
      $data['all_user_websites'] = $this->Customer_migration_model->get_all_user_websites($data['session_id']);
      $data['all_user_magento_websites']=array();
      $data['all_user_opencart_websites']=array();
      foreach ($data['all_user_websites'] as $row) {
        foreach ($row as $key => $value) {
          if ($key == 'magento_websiteurl') {
            array_push($data['all_user_magento_websites'], $value);
          } elseif ($key == 'opencart_websiteurl') {
            array_push($data['all_user_opencart_websites'], $value);
          }
        }
      }

      $this->load->view('user/customer_migration_view_one', $data);
    }

    public function get_user_website_selection() {
      $data['magento_url'] = $this->input->post('magento_website_url');
      $data['opencart_url'] = $this->input->post('opencart_website_url');

      // get connection details.
      $data['setting_data'] = $setting_data = $this->Customer_migration_model->get_selected_magento_website_details($data['magento_url']);

     //Set magenot database config dynamically
      $magento_config_app = switch_db_dynamic($setting_data->magento_dbhost,$setting_data->magento_dbusername,$setting_data->magento_dbpassword,$setting_data->magento_database);
      $this->magento_db = $this->load->database($magento_config_app,true);

      //Set opencart database config dynamically
      $opencart_config_app = switch_db_dynamic($setting_data->opencart_dbhost,$setting_data->opencart_dbusername,$setting_data->opencart_dbpassword,$setting_data->opencart_database);
      $this->opencart_db = $this->load->database($opencart_config_app,true);


      // Create Magento API connection.
      require('Marest.php');
      $data['magento_api_connection_status'] = $this->api=new Marest($setting_data->magento_websiteurl);
      $this->api->connect($setting_data->magento_admin, $setting_data->magento_admin_password);

      /* Run only once. */
      $this->Customer_migration_model->create_customer_group_mapping_table();
      $data['opencart_customer_group_ids'] = $this->Customer_migration_model->get_opencart_customer_group_id($this->opencart_db);
      $opencart_customer_group_id_array = array();
      foreach ($data['opencart_customer_group_ids'] as $row) {
        foreach ($row as $key => $value) {
          if ($key == 'customer_group_id') {
            $opencart_customer_group_id=$value;
            $opencart_customer_group_id_array = array('opencart_customer_group_id' => $value);
            $this->Customer_migration_model->insert_into_customer_group_mapping_table($opencart_customer_group_id_array);
          } elseif ($key == 'name') {
            $dataa=array(
              "group" => array(
                'code'              => $value
              )
            );
            $response=$this->api->post("customerGroups", $dataa);

            foreach ($response as $key=>$value) {
              if($key=='id'){
                $magento_customer_group_id = $value;
              }
            }
          }
        }
        $this->Customer_migration_model->update_customer_group_mapping_table($magento_customer_group_id, $opencart_customer_group_id);
      }
      /* */

      $this->load->view('user/customer_migration_view_two', $data);
    }
}
