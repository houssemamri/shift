<?php
/**
 * Posts Functions
 *
 * PHP Version 5.6
 *
 * I've created this file to store several generic 
 * functions called in the view's files
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if ( !defined('BASEPATH') ) {
    exit('No direct script access allowed');
}


if ( !function_exists( 'posts_clean_url_for_rss_posts' ) ) {
    
    /**
     * The function posts_clean_url_for_rss_posts removes non necessary characters from a url
     * 
     * @param string $url contains the url to clean
     * 
     * @return string with url
     */
    function posts_clean_url_for_rss_posts( $url ) {
        
        $new_url = explode('#', $url);
        $clean_url = $new_url[0];

        if (preg_match('/amazon./i', $clean_url)) {
            $uri = explode('ref=', $clean_url);
            $clean_url = $uri[0];
        }
        
        if (preg_match('/news.google/i', $clean_url)) {
            $uri = explode('&url=', $clean_url);
            $clean_url = @$uri [1];
        }
        
        return $clean_url;
        
    }
    
}

if ( !function_exists('posts_verify_post_published') ) {

    /**
     * The function posts_verify_post_published verifies by url if post was published
     * 
     * @param integer $rss_id contains the RSS's ID
     * @param string $post_url contains the post's url
     * 
     * @return boolean true or false
     */
    function posts_verify_post_published( $rss_id, $post_url ) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        if ( $CI->rss_model->was_published( $CI->user_id, $rss_id, $post_url) ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

}

if ( !function_exists('publish') ) {

    /**
     * The function publishes a post
     * 
     * @param array $args contains the post's data
     * @param integer $user_id contains the user's ID
     * 
     * @return boolean true or false
     */
    function publish($args, $user_id = NULL) {
        
        // Get codeigniter object instance
        $CI =& get_instance();
        
        // Load Main Helper
        $CI->load->helper('short_url_helper');
        
        // Make first word uppercase
        $network = ucfirst($args['network']);
        
        // Require the interface Autopost
        require_once APPPATH . 'interfaces/Autopost.php';
        
        // Verify if social network class exists
        if ( file_exists(APPPATH . 'autopost/' . $network . '.php') ) {
            
            // Require file
            require_once APPPATH . 'autopost/' . $network . '.php';
            
            // Call class
            $get = new $network;
            
            // Publish
            $pub = $get->post($args, $user_id);
            
            // Verify if post was published
            if ( $pub ) {
                
                return @$pub;
                
            } else {
                
                return false;
                
            }
            
        }
        
    }

}

if ( !function_exists('sami') ) {

    /**
     * The function saves publish status
     * 
     * @return void
     */
    function sami($param, $id, $acc, $net, $user_id = NULL) {
        
        // Get codeigniter object instance
        $CI = get_instance();
        
        // Load the model posts
        $CI->load->model('posts');
        
        // If user is null
        if ( !$user_id ) {
            
            // Get user_id
            $user_id = $CI->user_id;
            
        }
        
        if ( $param ) {
            
            // Saves response in the database
            $CI->posts->upo($id, $param, $acc, $net, $user_id);
            
        }
        
    }

}

if ( !function_exists('set_post_number') ) {

    /**
     * The public method set_post_number adds new post count
     *
     * @param integer $user_id contains user_id
     * 
     * @return boolean true or false
     */ 
    function set_post_number( $user_id ) {
        
        // Get number of published posts
        $posts_published = get_user_option('published_posts', $user_id);
        
        if ( $posts_published ) {
            
            $posts_array = unserialize($posts_published);
            
            if ( $posts_array['date'] === date('Y-m') ) {
                
                $posts = $posts_array['posts'];
                
                $posts++;
                
                // Set new record
                $record = serialize(
                    array(
                        'date' => date('Y-m'),
                        'posts' => $posts
                    )
                );
                
            } else {
                
                // Set new record
                $record = serialize(
                    array(
                        'date' => date('Y-m'),
                        'posts' => 1
                    )
                );  
                
            }
            
        } else {
            
            // Save first post number
            $record = serialize(
                array(
                    'date' => date('Y-m'),
                    'posts' => 1
                )
            );
            
        }
        
        update_user_meta($user_id, 'published_posts', $record);
        
    }

}