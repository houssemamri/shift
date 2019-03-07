<?php
/**
 * Instagram_insights
 *
 * PHP Version 5.6
 *
 * Connect and get Instagram's insights
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
 * Instagran_insights class - allow to get Instagram's insights
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Instagram_insights implements Autopost {

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
        $this->app_id = get_option('instagram_insights_app_id');
        
        // Get the Facebook App Secret
        $this->app_secret = get_option('instagram_insights_app_secret');
            
        // Load the Vendor dependencies
        require_once FCPATH . 'vendor/autoload.php';

        try {

            // Load the Facebook Class
            $this->fb = new Facebook\Facebook(
                array(
                    'app_id' => $this->app_id,
                    'app_secret' => $this->app_secret,
                    'default_graph_version' => 'v3.0',
                    'default_access_token' => '{access-token}',
                )
            );

        } catch ( Facebook\Exceptions\FacebookResponseException $e ) {

            // When Graph returns an error
            get_instance()->session->set_flashdata('error', 'Graph returned an error: ' . $e->getMessage());

        } catch ( Facebook\Exceptions\FacebookSDKException $e ) {

            // When validation fails or other local issues
            get_instance()->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());

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
            
        }
        
    }

    /**
     * The public method connect will redirect user to facebook login page.
     * 
     * @return void
     */
    public function connect() {
            
        // Redirect use to the login page
        $helper = $this->fb->getRedirectLoginHelper();

        // Permissions to request
        $permissions = array(
            'instagram_basic',
            'instagram_manage_comments',
            'instagram_manage_insights',
            'manage_pages');

        // Get redirect url
        $loginUrl = $helper->getLoginUrl(get_instance()->config->base_url() . 'user/callback/instagram_insights', $permissions);

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
        
        // Define the callback status
        $check = 0;
        
        // Obtain the user access token from redirect
        $helper = $this->fb->getRedirectLoginHelper();
        
        // Get the user access token
        $access_token = $helper->getAccessToken(base_url() . 'user/callback/instagram_insights');
        
        // Convert it to array
        $access_token = (array) $access_token;
        
        // Get array value
        $access_token = array_values($access_token);

        // Verify if access token exists
        if ( @$access_token[0] ) {
            
            // Get user data
            $getUserdata = json_decode(get('https://graph.facebook.com/me/accounts?fields=instagram_business_account,id,name&access_token=' . $access_token[0]), true);
            
            if ( $getUserdata ) {
                
                foreach ( $getUserdata['data'] as $data ) {
                    
                    if ( isset($data['instagram_business_account']) ) {
                        
                        // Calculate expire token period
                        $expires = '';

                        // Verify if the account was saved
                        if ($this->CI->networks->check_account_was_added('instagram_insights', $data['instagram_business_account']['id'], $this->CI->user_id)) {

                            $check = 2;

                        } else {

                            // Add new account
                            $this->CI->networks->add_network('instagram_insights', $data['instagram_business_account']['id'], $access_token[0], $this->CI->user_id, $expires, $data['name'], '');

                            $check = 1;
                        }
                        
                    }
                    
                }
                
            }
            
        }
        
        if ( $check === 1 ) {
            
            // Display the success message
            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . $this->CI->lang->line('your_account_was_connected') . '</p>', true); 
            
        } elseif ( $check === 2 ) {
            
            // Display the error message
            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('your_account_was_not_connected') . '</p>', true);             
            
        }else {
            
            // Display the error message
            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm3') . '</p>', false);             
            
        }
        
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
        
        return (object) array(
            'color' => '#c9349a',
            'icon' => '<i class="icon-social-instagram"></i>',
            'rss' => false,
            'api' => array(
                'app_id',
                'app_secret'
            ),
            'types' => '',
            'post' => false,
            'insights' => true,
            'categories' => false,
            'types' => array('insights', 'inbox')
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