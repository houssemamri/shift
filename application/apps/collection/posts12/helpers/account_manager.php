<?php
/**
 * Accounts Manager Helpers
 *
 * This file contains the class Account_manager
 * with methods to manage the accounts in the Posts Accounts Manager
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Helpers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Collection\Posts\Helpers as MidrubAppsCollectionPostsHelpers;

/*
 * Account_manager class provides the methods for the Posts Accounts Manager
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.4
*/
class Account_manager {
    
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
     * The public method load_networks loads all social networks available for user
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function load_networks() {
        
        // Get all available social networks.
        require_once APPPATH . 'interfaces/Autopost.php';

        $classes = '';
        
        $social_networks = '';

        foreach ( glob(APPPATH . 'autopost/*.php') as $filename ) {

            require_once $filename;

            $className = str_replace([APPPATH . 'autopost/', '.php'], '', $filename);

            // Check if the administrator has disabled the $className social network
            if ( !get_option(strtolower($className)) || !plan_feature(strtolower($className)) ) {
                continue;
            }

            // Get class's name
            $get = new $className;

            // Verify if the social networks is available
            if ( $get->check_availability() ) {

                $con = $this->CI->networks->get_network_data(strtolower($className), $this->CI->user_id);

                $info = $get->get_info();
                
                if ( !in_array('post', $info->types) && !in_array('rss', $info->types) && !in_array('insights', $info->types) ) {
                    continue;
                }

                $num_accounts = 0;

                if ( @$con[0]->num ) {

                    $num_accounts = $con[0]->num;

                }

                $netw = ucwords(str_replace('_', ' ', $className));

                $network_selected = '';

                if ( !$classes ) {
                    $network_selected = ' class="network-selected"';
                    $classes = $className;
                }

                $social_networks .= '<li' . $network_selected . '>'
                        . '<a href="#" data-network="' . $className . '">'
                            . '<div>' . $netw . '</div>'
                            . '<span style="background-color:' . $info->color . '">' . $num_accounts . ' ' . $this->CI->lang->line('mu111') . '</span>'
                        . '</a>'
                    . '</li>';
                

            }

        }
        
        if ( $social_networks ) {
            
            // Get Active Accounts
            $active_accounts = $this->CI->networks_model->get_accounts_by_network( $this->CI->user_id, $classes, 1 );
            
            $settings = (new MidrubAppsCollectionPostsHelpers\Accounts)->get_network_info($classes);
            
            $icon = '';
            
            if ( $settings ) {
                
                $icon = $settings['icon'];
                $hidden = $settings['hidden'];
                        
            } else {
                $hidden = '';
            }
            
            $display_hidden_content = '';
            
            if ( $hidden ) {
                $display_hidden_content = ' manage-accounts-display-hidden-content';
            }
            
            $social_data = '<div class="row">'
                                . '<div class="col-xl-3">'
                                    . '<ul class="nav nav-tabs tabs-left accounts-manager-available-networks">'
                                        . $social_networks
                                    . '</ul>'
                                . '</div>'
                                . '<div class="col-xl-5">'
                                    . '<div class="row manage-accounts-search-form">'
                                        . '<div class="col-xl-7 col-sm-7 col-7">'
                                            . '<div class="input-group accounts-manager-search">'
                                                . '<div class="input-group-prepend">'
                                                    . '<i class="icon-magnifier"></i>'
                                               . ' </div>'
                                                . '<input type="text" class="form-control accounts-manager-search-for-accounts" data-network="' . $classes . '" placeholder="' . $this->CI->lang->line('search_for_accounts')  . '">'
                                            . '</div>'
                                        . '</div>'
                                        . '<div class="col-xl-5 col-sm-5 col-5">'
                                            . '<button type="button" class="manage-accounts-new-account' . $display_hidden_content . '">'
                                                . $icon . ' ' . $this->CI->lang->line('new_account')
                                            . '</button>'
                                            . '<button type="button" class="cancel-accounts-manager-search">'
                                                . '<i class="icon-close"></i>'
                                            . '</button>'
                                        . '</div>'
                                    . '</div>'
                                    . '<div class="row">'
                                        . '<div class="col-xl-12 manage-accounts-hidden-content">'
                                            . $hidden
                                        . '</div>'
                                    . '</div>'                    
                                    . '<div class="row">'
                                        . '<div class="col-xl-12 manage-accounts-all-accounts">'
                                            . (new MidrubAppsCollectionPostsHelpers\Accounts)->get_active_accounts($this->CI->networks_model->get_accounts_by_network( $this->CI->user_id, $classes, 0 ), 0) . (new MidrubAppsCollectionPostsHelpers\Accounts)->get_active_accounts($active_accounts, 1)
                                        . '</div>'
                                    . '</div>'
                                . '</div>'
                                . '<div class="col-xl-4">'
                                    . '<div class="col-xl-12 manage-accounts-network-instructions">'
                                        . (new MidrubAppsCollectionPostsHelpers\Accounts)->get_network_instructions( $classes )
                                    . '</div>'
                                . '</div>'
                            . '</div>';
            
            // Load the lists model
            $this->CI->load->ext_model( MIDRUB_POSTS_APP_PATH . '/models/', 'Lists_model', 'lists_model' );

            // Get groups list
            $groups_list = $this->CI->lists_model->get_groups($this->CI->user_id, 0, 1000);
            
            $groups = '';
            
            if ( $groups_list ) {
            
                foreach ( $groups_list as $group ) {

                    $groups .= '<button class="dropdown-item" type="button" data-id="' . $group->list_id . '">'
                                    . $group->name
                                . '</button>';

                }
                
            }
            
            $groups_data = '<div class="row">'
                                . '<div class="col-xl-3">'
                                    . '<ul class="nav nav-tabs tabs-left accounts-manager-available-networks">'
                                        . $social_networks
                                    . '</ul>'
                                . '</div>'
                                . '<div class="col-xl-9">'
                                    . '<div class="row">'
                                        . '<div class="col-xl-6">'
                                            . '<div class="col-xl-12">'
                                                . '<div class="row">'
                                                    . '<div class="col-xl-12 input-group accounts-manager-search-accounts">'
                                                        . '<div class="input-group-prepend">'
                                                            . '<i class="icon-magnifier"></i>'
                                                        . '</div>'
                                                        . '<input type="text" class="form-control accounts-manager-search-for-accounts" placeholder="' . $this->CI->lang->line('search_for_accounts')  . '">'
                                                        . '<button type="button" class="cancel-accounts-manager-search">'
                                                            . '<i class="icon-close"></i>'
                                                        . '</button>'
                                                    . '</div>'
                                                . '</div>'
                                                . '<div class="row">'
                                                    . '<div class="col-xl-12 manage-accounts-groups-all-accounts">'
                                                        . (new MidrubAppsCollectionPostsHelpers\Accounts)->get_active_accounts($active_accounts, 2)
                                                    . '</div>'
                                                . '</div>'
                                            . '</div>'
                                        . '</div>'
                                        . '<div class="col-xl-6">'
                                            . form_open('user/app/posts', array('class' => 'create-new-group-form', 'data-csrf' => $this->CI->security->get_csrf_token_name()))
                                            . '<div class="col-xl-12">'
                                                . '<div class="row accounts-manager-groups-create-group">'
                                                    . '<div class="col-xl-7 col-sm-7 col-7 input-group">'
                                                        . '<div class="input-group-prepend">'
                                                            . '<i class="icon-folder-alt"></i>'
                                                        . '</div>'
                                                        . '<input type="text" class="form-control accounts-manager-groups-enter-group-name" placeholder="' . $this->CI->lang->line('enter_group_name') . '" required>'
                                                    . '</div>'
                                                    . '<div class="col-xl-5 col-sm-5 col-5">'
                                                        . '<button type="submit" class="accounts-manager-groups-save-group">'
                                                            . '<i class="far fa-save"></i> ' . $this->CI->lang->line('save_group')
                                                        . '</button>'
                                                    . '</div>'
                                                . '</div>'
                                                . '<div class="row accounts-manager-groups-select-group">'
                                                    . '<div class="col-xl-12">'
                                                        . '<div class="btn-group">'
                                                            . '<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                                                . $this->CI->lang->line('select_group')
                                                            . '</button>'
                                                            . '<div class="dropdown-menu dropdown-menu-right">'
                                                                . $groups
                                                            . '</div>'
                                                        . '</div>'
                                                    . '</div>'
                                                    . '<div class="col-xl-12 clean">'
                                                        . '<ul class="accounts-manager-groups-available-accounts">'
                                                        . '</ul>'
                                                    . '</div>'
                                                    . '<div class="col-xl-12">'
                                                        . '<button type="button" class="btn btn-danger accounts-manager-delete-group">'
                                                            . '<i class="icon-trash"></i> ' . $this->CI->lang->line('delete_group')
                                                        . '</button>'
                                                    . '</div>'                                               
                                                . '</div>'
                                            . '</div>'
                                            . form_close()
                                        . '</div>'
                                    . '</div>'
                                . '</div>'
                            . '</div>';
            
            $data = array(
                'success' => TRUE,
                'social_data' => $social_data,
                'groups_data' => $groups_data
            );

            echo json_encode($data);
        
        }
        
    }  
    
