<?php
/**
 * Midrub Apps
 *
 * This file loads the Midrub's apps
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps;

defined('BASEPATH') OR exit('No direct script access allowed');

// Verify if file autoload's plugin exists
if ( file_exists( APPPATH . '/apps/autoload.php' ) ) {

    // Require the autoload's plugin file
    require_once APPPATH . '/apps/autoload.php';

}

// Require the functions file
require_once APPPATH . 'apps/inc/functions.php';

// Define the dashboard app's path
defined('MIDRUB_APPS_PATH') OR define('MIDRUB_APPS_PATH', APPPATH . 'apps');

/*
 * MidrubApps is the apps loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */
class MidrubApps {
    
    /**
     * The public method init loads the apps
     * 
     * @since 0.0.7.0
     * 
     * @param string $app contains the application's name
     * 
     * @return void
     */
    public function user_init($app) {
        
        // Create an array
        $array = array(
            'MidrubApps',
            'Collection',
            $app,
            'Main'
        );       

        // Implode the array above
        $cl = implode('\\',$array);
        
        // Instantiate the class
        (new $cl())->user();
        
    }
    
    /**
     * The public method ajax_init processes the ajax calls
     * 
     * @since 0.0.7.0
     * 
     * @param string $app contains the application's name
     * 
     * @return void
     */
    public function ajax_init($app) {
        
        // Create an array
        $array = array(
            'MidrubApps',
            'Collection',
            $app,
            'Main'
        );       

        // Implode the array above
        $cl = implode('\\',$array);
        
        // Instantiate the class
        (new $cl())->ajax();
        
    }
    
    /**
     * The public method activities loads the activities
     * 
     * @since 0.0.7.0
     * 
     * @param string $app contains the application's name
     * @param integer $user_id contains the user's ID
     * @param integer $member_id contains the member's ID
     * @param string $template contains the template's name
     * @param integer $id contains the identificator for the requested template
     * 
     * @return array with template or false
     */
    public function activities( $app, $user_id, $member_id, $template, $id ) {
        
        // Create an array
        $array = array(
            'MidrubApps',
            'Collection',
            $app,
            'Main'
        );       

        // Implode the array above
        $cl = implode('\\',$array);
        
        // Instantiate the class
        return (new $cl())->activities( $user_id, $member_id, $template, $id );
        
    }
    
    /**
     * The public method options returns user or admin options
     * 
     * @since 0.0.7.0
     * 
     * @param string $app contains the application's name
     * @param string $role contains the user's role
     * 
     * @return array with options
     */
    public function options($app, $role) {
        
        // Create an array
        $array = array(
            'MidrubApps',
            'Collection',
            ucfirst(str_replace('-', '_', $app)),
            'Main'
        );       

        // Implode the array above
        $cl = implode('\\',$array);
        
        if ( $role === 'admin' ) {
        
            // Instantiate the class
            return (new $cl())->admin_options();
        
        }
        
    }
    
    /**
     * The public method plan_limits the admin plans limits
     * 
     * @since 0.0.7.0
     * 
     * @param string $app contains the application's name
     * 
     * @return array with plans limits
     */
    public function plan_limits($app) {
        
        // Create an array
        $array = array(
            'MidrubApps',
            'Collection',
            $app,
            'Main'
        );       

        // Implode the array above
        $cl = implode('\\',$array);
        
        // Instantiate the class
        return (new $cl())->plan_limits();
        
    }

}
