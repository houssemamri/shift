<?php
/**
 * General Options
 *
 * This file contains the class General
 * with all general app's options for admin
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
                'name' => 'app_posts_enable',
                'title' => $this->CI->lang->line('enable_app'),
                'description' => $this->CI->lang->line('if_is_enabled')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_posts_enable_composer',
                'title' => $this->CI->lang->line('enable_app_composer'),
                'description' => $this->CI->lang->line('if_is_enabled_composer')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_posts_enable_scheduled',
                'title' => $this->CI->lang->line('enable_app_scheduled'),
                'description' => $this->CI->lang->line('if_is_enabled_scheduled')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_posts_enable_insights',
                'title' => $this->CI->lang->line('enable_app_insights'),
                'description' => $this->CI->lang->line('if_is_enabled_insights')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_posts_enable_history',
                'title' => $this->CI->lang->line('enable_app_history'),
                'description' => $this->CI->lang->line('if_is_enabled_history')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_posts_rss_feeds',
                'title' => $this->CI->lang->line('enable_rss_feeds'),
                'description' => $this->CI->lang->line('if_is_enabled_rss_feeds')
            ), array (
                'type' => 'checkbox',
                'name' => 'app_posts_enable_faq',
                'title' => $this->CI->lang->line('enable_rss_faq'),
                'description' => $this->CI->lang->line('if_is_enable_rss_faq')
            ) 
            
        );
        
    }

}

