<?php
/**
 * Facebook
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Facebook
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// If session valiable doesn't exists will be created
if (!isset($_SESSION)) {
    session_start();
}

/**
 * Facebook class - allow to publish posts on Facebook.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Facebook implements Autopost {

    /**
     * Class variables
     */
    public $fb, $app_id, $app_secret;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Get the Facebook App ID
        $this->app_id = get_option('facebook_app_id');
        
        // Get the Facebook App Secret
        $this->app_secret = get_option('facebook_app_secret');
        
        // Load the Vendor dependencies
        require_once FCPATH . 'vendor/autoload.php';
        
        // Verify if user can use his App ID and App secret
        if ( !get_option('facebook_user_api_key') ) {
                
            try {

                // Load the Facebook Class
                $this->fb = new Facebook\Facebook(
                    [
                        'app_id' => $this->app_id,
                        'app_secret' => $this->app_secret,
                        'default_graph_version' => 'v2.12',
                        'default_access_token' => '{access-token}',
                    ]
                );

            } catch ( Facebook\Exceptions\FacebookResponseException $e ) {

                // When Graph returns an error
                get_instance()->session->set_flashdata('error', 'Graph returned an error: ' . $e->getMessage());

            } catch ( Facebook\Exceptions\FacebookSDKException $e ) {

                // When validation fails or other local issues
                get_instance()->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());

            }

        }
        
        // Verify if will be refreshed the token
        if ( $this->CI->input->get('account', TRUE) ) {
            
            // Verify if account is valid
            if ( is_numeric( $this->CI->input->get('account', TRUE) ) ) {
                
                // Create a session with the account ID
                $_SESSION['account'] = $this->CI->input->get('account', TRUE);
                
            }
            
        }
    }

    /**
     * The public method check_availability checks if the Facebook api is configured correctly.
     *
     * @return boolean true or false
     */
    public function check_availability() {
        
        // Verify if app_id and app_secret exists
        if ( ($this->app_id != '') AND ( $this->app_secret != '') ) {
            
            return true;
            
        } else {
            
            // If user can use app_id and app_secret the return will be always true
            if ( !get_option('facebook_user_api_key') ) {
                
                return false;
                
            } else {
                
                return true;
                
            }
            
        }
        
    }

    /**
     * The public method connect will redirect user to facebook login page.
     * 
     * @return void
     */
    public function connect() {
        
        // Verify if user can use his App ID and App secret
        if ( get_option('facebook_user_api_key') ) {

            // Check if data was submitted
            if ( $this->CI->input->post() ) {
                
                // Add form validation
                $this->CI->form_validation->set_rules('app_id', 'App ID', 'trim|required');
                $this->CI->form_validation->set_rules('app_secret', 'App Secret', 'trim|required');
                
                // Get post data
                $app_id = $this->CI->input->post('app_id');
                $app_secret = $this->CI->input->post('app_secret');
                
                // Verify if post data is correct
                if ( $this->CI->form_validation->run() == false ) {
                    
                    // Return error message
                    display_mess(45);
                    
                } else {
                    
                    // Create sessions with app_id and app_secret
                    $_SESSION['app_id'] = $app_id;
                    $_SESSION['app_secret'] = $app_secret;
                    
                }
                
            }

            // Verify if the session app_id exists
            if ( !isset($_SESSION['app_id']) ) {

                // If doesn't exists will be displayed the form
                echo get_instance()->ecl('Social_login')->content('App ID', 'App Secret', 'Connect', $this->get_info(), 'facebook', $this->CI->lang->line('mu208'));
                exit();
                
            } else {
                
                // Verify if the Facebook SDK exists
                if ( file_exists(FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php') ) {
                    
                    try {
                        
                        // Require the Facebook Library
                        include FCPATH . 'vendor/facebook/php-sdk-v4/src/Facebook/autoload.php';
                        
                        // Load the Facebook Class
                        $this->fb = new Facebook\Facebook(['app_id' => $_SESSION['app_id'], 'app_secret' => $_SESSION['app_secret'], 'default_graph_version' => 'v2.12', 'default_access_token' => '{access-token}']);
                        
                    } catch ( Facebook\Exceptions\FacebookResponseException $e ) {
                        
                        // When Graph returns an error
                        get_instance()->session->set_flashdata('error', 'Graph returned an error: ' . $e->getMessage());
                        
                    } catch ( Facebook\Exceptions\FacebookSDKException $e ) {
                        
                        // When validation fails or other local issues
                        get_instance()->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());
                        
                    }
                    
                }
                
            }
            
        }
            
        // Redirect use to the login page
        $helper = $this->fb->getRedirectLoginHelper();

        // Permissions to request
        $permissions = ['email', 'publish_actions'];

        // Get redirect url
        $loginUrl = $helper->getLoginUrl(get_instance()->config->base_url() . 'user/callback/facebook', $permissions);

        // Redirect
        header('Location:' . $loginUrl);
    }

    /**
     * The public method save will get access token.
     *
     * @param string $token contains the token for some social networks
     * 
     * @return boolean true or false
     */
    public function save($token = null) {
    }

    /**
     * The public method post publishes posts on facebook.
     *
     * @param array $args contains the post data.
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = null) {
    }

    /**
     * The public method get_info displays information about this class.
     * 
     * @return object with network data
     */
    public function get_info() {
        
        return (object) 
            array(
                'color' => '#3b5998',
                'icon' => '<i class="fa fa-facebook"></i>',
                'api' => array('app_id', 'app_secret'),
                'types' => 'text, links, images, videos',
                'rss' => true,
                'post' => true,
                'insights' => true,
                'categories' => false,
                'types' => array()
            );
        
    }

    /**
     * The public method preview generates a preview for facebook.
     *
     * @param array $args contains the img or url.
     * 
     * @return object with html content
     */
    public function preview($args) {
    }

}