    /**
     * The public method get_accounts gets social network's accounts
     * 
     * @since 0.0.7.4
     * 
     * @return void
     */ 
    public function get_accounts() {
        
        // Get network's input
        $network = $this->CI->input->get('network');
        
        // Get type's input
        $type = $this->CI->input->get('type');
        
        if ( $network && $type ) {
            
        $data = array(
            'success' => TRUE,
            'type' => $type
        );
        
        if ( $type === 'accounts_manager' ) {
            
            $settings = (new MidrubAppsCollectionPostsHelpers\Accounts)->get_network_info($network);
            
            $icon = '';
            
            if ( $settings ) {
                
                $icon = $settings['icon'];
                $data['hidden'] = $settings['hidden'];
                        
            } else {
                $data['hidden'] = '';
            }
            
            $display_hidden_content = '';
            
            if ( $data['hidden'] ) {
                $display_hidden_content = ' manage-accounts-display-hidden-content';
            }
            
            $data['active'] = (new MidrubAppsCollectionPostsHelpers\Accounts)->get_active_accounts($this->CI->networks_model->get_accounts_by_network( $this->CI->user_id, $network, 0 ), 0) . (new MidrubAppsCollectionPostsHelpers\Accounts)->get_active_accounts($this->CI->networks_model->get_accounts_by_network( $this->CI->user_id, $network, 1 ), 1);
            $data['instructions'] = (new MidrubAppsCollectionPostsHelpers\Accounts)->get_network_instructions($network);
            $data['search_form'] = '<div class="col-xl-7">'
                                        . '<div class="input-group accounts-manager-search">'
                                            . '<div class="input-group-prepend">'
                                                . '<i class="icon-magnifier"></i>'
                                            . '</div>'
                                            . '<input type="text" class="form-control accounts-manager-search-for-accounts" data-network="' . $network . '" placeholder="' . $this->CI->lang->line('search_for_accounts')  . '">'
                                        . '</div>'
                                    . '</div>'
                                    . '<div class="col-xl-5">'
                                        . '<button type="button" class="manage-accounts-new-account' . $display_hidden_content . '">'
                                            . $icon . ' ' . $this->CI->lang->line('new_account')
                                        . '</button>'
                                        . '<button type="button" class="cancel-accounts-manager-search">'
                                            . '<i class="icon-close"></i>'
                                        . '</button>'
                                    . '</div>';

            } else {

                $data['active'] = (new MidrubAppsCollectionPostsHelpers\Accounts)->get_active_accounts($this->CI->networks_model->get_accounts_by_network( $this->CI->user_id, $network, 1 ), 2);

            }

            echo json_encode($data);
        
        } else {
            
            $data = array(
                'success' => FALSE,
                'message' => $this->CI->lang->line('error_occurred')
            );

            echo json_encode($data);  
            
        }
        
    }  
    
}

