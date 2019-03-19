<?php
/**
 * Midrub Apps Posts
 *
 * This file loads the Posts app
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Classes as MidrubAppsClasses;
use MidrubApps\Interfaces as MidrubAppsInterfaces;
use MidrubApps\Collection\Posts\Controllers as MidrubAppsCollectionPostsControllers;
use MidrubApps\Collection\Posts\Options as MidrubAppsCollectionPostsOptions;
use MidrubApps\Collection\Posts\Helpers as MidrubAppsCollectionPostsHelpers;

if ( !defined('MIDRUB_POSTS_APP_PATH') ) {
    define('MIDRUB_POSTS_APP_PATH', APPPATH . 'apps/collection/posts');
}
if ( !defined('MIDRUB_POSTS_FACEBOOK_GRAPH_URL') ) {
    define('MIDRUB_POSTS_FACEBOOK_GRAPH_URL', 'https://graph.facebook.com/v3.2/');
}

// Require the functions file
require_once APPPATH . 'apps/collection/posts/functions.php';

/*
 * Main class loads the Posts app loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */
class Main implements MidrubAppsInterfaces\Apps {
    
   
    /**
     * Class variables
     *
     * @since 0.0.7.0
     */
    protected
            $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.0
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
        // Load the app's models
        $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Posts_model', 'posts_model' );
        $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Rss_model', 'rss_model' );
        $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Networks_model', 'networks_model' );
        
    }
    
    /**
     * The public method user loads the app's main page in the user panel
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function user() {
        
        // Verify if the app is enabled
        if ( !get_option('app_posts_enable') || !plan_feature('app_posts') ) {
            show_404();
        }
        
        // Instantiate the class
        (new MidrubAppsCollectionPostsControllers\User)->view();
        
    }
    
    /**
     * The public method widgets displays the app's widgets if are enabled
     * 
     * @since 0.0.7.0
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $plan_end contains the time when plan subscription ends
     * @param object $plan_data contains the plan's information
     * 
     * @return array with widgets or false
     */
    public function widgets( $user_id, $plan_end, $plan_data ) {

        // Load language
        if ( file_exists( MIDRUB_POSTS_APP_PATH . '/language/' . $this->CI->config->item('language') . '/posts_user_lang.php' ) ) {
            $this->CI->lang->load( 'posts_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_POSTS_APP_PATH . '/' );
        }
        
        $widgets = array();
        
        foreach ( glob( MIDRUB_POSTS_APP_PATH . '/widgets/*.php') as $filename ) {

            $className = str_replace( array( MIDRUB_POSTS_APP_PATH . '/widgets/', '.php' ), '', $filename );

            // Create an array
            $array = array(
                'MidrubApps',
                'Collection',
                'Posts',
                'Widgets',
                ucfirst($className)
            );       

            // Implode the array above
            $cl = implode('\\',$array);

            // Instantiate the class
            $response = (new $cl())->display_widget( $user_id, $plan_end, $plan_data );

            // Add widget to $widgets array
            $widgets[$response['order']]['widget'] = $response['widget'];
            $widgets[$response['order']]['styles_url'] = $response['styles_url'];
            $widgets[$response['order']]['js_url'] = $response['js_url'];

        }
        
        return $widgets;
        
    }
    
    /**
     * The public method activities returns the templates for activities
     * 
     * @since 0.0.7.0
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $member_id contains the member's ID
     * @param string $template contains the template's name
     * @param integer $id contains the identificator for the requested template
     * 
     * @return array with template or false
     */
    public function activities( $user_id, $member_id, $template, $id ) {
        
        // Instantiate the class
        return (new MidrubAppsCollectionPostsControllers\Activities)->manager( $user_id, $member_id, $template, $id );
        
    }

    /**
     * The public method user_options displays the app's options for user
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function user_options() {
        
        // Return user's settings
        return (new MidrubAppsCollectionPostsOptions\User_settings)->get_options();
        
    }
    
    /**
     * The public method admin_options displays the app's options for admin
     * 
     * @since 0.0.7.0
     * 
     * @return array with options
     */
    public function admin_options() {
        
        // Load the app's language files
        if ( file_exists( MIDRUB_POSTS_APP_PATH . '/language/' . $this->CI->config->item('language') . '/posts_admin_lang.php' ) ) {
            $this->CI->lang->load( 'posts_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_POSTS_APP_PATH . '/' );
        }
        
        // Get general's options
        $general_options = (new MidrubAppsCollectionPostsOptions\General)->get_options();
        
        // Get multimedia's options
        $multimedia_options = (new MidrubAppsCollectionPostsOptions\Multimedia)->get_options();        
        
        return array(
            'general_options' => array(
                'tab' => $this->CI->lang->line('general'),
                'options' => (new MidrubAppsClasses\Options)->process($general_options)
            ),
            'multimedia_options' => array(
                'tab' => $this->CI->lang->line('multimedia'),
                'options' => (new MidrubAppsClasses\Options)->process($multimedia_options)
            )           
        );
        
    }
    
    /**
     * The public method plan_limits displays the limits for the plans
     * 
     * @since 0.0.7.0
     * 
     * @param integer $plan_id contains the plan's ID
     * 
     * @return void
     */
    public function plan_limits($plan_id) {
        
        // Load the app's language files
        if ( file_exists( MIDRUB_POSTS_APP_PATH . '/language/' . $this->CI->config->item('language') . '/posts_admin_lang.php' ) ) {
            $this->CI->lang->load( 'posts_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_POSTS_APP_PATH . '/' );
        }
        
        // Get plan's limits
        $plans_limits = (new MidrubAppsCollectionPostsHelpers\Plans_limits)->get_limits();     
        
        return array(
            'limits' => (new MidrubAppsClasses\Plans)->process($plan_id, $plans_limits)          
        );
        
    }
    
    /**
     * The public method ajax processes the ajax's requests
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function ajax() {
        
        // Get action's get input
        $action = $this->CI->input->get('action');

        if ( !$action ) {
            $action = $this->CI->input->post('action');
        }
        
        try {
            
            // Call method if exists
            (new MidrubAppsCollectionPostsControllers\Ajax)->$action();
            
        } catch (Exception $ex) {
            
            $data = array(
                'success' => FALSE,
                'message' => $ex->getMessage()
            );
            
            echo json_encode($data);
            
        }
        
    }
    
    /**
     * The public method cron_jobs loads the cron jobs commands
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function cron_jobs() {

        // Publish scheduled posts
        (new MidrubAppsCollectionPostsControllers\Cron)->publish_scheduled();
        
        // Publish RSS's posts
        (new MidrubAppsCollectionPostsControllers\Cron)->publish_rss_posts();
        
        // Publish scheduled RSS's posts
        (new MidrubAppsCollectionPostsControllers\Cron)->publish_scheduled_rss_posts();
        
    }
    
    /**
     * The public method delete_account is called when user's account is deleted
     * 
     * @param integer $user_id contains the user's ID
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function delete_account($user_id) {
        
        // Delete user's posts
        $this->CI->posts_model->delete_user_posts($user_id);
        
        // Delete user's RSS Feeds
        $this->CI->rss_model->delete_rss_feeds($user_id);        
        
    }
    
    /**
     * The public method hooks contains the app's hooks
     * 
     * @param array $args contains the parameters
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    public function hooks($args) {
        
        // Load the lists model
        $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Lists_model', 'lists_model' );

        // Verify if hook cal is valid
        if ( isset($args['hook']) ) {
            
            switch ( $args['hook'] ) {
            
                case 'delete_social_post':
                    
                    if ( isset($args['post_id']) ) {
                        
                        $this->CI->posts_model->delete_post_records( $this->CI->user_id, $args['post_id'] );
                        
                    }

                    break;
                
                case 'delete_social_group':
                    
                    if ( isset($args['group_id']) ) {
                        
                        $this->CI->lists_model->delete_group_records( $this->CI->user_id, $args['group_id'] );
                        
                    }

                    break;
                    
                case 'delete_social_account':
                    
                    if ( isset($args['account_id']) ) {
                        
                        $this->CI->networks_model->delete_account_records( $this->CI->user_id, $args['account_id'] );
                        
                    }

                    break;
        
            }
            
        }
        
    }
    
    /**
     * The public method app_info contains the app's info
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */
    public function app_info() {
        
        // Load language
        if ( file_exists( MIDRUB_POSTS_APP_PATH . '/language/' . $this->CI->config->item('language') . '/posts_user_lang.php' ) ) {
            $this->CI->lang->load( 'posts_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_POSTS_APP_PATH . '/' );
        }
        
        // Return app information
        return array(
            'app_name' => $this->CI->lang->line('posts'),
            'display_app_name' => $this->CI->lang->line('posts'),
            'app_slug' => 'posts',
            'app_icon' => '<i class="icon-layers"></i>',
            'version' => '0.0.2',
            'required_version' => '0.0.7.4'
        );
        
    }

}
