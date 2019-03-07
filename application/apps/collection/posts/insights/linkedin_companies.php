<?php
/**
 * Linkedin Companies
 *
 * This file gets the insights for Linkedin Companies
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Insights;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Collection\Posts\Interfaces as MidrubAppsCollectionPostsInterfaces;

/*
 * Linkedin_companies class loads the insigts
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */
class Linkedin_companies implements MidrubAppsCollectionPostsInterfaces\Insights {
    
   
    /**
     * Class variables
     *
     * @since 0.0.7.0
     */
    protected
            $CI, $url = 'https://api.linkedin.com/v1/', $connection, $redirect_uri, $client_id, $client_secret;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.0
     */
    public function __construct() {
        
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        
        // Get Linkedin client_id
        $this->client_id = get_option('linkedin_companies_client_id');
        
        // Get Linkedin client_secret
        $this->client_secret = get_option('linkedin_companies_client_secret');
        
        // Set redirect_url
        $this->redirect_uri = base_url() . 'user/callback/linkedin_companies';
        
        // Require the vendor autoload
        include_once FCPATH . 'vendor/autoload.php';
        
        try {
            
            // Call the Linkedin's class
            $this->connection = new \LinkedIn\LinkedIn(
                [
                'api_key' => $this->client_id,
                'api_secret' => $this->client_secret,
                'callback_url' => $this->redirect_uri,
                ]
            );
            
        } catch (Exception $e) {
            
            return false;
            
        }
        
    }
    
    /**
     * Contains the Class's configurations
     *
     * @since 0.0.7.0
     * 
     * return array with class's configuration
     */
    public function configuration() {
        
        // Create the config array
        $config = array();
        
        // Set the post deletion
        $config['post_deletion'] = false;
        
        // Set the account's
        $config['account_insights'] = true;
        
        // Set the post's insights
        $config['post_insights'] = true;
        
        // Set the words
        $config['words'] = array (
            'reply' => $this->CI->lang->line('reply'),
            'delete' => $this->CI->lang->line('delete'),
            'insights' => $this->CI->lang->line('insights'),
            'delete_post' => $this->CI->lang->line('delete_post'),
            'no_posts_found' => $this->CI->lang->line('no_posts_found')
        );
        
        // Return config
        return $config;
        
    }
    
    /**
     * The public method get_account gets all accounts posts
     * 
     * @since 0.0.7.0
     * 
     * @param object $network contains the network details
     * 
     * @return array with posts or string with non found message
     */
    public function get_account($network) {

        $curl = curl_init($this->url . 'companies/' . $network[0]->net_id . '/updates?format=json');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $network[0]->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $posts = json_decode(curl_exec($curl));
        curl_close($curl);
        
        // Verify if posts exists
        if ( @$posts->values ) {
            
            $all_posts = array();
            
            foreach ( $posts->values as $post  ) {
                
                $network[0]->post_id = $post->updateKey;
                
                $image = '';
                
                if ( @$post->updateContent->companyStatusUpdate->share->content->submittedImageUrl ) {
                    $image = '<img src="' . $post->updateContent->companyStatusUpdate->share->content->submittedImageUrl . '">';
                }
                
                $all_posts[] = array(
                    'id' => $post->updateKey,
                    'title' => '',
                    'content' => $post->updateContent->companyStatusUpdate->share->comment . $image,
                    'created_time' => $post->timestamp,
                    'reactions' => $this->get_reactions($network)
                );
                
            }
            
            return $all_posts;
            
        } else {
            
            return $this->CI->lang->line('no_comments');
            
        }
        
    }
    
    /**
     * The public method get_reactions gets the post's reactions
     * 
     * @since 0.0.7.0
     * 
     * @param object $network contains the network details
     * 
     * @return array with reactions or empty array
     */
    public function get_reactions($network) {
        
        // Create reactions array
        $reactions = array();
        
        // Get comments
        $get_comments = $this->get_comments($network);
        
        // Add comments to $reactions
        $reactions[0] = array(
            'name' => '<i class="icon-speech"></i> ' . $this->CI->lang->line('comments'),
            'slug' => 'comments',
            'response' => $get_comments,
            'placeholder' => $this->CI->lang->line('enter_comment'),
            'post_id' => $network[0]->post_id,
            'form' => true,
            'delete' => false,
            'reply' => false
        );
        
        // Get reactions
        $get_reactions = $this->get_likes($network);
        
        // Add reactions to $reactions
        $reactions[1] = array(
            'name' => '<i class="icon-people"></i> ' . $this->CI->lang->line('reactions'),
            'slug' => 'reactions',
            'response' => $get_reactions,
            'placeholder' => '',
            'post_id' => $network[0]->post_id,
            'form' => false,
            'delete' => false,
            'reply' => false
        );
        
        return $reactions;
        
    }    
    
