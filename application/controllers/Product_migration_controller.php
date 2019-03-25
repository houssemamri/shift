<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_migration_controller extends MY_Controller {
	public $user_id, $user_role, $user_status, $socials = array();
  public $opencart_db;

  public function __construct() {
    parent::__construct();
    $this->load->model('user');
    $this->load->model('Product_migration_model');
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



  // Switch to "product_migration_view_one.php" view after user clicks on "Product migration" button on dashboard.
  public function get_product_migration_view_one(){
 	  $this->check_session($this->user_role, 0);
    $all_website = $this->Product_migration_model->get_all_user_websites($this->user_id);

	  $this->body = 'user/product_migration_one';
	  $this->content = ['user_websites' => $all_website];
	  $this->user_layout();
  }



	// After user selects his OpenCart website url using dropdown menu in "product_migration_one.php" view, display corresponding Magento  website url.
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



  // Start product migration after the user clicks "Start product migration" in "product_migration_view_one.php" view, after the connections are made, start with category and then product migration.
  public function get_user_website_selection(){
		$this->check_session($this->user_role, 0);
    $data['opencart_url_id'] = $this->input->post('opencart_website_url');

    // Get database and API connection details by querying "settings" table of our backend.
    $setting_data = $this->Product_migration_model->get_all_user_website_details($data['opencart_url_id'], $this->user_id);
	  if (empty($setting_data)) {
		  $data['error'] = "Url mismatch";
	  } else {
		  // Create a Magento database connection dynamically.
		  $magento_config_app = switch_db_dynamic($setting_data->magento_dbhost, $setting_data->magento_dbusername, $setting_data->magento_dbpassword, $setting_data->magento_database);

		  $this->magento_db = $this->load->database($magento_config_app, TRUE);
		  if (empty($this->magento_db)) {
			     $data['error'] = "Magento connection failed";
	  } else {
       // Create a Magento database connection dynamically after a successful Magento database connection is made.
  	   $opencart_config_app = switch_db_dynamic($setting_data->opencart_dbhost, $setting_data->opencart_dbusername, $setting_data->opencart_dbpassword, $setting_data->opencart_database);
  	   $this->opencart_db = $this->load->database($opencart_config_app, TRUE);
  	   if(empty($this->opencart_db)){
  		        $data['error'] = "Opencart connection failed";
  	   } else {
          // Create a Magento API connection a successful Magento and OpenCart database connection is made.
          require('Marest.php');
          $this->api = new Marest($setting_data->magento_websiteurl);
          $connection = $this->api->connect($setting_data->magento_admin, $setting_data->magento_admin_password);

          // Starting product category migration.
          // Creating "..._product_category_mapping" table name dynamically, specific to current user.
          $product_category_mapping_table_name = $this->session->userdata['username'].'_'.$setting_data->id.'_product_category_mapping';
          // Creating "..._product_category_mapping" table dynamically, specific to current user.
          $this->Product_migration_model->create_product_category_mapping_table($product_category_mapping_table_name);

          // Fetching all the OpenCart category details and then working on it.
          $all_opencart_category_details = $this->Product_migration_model->get_all_opencart_category_details($this->opencart_db, $setting_data->opencart_dbprefix);
          foreach ($all_opencart_category_details as $row) {
            $opencart_category_id = $row['category_id'];
            $magento_category_name = $row['name'];
            $opencart_category_parent = $row['parent_id'];

						if ($opencart_category_parent == 0) {
						  $magento_category_parent = 2;

						  $dataa=array(
  							"category" => array(
  							  'name'              => $magento_category_name,
  							  'parent_id'         => $magento_category_parent,
  							  'is_active'         => TRUE
  							)
						  );
						  $response = $this->api->post("categories", $dataa);
              // Checking if caltegory transfer was successful or not.
              if (property_exists($response, 'message')) {
                // Error occurred while transferring the category.
              } else {
                // Category transfer successful.
                $magento_category_id = $response->id;
						    $this->Product_migration_model->update_product_category_mapping_table($product_category_mapping_table_name, $opencart_category_id, $opencart_category_parent, $magento_category_id, $magento_category_parent, $opencart_category_id);
              }
						} else {
						  $magento_category_parent = $this->Product_migration_model->get_new_product_category_id($product_category_mapping_table_name, $opencart_category_parent);
              if ($magento_category_parent == FALSE) {
                // Error retrieving corresponding Magento category id of the Opencart id.
              } else {
                // Successfully retrieved corresponding Magento category id of the Opencart id.
                $dataa=array(
  							  "category" => array(
  							  'name'              => $magento_category_name,
  							  'parent_id'         => $magento_category_parent,
  							  'is_active'         => TRUE
  							  )
						    );
                $response = $this->api->post("categories", $dataa);
                if (property_exists($response, 'message')) {
                  // Error occurred while transferring the category.
                } else {
                  // Category transfer successful.
                  $magento_category_id = $response->id;
  						    $this->Product_migration_model->update_product_category_mapping_table($product_category_mapping_table_name, $opencart_category_id, $opencart_category_parent, $magento_category_id, $magento_category_parent, $opencart_category_id);
                }
              }
					  }
				  }

          // Starting product migration.
          // Creating "..._product_mapping" table name dynamically, specific to current user.
          $product_mapping_table_name = $this->session->userdata['username'].'_'.$setting_data->id.'_product_mapping';
          // Creating "..._product_mapping" table dynamically, specific to current user.
          $this->Product_migration_model->create_product_mapping_table($product_mapping_table_name);

          // Fetching all the OpenCart product details and then working on it.
          $all_opencart_product_details = $this->Product_migration_model->get_all_opencart_product_details($this->opencart_db, $setting_data->opencart_dbprefix);
          foreach ($all_opencart_product_details as $row) {
            $opencart_product_id = $row['product_id'];
            $magento_product_name = $row['name'];
            $magento_product_description = $row['description'];
            $magento_product_quantity = $row['quantity'];
            $magento_product_price = $row['price'];

            $magento_category_id_of_product = array();
            $opencart_category_id_of_product = $this->Product_migration_model->get_opencart_category_id_of_product($this->opencart_db, $setting_data->opencart_dbprefix, $opencart_product_id);
            foreach ($opencart_category_id_of_product as $row) {
              $value = $this->Product_migration_model->get_magento_category_id_of_product($product_category_mapping_table_name, $row['category_id']);
              if ($value == FALSE) {
                // Error retrieving corresponding Magento product id of the Opencart id.
              } else {
                // Successfully retrieved corresponding Magento product id of the Opencart id.
                array_push($magento_category_id_of_product, $value);
              }
            }

            if (!empty($magento_category_id_of_product)) {
              // Successfully retrieved corresponding Magento product id of the Opencart id.
              if ($magento_product_quantity>=1) {
                $magento_product_in_stock = TRUE;
              } else {
                $magento_product_in_stock = FALSE;
              }

              $dataa = array(
                "product" => array(
                  "sku"               => $opencart_product_id,
                  'name'              => $magento_product_name,
                  'visibility'        => 4,
                  'type_id'           => 'simple',
                  'price'             => $magento_product_price,
                  'status'            => 1,
                  'attribute_set_id'  => 4,
                  'weight'            => 1,
                  'custom_attributes' => array(
                    array( 'attribute_code' => 'category_ids',      'value' => $magento_category_id_of_product ),
                    array( 'attribute_code' => 'description',       'value' => $magento_product_description ),
                    array( 'attribute_code' => 'short_description', 'value' => $magento_product_description )
                  ),
                  'extension_attributes'    => array(
                    'website_ids'           => array(
                      1
                    ),
                    'stock_item'            => array(
                      'qty'                 => $magento_product_quantity,
                      'is_in_stock'         => $magento_product_in_stock
                    )
                  )
                )
              );

              $response = $this->api->post("products", $dataa);
              if (property_exists($response, 'message')) {
                // Error occurred while transferring the product.
              } else {
                // Product transfer successful.
                $magento_product_id = $response->id;
                $this->Product_migration_model->update_product_mapping_table($product_mapping_table_name, $magento_product_id, $opencart_product_id);
              }
            } else {
              // Error retrieving corresponding Magento product id of the Opencart id.
            }
          }
				}
			}
    }
    $this->body = 'user/product_migration_view_two';
    $this->content = ['data' => $data];
    $this->user_layout();
  }
}
