<?php
/**
 * Multimedia Options
 *
 * This file contains the class Main
 * with all Multimedia app's options for admin
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Options;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * General class provides the general app's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
*/
class Multimedia {
    
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
                'name' => 'app_posts_enable_dropbox',
                'title' => $this->CI->lang->line('enable_dropbox_picker'),
                'description' => $this->CI->lang->line('if_is_enabled_dropbox')
            ), array (
                'type' => 'text',
                'name' => 'app_posts_dropbox_app_key',
                'title' => $this->CI->lang->line('dropbox_appkey'),
                'description' => $this->CI->lang->line('if_is_enabled_dropbox_appkey')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_posts_enable_pixabay',
                'title' => $this->CI->lang->line('enable_pixabay'),
                'description' => $this->CI->lang->line('if_is_enable_pixabay')
            ), array (
                'type' => 'text',
                'name' => 'app_post_pixabay_api_key',
                'title' => $this->CI->lang->line('pixabay_api_key'),
                'description' => $this->CI->lang->line('if_is_enabled_pixabay_api_key')
            )
            
        );
        
    }

}

