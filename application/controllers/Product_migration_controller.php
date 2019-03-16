<?php
/*
Sanket Patel
Date: 2019.03.16
*/

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_migration_controller extends CI_Controller {

    public function __construct() {
      parent::__construct();
      $this->load->model('user');
      $this->load->model('Product_migration_model');
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
      $data['magento_website_full_details'] = $this->Product_migration_model->get_selected_magento_website_details($data['magento_url']);
      foreach ($data['magento_website_full_details'] as $key => $value) {
        switch ($key) {
          case 'magento_database':
            $config['database'] = "$value";
            break;
          case 'magentodbusername':
            $config['username'] = "$value";
            break;
          case 'magento_dbpassword':
            $config['password'] = "$value";
            break;
          case 'magento_dbhost':
            $config['hostname'] = "$value";
            break;
          case 'magento_admin':
            $data['magento_website_admin'] = $value;
            break;
          case 'magento_admin_password':
            $data['magento_website_admin_password'] = $value;
            break;
        }
      }
      $config['dbdriver'] = 'mysqli';
      $config['dbprefix'] = '';
      $config['pconnect'] = TRUE;
      $config['db_debug'] = TRUE;
      $config['cache_on'] = FALSE;
      $config['cachedir'] = '';
      $config['char_set'] = 'utf8';
      $config['dbcollat'] = 'utf8_general_ci';
      $data['magento_database_connection_status'] = $magento_database = $this->load->database($config, TRUE);

      // Create OpenCart database connection.
      $data['opencart_website_full_details'] = $this->Product_migration_model->get_selected_opencart_website_details($data['opencart_url']);
      foreach ($data['opencart_website_full_details'] as $key => $value) {
        switch ($key) {
          case 'opencart_database':
            $data['opencart_database_name'] = $config['database'] = "$value";
            break;
          case 'opencart_dbusername':
            $config['username'] = "$value";
            break;
          case 'opencart_dbpassword':
            $config['password'] = "$value";
            break;
          case 'opencart_dbhost':
            $config['hostname'] = "$value";
            break;
        }
      }
      $config['dbdriver'] = 'mysqli';
      $config['dbprefix'] = '';
      $config['pconnect'] = TRUE;
      $config['db_debug'] = TRUE;
      $config['cache_on'] = FALSE;
      $config['cachedir'] = '';
      $config['char_set'] = 'utf8';
      $config['dbcollat'] = 'utf8_general_ci';
      $data['opencart_database_connection_status'] = $opencart_database = $this->load->database($config, TRUE);

      // Create Magento API connection.
      require('Marest.php');
      $data['magento_api_connection_status'] = $this->api=new Marest($data['magento_url']);
      $this->api->connect($data['magento_website_admin'], $data['magento_website_admin_password']);



      // Starting category migration.
      $this->Product_migration_model->create_product_category_mapping_table($data['opencart_database_name']);
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
