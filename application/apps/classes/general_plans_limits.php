<?php
/**
 * General Plans Limits Helper
 *
 * This file contains the class General_plans_limits
 * with all general Midrub's limits for plans
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
 */

// Define the page namespace
namespace MidrubApps\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * General_plans_limits class provides the general Midrub's limits
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
*/
class General_plans_limits {
    
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
                'type' => 'text',
                'name' => 'plan_name',
                'title' => $this->CI->lang->line('ma19'),
                'description' => $this->CI->lang->line('plan_name_description')
            ), array (
                'type' => 'text',
                'name' => 'header',
                'title' => $this->CI->lang->line('ma219'),
                'description' => $this->CI->lang->line('plan_header_description')
            ), array (
                'type' => 'textarea',
                'name' => 'features',
                'title' => $this->CI->lang->line('ma27'),
                'description' => $this->CI->lang->line('features_plan_description')
            ), array (
                'type' => 'text',
                'name' => 'plan_price',
                'title' => $this->CI->lang->line('ma20'),
                'description' => $this->CI->lang->line('plan_price_description')
            ), array (
                'type' => 'text',
                'name' => 'currency_sign',
                'title' => $this->CI->lang->line('ma21'),
                'description' => $this->CI->lang->line('currency_sign_description')
            ), array (
                'type' => 'text',
                'name' => 'currency_code',
                'title' => $this->CI->lang->line('ma22'),
                'description' => $this->CI->lang->line('currency_code_description')
            ), array (
                'type' => 'text',
                'name' => 'network_accounts',
                'title' => $this->CI->lang->line('ma23'),
                'description' => $this->CI->lang->line('allowed_accounts_description'),
                'input_type' => 'number'
            ), array (
                'type' => 'text',
                'name' => 'sent_emails',
                'title' => $this->CI->lang->line('ma176'),
                'description' => $this->CI->lang->line('sent_emails_description'),
                'input_type' => 'number'
            ), array (
                'type' => 'text',
                'name' => 'teams',
                'title' => $this->CI->lang->line('teams_members'),
                'description' => $this->CI->lang->line('teams_members_description'),
                'input_type' => 'number'
            ), array (
                'type' => 'text',
                'name' => 'period',
                'title' => $this->CI->lang->line('ma28'),
                'description' => $this->CI->lang->line('plan_period_description'),
                'input_type' => 'number'
            ), array (
                'type' => 'text',
                'name' => 'storage',
                'title' => $this->CI->lang->line('user_storage'),
                'description' => $this->CI->lang->line('user_storage_description'),
                'maxlength' => 12,
                'input_type' => 'number'
            ), array (
                'type' => 'checkbox',
                'name' => 'visible',
                'title' => $this->CI->lang->line('ma180'),
                'description' => $this->CI->lang->line('plan_status_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'popular',
                'title' => $this->CI->lang->line('ma217'),
                'description' => $this->CI->lang->line('plan_popular_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'featured',
                'title' => $this->CI->lang->line('ma259'),
                'description' => $this->CI->lang->line('plan_featured_description')
            ), array (
                'type' => 'checkbox',
                'name' => 'trial',
                'title' => $this->CI->lang->line('ma261'),
                'description' => $this->CI->lang->line('plan_trial_description')
            )
            
        );
        
    }

}

