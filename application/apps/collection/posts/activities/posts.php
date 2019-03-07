<?php
/**
 * Posts Template
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
 * Posts class provides the methods to process the posts template
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
*/
class Posts implements MidrubAppsCollectionPostsInterfaces\Activities {
    
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
        $has_published_post = $this->CI->lang->line('has_published_post');
        
        // Get post data by user id and post id
        $get_post = $this->CI->posts_model->get_post( $user_id, $id );
        
        if ( $get_post ) {
            
            $time = $get_post['time'];

            if ( $get_post['status'] < 1 ) {
                $time = $this->CI->lang->line('draft_post');
                $has_published_post = $this->CI->lang->line('has_drafted_post');
            } else if ( $time > time() ) {
                $has_published_post = $this->CI->lang->line('has_scheduled_post') . ' ' . strip_tags(calculate_time($time,time()));
            }
            
            // Verify if team's member exists
            if ( $member_id > 0 ) {

                // Load Team Model
                $this->CI->load->model('team');

                // Get team's member information
                $member = $this->CI->team->get_member($user_id, $member_id);

                if ( $member ) {

                    $header = $member[0]->member_username . ' ' . $has_published_post;

                } else {

                    $header = $this->CI->session->userdata['username'] . ' ' . $has_published_post;

                }

            } else {

                $header = $this->CI->session->userdata['username'] . ' ' . $has_published_post;

            }

            $activity['header'] = $header;
            
            
            $activity['body'] = $get_post['title'] . ' ' . $get_post['body']; 
                        
            // Get image
            $img = unserialize($get_post['img']);

            // Get video
            $video = unserialize($get_post['video']);
            
            $activity['medias'] = '<div class="col-xl-12 clean">'
                                    . '<div class="post-history-media">';            

            // Verify if image exists
            if ( $img ) {
                
                $images = get_post_media_array($this->CI->user_id, $img );
                
                if ($images) {
                    
                    foreach ( $images as $image ) {
                        
                        $activity['medias'] .= '<img src="' . $image['body'] . '">';
                        
                    }                  
                    
                }
                
            }

            // Verify if video exists
            if ( $video ) {
                
                $videos = get_post_media_array($this->CI->user_id, $video );
                
                if ($videos) {

                    foreach ( $videos as $vid ) {
                    
                        $activity['medias'] .= '<video controls=""><source src="' . $vid['body'] . '" type="video/mp4"></video>';
                        
                    }
                    
                }
                
            }
            
            if ( !@$images && !@$videos ) {
                $activity['medias'] = '';
            } else {
                $activity['medias'] .= '</div>'
                                        . '</div>';  
            }
            
            // Get social networks
            $networks = $this->CI->posts_model->all_social_networks_by_post_id( $this->CI->user_id, $id );

            $profiles = array();
            
            $networks_icon = array();

            if ( $networks ) {

                foreach ( $networks as $network ) {

                    if ( in_array( $network['network_name'], $networks_icon ) ) {

                        $profiles[] = array(
                            'user_name' => $network['user_name'],
                            'status' => $network['status'],
                            'icon' => $networks_icon[$network['network_name']],
                            'network_name' => ucwords( str_replace('_', ' ', $network['network_name']) )
                        );

                    } else {

                        $network_icon = (new MidrubAppsCollectionPostsHelpers\Accounts)->get_network_icon($network['network_name']);

                        if ( $network_icon ) {
                            
                            $profiles[] = array(
                                'user_name' => $network['user_name'],
                                'status' => $network['status'],
                                'icon' => $network_icon,
                                'network_name' => ucwords( str_replace('_', ' ', $network['network_name']) )
                            );
                            
                            $networks_icon[$network['network_name']] = $network_icon;
                            
                        }

                    }

                }

            }
            
            if ( $profiles ) {
                
                $activity['footer'] = '<ul class="activities-post-social-accounts">';
                
                foreach ( $profiles as $profile ) {
                    
                    $status = '<i class="icon-check"></i>';
                    
                    if ( $profile['status'] != '1' ) {
                        $status = '<i class="icon-close"></i>';
                    }
                    
                    $activity['footer'] .= '<li>'
                                            . $profile['icon'] . ' ' . $profile['user_name'] . ' ' . $status
                                        . '</li>';
                    
                }
                
                $activity['footer'] .= '<ul>';
                
            } else {
                
                $activity['footer'] = '';
                
            }
            
        } else {
            
            // Define the header text
            $has_published_post = $this->CI->lang->line('has_published_drafted_scheduled_post');
            
            // Verify if team's member exists
            if ( $member_id > 0 ) {

                // Load Team Model
                $this->CI->load->model('team');

                // Get team's member information
                $member = $this->CI->team->get_member($user_id, $member_id);

                if ( $member ) {

                    $header = $member[0]->member_username . ' ' . $has_published_post;

                } else {

                    $header = $this->CI->session->userdata['username'] . ' ' . $has_published_post;

                }

            } else {

                $header = $this->CI->session->userdata['username'] . ' ' . $has_published_post;

            }

            $activity['header'] = $header;
            
            $activity['body'] = '';
            
            $activity['medias'] = '';
            
            $activity['footer'] = '';
            
        }
        
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