    /**
     * The public method get_comments gets the post's comments
     * 
     * @since 0.0.7.0
     * 
     * @param object $network contains the network details
     * 
     * @return array with comments or string
     */
    public function get_comments($network) {
        
        $curl = curl_init($this->url . 'companies/' . $network[0]->net_id . '/updates/key=' . $network[0]->post_id . '/update-comments?format=json');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $network[0]->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $comments = json_decode(curl_exec($curl));
        curl_close($curl);
        
        if ( @$comments->values ) {
            
            $all_comments = array();
            
            foreach ( $comments->values as $comment ) {
                
                $from = array();
                
                if ( @$comment->company ) {
                    
                    $from = array(
                        'name' => $comment->company->name,
                        'id' => $comment->company->id,
                        'link' => 'https://www.linkedin.com/company/' . $comment->company->id,
                        'user_picture' => base_url('assets/img/avatar-placeholder.png')
                        
                    );
                    
                } else if ( @$comment->person ) {
                    
                    $from = array(
                        'name' => $comment->person->firstName . ' ' . $comment->person->lastName,
                        'id' => $comment->person->id,
                        'link' => $comment->person->siteStandardProfileRequest->url,
                        'user_picture' => base_url('assets/img/avatar-placeholder.png')
                        
                    );
                    
                }
                
                $all_comments[$comment->id] = array(
                    'created_time' => $comment->timestamp,
                    'message' => $comment->comment,
                    'from' => $from,
                    'id' => $comment->id
                );
                
                $all_comments[$comment->id]['replies'] = array();
                
            }
            
            return array_values($all_comments);
            
        } else {
            
            return $this->CI->lang->line('no_comments');
            
        }
        
    }
    
    /**
     * The public method get_likes gets the post's likes
     * 
     * @since 0.0.7.0
     * 
     * @param object $network contains the network details
     * 
     * @return array with likes or string
     */
    public function get_likes($network) {
        
        $curl = curl_init($this->url . 'companies/' . $network[0]->net_id . '/updates/key=' . $network[0]->post_id . '/likes?format=json');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $network[0]->token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $reactions = json_decode(curl_exec($curl));
        curl_close($curl);
        
        if ( @$reactions->values ) {
            
            $all_reactions = array();
            
            foreach ( $reactions->values as $reaction ) {
                
                $from = array();
                
                if ( @$reaction->company ) {
                    
                    $from = array(
                        'name' => $reaction->company->name,
                        'id' => $reaction->company->id,
                        'link' => 'https://www.linkedin.com/company/' . $reaction->company->id,
                        'user_picture' => base_url('assets/img/avatar-placeholder.png')
                        
                    );
                    
                } else if ( @$reaction->person ) {
                    
                    $from = array(
                        'name' => $reaction->person->firstName . ' ' . $reaction->person->lastName,
                        'id' => $reaction->person->id,
                        'link' => 'https://www.linkedin.com/company/',
                        'user_picture' => base_url('assets/img/avatar-placeholder.png')
                        
                    );
                    
                }
                
                $all_reactions[1] = array(
                    'created_time' => '',
                    'message' => '<i class="icon-like"></i>',
                    'from' => $from,
                    'id' => 1
                );
                
            }
            
            return array_values($all_reactions);
            
        } else {
            
            return $this->CI->lang->line('no_reactions');
            
        }
        
    }
    
    /**
     * The public method get_insights gets the post's insights
     * 
     * @since 0.0.7.0
     * 
     * @param object $network contains the network details
     * @param object $type contains the insights type
     * 
     * @return array with insights or string
     */
    public function get_insights($network, $type) {
        
        // Display insights by type
        switch ( $type ) {
            
            case 'post':
        
                // Create insights array
                $insights = array();

                $url = $this->url . 'companies/' . $network[0]->net_id . '/updates/key=' . $network[0]->post_id . '/likes?format=json';

                // Get linkedin pages
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $network[0]->token ) );
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $update = json_decode(curl_exec($curl));
                curl_close($curl);
                
                $likes = 0;

                if ( @$update->_total ) {

                    $likes = $update->_total;

                }

                // Add organic followers to $insights
                $insights[] = array(
                    'name' => 'Likes',
                    'value' => $likes,
                    'background_color' => 'rgba(0, 99, 132, 0.6)',
                    'border_color' => 'rgba(0, 99, 132, 1)'
                );
                
                $url = $this->url . 'companies/' . $network[0]->net_id . '/updates/key=' . $network[0]->post_id . '/update-comments?format=json';

