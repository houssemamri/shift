<?php
/**
 * User Settings helper
 *
 * This file contains the methods
 * for User's Settings
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
 */

use MidrubApps\Classes as MidrubAppsClasses;

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('settings_load_invoices')) {
    
    /**
     * The function settings_load_invoices returns user's invoices by page
     * 
     * @return void
     */
    function settings_load_invoices() {
        
        // Get codeigniter object instance
        $CI = get_instance();

        // Load Invoices Model
        $CI->load->model('invoice');
        
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_settings_lang.php') ) {
            $CI->lang->load( 'default_settings', $CI->config->item('language') );
        }
        
        // Get page's input
        $page = $CI->input->get('page');
        
        // Set the limit
        $limit = 10;
        $page--;
        
        // Now get total number of invoices
        $total = $CI->invoice->get_invoices( $page * $limit, $limit, $CI->user_id, 0, 0, false );

        // Now get all invoices
        $invoices = $CI->invoice->get_invoices( $page * $limit, $limit, $CI->user_id, 0, 0, true );

        if ( $invoices ) {

            echo json_encode(array(
                    'success' => TRUE,
                    'invoices' => $invoices,
                    'total' => $total,
                    'page' => ($page + 1),
                    'paid' => $CI->lang->line('paid')
                )
            );

        } else {
            
            echo json_encode(array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('no_invoices_found')
                )
            );
            
        }
        
    }
    
}

