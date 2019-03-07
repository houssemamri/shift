<?php
/**
 * General Options
 *
 * This file contains the class Main
 * with all general app's options for admin
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Dashboard\Options;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * General class provides the general app's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
*/
class General {
    
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
        
    }

    /**
     * The public method get_options return array with all class's options
     * 
     * @since 0.0.7.0
     * 
     * @return array with options
     */ 
    public function get_options() {
        
        // Array with all admin's options
        return array (
            
            array (
                'type' => 'checkbox',
                'name' => 'app_dashboard_enable',
                'title' => $this->CI->lang->line('enable_app'),
                'description' => $this->CI->lang->line('if_is_enabled')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_dashboard_enable_default_widgets',
                'title' => $this->CI->lang->line('enable_app_default_widgets'),
                'description' => $this->CI->lang->line('if_is_enabled_default_widgets')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_dashboard_left_side_position',
                'title' => $this->CI->lang->line('left_side_defaul_widgets'),
                'description' => $this->CI->lang->line('if_is_enabled_default_side')
            )
            
        );
        
    }

}

