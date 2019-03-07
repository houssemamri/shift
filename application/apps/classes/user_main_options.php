<?php
/**
 * Main User Options
 *
 * This file contains the class User_main_options
 * with all main user's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
 */

// Define the page namespace
namespace MidrubApps\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User_main_options class provides the user's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
*/
class User_main_options {
    
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
        
        // Array with main user's options
        return array (
            
            array (
                'type' => 'checkbox',
                'name' => 'email_notifications',
                'title' => $this->CI->lang->line('email_notifications'),
                'description' => $this->CI->lang->line('email_notifications_if_enabled'),
            ), array (
                'type' => 'checkbox',
                'name' => 'notification_tickets',
                'title' => $this->CI->lang->line('tickets_email_notification'),
                'description' => $this->CI->lang->line('notifications_about_tickets_replies')
            ), array (
                'type' => 'checkbox',
                'name' => 'display_activities',
                'title' => $this->CI->lang->line('display_activities'),
                'description' => $this->CI->lang->line('display_activities_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'settings_delete_activities',
                'title' => $this->CI->lang->line('settings_delete_activities'),
                'description' => $this->CI->lang->line('settings_delete_activities_description')
            ), array (
                'type' => 'checkbox',
                'name' => '24_hour_format',
                'title' => $this->CI->lang->line('24_hour_format'),
                'description' => $this->CI->lang->line('24_hour_format_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'invoices_by_email',
                'title' => $this->CI->lang->line('invoices_by_email'),
                'description' => $this->CI->lang->line('invoices_by_email_description')
            )
            
        );
        
    }

}

