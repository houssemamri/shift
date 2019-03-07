<?php
/**
 * Activities helper
 *
 * This file contains the methods
 * for Activities page
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('activities_load_activities')) {
    
    /**
     * The function activities_load_activities loads available activities
     * 
     * @return void
     */
    function activities_load_activities() {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load Activities Model
        $CI->load->model('activities');
        
        // Get page's get input
        $page = $CI->input->get('page');
        
        $limit = 10;
        
        $page--;
        
        // Get saved activities
        $activities = $CI->activities->get_activities( $CI->user_id, $page * $limit, $limit );
        
        // Get total activities
        $total = $CI->activities->get_activities( $CI->user_id );
        
        // Verify if activities exists
        if ( $activities ) {
            
            $all_activities = array();
            
            // Require the Apps class
            $CI->load->file( APPPATH . '/apps/main.php' );
            
            // Call the apps class
            $apps = new MidrubApps\MidrubApps();
            
            foreach ( $activities as $activity ) {
                
                // Verify if the app exists
                if ( is_dir( APPPATH . '/apps/collection/' . $activity->app . '/' ) ) {
            
                    try {
                        
                        // Instantiate the class
                        $response = $apps->activities( $activity->app, $activity->user_id, $activity->member_id, $activity->template, $activity->id );
                        
                        $response['time'] = $activity->created;
                        
                        $all_activities[] = $response;
                        
                    } catch (Exception $ex) {
                        
                        continue;
                        
                    }

                } else {

                    continue;

                }
                
            }
            
            // Verify if activities exists
            if ( $all_activities ) {

                $data = array(
                    'success' => TRUE,
                    'activities' => $all_activities,
                    'date' => time(),
                    'total' => $total,
                    'page' => $page
                );

                echo json_encode($data);

            } else {

                $data = array(
                    'success' => FALSE,
                    'message' => $CI->lang->line('no_activities_found')
                );

                echo json_encode($data);            

            }
            
        } else {

            $data = array(
                'success' => FALSE,
                'message' => $CI->lang->line('no_activities_found')
            );

            echo json_encode($data);            

        }
        
    }
    
}