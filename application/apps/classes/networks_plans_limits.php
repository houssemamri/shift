<?php
/**
 * Networks Plans Limits Helper
 *
 * This file contains the class Networks_plans_limits
 * with all general Midrub's limits for plans
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
 */

// Define the page namespace
namespace MidrubApps\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Networks_plans_limits class provides the general Midrub's limits
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
*/
class Networks_plans_limits {
    
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
        
    }

    /**
     * The public method get_limits return array with all plan's limits
     * 
     * @since 0.0.7.4
     * 
     * @return array with limits
     */ 
    public function get_limits() {
        
        // Get all available social networks.
        require_once APPPATH . 'interfaces/Autopost.php';

        $classes = array();

        foreach ( glob(APPPATH . 'autopost/*.php') as $filename ) {

            require_once $filename;

            $className = str_replace([APPPATH . 'autopost/', '.php'], '', $filename);

            // Check if the administrator has disabled the $className social network
            if ( !get_option(strtolower($className)) ) {
                continue;
            }

            // Get class's name
            $get = new $className;

            // Verify if the social networks is available
            if ( $get->check_availability() ) {

                $info = $get->get_info();

                $classes[] = array (
                                'type' => 'checkbox',
                                'name' => strtolower($className),
                                'title' => ucwords(str_replace('_', ' ', $className)),
                                'description' => $this->CI->lang->line('networks_plan_description')
                            );

            }

        }
        
        // Array with all admin's options
        return $classes;
        
    }

}

