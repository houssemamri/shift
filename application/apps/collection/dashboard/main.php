<?php
/**
 * Midrub Apps Dashboard
 *
 * This file loads the Dashboard app
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Dashboard;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Classes as MidrubAppsClasses;
use MidrubApps\Interfaces as MidrubAppsInterfaces;
use MidrubApps\Collection\Dashboard\Controllers as MidrubAppsCollectionDashboardControllers;
use MidrubApps\Collection\Dashboard\Options as MidrubAppsCollectionDashboardOptions;
use MidrubApps\Collection\Dashboard\Helpers as MidrubAppsCollectionDashboardHelpers;

if ( !defined('MIDRUB_DASHBOARD_APP_PATH') ) {
    define('MIDRUB_DASHBOARD_APP_PATH', APPPATH . 'apps/collection/dashboard');
}

/*
 * Main class loads the Dashboard app loader
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
        if ( !get_option('app_dashboard_enable') || !plan_feature('app_dashboard') ) {
            show_404();
        }
        
        // Instantiate the class
        (new MidrubAppsCollectionDashboardControllers\User)->view();
        
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
    public function activities( $user_id, $member_id, $template, $id  ) {
        
        
        
    }

    /**
     * The public method user_options displays the app's options for user
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function user_options() {
        
        return false;
        
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
        if ( file_exists( MIDRUB_DASHBOARD_APP_PATH . '/language/' . $this->CI->config->item('language') . '/dashboard_admin_lang.php' ) ) {
            $this->CI->lang->load( 'dashboard_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_DASHBOARD_APP_PATH . '/' );
        }
        
        // Get general's options
        $general_options = (new MidrubAppsCollectionDashboardOptions\General)->get_options();
        
        return array(
            'general_options' => array(
                'tab' => $this->CI->lang->line('general'),
                'options' => (new MidrubAppsClasses\Options)->process($general_options)
            )           
        );
        
    }
    
    /**
     * The public method plan_limits displays the options for the plans
     * 
     * @since 0.0.7.0
     * 
     * @param integer $plan_id contains the plan's ID
     * 
     * @return void
     */
    public function plan_limits($plan_id) {
        
        // Load the app's language files
        if ( file_exists( MIDRUB_DASHBOARD_APP_PATH . '/language/' . $this->CI->config->item('language') . '/dashboard_admin_lang.php' ) ) {
            $this->CI->lang->load( 'dashboard_admin', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_DASHBOARD_APP_PATH . '/' );
        }
        
        // Get plan's limits
        $plans_limits = (new MidrubAppsCollectionDashboardHelpers\Plans_limits)->get_limits();     
        
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
            (new MidrubAppsCollectionDashboardControllers\Ajax)->$action();
            
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
        
    }
    
    /**
     * The public method app_info contains the app's info
     * 
     * @since 0.0.7.4
     * 
     * @return array with app's information
     */
    public function app_info() {
        
        // Load the app's language files
        if ( file_exists( MIDRUB_DASHBOARD_APP_PATH . '/language/' . $this->CI->config->item('language') . '/dashboard_user_lang.php' ) ) {
            $this->CI->lang->load( 'dashboard_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_DASHBOARD_APP_PATH . '/' );
        }
        
        // Return app information
        return array(
            'app_name' => $this->CI->lang->line('dashboard'),
            'display_app_name' => $this->CI->lang->line('dashboard'),
            'app_slug' => 'dashboard',
            'app_icon' => '<i class="icon-speedometer"></i>',
            'version' => '0.0.2',
            'required_version' => '0.0.7.4'
        );
        
    }

}
