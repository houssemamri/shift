<?php
/**
 * Activities Controller
 *
 * This file loads the Posts activities
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Activities class loads the app activities
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */
class Activities {
    
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
        
        // Load language
        if ( file_exists( MIDRUB_POSTS_APP_PATH . '/language/' . $this->CI->config->item('language') . '/posts_user_lang.php' ) ) {
            $this->CI->lang->load( 'posts_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_POSTS_APP_PATH . '/' );
        }
        
    }
    
    /**
     * The public method manager loads the activities
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
    public function manager( $user_id, $member_id, $template, $id ) {
        
        // Create an array
        $array = array(
            'MidrubApps',
            'Collection',
            'Posts',
            'Activities',
            ucfirst($template)
        );       

        // Implode the array above
        $cl = implode('\\',$array);

        // Instantiate the class and return response
        return (new $cl())->template( $user_id, $member_id, $id );
        
    }

}
