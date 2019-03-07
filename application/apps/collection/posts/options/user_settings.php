<?php
/**
 * User Settings
 *
 * This file contains the class General
 * with all user's settings in the settings page
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Options;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User_settings class provides the general app's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
*/
class User_settings {
    
    /**
     * Class variables
     *
     * @since 0.0.7.5
     */
    protected $CI;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.5
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
    }

    /**
     * The public method get_options return array with all class's options
     * 
     * @since 0.0.7.5
     * 
     * @return array with options
     */ 
    public function get_options() {
        
        return array (
            
            array (
                'type' => 'checkbox',
                'name' => 'settings_character_count',
                'title' => $this->CI->lang->line('character_count'),
                'description' => $this->CI->lang->line('character_count_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'error_notifications',
                'title' => $this->CI->lang->line('email_errors'),
                'description' => $this->CI->lang->line('email_errors_if_enabled')
            ), array (
                'type' => 'checkbox',
                'name' => 'settings_display_groups',
                'title' => $this->CI->lang->line('display_groups'),
                'description' => $this->CI->lang->line('display_groups_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'settings_social_pagination',
                'title' => $this->CI->lang->line('accounts_pagination'),
                'description' => $this->CI->lang->line('accounts_pagination_description')
            )
            
        );
        
    }

}

