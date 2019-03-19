<?php
/**
 * Plans Limits Helper
 *
 * This file contains the class Plans_limits
 * with all app's limits for plans
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Plans_limits class provides the app's limits
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
*/
class Plans_limits {
    
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
        
        // Array with all admin's options
        return array (
            
            array (
                'type' => 'checkbox',
                'name' => 'app_posts',
                'title' => $this->CI->lang->line('enable_app'),
                'description' => $this->CI->lang->line('if_is_enabled_plan')
            ), array (
                'type' => 'text',
                'name' => 'publish_posts',
                'title' => $this->CI->lang->line('number_published_posts_month'),
                'description' => $this->CI->lang->line('number_published_posts_month_description'),
                'input_type' => 'number'
            ), array (
                'type' => 'text',
                'name' => 'rss_feeds',
                'title' => $this->CI->lang->line('number_allowed_rss'),
                'description' => $this->CI->lang->line('number_allowed_rss_description'),
                'input_type' => 'number'
            )
            
        );
        
    }
    
    /**
     * The public method get_usage returns usage per plan's limit
     * 
     * @param string $name contains the param's name
     * 
     * @since 0.0.7.4
     * 
     * @return array with limits
     */ 
    public function get_usage($name) {
        
        switch ( $name ) {
            
            case 'publish_posts':
                
                // Get published posts
                $published_posts = get_user_option( 'published_posts' );

                // Create $published variable
                $published = 0;

                if ( $published_posts ) {

                    $posts_data = unserialize($published_posts);

                    if ( ($posts_data['date'] === date('Y-m')) ) {

                        $published = $posts_data['posts'];

                    }

                }
                
                return $published;
                
            case 'rss_feeds':
                
                // Get total number of rss feeds
                $rss_feeds_total = $this->CI->rss_model->get_rss_feeds( $this->CI->user_id, 0, 0, '' );
                
                if ( !$rss_feeds_total ) {
                    $rss_feeds_total = 0;
                }
                
                return $rss_feeds_total;                
            
        }
        
    }

}

