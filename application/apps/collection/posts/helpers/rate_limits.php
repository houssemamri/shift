<?php
/**
 * Rate Limits Helpers
 *
 * This file contains the class Rate Limits
 * with methods to process the plan's limits for the Posts app
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Rate_limits class provides the methods to verify the plan limits
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
*/
class Rate_limits {
    
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
     * The public method posts_plan_limit verifies if user have reached the maximum number of posts for this month
     * 
     * @since 0.0.7.4
     * 
     * @param integer $user_id contains the user's id
     * 
     * @return true or false
     */ 
    public function posts_plan_limit($user_id) {
        
        // Get number of published posts in this month for the user
        $posts_published = get_user_option('published_posts', $user_id);

        if ( $posts_published ) {
            
            $posts_published = unserialize($posts_published);

            $published_limit = plan_feature('publish_posts');

            if ( ($posts_published['date'] == date('Y-m')) AND ( $published_limit <= $posts_published ['posts']) ) {

                return true;

            }

        }
        
        return false;
        
    }
    
    /**
     * The public method rss_plan_limit verifies if the user can add new RSS's feeds
     * 
     * @since 0.0.7.4
     * 
     * @param integer $user_id contains the user's id
     * 
     * @return true or false
     */ 
    public function rss_plan_limit($user_id) {
        
        // Get total number of rss feeds
        $rss_feeds_total = $this->CI->rss_model->get_rss_feeds( $user_id, 0, 0, '' );

        if ( $rss_feeds_total ) {

            $rss_limit = plan_feature('rss_feeds');

            if ( $rss_limit <= $rss_feeds_total ) {

                return true;

            }

        }
        
        return false;
        
    }    

}

