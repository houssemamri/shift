<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Name: User Helper
 * Author: Scrisoft
 * Created: 20/11/2017
 * 
 * Here you will find the following functions:
 * user_header - gets information to display in the user top page
 * user_custom_header - custom the user's header with css files
 * get_user_email_by_id - gets the user email by user's id
 * */

if ( !function_exists('user_header') ) {

    /**
     * The function generates statistics for user header
     *
     * @return array with statistics
     */
    function user_header() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Notifications Model
        $CI->load->model('notifications');
        
        // Load Tickets Model
        $CI->load->model('tickets');
        
        $user_profile = array();
        
        if ( !$CI->session->userdata( 'member' ) ) {
        
            // Gets current user's information
            $user_info = $CI->user->get_user_info( $CI->user_id );

            if ( $user_info['first_name'] ) {

                $user_profile['name'] = $user_info['first_name'] . ' ' . $user_info['last_name'];

            } else {

                $user_profile['name'] = $user_info['username'];

            }

            $user_profile['email'] = $user_info['email'];
            
        } else {
            
            // Load Team Model
            $CI->load->model('team');
            
            // Get member team info
            $member_info = $CI->team->get_member( $CI->user_id, 0, $CI->session->userdata( 'member' ) );

            $user_profile['name'] = $member_info[0]->member_username;

            $user_profile['email'] = $member_info[0]->member_email;
            
        }
        
        // Get notifications
        $notifications = $CI->notifications->get_notifications( $CI->user_id );
        
        $ntfcs = '';
        
        $count = 0;
        
        // Verify if notifications exists
        if ($notifications) {
            
            // List all notifications
            foreach ($notifications as $notification) {
                
                // Define variable new
                $new = '';
                
                // Verify if user has read the notification
                if ( $notification->user_id != $CI->user_id ) {
                    
                    $new = 'new';
                    $count++;
                    
                }
                
                $ntfcs .= '<li class="' . $new . '">
                            <div class="row">
                                <div class="col-lg-2 col-xs-3"><i class="icon-bell"></i></div>
                                <div class="col-lg-10 col-xs-9"><p><a href="' . site_url('user/notifications') . '#' . $notification->id . '">' . $notification->notification_title . '</a></p><span>' . calculate_time($notification->sent_time, time()) . '</span> </div>
                            </div>
                        </li>';
            }
            
        } else {
            
            // No notifications message
            $ntfcs = '<li><div class="col-xl-12 clean col-xs-12"><p class="no-results">' . $CI->lang->line('mm131') . '</p></div></li>';
            
        }
        
        // Get all tickets
        $all_tickets = $CI->tickets->get_all_tickets_for( $CI->user_id );
        
        $tickets = '';
        
        $counti = 0;
        
        // Verify if tickets exists
        if ( $all_tickets ) {
            
            // List all tickets
            foreach ( $all_tickets as $ticket ) {
                
                // Define new variable
                $new = '';
                
                // Verify if the ticket was read already
                if ( $ticket->status == 2 ) {
                    
                    $new = 'new';
                    $counti++;
                    
                }
                
                $tickets .= '<li class="' . $new . '">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-3"><i class="icon-question"></i></div>
                                    <div class="col-lg-10 col-xs-9"><p><a href="' . site_url('user/get-ticket/' . $ticket->ticket_id) . '">' . $ticket->subject . '</a></p><span>' . calculate_time($ticket->created, time()) . '</span></div>
                                </div>
                            </li>';
            }
            
        } else {
            
            // No tickets found
            $tickets = '<li><div class="col-lg-12 clean col-xs-12"><p class="no-results">' . $CI->lang->line('mm201') . '</p></div></li>';
            
        }
        
        // Create an array 
        return array(
            'new_notifications' => $count,
            'new_tickets' => $counti,
            'notifications' => $ntfcs,
            'tickets' => $tickets,
            'user_profile' => $user_profile
        );
        
    }

}

if ( !function_exists('user_custom_header') ) {
    
    /**
     * The function helps to custom the header
     * 
     * @return string with custom code
     */
    function user_custom_header() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Add main stylesheet file
        $data = '';
        
        if ( $CI->router->fetch_method() === 'emails' ) {
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/css/jquery-ui.min.css" media="all"/> ';
            $data .= "\n";
        }

        if ( $CI->router->fetch_method() === 'team' ) {
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/user/styles/css/teams.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";
        }
        
        if ( $CI->router->fetch_method() === 'settings' ) {
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/user/styles/css/settings.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";
        }
        
        if ( $CI->router->fetch_method() === 'faq_page' || $CI->router->fetch_method() === 'faq_categories' || $CI->router->fetch_method() === 'faq_article' || $CI->router->fetch_method() === 'ticket' ) {
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/user/styles/css/faq.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";
        } 
        
        return $data;
        
    }

}

if (!function_exists('get_user_email_by_id')) {
    
    /**
     * The function get_user_email_by_id gets user's email by user_id
     * 
     * @param integer $user_id contains the user's id
     * 
     * @return string with email or false
     */
    function get_user_email_by_id($user_id) {
        
        $CI = get_instance();
        
        $email = $CI->user->get_email_by('user_id', $user_id);
        
        if ( $email ) {
            
            return $email;
            
        } else {
        
            return false;
            
        }
        
    }
    
}