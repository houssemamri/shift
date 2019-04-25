<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Common_migration_controller extends MY_Controller {
  public $user_id, $user_role = array();

  public function __construct() {
    parent::__construct();
    $this->load->model(array('user', 'Opencart_to_magento_common_migration_model', 'Opencart_to_magento_product_migration_model', 'Opencart_to_magento_customer_migration_model', 'Opencart_to_magento_order_migration_model'));
    $this->load->helper(array('main_helper', 'user_helper', 'db_dynamic_helper'));

    // Check if session username exists.
    if (isset($this->session->userdata['username'])) {
      // Set user ID.
      $this->user_id = $this->user->get_user_id_by_username($this->session->userdata['username']);
      // Set user role.
      $this->user_role = $this->user->check_role_by_username($this->session->userdata['username']);
    }
  }





  // Switch to "Common_migration_view.php" view from dashboard.
  public function get_common_migration_view() {
    $this->check_session($this->user_role, 0);

    $all_opencart_websites = $this->Opencart_to_magento_common_migration_model->get_all_user_opencart_websites($this->user_id);
    $this->body = 'user/Common_migration_view';
    $this->content = ['all_user_opencart_websites' => $all_opencart_websites];
    $this->user_layout();
  }





  // Get corresponding Magento website URL after OpenCart URL selection.
  public function get_magento_website_url(){
    $this->check_session($this->user_role, 0);

    $all_user_selected_website_details = $this->Opencart_to_magento_common_migration_model->get_all_user_selected_website_details($this->input->post('opencart_website_id'), $this->user_id);
    $connections = $this->create_database_and_api_connections($all_user_selected_website_details);

    if (!empty($all_user_selected_website_details)) {
      $data = ['opencart_website_url' => $all_user_selected_website_details->opencart_website_url, 'opencart_database_connection_status' => $connections['opencart_database'], 'magento_website_url' => $all_user_selected_website_details->magento_website_url, 'magento_database_connection_status' => $connections['magento_database']];
      echo json_encode($data);
    } else {
      $data = ['magento_website_url' => ''];
      echo json_encode($data);
    }
    $this->session->set_userdata('all_user_website_details', $all_user_selected_website_details);
  }





  // Start product migration.
  public function start_product_migration() {
    $this->check_session($this->user_role, 0);

    $connections = $this->create_database_and_api_connections($this->session->userdata['all_user_website_details']);

    // Create "..._product_category_mapping" table, specific to the current user, if it does not already exist.
    $product_category_mapping_table_name = $this->session->userdata['username'].'_'.$this->session->userdata['all_user_website_details']->id.'_product_category_mapping';
    $this->Opencart_to_magento_product_migration_model->create_product_category_mapping_table($product_category_mapping_table_name);

    // Fetch all the OpenCart product category details and then work on it.
    $all_opencart_category_details = $this->Opencart_to_magento_product_migration_model->get_all_opencart_category_details($connections['opencart_database'], $this->session->userdata['all_user_website_details']->opencart_database_prefix);
    foreach ($all_opencart_category_details as $row) {
      $opencart_category_id = $row['category_id'];
      $magento_category_name = $row['name'];
      $opencart_category_parent = $row['parent_id'];

      if ($opencart_category_parent == 0) {
        $magento_category_parent = 2;
        $dataa = array(
          "category" => array(
            'name'              => addslashes($magento_category_name),
            'parent_id'         => $magento_category_parent,
            'is_active'         => TRUE
          )
        );

        $response = $connections['magento_api']->post("categories", $dataa);
        if (property_exists($response, 'id')) {
          // Category migration successful.
          $magento_category_id = $response->id;
          $this->Opencart_to_magento_product_migration_model->update_product_category_mapping_table($product_category_mapping_table_name, $opencart_category_id, $opencart_category_parent, $magento_category_id, $magento_category_parent, $opencart_category_id);
          $dataaa = ['item' => 'category', 'migration_status' => 'successful', 'item_name' => addslashes($magento_category_name)];
          echo json_encode($dataaa);
        } elseif (property_exists($response, 'message')) {
          // Category migration failed.
          $dataaa = ['item' => 'category', 'migration_status' => 'failed', 'item_name' => addslashes($magento_category_name)];
          echo json_encode($dataaa);
        } else {
          // Category migration failed.
          $dataaa = ['item' => 'category', 'migration_status' => 'successful', 'item_name' => addslashes($magento_category_name)];
          echo json_encode($dataaa);
        }
      } else {
        $magento_category_parent_query = $this->Opencart_to_magento_product_migration_model->get_new_product_category_id($product_category_mapping_table_name, $opencart_category_parent);
        if ($magento_category_parent_query->num_rows() == 1) {
          // Retrieval of corresponding Magento category id of Opencart category id successful.
          $magento_category_parent_query_result = $magento_category_parent_query->row();
          $magento_category_parent = $magento_category_parent_query_result->magento_category_id;
          $dataa=array(
            "category" => array(
              'name'              => addslashes($magento_category_name),
              'parent_id'         => $magento_category_parent,
              'is_active'         => TRUE
            )
          );

          $response = $connections['magento_api']->post("categories", $dataa);
          if (property_exists($response, 'id')) {
            // Category migration successful.
            $magento_category_id = $response->id;
            $this->Opencart_to_magento_product_migration_model->update_product_category_mapping_table($product_category_mapping_table_name, $opencart_category_id, $opencart_category_parent, $magento_category_id, $magento_category_parent, $opencart_category_id);
            $dataaa = ['item' => 'category', 'migration_status' => 'successful', 'item_name' => addslashes($magento_category_name)];
            echo json_encode($dataaa);
          } elseif (property_exists($response, 'message')) {
            // Category migration failed.
            $dataaa = ['item' => 'category', 'migration_status' => 'failed', 'item_name' => addslashes($magento_category_name)];
            echo json_encode($dataaa);
          } else {
            // Category migration failed.
            $dataaa = ['item' => 'category', 'migration_status' => 'failed', 'item_name' => addslashes($magento_category_name)];
            echo json_encode($dataaa);
          }
        } else {
          // Retrieval of corresponding Magento category id of Opencart category id failed.
        }
      }
    }

    // Start product migration.
    // Create "..._product_mapping" table, specific to current user, if it does not alreasy exist.
    $product_mapping_table_name = $this->session->userdata['username'].'_'.$this->session->userdata['all_user_website_details']->id.'_product_mapping';
    $this->Opencart_to_magento_product_migration_model->create_product_mapping_table($product_mapping_table_name);

    // Fetch all the OpenCart product details and then work on it.
    $all_opencart_product_details = $this->Opencart_to_magento_product_migration_model->get_all_opencart_product_details($connections['opencart_database'], $this->session->userdata['all_user_website_details']->opencart_database_prefix);
    foreach ($all_opencart_product_details as $row) {
      $opencart_product_id = $row['product_id'];
      $magento_product_name = $row['name'];
      $magento_product_description = $row['description'];
      $magento_product_quantity = $row['quantity'];
      $magento_product_price = $row['price'];
      $magento_category_id_of_product = array();
      $opencart_category_id_of_product = $this->Opencart_to_magento_product_migration_model->get_opencart_category_id_of_product($connections['opencart_database'], $this->session->userdata['all_user_website_details']->opencart_database_prefix, $opencart_product_id);
      foreach ($opencart_category_id_of_product as $row) {
        $insert_query = $this->Opencart_to_magento_product_migration_model->get_magento_category_id_of_product($product_category_mapping_table_name, $row['category_id']);
        if($insert_query->num_rows() == 1) {
          // Retrieval of corresponding Magento category id of Opencart category id successful.
          $insert_query_result = $insert_query->row();
          $insert = $insert_query_result->magento_category_id;
          array_push($magento_category_id_of_product, $insert);
        } else {
          // Retrieval of corresponding Magento category id of Opencart category id failed.
        }
      }
      if (!empty($magento_category_id_of_product)) {
        // Retrieval of corresponding Magento category id of Opencart category id successful.
        if ($magento_product_quantity >= 1) {
          $magento_product_in_stock = TRUE;
        } else {
          $magento_product_in_stock = FALSE;
        }
        $dataa = array(
          "product" => array(
            "sku"               => "OPENCARTID-".$opencart_product_id,
            'name'              => addslashes($magento_product_name),
            'visibility'        => 4,
            'type_id'           => 'simple',
            'price'             => $magento_product_price,
            'status'            => 1,
            'attribute_set_id'  => 4,
            'weight'            => 1,
            'custom_attributes' => array(
              array( 'attribute_code' => 'category_ids',      'value' => $magento_category_id_of_product ),
              array( 'attribute_code' => 'description',       'value' => addslashes($magento_product_description) ),
              array( 'attribute_code' => 'short_description', 'value' => addslashes($magento_product_description) )
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

        $response = $connections['magento_api']->post("products", $dataa);
        if (property_exists($response, 'id')) {
          // Product migration successful.
          $magento_product_id = $response->id;
          $this->Opencart_to_magento_product_migration_model->update_product_mapping_table($product_mapping_table_name, $magento_product_id, $opencart_product_id);
          $dataaa = ['item' => 'product', 'migration_status' => 'successful', 'item_name' => addslashes($magento_category_name)];
          echo json_encode($dataaa);

          // Start product image migration.
          $opencart_product_image_path_query = $this->Opencart_to_magento_product_migration_model->get_opencart_product_image_path($connections['opencart_database'], $this->session->userdata['all_user_website_details']->opencart_database_prefix, $opencart_product_id);
          if($opencart_product_image_path_query->num_rows() == 1) {
            // Retrieval of product image path successful.
            $opencart_product_image_path_query_result = $opencart_product_image_path_query->row();
            $opencart_product_image_path = $opencart_product_image_path_query_result->image;
            $opencart_product_image_path_array = explode('/', $opencart_product_image_path);
            if ($opencart_product_image_path_array[0] == 'image') {

            } else {
              $opencart_product_image_path = 'image/'.$opencart_product_image_path;
            }
            $opencart_product_image_name = $opencart_product_image_path_array[count($opencart_product_image_path_array)-1];
            $opencart_product_image_url = $this->session->userdata['all_user_website_details']->opencart_website_url.$opencart_product_image_path;
            $dataa = array(
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
                  'base64_encoded_data'=> base64_encode(file_get_contents($opencart_product_image_url)),
                  'type'    => 'image/jpeg',
                  'name'    => $opencart_product_image_name
                )
              )
            );

            $response = $connections['magento_api']->post("products/OPENCARTID-"."$opencart_product_id"."/media", $dataa);
            if (is_numeric($response)) {
              // Product image migration successful.
            } elseif (property_exists($response, 'message')) {
              // Product image migration failed.
            } else {
              // Product image migration failed.
            }
          } else {
            // Retrieval of product image path failed.
          }
        } elseif (property_exists($response, 'message')) {
          $dataaa = ['item' => 'product', 'migration_status' => 'failed', 'item_name' => addslashes($magento_category_name)];
          echo json_encode($dataaa);
          // Product migration failed.
        } else {
          $dataaa = ['item' => 'product', 'migration_status' => 'failed', 'item_name' => addslashes($magento_category_name)];
          echo json_encode($dataaa);
          // Product migration failed.
        }
      } else {
        // Retrieval of corresponding Magento category id of Opencart category id failed.
        $dataaa = ['item' => 'product', 'migration_status' => 'failed', 'item_name' => addslashes($magento_category_name)];
        echo json_encode($dataaa);
      }
    }
  }





  // Start customer migration.
  public function start_customer_migration() {
    $this->check_session($this->user_role, 0);

    $connections = $this->create_database_and_api_connections($this->session->userdata['all_user_website_details']);

    // Create "..._customer_group_mapping" table, specific to the current user, if it does not already exist.
    $customer_group_mapping_table_name = $this->session->userdata['username'].'_'.$this->session->userdata['all_user_website_details']->id.'_customer_group_mapping';
    $this->Opencart_to_magento_customer_migration_model->create_customer_group_mapping_table($customer_group_mapping_table_name);

    // Fetching all the OpenCart customer group details and then working on it.
    $all_opencart_customer_group_details = $this->Opencart_to_magento_customer_migration_model->get_all_opencart_customer_group_details($connections['opencart_database'], $this->session->userdata['all_user_website_details']->opencart_database_prefix);
    foreach ($all_opencart_customer_group_details as $row) {
      $opencart_customer_group_id = $row['customer_group_id'];
      $magento_customer_group_name = $row['name'];
      $dataa = array(
        "group" => array(
          'code'              => addslashes($magento_customer_group_name)
        )
      );

      $response = $connections['magento_api']->post("customerGroups", $dataa);
      if (property_exists($response, 'id')) {
        // Customer group transfer successful.
        $magento_customer_group_id = $response->id;
        $this->Opencart_to_magento_customer_migration_model->update_customer_group_mapping_table($customer_group_mapping_table_name, $opencart_customer_group_id, $magento_customer_group_id);
      } elseif (property_exists($response, 'message')) {
        // Customer group transfer failed.
      } else {
        // Customer group transfer failed.
      }
    }

    // Starting customer migration.
    // Creating "..._customer_mapping" table dynamically, specific to the current user, if it does not already exist.
    $customer_mapping_table_name = $this->session->userdata['username'].'_'.$this->session->userdata['all_user_website_details']->id.'_customer_mapping';
    $this->Opencart_to_magento_customer_migration_model->create_customer_mapping_table($customer_mapping_table_name);

    // Fetching all the OpenCart customer details and then working on it.
    $all_opencart_customer_details = $this->Opencart_to_magento_customer_migration_model->get_all_opencart_customer_details($connections['opencart_database'], $this->session->userdata['all_user_website_details']->opencart_database_prefix);
    foreach ($all_opencart_customer_details as $row) {
      $opencart_customer_id = $row['customer_id'];
      $magento_customer_firstname = $row['firstname'];
      $magento_customer_lastname = $row['lastname'];
      $magento_customer_email = $row['email'];
      $magento_customer_address_1 = $row['address_1'];
      $magento_customer_address_2 = $row['address_2'];
      $magento_customer_address_city = $row['city'];
      $opencart_customer_group_id = $row['customer_group_id'];
      $magento_customer_group_id = $this->Opencart_to_magento_customer_migration_model->get_magento_customer_group_id_of_customer($customer_group_mapping_table_name, $opencart_customer_group_id);
      if ($magento_customer_group_id == FALSE) {

      } else {
        $dataa = array(
          "customer" => array(
            'group_id'          => $magento_customer_group_id,
            'default_billing'   => addslashes($magento_customer_address_1)." ".addslashes($magento_customer_address_2)." ".addslashes($magento_customer_address_city),
            'default_shipping'  => addslashes($magento_customer_address_1)." ".addslashes($magento_customer_address_2)." ".addslashes($magento_customer_address_city),
            'email'             => $magento_customer_email,
            'firstname'         => addslashes($magento_customer_firstname),
            'lastname'          => addslashes($magento_customer_lastname)
          )
        );

        $response = $connections['magento_api']->post("customers", $dataa);
        if (property_exists($response, 'id')) {
          // Customer migration successful.
          $magento_customer_id = $response->id;
          $this->Opencart_to_magento_customer_migration_model->update_customer_mapping_table($customer_mapping_table_name, $opencart_customer_id, $magento_customer_id);
        } elseif (property_exists($response, 'message')) {
          // Customer migration failed.
        } else {
          // Customer migration failed.
        }
      }
    }
  }





  // Start order migration.
  public function start_order_migration() {
    $this->check_session($this->user_role, 0);

    $connections = $this->create_database_and_api_connections($this->session->userdata['all_user_website_details']);

    $product_mapping_table_name = $this->session->userdata['username'].'_'.$this->session->userdata['all_user_website_details']->id.'_product_mapping';
    $customer_group_mapping_table_name = $this->session->userdata['username'].'_'.$this->session->userdata['all_user_website_details']->id.'_customer_group_mapping';
    $customer_mapping_table_name = $this->session->userdata['username'].'_'.$this->session->userdata['all_user_website_details']->id.'_customer_mapping';

    $all_opencart_order_details = $this->Opencart_to_magento_order_migration_model->get_all_opencart_order_details($connections['opencart_database'], $this->session->userdata['all_user_website_details']->opencart_database_prefix);
    foreach ($all_opencart_order_details as $row) {
      $opencart_order_id = $row['order_id'];
      $opencart_customer_id = $row['customer_id'];
      $opencart_customer_group_id = $row['customer_group_id'];
      $magento_customer_firstname = $row['firstname'];
      $magento_customer_lastname = $row['lastname'];
      $magento_customer_email = $row['email'];
      $magento_payment_address_1 = $row['payment_address_1'];
      $magento_payment_address_2 = $row['payment_address_2'];
      $magento_payment_address_city = $row['payment_city'];
      $magento_payment_address_country = $row['payment_country'];
      $magento_payment_address_postcode = $row['payment_postcode'];
      $magento_payment_method = $row['payment_method'];
      $magento_payment_address_telephone = $row['telephone'];
      $magento_order_total = $row['total'];
      $opencart_product_id_query_result = $this->Opencart_to_magento_order_migration_model->get_product_id_of_order($connections['opencart_database'], $this->session->userdata['all_user_website_details']->opencart_database_prefix, $opencart_order_id);
      foreach ($opencart_product_id_query_result as $roww) {
        $magento_product_id_query = $this->Opencart_to_magento_order_migration_model->get_magento_product_id_of_product($product_mapping_table_name, $roww['product_id']);
        if($magento_product_id_query->num_rows() == 1) {
          $magento_product_id_query_result = $magento_product_id_query->row();
          $magento_product_id = $magento_product_id_query_result->magento_product_id;
          $magento_product_sku_query = $this->Opencart_to_magento_order_migration_model->get_magento_product_sku($connections['magento_database'], $this->session->userdata['all_user_website_details']->magento_database_prefix, $magento_product_id);
          if($magento_product_sku_query->num_rows() == 1) {
            $magento_product_sku_query_result = $magento_product_sku_query->row();
            $magento_product_sku = $magento_product_sku_query_result->sku;
            $magento_customer_id_query = $this->Opencart_to_magento_order_migration_model->get_magento_customer_id_of_customer($customer_mapping_table_name, $opencart_customer_id);
            $magento_customer_group_id_query = $this->Opencart_to_magento_order_migration_model->get_magento_customer_group_id_of_customer($customer_group_mapping_table_name, $opencart_customer_group_id);
            if($magento_customer_id_query->num_rows() == 1 && $magento_customer_group_id_query->num_rows() == 1) {
              $magento_customer_id_query_result = $magento_customer_id_query->row();
              $magento_customer_id = $magento_customer_id_query_result->magento_customer_id;
              $magento_customer_group_id_query_result = $magento_customer_group_id_query->row();
              $magento_customer_group_id = $magento_customer_group_id_query_result->magento_customer_group_id;
              $dataa = array(
                "entity" => array(
                  'base_grand_total' => $magento_order_total,
                  'grand_total' => $magento_order_total,
                  'customer_id' => $magento_customer_id,
                  'customer_group_id' => $magento_customer_group_id,
                  'customer_firstname' => addslashes($magento_customer_firstname),
                  'customer_lastname' => addslashes($magento_customer_lastname),
                  'customer_email' => $magento_customer_email,
                  'billing_address' => array(
                    'address_type' => 'Billing address.',
                    'city' => addslashes($magento_payment_address_city),
                    'firstname' => addslashes($magento_customer_firstname),
                    'lastname' => addslashes($magento_customer_lastname),
                    'postcode' => $magento_payment_address_postcode,
                    'country_id' => addslashes($magento_payment_address_country),
                    'street' => array(
                      addslashes($magento_payment_address_1." ".$magento_payment_address_2." ".$magento_payment_address_city." ".$magento_payment_address_country." ".$magento_payment_address_postcode)
                    ),
                    'telephone' => $magento_payment_address_telephone,
                    'email' => $magento_customer_email
                  ),
                  'items' => array(
                    'product_id' => $magento_product_id,
                    'sku' => addslashes($magento_product_sku)
                  ),
                  'payment' => array(
                    'method' => addslashes($magento_payment_method)
                  )
                )
              );

              $response = $connections['magento_api']->post("orders", $dataa);
              if (property_exists($response, 'base_grand_total')) {
                // Order transfer successful.
              } elseif (property_exists($response, 'message')) {
                // Order migration failed.
              } else {
                // Order migration failed.
              }
            } else {

            }
          } else {

          }
        } else {

        }
      }
    }
  }





  // Start database and API connections.
  public function  create_database_and_api_connections($all_user_selected_website_details) {
    // Create an OpenCart database connection.
    $opencart_database_configuration = switch_db_dynamic($all_user_selected_website_details->opencart_database_host, $all_user_selected_website_details->opencart_database_username, $all_user_selected_website_details->opencart_database_password, $all_user_selected_website_details->opencart_database_name);
    $opencart_database = $this->load->database($opencart_database_configuration, TRUE);
    $connection = $opencart_database->initialize();
    if($connection) {
      $opencart_database_connection_status = true;
    } else {
      $opencart_database_connection_status = false;
    }

    // Create an Magento database connection.
    $magento_database_configuration = switch_db_dynamic($all_user_selected_website_details->magento_database_host, $all_user_selected_website_details->magento_database_username, $all_user_selected_website_details->magento_database_password, $all_user_selected_website_details->magento_database_name);
    $magento_database = $this->load->database($magento_database_configuration, TRUE);
    $connection = $magento_database->initialize();
    if($connection) {
      $magento_database_connection_status = true;
    } else {
      $magento_database_connection_status = false;
    }

    // Create an Magento API connection.
    require('Marest.php');
    $magento_api = new Marest($all_user_selected_website_details->magento_website_url);
    $connection = $magento_api->connect($all_user_selected_website_details->magento_website_admin_username, $all_user_selected_website_details->magento_website_admin_password);

    $connections = array('opencart_database' => $opencart_database, 'opencart_database_connection_status' => $opencart_database_connection_status, 'magento_database' => $magento_database, 'magento_database_connection_status' => $magento_database_connection_status, 'magento_api' => $magento_api);
    return $connections;
  }
}
