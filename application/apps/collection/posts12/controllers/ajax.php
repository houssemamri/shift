<?php
/**
 * Ajax Controller
 *
 * This file processes the app's ajax calls
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Collection\Posts\Helpers as MidrubAppsCollectionPostsHelpers;

/*
 * Ajaz class processes the app's ajax calls
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */
class Ajax {
    
    /**
     * Class variables
     *
     * @since 0.0.7.0
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load language
        if ( file_exists( MIDRUB_POSTS_APP_PATH . '/language/' . $this->CI->config->item('language') . '/posts_user_lang.php' ) ) {
            $this->CI->lang->load( 'posts_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_POSTS_APP_PATH . '/' );
        }
        
    }
    
    /**
     * The public method composer_search_accounts gets accounts to composer by search
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function composer_search_accounts() {
        
        // Gets accounts for composer
        (new MidrubAppsCollectionPostsHelpers\Accounts)->composer_search_accounts();
        
    }
    
    /**
     * The public method composer_search_groups gets groups to composer by search
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function composer_search_groups() {
        
        // Gets groups for composer
        (new MidrubAppsCollectionPostsHelpers\Accounts)->composer_search_groups();        
        
    }    
    
    /**
     * The public method composer_publish_post publishes a post
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function composer_publish_post() {
        
        // Publish a post
        (new MidrubAppsCollectionPostsHelpers\Posts)->composer_publish_post();
        
    }
    
    /**
     * The public method composer_display_all_posts will display posts with pagination
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function composer_display_all_posts() {
        
        // Display all posts with the Posts Helper
        (new MidrubAppsCollectionPostsHelpers\Posts)->composer_display_all_posts();
        
    }
    
    /**
     * The public method get_user_post gets post's details
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function get_user_post() {
        
        // Display user's post with the Posts Helper
        (new MidrubAppsCollectionPostsHelpers\Posts)->get_user_post();
        
    }
    
    /**
     * The public method scheduler_display_all_posts displays all scheduled posts
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function scheduler_display_all_posts() {
        
        // Display posts in scheduler with the Start Helper
        (new MidrubAppsCollectionPostsHelpers\Start)->scheduler_display_all_posts();
        
    }
    
    /**
     * The public method insights_display_all_posts will display's user's posts
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_display_all_posts() {
        
        // Display posts in the Insights tab with the Start Helper
        (new MidrubAppsCollectionPostsHelpers\Start)->insights_display_all_posts();        
        
    }
    
    /**
     * The public method insights_display_post_details displays the post's insights
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_display_post_details() {
        
        // Display post's details in the Insights tab with the Posts Helper
        (new MidrubAppsCollectionPostsHelpers\Posts)->insights_display_post_details();   
        
    }
    
    /**
     * The public method insights_display_post_details displays the post's insights
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_display_send_react() {
        
        // Display post's reactions in the Insights tab with the Insights Helper
        (new MidrubAppsCollectionPostsHelpers\Insights)->insights_display_send_react();  
        
    }
    
    /**
     * The public method insights_display_delete_react delete a reaction
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_display_delete_react() {
                
        // Delete post's reactions in the Insights tab with the Insights Helper
        (new MidrubAppsCollectionPostsHelpers\Insights)->insights_display_delete_react();  
        
    }
    
    /**
     * The public method insights_post_delete_post deletes a post
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_post_delete_post() {

        // Delete post in the Insights tab with the Insights Helper
        (new MidrubAppsCollectionPostsHelpers\Insights)->insights_post_delete_post(); 
        
    }    
    
    /**
     * The public method insights_display_all_accounts gets accounts for the Insights tab
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_display_all_accounts() {
        
        // Display all accounts in the Insights tab with the Start Helper
        (new MidrubAppsCollectionPostsHelpers\Start)->insights_display_all_accounts(); 
        
    }
    
    /**
     * The public method insights_display_account_details gets account insights
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_display_account_details() {
                
        // Display account's details in the Insights tab with the Insights Helper
        (new MidrubAppsCollectionPostsHelpers\Insights)->insights_display_account_details();         
        
    }
    
    /**
     * The public method insights_accounts_send_react publishes on accounts
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_accounts_send_react() {

        // Send account reactions in the Insights tab with the Insights Helper
        (new MidrubAppsCollectionPostsHelpers\Insights)->insights_accounts_send_react(); 
        
    }
    
    /**
     * The public method insights_accounts_delete_react deletes an post reaction
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_accounts_delete_react() {
                
        // Send account reactions in the Insights tab with the Insights Helper
        (new MidrubAppsCollectionPostsHelpers\Insights)->insights_accounts_delete_react(); 
        
    }
    
    /**
     * The public method insights_account_delete_post deletes an account's post
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_account_delete_post() {
                
        // Delete post in the Insights tab with the Insights Helper
        (new MidrubAppsCollectionPostsHelpers\Insights)->insights_account_delete_post();
        
    }
    
    /**
     * The public method insights_account_display_post_insights displays posts insights
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function insights_account_display_post_insights() {
                
        // Get id's input
        $id = $this->CI->input->get('id');
        
        // Get type's input
        $type = $this->CI->input->get('type');
        
        // Get account's input
        $account = $this->CI->input->get('account');

        $network_data = $this->CI->networks_model->get_account( $account );

        if ( $network_data ) {
            
            // Verify if current user is the owner of the selected account
            if ( $this->CI->user_id != $network_data[0]->user_id ) {

                $data = array(
                    'success' => FALSE,
                    'message' => $this->CI->lang->line('error_occurred')
                );

                echo json_encode($data);
                exit();

            }

            // Create an array
            $array = array(
                'MidrubApps',
                'Collection',
                'Posts',
                'Insights',
                $network_data[0]->network_name
            );       

            // Implode the array above
            $cl = implode('\\',$array);

            // Set post id
            $network_data[0]->post_id = $id;

            try {

                // Get insights
                $insights = (new $cl())->get_insights($network_data, $type);

                $data = array(
                    'success' => TRUE,
                    'insights' => $insights,
                    'post_id' => $id
                );

                echo json_encode($data);                    

            } catch (Exception $ex) {

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
     * The public method history_delete_post deletes a post by post_id
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function history_delete_post() {
        
        // Get post_id's input
        $post_id = $this->CI->input->get('post_id');
        
        if ( $post_id ) {
        
            // Delete post data by user id and post id
            $get_respponse = $this->CI->posts_model->delete_post($this->CI->user_id, $post_id);

            if ( $get_respponse ) {

                $data = array(
                    'success' => TRUE,
                    'message' => $this->CI->lang->line('post_was_deleted'),
                    'no_post_selected' => $this->CI->lang->line('no_post_selected')
                );

                echo json_encode($data);

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
                'message' => $this->CI->lang->line('no_post_found')
            );

            echo json_encode($data);
            
        }
        
    }   
    
    /**
     * The public method dashboard_get_published_posts gets published posts in the last 30 days
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function dashboard_get_published_posts() {
        
        // Get last published posts in 30 days
        $posts = $this->CI->posts_model->get_last_posts(30, $this->CI->user_id);
        
        // Get last rss published posts in 30 days
        $rss_posts = $this->CI->rss_model->get_last_posts(30, $this->CI->user_id);        

        $data = array(
            'success' => TRUE,
            'posts' => $posts,
            'rss_posts' => $rss_posts,
            'words' => array(
                'posts' => $this->CI->lang->line('posts'),
                'rss_posts' => $this->CI->lang->line('rss_posts')
            )
        );

        echo json_encode($data);
        
    } 

    /**
     * The public method dashboard_scheduled_posts gets all scheduled posts
     *
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function dashboard_scheduled_posts() {
        
        // Get scheduled posts
        $scheduled_posts = $this->CI->posts_model->get_scheduled_posts($this->CI->user_id, 7);
        
        if ( $scheduled_posts ) {

            $data = array(
                'success' => TRUE,
                'posts' => $scheduled_posts,
                'date' => time(),
                'delete_btn' => $this->CI->lang->line('delete')
            );

            echo json_encode($data);
        
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('no_posts_found')
            );

            echo json_encode($data);
            
        }
        
    }
    
    /**
     * The public method account_manager_get_accounts gets accounts by social network
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function account_manager_get_accounts() {
        
        // Get accounts by social networks
        (new MidrubAppsCollectionPostsHelpers\Account_manager)->get_accounts();
        
    }
    
    /**
     * The public method account_manager_load_networks loads available social networks
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function account_manager_load_networks() {
        
        // Get available social networks
        (new MidrubAppsCollectionPostsHelpers\Account_manager)->load_networks();
        
    }
    
    /**
     * The public method account_manager_search_for_accounts search accounts by key and network
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function account_manager_search_for_accounts() {
        
        // Search accounts
        (new MidrubAppsCollectionPostsHelpers\Accounts)->search_accounts();
        
    } 
    
    /**
     * The public method account_manager_delete_accounts delete an account
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function account_manager_delete_accounts() {
        
        // Delete accounts
        (new MidrubAppsCollectionPostsHelpers\Accounts)->delete_accounts();
        
    }
    
    /**
     * The public method account_manager_create_accounts_group creates a new group
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function account_manager_create_accounts_group() {
        
        // Create a new group
        (new MidrubAppsCollectionPostsHelpers\Groups)->save_group();
        
    }
    
    /**
     * The public method accounts_manager_groups_available_accounts gets all available group's accounts
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function accounts_manager_groups_available_accounts() {
        
        // Gets available group accounts
        (new MidrubAppsCollectionPostsHelpers\Groups)->available_group_accounts();
        
    }
    
    /**
     * The public method accounts_manager_groups_delete_group deletes a group
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function accounts_manager_groups_delete_group() {
        
        // Delete group 
        (new MidrubAppsCollectionPostsHelpers\Groups)->delete_group();
        
    }
    
    /**
     * The public method account_manager_add_account_to_group adds account to group
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function account_manager_add_account_to_group() {
        
        // Add account
        (new MidrubAppsCollectionPostsHelpers\Groups)->add_account();
        
    }
    
    /**
     * The public method account_manager_remove_account_from_group removes accounts from a group
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function account_manager_remove_account_from_group() {
        
        // Remove account
        (new MidrubAppsCollectionPostsHelpers\Groups)->remove_account();
        
    }
    
    /**
     * The public method load_rss_feeds loads all user's RSS Feeds
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function load_rss_feeds() {
        
        // Save new RSS
        (new MidrubAppsCollectionPostsHelpers\Rss)->load_rss_feeds();
        
    }    
    
    /**
     * The public method rss_feeds_save_new_rss_feed saves a new RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feeds_save_new_rss_feed() {
        
        // Save new RSS
        (new MidrubAppsCollectionPostsHelpers\Rss)->save_new_rss();
        
    }
    
    /**
     * The public method rss_feed_get_selected_accounts gets selected rss's accounts
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_get_selected_accounts() {
        
        // Get selected RSS's accounts
        (new MidrubAppsCollectionPostsHelpers\Rss)->get_selected_accounts();
        
    }
    
    /**
     * The public method rss_feed_add_selected_account adds account to RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_add_selected_account() {
        
        // Add account to the selected RSS Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_add_selected_account();
        
    }
    
    /**
     * The public method rss_feed_delete_selected_account deletes account from RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_delete_selected_account() {
        
        // Delete account from the selected RSS Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_delete_selected_account();
        
    }
    
    /**
     * The public method rss_feed_add_selected_group adds group to RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_add_selected_group() {
        
        // Add group to the selected RSS Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_add_selected_group();
        
    }
    
    /**
     * The public method rss_feed_delete_selected_group deletes group from RSS Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_delete_selected_group() {
        
        // Add group to the selected RSS Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_delete_selected_group();
        
    }
    
    /**
     * The public method rss_feed_get_selected_group gets the selected group
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_get_selected_group() {
        
        // Get selected RSS's accounts
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_get_selected_group();
        
    }
    
    /**
     * The public method rss_delete_rss_feed deletes an RSS's Feed
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_delete_rss_feed() {
        
        // Deletes an RSS's Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_delete_rss_feed();
        
    }
    
    /**
     * The public method rss_feeds_execute_mass_action executes an action on more RSS Feeds
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feeds_execute_mass_action() {
        
        // Deletes an RSS's Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feeds_execute_mass_action();
        
    }
    
    /**
     * The public method rss_publish_post publishes or schedules a RSS's post
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_publish_post() {
        
        // Deletes an RSS's Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_publish_post();
        
    }
    
    /**
     * The public method rss_feed_get_rss_posts gets all RSS Feed's posts
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_get_rss_posts() {
        
        // Deletes an RSS's Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_get_rss_posts();
        
    }
    
    /**
     * The public method rss_feed_get_post gets the RSS's post
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_get_post() {
        
        // Deletes an RSS's Feed
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_get_post();
        
    }
    
    /**
     * The public method rss_feed_option_action enable or disable a RSS Feed's option
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_option_action() {
        
        // Enable or disable a RSS Feed's option
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_option_action();
        
    }
    
    /**
     * The public method rss_feed_settings_input adds value for an RSS's option
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function rss_feed_settings_input() {
        
        // Adds value for an RSS's option
        (new MidrubAppsCollectionPostsHelpers\Rss)->rss_feed_settings_input();
        
    }
    
    /**
     * The public method download_images_from_urls downloads images from urls
     * 
     * @since 0.0.7.6
     * 
     * @return void
     */
    public function download_images_from_urls() {

        // Download and save images
        (new MidrubAppsCollectionPostsHelpers\Save_images)->download_images_from_urls();
        
    }
    
}
