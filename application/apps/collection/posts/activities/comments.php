<?php
/**
 * Comments Template
 *
 * This file contains the class Posts
 * with contains the Posts template
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Activities;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Collection\Posts\Interfaces as MidrubAppsCollectionPostsInterfaces;
use MidrubApps\Collection\Posts\Helpers as MidrubAppsCollectionPostsHelpers;

/*
 * Comments class provides the methods to process the comments template
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
*/
class Comments implements MidrubAppsCollectionPostsInterfaces\Activities {
    
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
     * The public method template returns the Ativities template
     * 
     * @since 0.0.7.0
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $member_id contains the member's ID
     * @param integer $id contains the identificator for the requested template
     * 
     * @return array with template's data
     */ 
    public function template( $user_id, $member_id, $id ) {
        
        // Define the activity's array
        $activity = array();
        
        // Define the activity's header
        $header = '';
        
        // Define the header text
        $has_published_comment = $this->CI->lang->line('has_published_comment');

        // Verify if team's member exists
        if ( $member_id > 0 ) {

            // Load Team Model
            $this->CI->load->model('team');

            // Get team's member information
            $member = $this->CI->team->get_member($user_id, $member_id);

            if ( $member ) {

                $header = $member[0]->member_username . ' ' . $has_published_comment;

            } else {

                $header = $this->CI->session->userdata['username'] . ' ' . $has_published_comment;

            }

        } else {

            $header = $this->CI->session->userdata['username'] . ' ' . $has_published_comment;

        }
        
        $network_data = $this->CI->networks_model->get_account($id);
        
        if ( $network_data ) {
            
                // Get network's name
            $network = ucfirst($network_data[0]->network_name);
            
            // Require Autopost's interface
            require_once APPPATH . 'interfaces/Autopost.php';

            // Check if the $network exists in autopost
            if (file_exists(APPPATH . 'autopost/' . $network . '.php')) {

                // Now we need to get the key
                require_once APPPATH . 'autopost/' . $network . '.php';

                // Call the network class
                $get = new $network;

                // Add network info in the array
                $info = $get->get_info();

                $header = $header . ' ' . $info->icon;
                
            }

            $header = $header . '<strong>' . $network_data[0]->user_name . '</strong>';
            
        }

        $activity['header'] = $header;
        
        $activity['body'] = '';

        $activity['medias'] = '';

        $activity['footer'] = '';
        
        $activity['icon'] = '<i class="icon-layers"></i>';

        return $activity;
        
    }
    
    /**
     * The public method adapter adapts database content for template
     * 
     * @since 0.0.7.0
     * 
     * @param integer $user_id contains the user's ID
     * @param integer $member_id contains the member's ID
     * @param integer $id contains the identificator for the requested template
     * 
     * @return array with db's data
     */ 
    public function adapter( $user_id, $member_id, $id ) {
        
    }

}

