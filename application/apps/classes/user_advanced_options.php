<?php
/**
 * Advanced User Options
 *
 * This file contains the class User_advanced_options
 * with all advanced user's options
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
 */

// Define the page namespace
namespace MidrubApps\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User_advanced_options class provides the advanced user's options
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.5
*/
class User_advanced_options {
    
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
        
        // Array with advanced user's options
        return array (
            
            array (
                'type' => 'textedit',
                'name' => 'first_name',
                'title' => $this->CI->lang->line('first_name'),
                'description' => $this->CI->lang->line('first_name_description'),
                'edit' => true
            ), array (
                'type' => 'textedit',
                'name' => 'last_name',
                'title' => $this->CI->lang->line('last_name'),
                'description' => $this->CI->lang->line('last_name_description'),
                'edit' => true
            ), array (
                'type' => 'textedit',
                'name' => 'username',
                'title' => $this->CI->lang->line('username'),
                'description' => $this->CI->lang->line('username_description'),
                'edit' => false
            ), array (
                'type' => 'textedit',
                'name' => 'email',
                'title' => $this->CI->lang->line('email'),
                'description' => $this->CI->lang->line('email_description'),
                'edit' => true
            ), array (
                'type' => 'modal_link',
                'name' => 'change-password',
                'title' => $this->CI->lang->line('password'),
                'description' => $this->CI->lang->line('password_description'),
                'modal_link' => $this->CI->lang->line('change_password'),
                'edit' => false
            ), array (
                'type' => 'textedit',
                'name' => 'country',
                'title' => $this->CI->lang->line('country'),
                'description' => $this->CI->lang->line('country_description'),
                'edit' => true
            ), array (
                'type' => 'textedit',
                'name' => 'city',
                'title' => $this->CI->lang->line('city'),
                'description' => $this->CI->lang->line('city_description'),
                'edit' => true
            ), array (
                'type' => 'textedit',
                'name' => 'address',
                'title' => $this->CI->lang->line('address'),
                'description' => $this->CI->lang->line('address_description'),
                'edit' => true
            ), array (
                'type' => 'modal_link',
                'name' => 'delete-account',
                'title' => $this->CI->lang->line('delete_account'),
                'description' => $this->CI->lang->line('delete_account_description'),
                'modal_link' => $this->CI->lang->line('delete_my_account'),
                'edit' => false
            )
            
        );
        
    }

}