if (!function_exists('save_user_settings')) {
    
    /**
     * The function save_user_settings saves user's settings
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function save_user_settings() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('all_inputs', 'All Inputs', 'trim');
            $CI->form_validation->set_rules('all_options', 'All Options', 'trim');
            $CI->form_validation->set_rules('selected_options', 'Selected Options', 'trim');

            // Get data
            $all_inputs = $CI->input->post('all_inputs');
            $all_options = $CI->input->post('all_options');
            $selected_options = $CI->input->post('selected_options');

            // Check form validation
            if ($CI->form_validation->run() === false) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('mm3')
                );

                echo json_encode($data);

            } else {
                
                $allowed_metas = array(
                    'country',
                    'city',
                    'address',
                    'email_notifications',
                    'notification_tickets',
                    'display_activities',
                    'settings_delete_activities',
                    '24_hour_format',
                    'invoices_by_email',
                    'user_language'
                );
            
                // Require the Apps class
                $CI->load->file( APPPATH . '/apps/main.php' );
                
                // List all apps
                foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

                    $app_dir = trim(basename($dir).PHP_EOL);

                    if ( !get_option('app_' . $app_dir . '_enable') || !plan_feature('app_' . $app_dir) ) {
                        continue;
                    }

                    // Create an array
                    $array = array(
                        'MidrubApps',
                        'Collection',
                        ucfirst($app_dir),
                        'Main'
                    );       

                    // Implode the array above
                    $cl = implode('\\',$array);

                    // Get User's settings
                    $user_options = (new $cl())->user_options();

                    if ( !$user_options ) {
                        continue;
                    }
                    
                    foreach ( $user_options as $user_option ) {
                        
                        $allowed_metas[] = $user_option['name'];
                        
                    }

                }
                
                $count = 0;
                        
                foreach( $all_inputs as $input ) {

                    if ( $input[0] === 'email' ) {
                        
                        $email = trim($input[1]);
                        
                        if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
                            
                            $data = array(
                                'success' => FALSE,
                                'message' => $CI->lang->line('mm19')
                            );

                            echo json_encode($data);
                            exit();
                            
                        } else {
                            
                            if ( $CI->user->check_email( $email, $CI->user_id ) ) {
                                
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $CI->lang->line('mm49')
                                );

                                echo json_encode($data);
                                exit();
                                
                            } else {
                                
                                $CI->db->where('user_id', $CI->user_id);

                                $data = array(
                                    'email' => $email
                                );

                                $CI->db->update('users', $data);

                                if ( $CI->db->affected_rows() ) {
                                    
                                    $count++;

                                }
                                
                            }
                            
                        }
                        
                    } else if ( $input[0] === 'last_name' ) {

                        $CI->db->where('user_id', $CI->user_id);

                        $data = array(
                            'last_name' => $input[1]
                        );

                        $CI->db->update('users', $data);

                        if ( $CI->db->affected_rows() ) {

                            $count++;

                        }
                        
                    } else if ( $input[0] === 'first_name' ) {

                        $CI->db->where('user_id', $CI->user_id);

                        $data = array(
                            'first_name' => $input[1]
                        );

                        $CI->db->update('users', $data);

                        if ( $CI->db->affected_rows() ) {

                            $count++;

                        }
                        
                    } else if ( in_array( $input[0], $allowed_metas ) ) {
                        
                        if ( $CI->user_meta->update_user_meta($CI->user_id, $input[0], $input[1]) ) {
                            
                            $count++;
                            
                        }
                        
                    }

                }
                
                foreach( $all_options as $option ) {
                    
                    if (in_array($option[0], $allowed_metas)) {

                        if ($CI->user_meta->update_user_meta($CI->user_id, $option[0], $option[1])) {

                            $count++;
                        }
                        
                    }

                }
                
                foreach( $selected_options as $selected ) {
                    
                    if (in_array($selected[0], $allowed_metas)) {

                        if ($CI->user_meta->update_user_meta($CI->user_id, $selected[0], $selected[1])) {

                            $count++;
                        }
                        
                    }

                }                
                
                if( $count ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $CI->lang->line('mm2')
                    );

                    echo json_encode($data);                    
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('mm1')
                    );

                    echo json_encode($data);                    
                    
                }
                
            }
            
        }
        
    }
    
}

if (!function_exists('change_user_password')) {
    
    /**
     * The function change_user_password tries to change the user's password
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    function change_user_password() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_settings_lang.php') ) {
            $CI->lang->load( 'default_settings', $CI->config->item('language') );
        }
        
        // Check if data was submitted
        if ( $CI->input->post() ) {

            // Add form validation
            $CI->form_validation->set_rules('current_password', 'Current Password', 'trim');
            $CI->form_validation->set_rules('new_password', 'New Password', 'trim');
            $CI->form_validation->set_rules('repeat_password', 'Repeat Password', 'trim');
            

            // Get data
            $current_password = $CI->input->post('current_password');
            $new_password = $CI->input->post('new_password');
            $repeat_password = $CI->input->post('repeat_password');

            // Check form validation
            if ($CI->form_validation->run() === false) {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('please_fill_all_required_fields')
                );

                echo json_encode($data);

            } else {
                
                // Verify if new password match the repeat password
                if ( $new_password !== $repeat_password ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('password_password')
                    );

                    echo json_encode($data);
                    
                } else if ( $new_password === $current_password ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('no_password_difference')
                    );

                    echo json_encode($data);                   
                    
                } else if ( ( strlen($new_password) < 6 ) || ( strlen($new_password) > 20 ) ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('mm25')
                    );

                    echo json_encode($data);                   
                    
                } else if ( preg_match('/\s/', $new_password) ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('mm26')
                    );

                    echo json_encode($data);                
                    
                } else if ( !$CI->user->check( $CI->session->userdata['username'], $current_password ) ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $CI->lang->line('incorrect_current_password')
                    );

                    echo json_encode($data);                 
                    
                } else {
                    
                    $CI->db->where('username', $CI->session->userdata['username']);

                    $data = array(
                        'password' => $CI->bcrypt->hash_password($new_password)
                    );

                    $CI->db->update('users', $data);

                    if ( $CI->db->affected_rows() ) {

                        $data = array(
                            'success' => TRUE,
                            'message' => $CI->lang->line('password_changed')
                        );

                        echo json_encode($data);

                    } else {
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $CI->lang->line('password_not_changed')
                        );

                        echo json_encode($data);                        
                        
                    }
                    
                }
                
            }
            
        }
        
    }
    
}