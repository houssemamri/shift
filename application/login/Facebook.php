<?php
/**
 * Facebook
 *
 * PHP Version 5.6
 *
 * Connect and and sign up with Facebook
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
 * Facebook class - connect and sign up with Facebook
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Facebook implements Login {

    /**
     * Class variables
     */
    protected $CI,
            $fb,
            $app_id,
            $app_secret;
    
    public $icon = '<i class="fab fa-facebook-f"></i>';

    /**
     * Initialize the class
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Get the Facebook app id
        $this->app_id = get_option('facebook_app_id');
        
        // Get the Facebook app secret
        $this->app_secret = get_option('facebook_app_secret');
        
        // Load the Vendor dependencies
        require_once FCPATH . 'vendor/autoload.php';
            
        if (($this->app_id != "") AND ( $this->app_secret != '')) {
            
            $this->fb = new Facebook\Facebook([
                'app_id' => $this->app_id,
                'app_secret' => $this->app_secret,
                'default_graph_version' => 'v3.0',
                'default_access_token' => '{access-token}',
            ]);
            
        }
        
    }

    /**
     * The public method check_availability checks if the Facebook option is configured correctly
     *
     * @return boolean true or false
     */
    public function check_availability() {
        
        // check if the Facebook api is configured correctly
        if ( ($this->app_id != '') AND ( $this->app_secret != '') ) {
            
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

        $helper = $this->fb->getRedirectLoginHelper();
        
        // We need only email permission
        $permissions = ['email'];

        // Create the redirect url
        $loginUrl = $helper->getLoginUrl(base_url() . 'callback/facebook', $permissions);
        
        // Redirect user
        header('Location:' . $loginUrl);
        
    }

    /**
     * The public method get_token generates the token and saves the user data
     * 
     * @return void
     */ 
    public function get_token() {

        // Set default plan
        $plan_id = 1;

        if ($this->CI->session->userdata('plan_id')) {

            $plan_id = $this->CI->session->userdata('plan_id');
        }

        // This function will get access token
        try {
            
            $helper = $this->fb->getRedirectLoginHelper();
            $access_token = $helper->getAccessToken(base_url() . 'callback/facebook');
            $access_token = (array) $access_token;
            $access_token = array_values($access_token);
            
            if (array_key_exists(0, $access_token)) {

                // Get cURL resource
                $curl = curl_init();
                
                // Set some options - we are passing in a useragent too here
                curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => 'https://graph.facebook.com/me?fields=id,name,email&access_token=' . $access_token[0], CURLOPT_HEADER => false));
                
                // Send the request & save response to $resp
                $resp = curl_exec($curl);
                
                // Close request to clear up some resources
                curl_close($curl);

                $getUserdata = json_decode($resp);

                if ( isset($getUserdata->id) ) {
                    
                    $userData = array('id' => 'f.' . $getUserdata->id); // f. in this way we sure that the id not exists. An user can use . for his id.
                    $userData['network'] = 'facebook';
                    $userData['name'] = $getUserdata->name;
                    $userData['fullname'] = $getUserdata->name;
                    $userData['photo'] = 'http://graph.facebook.com/' . $getUserdata->id . '/picture?type=square&access_token=' . $access_token[0];
                    $userData['net_id'] = $getUserdata->id;
                    
                    $a = (array) $access_token[1];
                    
                    $userData['expires'] = (@$a["date"]) ? $a["date"] : ' ';
                    
                    if (isset($getUserdata->email)) {
                        
                        $userData['email'] = str_replace("\u0040", "@", $getUserdata->email);
                        
                    } else {
                        
                        $userData['email'] = '';
                        
                    }
                    
                    $userData['access_token'] = $access_token[0];
                    
                    $this->CI->session->set_flashdata('userdata', $userData);

                    redirect('auth/signup/' . $plan_id);
                    
                } else {
                    
                    $this->CI->session->set_flashdata('error', 'An error occurred while processing your request.<br>Please, try again or signup by using the form above.');
                    redirect('auth/signup/' . $plan_id);
                    
                }
                
            } else {
                
                $this->CI->session->set_flashdata('error', 'An error occurred while processing your request.<br>Please, try again or signup by using the form above.');
                redirect('auth/signup/' . $plan_id);
                
            }
            
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            
            // When Graph returns an error
            $this->CI->session->set_flashdata('error', 'Graph returned an error: ' . $e->getMessage());
            redirect('auth/signup/' . $plan_id);
            
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            
            // When validation fails or other local issues
            $this->CI->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());
            redirect('auth/signup/' . $plan_id);
            
        }
        
    }

}
