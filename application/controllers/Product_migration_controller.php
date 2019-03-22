<?php
/*
Sanket Patel
Date: 2019.03.18
*/

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

	  // Load session library
      $this->load->library('session');
	  // Load URL Helper
      $this->load->helper('url');
	  // Load Main Helper
      $this->load->helper('main_helper');
	  // Load User Helper
      $this->load->helper('user_helper');

	  // Check if session username exists
      if (isset($this->session->userdata['username'])) {

            // Set user_id
            $this->user_id = $this->user->get_user_id_by_username($this->session->userdata['username']);

            // Set user_role
            $this->user_role = $this->user->check_role_by_username($this->session->userdata['username']);

            // Set user_status
            $this->user_status = $this->user->check_status_by_username($this->session->userdata['username']);

        }
    }

    public function get_product_migration_view_one(){
 	  $this->check_session($this->user_role, 0);
      $all_website = $this->Product_migration_model->get_all_user_websites($this->user_id);

	  $this->body = 'user/product_migration_one';
	  $this->content = ['user_websites' => $all_website];
	  $this->user_layout();
    }






















	// onchange web url return
	public function magento_website_data(){
		$this->check_session($this->user_role, 0);
		$opencart_website_id = $this->input->post('opencart_websiteurl');
		$magentoweb = $this->Product_migration_model->get_magento_web_by_opencart($opencart_website_id,$this->user_id);
		if(!empty($magentoweb)){
			$magentoweb =  $magentoweb->magento_websiteurl;
		}else{
			$magentoweb = '';
		}
		$data = [
				'webdata' => $magentoweb
            ];
         echo json_encode($data);
	}





















	// start migration product
    public function get_user_website_selection(){
		$this->check_session($this->user_role, 0);
     // $data['magento_url'] = $this->input->post('magento_website_url');
      $data['opencart_url_id'] = $this->input->post('opencart_website_url');

      // get connection details.
      $setting_data = $this->Product_migration_model->get_selected_magento_website_details($data['opencart_url_id'],$this->user_id);
	  if(empty($setting_data)){
		  $data['error'] = "Url mismatch";
	  }else{
		  //Set magenot database config dynamically
		  $magento_config_app = switch_db_dynamic($setting_data->magento_dbhost,$setting_data->magento_dbusername,$setting_data->magento_dbpassword,$setting_data->magento_database);

		  $this->magento_db = $this->load->database($magento_config_app,true);
		  if(empty($this->magento_db)){
			   $data['error'] = "Magento connection failed";
		  }else{

				  //Set opencart database config dynamically
				$opencart_config_app = switch_db_dynamic($setting_data->opencart_dbhost,$setting_data->opencart_dbusername,$setting_data->opencart_dbpassword,$setting_data->opencart_database);
				$this->opencart_db = $this->load->database($opencart_config_app,true);
				if(empty($this->opencart_db)){
					$data['error'] = "Opencart connection failed";
				}else{
					  // Create Magento API connection.
					  require('Marest.php');
					  $data['magento_api_connection_status'] = $this->api=new Marest($setting_data->magento_websiteurl);
					  $this->api->connect($setting_data->magento_admin, $setting_data->magento_admin_password);

					  // Starting category migration.
					  $this->Product_migration_model->create_product_category_mapping_table();
					  $opencartdb = $this->Product_migration_model->opencart_checkquery($this->opencart_db,$setting_data->opencart_database);


					  foreach($opencartdb as $ocvalue){
						 $ocdata = array("opencart_category_id" => $ocvalue->opencart_category_id,
										"opencart_category_parent" => $ocvalue->opencart_category_parent);
						 $mapping_insert = $this->Product_migration_model->insert_mapping_data($ocdata);
					  }

					  $data['opencart_category_details'] = $this->Product_migration_model->get_opencart_category_details($this->opencart_db);
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
						$data['success']=$response;
					  }
            if ($response) {
              $this->Product_migration_model->create_product_mapping_table();
              $data['all_product_details'] = $this->Product_migration_model->get_all_product_details($this->opencart_db);
              foreach ($data['all_product_details'] as $row) {
                foreach ($row as $key => $value) {
                  switch ($key) {
                    case 'product_id':
                      $product_id=$value;
                      break;
                    case 'name':
                      $product_name=$value;
                      break;
                    case 'description':
                      $product_description=$value;
                      break;
                    case 'quantity':
                      $product_quantity=$value;
                      break;
                    case 'price':
                      $product_price=$value;
                      break;
                  }
                }
                $data['category_id_of_product'] = array();
                $category_id_of_product_raw = $this->Product_migration_model->get_category_id_of_product($this->opencart_db, $product_id);
                foreach ($category_id_of_product_raw as $row) {
                  foreach ($row as $key => $value) {
                    $magento_category_id_of_product_raw = $this->Product_migration_model->get_magento_category_id_of_product($value);
                    foreach ($magento_category_id_of_product_raw as $roww) {
                      foreach ($roww as $keyy => $valuee) {
                        array_push($data['category_id_of_product'], $valuee);
                      }
                    }
                  }
                }
                if ($product_quantity>=1) {
                  $product_in_stock = true;
                } else {
                  $product_in_stock = false;
                }

                $dataaaa = array(
                  "product" => array(
                    "sku"               => $product_id,
                    'name'              => $product_name,
                    'visibility'        => 4,
                    'type_id'           => 'simple',
                    'price'             => $product_price,
                    'status'            => 1,
                    'attribute_set_id'  => 4,
                    'weight'            => 1,
                    'custom_attributes' => array(
                      array( 'attribute_code' => 'category_ids',      'value' => $data['category_id_of_product'] ),
                      array( 'attribute_code' => 'description',       'value' => $product_description ),
                      array( 'attribute_code' => 'short_description', 'value' => $product_description )
                    ),
                    'extension_attributes'    => array(
                      'website_ids'           => array(
                        1
                      ),
                      'stock_item'            => array(
                        'qty'                 => $product_quantity,
                        'is_in_stock'         => $product_in_stock
                      )
                    )
                  )
                );

                $data['responsee'] = $this->api->post("products", $dataaaa);
                foreach($data['responsee'] as $key=>$value){
                  if($key=='id'){
                    $magento_product_id=$value;
                  }
                }

                $this->Product_migration_model->update_product_mapping_table($magento_product_id, $product_id);
                $image_path = $this->Product_migration_model->get_product_image_path($this->opencart_db, $product_id);
                foreach ($image_path as $key => $value) {
                  if ($key == 'image') {
                    $data['image_path'] = $value;
                  }
                }
                $opencart_website_url_string = $setting_data->opencart_websiteurl;
                $image_url = $opencart_website_url_string."/image"."/".$data['image_path'];
                $starting_point= strlen($opencart_website_url_string)+21;
                $ending_point= strlen($image_url)-$starting_point+1;
                $product_image_name=substr("$image_url", $starting_point, $ending_point);
                print_r($product_image_name);

                $dataaaaaa = array(
                  "entry" => array(
                    'media_type'=> 'image',
                    'label'     => 'Image',
                    'position'  => 1,
                    'disabled'  => FALSE,
                    'types'     => array(
                      'image',
                      'small_image',
                      'thumbnail'
                    ),
                    'content'   => array(
                      'base64_encoded_data'=> base64_encode(file_get_contents($image_url)),
                      'type'    => 'image/jpeg',
                      'name'    => $product_image_name
                    )
                  )
                );
                $data['responseeee']=$this->api->post("products/"."$product_id"."/media", $dataaaaaa);

              }
            } else {

            }
					}
				}
	  }
	  $this->body = 'user/product_migration_view_two';
	  $this->content = ['data' => $data];
	  $this->user_layout();
    }
}
