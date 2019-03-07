<?php
/**
 * Rss Helpers
 *
 * This file contains the class Rss
 * with methods to process the rss methods
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Collection\Posts\Helpers as MidrubAppsCollectionPostsHelpers;

/*
 * Rss class provides the methods to process the rss data
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
*/
class Rss {
    
    /**
     * Class variables
     *
     * @since 0.0.7.4
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.4
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load RSS Helper
        $this->CI->load->helper('fifth_helper');
        
    }
    
    /**
     * The public method load_rss_feeds loads all RSS's Feeds
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function load_rss_feeds() {
        
        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            
            // Get data
            $page = $this->CI->input->post('page');
            $key = $this->CI->input->post('key');
            
            if ( $this->CI->form_validation->run() == false ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_rss_feeds_found')
                );

                echo json_encode($data);   
                
            } else {
                
                // Get total number of rss feeds
                $rss_feeds_total = $this->CI->rss_model->get_rss_feeds( $this->CI->user_id, 0, 0, $key );
               
                $limit = 10;

                $page--;

                // Get the RSS's feeds by page
                $rss_feeds = $this->CI->rss_model->get_rss_feeds( $this->CI->user_id, ($page * $limit), $limit, $key );
                
                // Set destination
                $destination = strtolower($this->CI->lang->line('selected_accounts'));
                
                $groups = 0;
                
                if ( get_user_option('settings_display_groups') ) {
                    $destination = strtolower($this->CI->lang->line('selected_groups'));
                    $groups = 1;
                }
                
                // Verify if RSS Feeds were found
                if ( $rss_feeds ) {
                    
                    $data = array(
                        'success' => TRUE,
                        'rss_feeds' => $rss_feeds,
                        'published_posts' => $this->CI->lang->line('published_posts'),
                        'destination' => $destination,
                        'delete' => $this->CI->lang->line('delete'),
                        'manage' => $this->CI->lang->line('manage'),
                        'total' => $rss_feeds_total,
                        'page' => ($page + 1),
                        'groups' => $groups
                    );

                    echo json_encode($data);                     
                    
                } else {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('no_rss_feeds_found')
                    );

                    echo json_encode($data);                     
                    
                }
                
            }
            
        } else {

            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('no_rss_feeds_found')
            );

            echo json_encode($data); 

        }
        
    }

    /**
     * The public method save_new_rss saves a new RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function save_new_rss() {
        
        // Verify if the user has reached the limit
        if ( (new MidrubAppsCollectionPostsHelpers\Rate_limits)->rss_plan_limit($this->CI->user_id) ) {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('reached_maximum_number_rss_feeds')
            );

            echo json_encode($data);  
            exit();
            
        }
        
        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('rss_url', 'RSS Url', 'trim|required');
            
            // Get data
            $rss_url = $this->CI->input->post('rss_url');
            
            if ( $this->CI->form_validation->run() == false ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);   
                
            } else {

                if ( filter_var($rss_url, FILTER_VALIDATE_URL) ) {
                        
                    // Try to get RSS content
                    $get_content = parse_rss_feed($rss_url);
                    
                    // Verify if the url is of a valid RSS Feed
                    if ( $get_content ) {
                     
                        // Try to save the url
                        $rss_save = $this->CI->rss_model->save_new_rss( $this->CI->user_id, $rss_url, stripslashes($get_content['rss_title']), stripslashes($get_content['rss_description']) );
                        
                        // Verify if the RSS Feed was saved
                        if ( $rss_save === '1' ) {
                            
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('rss_was_already_added')
                            );

                            echo json_encode($data);                              
                            
                        } else if ( $rss_save > 3 ) {
                            
                            $data = array(
                                'success' => TRUE,
                                'message' => $this->CI->lang->line('rss_was_added_successfully'),
                                'rss_content' => $get_content,
                                'last_id' => $rss_save
                            );

                            echo json_encode($data);                             
                            
                        } else {
                            
                            $data = array(
                                'success' => FALSE,
                                'message' => $this->CI->lang->line('rss_was_not_added_successfully')
                            );

                            echo json_encode($data);                             
                            
                        }
                        
                    } else {
                        
                        $data = array(
                            'success' => FALSE,
                            'message' => $this->CI->lang->line('rss_not_supported')
                        );

                        echo json_encode($data);                         
                        
                    }

                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('url_not_valid')
                    );

                    echo json_encode($data); 

                }
                
            }
            
        }
        
    }
    
    /**
     * The public method get_selected_accounts gets selected rss's social accounts
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function get_selected_accounts() {
        
        // Get rss_id's input
        $rss_id = $this->CI->input->get('rss_id');
        
        // Verify if $rss_id and $network_id is numeric
        if ( is_numeric( $rss_id ) ) {
            
            // Verify if the user is the owner of the rss feed
            $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);
            
            if ( !$rss ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            }
            
            // Load the RSS's accounts model
            $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Rss_accounts_model', 'rss_accounts_model' );
            
            // Load the RSS'S selected accounts
            $selected_accounts = (new MidrubAppsCollectionPostsHelpers\Accounts)->list_accounts_for_composer($this->CI->rss_accounts_model->get_rss_accounts( $rss_id ));
            
            if ( $selected_accounts ) {
                
                $data = array(
                    'success' => TRUE,
                    'selected_accounts' => $selected_accounts
                );

                echo json_encode($data);  
                
            } else {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_accounts_selected')
                );

                echo json_encode($data); 
                
            }
           
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred')
            );

            echo json_encode($data); 
            
        }
        
    }
    
    /**
     * The public method rss_feed_add_selected_account adds an account to RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_add_selected_account() {
        
        // Get rss_id's input
        $rss_id = $this->CI->input->get('rss_id');
        
        // Get network_id's input
        $network_id = $this->CI->input->get('network_id');
        
        // Verify if $rss_id and $network_id is numeric
        if ( is_numeric( $rss_id ) && is_numeric( $network_id ) ) {
            
            // Verify if the user is the owner of the rss feed
            $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);
            
            if ( !$rss ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            }
            
            // Verify if the user is the owner of the network_id
            $network_data = $this->CI->networks_model->get_account( $network_id );
            
            if ( !$network_data || @$network_data[0]->user_id !== $this->CI->user_id ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();                
                
            }
            
            // Load the RSS's accounts model
            $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Rss_accounts_model', 'rss_accounts_model' );
            
            // Save the network_id and rss_feed
            $account_save = $this->CI->rss_accounts_model->save_rss_account( $network_id, $rss_id );

            // Verify if the RSS social account was saved
            if ( $account_save === '1' ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('account_was_already_added')
                );

                echo json_encode($data);                              

            } else if ( $account_save > 3 ) {

                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('account_was_added_successfully')
                );

                echo json_encode($data);                             

            } else {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('account_was_not_added')
                );

                echo json_encode($data);                             

            }
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred')
            );

            echo json_encode($data); 
            
        }
        
    }
    
    /**
     * The public method rss_feed_delete_selected_account deletes an account from a RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_delete_selected_account() {
        
        // Get rss_id's input
        $rss_id = $this->CI->input->get('rss_id');
        
        // Get network_id's input
        $network_id = $this->CI->input->get('network_id');
        
        // Verify if $rss_id and $network_id is numeric
        if ( is_numeric( $rss_id ) && is_numeric( $network_id ) ) {
            
            // Verify if the user is the owner of the rss feed
            $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);
            
            if ( !$rss ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            }
            
            // Verify if the user is the owner of the network_id
            $network_data = $this->CI->networks_model->get_account( $network_id );
            
            if ( !$network_data || @$network_data[0]->user_id !== $this->CI->user_id ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();                
                
            }
            
            // Load the RSS's accounts model
            $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Rss_accounts_model', 'rss_accounts_model' );
            
            // Delete account by the network_id and rss_feed
            $account_delete = $this->CI->rss_accounts_model->delete_rss_account( $network_id, $rss_id );
            
            // Verify if the RSS social account was deleted
            if ( $account_delete ) {

                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('account_was_deleted_successfully')
                );

                echo json_encode($data);                             

            } else {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('account_was_not_deleted')
                );

                echo json_encode($data);                             

            }
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred')
            );

            echo json_encode($data); 
            
        }
        
    }
    
    /**
     * The public method rss_feed_add_selected_group adds group to RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_add_selected_group() {
        
        // Get rss_id's input
        $rss_id = $this->CI->input->get('rss_id');
        
        // Get group_id's input
        $group_id = $this->CI->input->get('group_id');
        
        // Verify if $rss_id and $group_id is numeric
        if ( is_numeric( $rss_id ) && is_numeric( $group_id ) ) {
            
            // Verify if the user is the owner of the rss feed
            $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);
            
            if ( !$rss ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            }
            
            $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Lists_model', 'lists_model' );
            
            // Verify if the user is the owner of the group_id
            $group_owner = $this->CI->lists_model->get_lists_meta($this->CI->user_id, $group_id);
            
            if ( $group_owner ) {
                
                // Try to add the group
                $rss_add_group = $this->CI->rss_model->update_rss_meta($rss_id, 'group_id', $group_id);
                
                // Verify if the group was saved
                if ( $rss_add_group ) {

                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('group_was_added_successfully')
                    );

                    echo json_encode($data);                             

                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('group_was_not_added')
                    );

                    echo json_encode($data);                             

                }
                
            } else {
            
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('group_is_empty')
                );

                echo json_encode($data); 

            }
            
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred')
            );

            echo json_encode($data); 
            
        }
        
    }
    
    /**
     * The public method rss_feed_delete_selected_group removes group from RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_delete_selected_group() {
        
        // Get rss_id's input
        $rss_id = $this->CI->input->get('rss_id');
        
        // Get group_id's input
        $group_id = $this->CI->input->get('group_id');
        
        // Verify if $rss_id and $group_id is numeric
        if ( is_numeric( $rss_id ) && is_numeric( $group_id ) ) {
            
            // Verify if the user is the owner of the rss feed
            $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);
            
            if ( !$rss ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            }
            
            $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Lists_model', 'lists_model' );
            
            // Verify if the user is the owner of the group_id
            $group_owner = $this->CI->lists_model->if_user_has_list($this->CI->user_id, $group_id, 'social');
            
            if ( $group_owner ) {
                
                // Try to add the group
                $rss_add_group = $this->CI->rss_model->update_rss_meta($rss_id, 'group_id', 0);
                
                // Verify if the group was saved
                if ( $rss_add_group ) {

                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('group_was_deleted_successfully')
                    );

                    echo json_encode($data);                             

                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('group_was_not_deleted')
                    );

                    echo json_encode($data);                             

                }
                
            } else {
            
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data); 

            }
            
            
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred')
            );

            echo json_encode($data); 
            
        }
        
    }
    
    /**
     * The public method rss_feed_get_selected_group gets the selected RSS's group
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_get_selected_group() {
        
        // Get rss_id's input
        $rss_id = $this->CI->input->get('rss_id');
        
        // Verify if $rss_id is numeric
        if ( is_numeric( $rss_id ) ) {
            
            // Verify if the user is the owner of the rss feed
            $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);
            
            if ( !$rss ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            }
                
            // Get the RSS's group
            $get_rss_group = $this->CI->rss_model->get_rss_group( $rss_id );

            // Verify if group was found
            if ( @$get_rss_group[0]->group_id ) {

                $data = array(
                    'success' => TRUE,
                    'group' => $get_rss_group
                );

                echo json_encode($data);

            } else {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_groups_found')
                );

                echo json_encode($data);            

            }
           
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred')
            );

            echo json_encode($data); 
            
        }
        
    }
    
    /**
     * The public method rss_delete_rss_feed deletes a RSS's Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_delete_rss_feed() {
        
        // Get rss_id's input
        $rss_id = $this->CI->input->get('rss_id');
        
        // Verify if $rss_id is numeric
        if ( is_numeric( $rss_id ) ) {
            
            // Verify if the user is the owner of the rss feed
            $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);
            
            if ( !$rss ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            }
                
            // Delete a RSS's Feed
            $delete_rss = $this->CI->rss_model->delete_rss_feed( $rss_id );

            // Verify if the RSS was deleted
            if ( $delete_rss ) {

                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('rss_feed_was_deleted')
                );

                echo json_encode($data);

            } else {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('rss_feed_was_not_deleted')
                );

                echo json_encode($data);            

            }
           
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred')
            );

            echo json_encode($data); 
            
        }
        
    }
    
    /**
     * The public method rss_feeds_execute_mass_action executes an action on more RSS Feeds
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feeds_execute_mass_action() {
        
        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('rss_action', 'RSS Action', 'trim');
            $this->CI->form_validation->set_rules('rss_ids', 'RSS IDS', 'trim|integer');
            
            // Get data
            $rss_action = $this->CI->input->post('rss_action');
            $rss_ids = $this->CI->input->post('rss_ids');
            
            if ( $this->CI->form_validation->run() == false ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);   
                
            } else {
                
                if ( !$rss_ids ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('no_rss_feeds_selected')
                    );

                    echo json_encode($data);  
                    exit();
                    
                }
                
                $n = 0;
                
                foreach ( $rss_ids as $rss_id ) {
                    
                    // Verify if the user is the owner of the rss feed
                    $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);

                    if ( !$rss ) {
                        continue;
                    }
                    
                    switch ( $rss_action ) {

                        case '1':

                            // Try to enable the RSS's Feed
                            $rss_enable = $this->CI->rss_model->update_rss_meta($rss_id, 'enabled', 1);
                            
                            // Verify if the RSS was enabled
                            if ( $rss_enable ) {
                                $n++;
                            }

                            break;

                        case '2':
                            
                            // Try to disable the RSS's Feed
                            $rss_enable = $this->CI->rss_model->update_rss_meta($rss_id, 'enabled', 0);
                            
                            // Verify if the RSS was enabled
                            if ( $rss_enable ) {
                                $n++;
                            }

                            break;

                        case '3':
                            
                            // Delete a RSS's Feed
                            $delete_rss = $this->CI->rss_model->delete_rss_feed( $rss_id );

                            // Verify if the RSS was deleted
                            if ( $delete_rss ) {
                                $n++;
                            }

                            break;                    

                    }   
                    
                }
                
                switch ( $rss_action ) {

                    case '1':
                        
                        $data = array(
                            'success' => TRUE,
                            'message' => $n . $this->CI->lang->line('were_enabled_successfully')
                        );

                        echo json_encode($data);
                        
                        break;

                    case '2':

                        $data = array(
                            'success' => TRUE,
                            'message' => $n . $this->CI->lang->line('were_disabled_successfully')
                        );

                        echo json_encode($data);

                        break;

                    case '3':

                        $data = array(
                            'success' => TRUE,
                            'message' => $n . $this->CI->lang->line('were_deleted_successfully')
                        );

                        echo json_encode($data);

                        break;                    

                } 
                
            }
            
        }
        
    }
    
    /**
     * The public method rss_publish_post publishes or schedules a RSS's post
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_publish_post() {
        
        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('post', 'Post', 'trim');
            $this->CI->form_validation->set_rules('url', 'Url', 'trim');
            $this->CI->form_validation->set_rules('image', 'Image', 'trim');
            $this->CI->form_validation->set_rules('date', 'Date', 'trim');
            $this->CI->form_validation->set_rules('current_date', 'Current Date', 'trim');
            $this->CI->form_validation->set_rules('post_title', 'Post Title', 'trim');
            $this->CI->form_validation->set_rules('rss_id', 'RSS ID', 'trim|numeric|required');
            
            // Get data
            $post = str_replace('-', '/', $this->CI->input->post('post'));
            $post = $this->CI->security->xss_clean(base64_decode($post));
            $url = $this->CI->input->post('url');
            $image = $this->CI->input->post('image');
            $date = $this->CI->input->post('date');
            $current_date = $this->CI->input->post('current_date');
            $post_title = $this->CI->input->post('post_title');
            $rss_id = $this->CI->input->post('rss_id');
            
            if ( $this->CI->form_validation->run() == false ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('please_select_a_post')
                );

                echo json_encode($data);   
                
            } else {
                
                // Verify if the user is the owner of the rss feed
                $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);

                if ( !$rss ) {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('error_occurred')
                    );

                    echo json_encode($data);
                    exit();

                }
                
                // Verify if the RSS's Feed is enabled
                if ( $rss[0]->enabled < 1 ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('rss_feed_disabled')
                    );

                    echo json_encode($data);
                    exit();                    
                    
                }
                
                // Verify if the RSS's posts could be published manually
                if ( $rss[0]->pub < 1 ) {
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('enable_manual_publish')
                    );

                    echo json_encode($data);
                    exit();                    
                    
                }
                
                // Get the post time
                $time = (is_numeric(strtotime($date))) ? strtotime($date) : time();
                
                // Get current user's time
                $current_date = (is_numeric(strtotime($current_date))) ? strtotime($current_date) : time();
                
                // If date is null or has invalid format will be converted to current time or null with strtotime
                if ( $time > $current_date ) {
                    
                    // Calculate the time difference
                    $d = $time - $current_date;
                    
                    // Set new time
                    $time = time() + $d;
                    
                    // Set the post's status
                    $status = 2;
                    
                } else {
                    
                    // Set current time
                    $time = time();
                    
                    // Set the post's status
                    $status = 0;
                    
                }
                
                $img = '';
                
                $im = '';
                    
                // Verify if user wants to publish photos instead urls
                if ( $rss[0]->type ) {
                    
                    if ( $image ) {

                        $img = array(
                            array(
                                'body' => $image
                            )
                        );
                        
                        $im = $image;

                    }

                }
                
                // Save the post
                $post_save = $this->CI->rss_model->save_rss_post( $this->CI->user_id, $rss_id, $url, $time, $post_title, $post, $im, $status);
                
                // Verify if the post was saved
                if ( $post_save ) {
                    
                    // Verify if the post should be published now
                    if ( !$status ) {
                        
                        // Mark post as published
                        $this->CI->rss_model->update_rss_post_field($post_save, 'status', 1);
                        
                        // Define the variable which will count the number of published posts
                        $publish_status = 0;
                    
                        // Load Main Helper
                        $this->CI->load->helper('short_url_helper');

                        if ( get_user_option('settings_display_groups') ) {
                            
                            $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Lists_model', 'lists_model' );
                            
                            // Verify if group exists
                            if ( $rss[0]->group_id < 1 ) {
                                
                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('no_group_selected')
                                );

                                echo json_encode($data);
                                exit();
                                
                            }

                            $rss_accounts = $this->CI->lists_model->get_lists_meta($this->CI->user_id, $rss[0]->group_id);

                            if ( $rss_accounts ) {

                                foreach ( $rss_accounts as $rss_account ) {

                                    $args = array(
                                        'post' => $post,
                                        'title' => $post_title,
                                        'network' => $rss_account->network_name,
                                        'account' => $rss_account->network_id,
                                        'url' => short_url($url),
                                        'img' => $img,
                                        'video' => '',
                                        'category' => ''
                                    );

                                    $check_pub = publish($args);

                                    if ( $check_pub ) {

                                        if ( $check_pub === true ) {
                                            $check_pub = 0;
                                        }

                                        $this->CI->rss_model->save_post_meta($post_save, $rss_account->network_id, $rss_account->network_name, 1, $this->CI->user_id, $check_pub);

                                        $publish_status++;

                                    } else {

                                        $this->CI->rss_model->save_post_meta($post_save, $rss_account->network_id, $rss_account->network_name, 2, $this->CI->user_id); 

                                    }

                                }

                            } else {

                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('selected_group_empty')
                                );

                                echo json_encode($data);

                                // Delete the RSS's post
                                $this->CI->rss_model->delete_rss_post( $rss_id );

                                exit();

                            }

                        } else {

                            // Load the RSS's accounts model
                            $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Rss_accounts_model', 'rss_accounts_model' );

                            // Get RSS's accounts by RSS's ID
                            $rss_accounts = $this->CI->rss_accounts_model->get_rss_accounts($rss_id);

                            if ( $rss_accounts ) {

                                foreach ( $rss_accounts as $rss_account ) {

                                    $args = array(
                                        'post' => $post,
                                        'title' => $post_title,
                                        'network' => $rss_account->network_name,
                                        'account' => $rss_account->network_id,
                                        'url' => short_url($url),
                                        'img' => $img,
                                        'video' => '',
                                        'category' => ''
                                    );

                                    $check_pub = publish($args);

                                    if ( $check_pub ) {

                                        if ( $check_pub === true ) {
                                            $check_pub = 0;
                                        }

                                        $this->CI->rss_model->save_post_meta($post_save, $rss_account->network_id, $rss_account->network_name, 1, $this->CI->user_id, $check_pub);

                                        $publish_status++;

                                    } else {

                                        $this->CI->rss_model->save_post_meta($post_save, $rss_account->network_id, $rss_account->network_name, 2, $this->CI->user_id);                                     

                                    }

                                }

                            } else {

                                $data = array(
                                    'success' => FALSE,
                                    'message' => $this->CI->lang->line('no_accounts_selected')
                                );

                                echo json_encode($data);

                                // Delete the RSS's post
                                $this->CI->rss_model->delete_rss_post( $rss_id );

                                exit();                            

                            }

                        }
                        
                    }
                    
                    $message = $this->CI->lang->line( 'your_post_was_published_sucessfully' );
                    
                    if ( $status > 1 ) {
                        $message = $this->CI->lang->line( 'your_post_was_scheduled' );
                    }
                    
                    $data = array(
                        'success' => TRUE,
                        'message' => $message
                    );

                    echo json_encode($data);
                    
                } else {
                    
                    $message = $this->CI->lang->line( 'your_post_was_not_published' );
                    
                    if ( $status > 1 ) {
                        $message = $this->CI->lang->line( 'your_post_was_not_scheduled' );
                    }                    
                    
                    $data = array(
                        'success' => FALSE,
                        'message' => $message
                    );

                    echo json_encode($data);
                    
                }
                
            }
            
        }
        
    }
    
    /**
     * The public method rss_feed_get_rss_posts gets the RSS Feed's posts
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_get_rss_posts() {
        
        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('key', 'Key', 'trim');
            $this->CI->form_validation->set_rules('page', 'Page', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('rss_id', 'RSS ID', 'trim|numeric|required');
            
            // Get data
            $key = $this->CI->input->post('key');
            $page = $this->CI->input->post('page');
            $rss_id = $this->CI->input->post('rss_id');
            
            if ( $this->CI->form_validation->run() !== false ) {
            
                // Verify if the user is the owner of the rss feed
                $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);

                if ( !$rss ) {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('no_posts_found')
                    );

                    echo json_encode($data);
                    exit();

                }

                $limit = 10;

                $page--;

                // Get total number of posts
                $total_posts = $this->CI->rss_model->get_posts( $this->CI->user_id, 0, 0, $rss_id, $key );

                // Get all RSS Feed's posts
                $rss_posts = $this->CI->rss_model->get_posts( $this->CI->user_id, ($page * $limit), $limit, $rss_id, $key );

                // Verify if the RSS was deleted
                if ( $rss_posts ) {

                    $data = array(
                        'success' => TRUE,
                        'total' => $total_posts,
                        'date' => time(),
                        'page' => ($page + 1),
                        'posts' => $rss_posts,
                        'details' => $this->CI->lang->line('details')
                    );

                    echo json_encode($data);

                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('no_posts_found')
                    );

                    echo json_encode($data);            

                }
                
                exit();
                
            }
            
        }
            
        $data = array(
            'success' => FALSE,
            'message' => $this->CI->lang->line('no_posts_found')
        );

        echo json_encode($data);
        
    }
    
    /**
     * The public method rss_feed_get_post gets the RSS's post
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_get_post() {
        
        // Get post_id's input
        $post_id = $this->CI->input->get('post_id');   
        
        // Verify if $post_id is numeric
        if ( is_numeric( $post_id ) ) {
                
            // Get all RSS Feed's post
            $rss_post = $this->CI->rss_model->get_post( $this->CI->user_id, $post_id );

            // Verify if the RSS's post was deleted
            if ( $rss_post ) {
                
                // Get social networks
                $networks = $this->CI->rss_model->all_social_networks_by_post_id( $this->CI->user_id, $post_id );

                $profiles = array();

                $networks_icon = array();

                if ( $networks ) {

                    foreach ( $networks as $network ) {

                        if ( in_array( $network['network_name'], $networks_icon ) ) {

                            $profiles[] = array(
                                'user_name' => $network['user_name'],
                                'status' => $network['status'],
                                'network_status' => $network['network_status'],
                                'icon' => $networks_icon[$network['network_name']],
                                'network_name' => ucwords( str_replace('_', ' ', $network['network_name']) )
                            );

                        } else {

                            $network_icon = (new MidrubAppsCollectionPostsHelpers\Accounts)->get_network_icon($network['network_name']);

                            if ( $network_icon ) {

                                $profiles[] = array(
                                    'user_name' => $network['user_name'],
                                    'status' => $network['status'],
                                    'network_status' => $network['network_status'],
                                    'icon' => $network_icon,
                                    'network_name' => ucwords( str_replace('_', ' ', $network['network_name']) )
                                );

                                $networks_icon[$network['network_name']] = $network_icon;

                            }

                        }

                    }

                }

                // Get post content
                $post = array(
                    'success' => TRUE,
                    'post_id' => $rss_post[0]->post_id,
                    'rss_id' => $rss_post[0]->rss_id,
                    'title' => $rss_post[0]->title,
                    'body' => $rss_post[0]->content,
                    'url' => $rss_post[0]->url,
                    'img' => $rss_post[0]->img,
                    'datetime' => $rss_post[0]->scheduled,
                    'time' => time(),
                    'profiles' => $profiles
                );
                
                $data = array(
                    'success' => TRUE,
                    'content' => $post
                );

                echo json_encode($data);

            } else {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('no_post_found')
                );

                echo json_encode($data);            

            }
           
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('no_post_found')
            );

            echo json_encode($data); 
            
        }
        
    }
    
    /**
     * The public method rss_feed_option_action enables or disabled a RSS's option
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_option_action() {
        
        // Get rss_id's input
        $rss_id = $this->CI->input->get('rss_id');
        
        // Get option_id's input
        $option_id = $this->CI->input->get('option_id');
        
        // Verify if $rss_id is numeric
        if ( is_numeric( $rss_id ) ) {
            
            // Verify if the user is the owner of the rss feed
            $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);
            
            if ( !$rss ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();
                
            }
            
            // Define allowed RSS's options
            $options = array('enabled', 'publish_description', 'pub', 'type');
            
            // Verify if $options_id is in array
            if ( !in_array($option_id, $options) ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();                
                
            }
            
            // Enable or disable RSS's option
            $response = $this->CI->rss_model->enable_or_disable_rss_option( $this->CI->user_id, $rss_id, $option_id );
            
            if ( $response ) {
                
                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('changes_were_saved')
                );

                echo json_encode($data);                 
                
            } else {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);                
                
            }
            
        }
        
    }
    
    /**
     * The public method rss_feed_settings_input adds RSS's option value
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function rss_feed_settings_input() {
        
        // Check if data was submitted
        if ($this->CI->input->post()) {
            
            // Add form validation
            $this->CI->form_validation->set_rules('rss_id', 'RSS ID', 'trim|numeric|required');
            $this->CI->form_validation->set_rules('option_id', 'Option\'s ID', 'trim|required');
            $this->CI->form_validation->set_rules('option_value', 'Option\'s Value', 'trim');
            
            // Get data
            $rss_id = $this->CI->input->post('rss_id');
            $option_id = $this->CI->input->post('option_id');
            $option_value = $this->CI->input->post('option_value');
            
            if ( $this->CI->form_validation->run() == false ) {
                
                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);  
                
            } else {
                
                // Verify if the user is the owner of the rss feed
                $rss = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);

                if ( !$rss ) {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('no_posts_found')
                    );

                    echo json_encode($data);
                    exit();

                }
                
                // Define allowed RSS's options
                $options = array('refferal', 'period', 'include', 'exclude');
                
                // Verify if $options_id is in array
                if ( !in_array($option_id, $options) ) {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('error_occurred')
                    );

                    echo json_encode($data);
                    exit();                

                }
                
                // Enable or disable RSS's option
                $response = $this->CI->rss_model->enable_or_disable_rss_option( $this->CI->user_id, $rss_id, $option_id, $option_value );

                if ( $response ) {

                    $data = array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('changes_were_saved')
                    );

                    echo json_encode($data);                 

                } else {

                    $data = array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('error_occurred')
                    );

                    echo json_encode($data);                

                }
                
            }
            
        }
        
    }
    
}

