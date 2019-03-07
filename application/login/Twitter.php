<?php
/**
 * Twitter
 *
 * PHP Version 5.6
 *
 * Connect and and sign up with Twitter
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

use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Twitter class - connect and sign up with Twitter
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Twitter implements Login {

    /**
     * Class variables
     */
    protected $CI,
            $connection,
            $twitter_key,
            $twitter_secret;
    
    public $icon = '<i class="fab fa-twitter"></i>';

    /**
     * Initialize the class
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Set the Twitter app key
        $this->twitter_key = get_option('twitter_app_id');
        
        // Set the Twitter app secret
        $this->twitter_secret = get_option('twitter_app_secret');
        
        // Load the Twtter dependencies
        require_once FCPATH . 'vendor/autoload.php';
        
        // Connect to Twitter api
        $this->connection = new TwitterOAuth($this->twitter_key, $this->twitter_secret);
        
        // Set timeout
        $this->connection->setTimeouts(10, 15);
        
    }

    /**
     * The public method check_availability checks if the Twitter option is configured correctly
     *
     * @return boolean true or false
     */
    public function check_availability() {

        if ( ($this->twitter_key != '') AND ( $this->twitter_secret != '') ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
        
    }

    /**
     * The public method sign_in redirects user to the Twitter login page
     *
     * @return void
     */
    public function sign_in() {

        // Set the callback 
        $request_token = $this->connection->oauth('oauth/request_token', array('oauth_callback' => base_url() . 'callback/twitter'));
        
        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
        
        // Create the redirect url
        $url = $this->connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']) );
        
        // Redirect user
        header('Location: ' . $url);
    }

    /**
     * The public method get_token generates the token and saves the user data
     * 
     * @return void
     */
    public function get_token() {
        
        if ( $this->CI->input->get('oauth_verifier', TRUE) ) {

            $plan_id = 1;

            if ($this->CI->session->userdata('plan_id')) {

                $plan_id = $this->CI->session->userdata('plan_id');
            }

            // this function will get access token
            if ($this->CI->input->get('denied', TRUE)) {
                $this->CI->session->set_flashdata('error', 'An error occurred while processing your request.<br>Please, try again or signup by using the form above.');
                redirect('auth/signup/' . $plan_id);
            }

            $twitterOauth = new TwitterOAuth($this->twitter_key, $this->twitter_secret, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
            
            $twitterOauth->setTimeouts(10, 15);
            
            $twToken = $twitterOauth->oauth('oauth/access_token', array('oauth_verifier' => $this->CI->input->get('oauth_verifier', TRUE)));
            
            $newTwitterOauth = new TwitterOAuth($this->twitter_key, $this->twitter_secret, $twToken['oauth_token'], $twToken['oauth_token_secret']);
            
            $newTwitterOauth->setTimeouts(10, 15);
            
            $response = (array) $newTwitterOauth->get('account/verify_credentials', array('include_email' => 'true') );
            
            if ( $twToken['oauth_token'] ) {
                
                $userData['id'] = 't.' . $response['id']; // t. in this way we sure that the id not exists. An user can use . for his id.
                $userData['network'] = 'twitter';
                $userData['name'] = @$response['screen_name'];
                $userData['fullname'] = @$response['name'];
                $userData['net_id'] = @$response['id'];
                $userData['expires'] = ' ';
                
                if ($response["email"]) {
                    
                    $userData['email'] = $response['email'];
                    
                } else {
                    
                    $userData['email'] = '';
                    
                }
                
                $userData['access_token'] = $twToken['oauth_token'];
                $userData['secret'] = $twToken['oauth_token_secret'];
                $userData['photo'] = $response['profile_image_url'];
                
                $this->CI->session->set_flashdata('userdata', $userData);
                
                redirect('auth/signup/' . $plan_id);
                
            } else {
                
                $this->CI->session->set_flashdata('error', 'An error occurred while processing your request.<br>Please, try again or signup by using the form above.');
                redirect('auth/signup/' . $plan_id);
                
            }
        
        }
        
    }

}
