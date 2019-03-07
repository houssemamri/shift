<?php
/**
 * Vimeo
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Vimeo
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

// If session valiable doesn't exists will be called
if ( !isset($_SESSION) ) {
    
    session_start();
    
}

use Vimeo\Exceptions\VimeoUploadException;

/**
 * Vimeo class - allows users to connect to their Vimeo and publish posts.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Vimeo implements Autopost {

    /**
     * Class variables
     */
    protected $CI, $check, $params, $redirect_uri, $client_id, $client_secrets;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Get Vimeo's client id
        $this->client_id = get_option('vimeo_client_identifier');
        
        // Get Vimeo client's secret
        $this->client_secrets = get_option('vimeo_client_secret');
        
        // Get Vimeo redirect
        $this->redirect_uri = base_url() . 'user/callback/vimeo';
        
        // Verify if the Vimeo's library exists
        if ( file_exists( FCPATH . 'vendor/vm/autoload.php' ) ) {
            
            // Require the Vimeo's library
            include_once FCPATH . 'vendor/vm/autoload.php';
            
        }
        
    }

    /**
     * The public method check_availability check if the Vimeo api is configured correctly.
     *
     * @return boolean true or false
     */
    public function check_availability() {
        
        // Verify if client_id and client_secret exists
        if ( ($this->client_id != '') AND ( $this->client_secrets != '') ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method connect will redirect user to Vimeo login page.
     * 
     * @return void
     */
    public function connect() {
                
        // Create the session variables
        $_SESSION['client_identifier'] = $this->client_id;
        $_SESSION['client_secrets'] = $this->client_secrets;

        // Get redirect
        $loginUrl = 'https://api.vimeo.com/oauth/authorize?response_type=code&client_id='.$_SESSION['client_identifier'].'&redirect_uri='.$this->redirect_uri.'&scope=public+private+upload+edit&state=12345';

        // Redirect
        header('Location:' . $loginUrl);
        
    }

    /**
     * The public method save will get access token.
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function save($token = null) {
        
        // Call the Vimeo class
        $lib = new \Vimeo\Vimeo($_SESSION['client_identifier'], $_SESSION['client_secrets']);
        
        // Get access token
        $data = $lib->accessToken($_GET['code'], $this->redirect_uri);
        
        // Verify if access token exists
        if ( @$data['body']['access_token'] ) {
            
            // Get access token
            $token = $data['body']['access_token'];
            
            // Get user name
            $name = $data['body']['user']['name'];
            
            // Get user ID
            $net_id = str_replace('/users/', '', $data['body']['user']['uri']);
            
            // Get user_id
            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            
            // Verify if the account was already saved
            if ( $this->CI->networks->check_account_was_added('vimeo', $net_id, $user_id)) {
                
                // Display the error message
                echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('your_account_was_not_connected') . '</p>', false); 
                
            } else {
                
                $this->CI->networks->add_network('vimeo', $net_id, $token, $user_id, '', $name, '', '', $_SESSION['client_identifier'], $_SESSION['client_secrets']);

                // Display the success message
                echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . $this->CI->lang->line('your_account_was_connected') . '</p>', true);
                
            }
            
        } else {
            
            // Display the error message
            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm3') . '</p>', false);             
            
        }
        
    }

    /**
     * The public method post publishes posts on Vimeo.
     *
     * @param array $args contains the post data.
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = null) {
        
        // Get user details
        if ($user_id) {
            
            // if the $user_id variable is not null, will be published a scheduled post
            $user_details = $this->CI->networks->get_network_data(strtolower('vimeo'), $user_id, $args['account']);
            
        } else {
            
            // Get the user ID
            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            $user_details = $this->CI->networks->get_network_data(strtolower('vimeo'), $user_id, $args['account']);
            
        }
        
        // Verify if video exists
        if ( !$args['video'] ) {
            
            // Save the error
            $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', json_encode($this->CI->lang->line('a_video_is_required_to_publish_here')));

            // Then return false
            return false;
            
        }
        
        // If user has the social account
        if ($user_details) {
            
            try {
                $lib = new \Vimeo\Vimeo($user_details[0]->api_key, $user_details[0]->api_secret, $user_details[0]->token);
                
                // Get the video
                $video = str_replace(base_url(), FCPATH, $args['video'][0]['body']);
                
                // Upload the video
                $uri = $lib->upload($video);
                
                // Get video url
                $up = $lib->request($uri);
                
                $post = $args['post'];

                // Verify if url exists
                if ( $args['url'] ) {
                    $post = str_replace($args['url'], ' ', $post) . ' ' . short_url($args['url']);
                }

                
                // Verify if title is not empty
                if ( $args ['title'] ) {
                    
                    $vidu = array(
                        'name' => $args['title'],
                        'description' => $post
                    );
                    
                } else {
                    
                    $vidu = array('name' => $post);
                    
                }
                
                // Publish the video
                if ($up) {
                    
                    $response = $lib->request($up['body']['uri'], $vidu, 'PATCH');
                    
                    if ( $response ) {
                        
                        return true;
                        
                    } else {
                        
                        return false;
                        
                    }
                    
                }
                
            } catch (Exception $e) {

                // Save the error
                $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', $e->getMessage());

                // Then return falsed
                return false;

            }
        }
    }

    /**
     * The public method get_info displays information about this class.
     * 
     * @return object with network's data
     */
    public function get_info() {
        
        return (object) array(
            'color' => '#44bbff',
            'icon' => '<i class="fab fa-vimeo-v"></i>',
            'api' => array('client_identifier', 'client_secret'),
            'types' => 'text, links, videos',
            'categories' => false,
            'post' => true,
            'rss' => false,
            'insights' => false,
            'types' => array('post')
        );
        
    }

    /**
     * The public method preview generates a preview for Vimeo.
     *
     * @param array $args contains the img or url.
     * 
     * @return object with html content
     */
    public function preview($args) {
        
    }

}
