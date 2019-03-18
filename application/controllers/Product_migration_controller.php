<?php
/*
Sanket Patel
Date: 2019.03.18
Summary : Migration Controller Class
*/

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_migration_controller extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->model('user');
      $this->load->model('Product_migration_model');
      $this->load->helper(array('db_dinamic_helper'));
    }

    public function get_product_migration_view_one(){
      $data['session_id'] = $this->user->get_user_id_by_username($this->session->userdata['username']);

      // Fetching all website information related to current user to display in the dropdown menu.
      $data['all_user_websites'] = $this->Product_migration_model->get_all_user_websites($data['session_id']);
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
      $this->load->view('user/product_migration_view_one', $data);
    }

    public function get_user_website_selection(){
      $data['magento_url'] = $this->input->post('magento_website_url');
      $data['opencart_url'] = $this->input->post('opencart_website_url');

      // Create Magento database connection.
      $setting_data = $this->Product_migration_model->get_selected_magento_website_details($data['magento_url']);
      
     //Set magenot database config dynamically
      $magento_config_app = switch_db_dynamic($setting_data->magento_dbhost,$setting_data->magento_dbusername,$setting_data->magento_dbpassword,$setting_data->magento_database);
      $this->magento_db = $this->load->database($magento_config_app,true); 
      
    
      //Set opencart database config dynamically
      $opencart_config_app = switch_db_dynamic($setting_data->opencart_dbhost,$setting_data->opencart_dbusername,$setting_data->opencart_dbpassword,$setting_data->opencart_database);
      $this->opencart_db = $this->load->database($opencart_config_app,true); 
      
      // Create Magento API connection.
      require('Marest.php');
      $data['magento_api_connection_status'] = $this->api=new Marest($setting_data->magento_url);
      $this->api->connect($setting_data->magento_admin, $setting_data->magento_admin_password);



      // Starting category migration.
      $this->Product_migration_model->create_product_category_mapping_table($data['opencart_database_name']);
      $opencartdb = $this->Product_migration_model->opencart_checkquery($data['opencart_website_full_details']->opencart_dbusername,$data['opencart_website_full_details']->opencart_dbpassword,$data['opencart_website_full_details']->opencart_database);
      echo "oc";print_r($opencartdb);exit;
     
      $data['opencart_category_details']=$this->Product_migration_model->get_opencart_category_details($data['opencart_database_name']);
      foreach ($data['opencart_category_details'] as $row) {
        foreach ($row as $key => $value) {
          switch ($key) {
            case 'category_id':
              $data['opencart_category_id'] = $value;
              break;
            case 'name':
              $data['magento_category_name'] = $value;
              break;
            case 'parent_id':
              $data['opencart_category_parent'] = $value;
              break;
          }
        }

        if ($data['opencart_category_parent'] == 0) {
          $data['magento_category_parent'] = 2;

          $dataa=array(
            "category" => array(
              'name'              => $data['magento_category_name'],
              'parent_id'         => $data['magento_category_parent'],
              'is_active'         => TRUE
            )
          );
          $response = $this->api->post("categories", $dataa);
          foreach ($response as $key => $value) {
            if($key == 'id'){
              $data['magento_category_id']=$value;
            }
          }
          $data['response_status']=$response;

          $this->Product_migration_model->update_product_category_mapping_table($data['magento_category_id'], $data['magento_category_parent'], $data['opencart_category_id']);
        } else {
          $data['magento_category_parent_row'] = $this->Product_migration_model->get_new_product_category_id($data['opencart_category_parent']);
          foreach ($data['magento_category_parent_row'] as $key => $value) {
              if ($key=='magento_category_id') {
                $data['magento_category_parent']=$value;
              }
          }

          $dataa=array(
            "category" => array(
              'name'              => $data['magento_category_name'],
              'parent_id'         => $data['magento_category_parent'],
              'is_active'         => TRUE
            )
          );
          $response = $this->api->post("categories", $dataa);
          foreach ($response as $key => $value) {
            if($key=='id'){
              $data['magento_category_id']=$value;
            }
          }
          $data['response_status']=$response;

          $this->Product_migration_model->update_product_category_mapping_table($data['magento_category_id'], $data['magento_category_parent'], $data['opencart_category_id']);
        }
      }
      $this->load->view('user/product_migration_view_two', $data);
    }
}
