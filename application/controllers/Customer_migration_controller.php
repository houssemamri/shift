<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Customer_migration_controller extends MY_Controller {
	public $user_id, $user_role, $user_status, $socials = array();
  public $opencart_db;

  public function __construct() {
    parent::__construct();
    $this->load->model('user');
    $this->load->model('Product_migration_model');
    $this->load->model('Customer_migration_model');
    $this->load->helper(array('db_dinamic_helper'));
    $this->load->library('session');
    $this->load->helper('url');
    $this->load->helper('main_helper');
    $this->load->helper('user_helper');

    // Check if session username exists.
    if (isset($this->session->userdata['username'])) {
      // Set user id.
      $this->user_id = $this->user->get_user_id_by_username($this->session->userdata['username']);
      // Set user role.
      $this->user_role = $this->user->check_role_by_username($this->session->userdata['username']);
      // Set user status.
      $this->user_status = $this->user->check_status_by_username($this->session->userdata['username']);
    }
  }



  // Switch to "customer_migration_view_one.php" view after the user clicks on "customer migration" button on dashboard.
  public function get_customer_migration_view(){
 	  $this->check_session($this->user_role, 0);
    $all_website = $this->Product_migration_model->get_all_user_websites($this->user_id);
	  $this->body = 'user/customer_migration_view';
	  $this->content = ['user_websites' => $all_website];
	  $this->user_layout();
  }



	// After the user selects OpenCart website URL he/she wants to migrate data from, using dropdown menu in "customer_migration_one.php" view, display the corresponding Magento  website url.
	public function magento_website_data(){
		$this->check_session($this->user_role, 0);
		$opencart_website_id = $this->input->post('opencart_websiteurl');
		$magentoweb = $this->Product_migration_model->get_all_user_website_details($opencart_website_id, $this->user_id);
		if (!empty($magentoweb)) {
			$magentoweb =  $magentoweb->magento_websiteurl;
		} else {
			$magentoweb = '';
		}

		$data = [
		    'webdata' => $magentoweb
    ];
    echo json_encode($data);
	}



  // Start customer migration after the user clicks on "Start customer migration" button in "customer_migration_view_one.php" view.
  public function get_user_website_selection(){
		$this->check_session($this->user_role, 0);
    $opencart_url_id = $this->input->post('opencart_website_url');

    // Get database and API connection details by querying "settings" table in our database.
    $setting_data = $this->Product_migration_model->get_all_user_website_details($opencart_url_id, $this->user_id);
	  if (empty($setting_data)) {
		  $data['error'] = "Website URL mismatch.";
	  } else {
		  // Create a Magento database connection dynamically.
		  $magento_config_app = switch_db_dynamic($setting_data->magento_dbhost, $setting_data->magento_dbusername, $setting_data->magento_dbpassword, $setting_data->magento_database);
		  $this->magento_db = $this->load->database($magento_config_app, TRUE);
		  if (empty($this->magento_db)) {
         // Magento database connection failed.
			   $data['error'] = "Magento database connection failed.";
	     } else {
         // Magento database connection successful.
         // Create an OpenCart database connection dynamically.
    	   $opencart_config_app = switch_db_dynamic($setting_data->opencart_dbhost, $setting_data->opencart_dbusername, $setting_data->opencart_dbpassword, $setting_data->opencart_database);
    	   $this->opencart_db = $this->load->database($opencart_config_app, TRUE);
    	   if(empty($this->opencart_db)){
           // OpenCart database connection failed.
    		   $data['error'] = "Opencart database connection failed.";
    	   } else {
           // OpenCart database connection successful.
           // Create a Magento API connection dynamically.
           require('Marest.php');
           $this->api = new Marest($setting_data->magento_websiteurl);
           $this->api->connect($setting_data->magento_admin, $setting_data->magento_admin_password);

           // Starting customer group migration.
           // Creating "..._customer_group_mapping" table dynamically, specific to the current user, if it does not already exist.
           $customer_group_mapping_table_name = $this->session->userdata['username'].'_'.$setting_data->id.'_customer_group_mapping';
           $this->Customer_migration_model->create_customer_group_mapping_table($customer_group_mapping_table_name);

           // Fetching all the OpenCart customer group details and then working on it.
           $all_opencart_customer_group_details = $this->Customer_migration_model->get_all_opencart_customer_group_details($this->opencart_db, $setting_data->opencart_dbprefix);
           foreach ($all_opencart_customer_group_details as $row) {
             $opencart_customer_group_id = $row['customer_group_id'];
             $magento_customer_group_name = $row['name'];
             $dataa = array(
        				        "group" => array(
        				          'code'              => addslashes($magento_customer_group_name)
        					      )
        				      );

             $response = $this->api->post("customerGroups", $dataa);
             if (property_exists($response, 'id')) {
               // Customer group transfer successful.
               $magento_customer_group_id = $response->id;
  				     $this->Customer_migration_model->update_customer_group_mapping_table($customer_group_mapping_table_name, $opencart_customer_group_id, $magento_customer_group_id);
             } elseif (property_exists($response, 'message')) {
               // Error occurred while transferring the customer group.
             } else {
               // Error occurred while transferring the customer group.
             }
           }

           // Starting customer migration.
           // Creating "..._customer_mapping" table dynamically, specific to the current user, if it does not already exist.
           $customer_mapping_table_name = $this->session->userdata['username'].'_'.$setting_data->id.'_customer_mapping';
           $this->Customer_migration_model->create_customer_mapping_table($customer_mapping_table_name);

           // Fetching all the OpenCart customer details and then working on it.
           $all_opencart_customer_details = $this->Customer_migration_model->get_all_opencart_customer_details($this->opencart_db, $setting_data->opencart_dbprefix);
           foreach ($all_opencart_customer_details as $row) {
             $opencart_customer_id = $row['customer_id'];
             $magento_customer_firstname = $row['firstname'];
             $magento_customer_lastname = $row['lastname'];
             $magento_customer_email = $row['email'];
             $magento_customer_address_1 = $row['address_1'];
             $magento_customer_address_2 = $row['address_2'];
             $magento_customer_address_city = $row['city'];
             $opencart_customer_group_id = $row['customer_group_id'];
             $magento_customer_group_id = $this->Customer_migration_model->get_magento_customer_group_id_of_customer($customer_group_mapping_table_name, $opencart_customer_group_id);
             if ($magento_customer_group_id == FALSE) {

             } else {
               $dataa = array(
                 "customer" => array(
                   'group_id'          => $magento_customer_group_id,
                   'default_billing'   => addslashes($magento_customer_address_1)." ".addslashes($magento_customer_address_2)." ".addslashes($magento_customer_address_city),
                   'default_shipping'  => addslashes($magento_customer_address_1)." ".addslashes($magento_customer_address_2)." ".addslashes($magento_customer_address_city),
                   'email'             => addslashes($magento_customer_email),
                   'firstname'         => addslashes($magento_customer_firstname),
                   'lastname'          => addslashes($magento_customer_lastname)
                 )
               );

               $response = $this->api->post("customers", $dataa);
               if (property_exists($response, 'id')) {
                 // Customer transfer successful.
                 $magento_customer_id = $response->id;
    				     $this->Customer_migration_model->update_customer_mapping_table($customer_mapping_table_name, $opencart_customer_id, $magento_customer_id);
               } elseif (property_exists($response, 'message')) {
                 // Error occurred while transferring the customer.
               } else {
                 // Error occurred while transferring the customer.
               }
             }
           }
				 }
			 }
     }
    $this->body = 'user/customer_migration_view_two';
    //$this->content = ['data' => $data];
    $this->user_layout();
  }
}