                // Get linkedin pages
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $network[0]->token ) );
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $update = json_decode(curl_exec($curl));
                curl_close($curl);
                
                $comments = 0;

                if ( @$update->_total ) {

                    $comments = $update->_total;

                }

                // Add organic followers to $insights
                $insights[] = array(
                    'name' => 'Comments',
                    'value' => $comments,
                    'background_color' => 'rgba(30, 99, 132, 0.6)',
                    'border_color' => 'rgba(30, 99, 132, 1)'
                );                

                return $insights;
                
            case 'account':
                
                // Create insights array
                $insights = array();

                $start = time() * 1000;

                $end = (time() * 1000) - (604800 * 1000);

                $url = 'https://api.linkedin.com/v1/companies/' . $network[0]->net_id . '/historical-follow-statistics?format=json&time-granularity=day&start-timestamp=' . $end . '&end-timestamp=' . $start;

                // Get linkedin pages
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $network[0]->token ) );
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $companies = json_decode(curl_exec($curl));
                curl_close($curl);
                
                $organicFollowerCount = 0;
                $paidFollowerCount = 0;
                $totalFollowerCount = 0;

                if ( @$companies->values ) {

                        foreach( $companies->values as $value) {

                            $organicFollowerCount = $organicFollowerCount + $value->organicFollowerCount;
                            $paidFollowerCount = $paidFollowerCount + $value->paidFollowerCount;
                            $totalFollowerCount = $totalFollowerCount + $value->totalFollowerCount;

                        }

                }

                // Add organic followers to $insights
                $insights[] = array(
                    'name' => 'Organic Followers',
                    'value' => $organicFollowerCount,
                    'background_color' => 'rgba(0, 99, 132, 0.6)',
                    'border_color' => 'rgba(0, 99, 132, 1)'
                );
                
                // Add paid followers to $insights
                $insights[] = array(
                    'name' => 'Paid Followers',
                    'value' => $paidFollowerCount,
                    'background_color' => 'rgba(30, 99, 132, 0.6)',
                    'border_color' => 'rgba(30, 99, 132, 1)'
                );
                
                // Add total followers to $insights
                $insights[] = array(
                    'name' => 'Paid Followers',
                    'value' => $totalFollowerCount,
                    'background_color' => 'rgba(60, 99, 132, 0.6)',
                    'border_color' => 'rgba(60, 99, 132, 1)'
                ); 
                
                return $insights;
                
        }
        
    }
    
    /**
     * The public method post send submit data to social network
     * 
     * @since 0.0.7.0
     * 
     * @param object $network contains the network details
     * @param string type contains the data type
     * @param string $msg contains the data to send
     * @param string $parent contains the parent
     * 
     * @return array with status or string
     */
    public function post($network, $type, $msg, $parent = NULL) {
        
        switch ($type) {
            
            case 'comments':
                
                $id = @$network[0]->post_id;
                
                if ( $parent ) {
                    $id = $parent;
                }

                // Set access token
                $this->connection->setAccessToken($network[0]->token);

                // Verify if title exists
                $object['comment'] = mb_substr($msg, 0, 699);

                // Publish
                $post = $this->connection->fetch('/companies/' . $network[0]->net_id . '/updates/key=' . $id . '/update-comments-as-company/', $object, \LinkedIn\LinkedIn::HTTP_METHOD_POST);

                if ( @$post ) {
                    
                    return array(
                        'success' => FALSE,
                        'message' => $this->CI->lang->line('comment_not_published')
                    );
                    
                } else {
                    
                    return array(
                        'success' => TRUE,
                        'message' => $this->CI->lang->line('comment_published')
                    );
                    
                }
            
                break;        
            
        }
        
    }
    
    /**
     * The public method delete deletes data from social network
     * 
     * @since 0.0.7.0
     * 
     * @param object $network contains the network details
     * @param string type contains the data type
     * @param string $parent contains the parent
     * 
     * @return array with status or string
     */
    public function delete($network, $type, $parent = NULL) {
        
        switch ($type) {
            
            case 'comments':
                
                $post = json_decode(delete( $this->url . $parent, $network[0]->secret));
                
                if ( @$post->success ) {
                    
                    return $this->CI->lang->line('comment_deleted');
                    
                } else {
                    
                    return false;
                    
                }
            
                break;
                
            case 'post':
                
                $post = json_decode(delete( $this->url . $network[0]->post_id, $network[0]->secret));
                
                if ( @$post->success ) {
                    
                    return $this->CI->lang->line('post_was_deleted');
                    
                } else {
                    
                    return false;
                    
                }
            
                break; 
            
        }
        
    }    

}
