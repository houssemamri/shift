<?php
/**
 * Google Plus
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Google Plus
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

/**
 * Google_plus class - allows users to connect to their Google Plus Account and publish posts
 *
 * @category Social
 * @package Midrub
 * @author Scrisoft <asksyn@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link https://www.midrub.com/
 */
class Google_plus implements Autopost {

    /**
     * Class variables
     */
    protected $connect, $client, $CI, $clientId, $clientSecret, $apiKey;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Get the Google's client_id
        $this->clientId = get_option('google_plus_client_id');
        
        // Get the Google's client_secret
        $this->clientSecret = get_option('google_plus_client_secret');
        
        // Get the Google's api key
        $this->apiKey = get_option('google_plus_api_key');
        
        // Get the Google's application name
        $appName = get_option('google_plus_application_name');
        
        // Verify if the class Google_Client was already called
        if ( !class_exists( 'Google_Client', false ) ) {
            
            require_once FCPATH . 'vendor/google/src/Google_Client.php';
            
        }
        
        // Google Plus Callback
        $scriptUri = base_url() . 'user/callback/google_plus';
        
        // Call the class Google_Client
        $this->client = new \Google_Client();
        
        // Offline because we need to get refresh token
        $this->client->setAccessType('offline');
        
        // Name of the google application
        $this->client->setApplicationName($appName);
        
        // Set the client_id
        $this->client->setClientId($this->clientId);
        
        // Set the client_secret
        $this->client->setClientSecret($this->clientSecret);
        
        // Redirects to same url
        $this->client->setRedirectUri($scriptUri);
        
        // Set the api key
        $this->client->setDeveloperKey($this->apiKey);
        
        // Set approval prompt to force
        $this->client->setApprovalPrompt('force');
        
        // Load required scopes
        $this->client->setScopes( array(
            "https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/plus.stream.read https://www.googleapis.com/auth/plus.stream.write https://www.googleapis.com/auth/userinfo.profile"
        ) );
        
    }

    /**
     * The public method check_availability checks if the Google Plus api is configured correctly.
     *
     * @return boolean true or false
     */
    public function check_availability() {
        
        // Verify if clientId, clientSecret and apiKey exists
        if ( ($this->clientId != "") AND ( $this->clientSecret != "") AND ( $this->apiKey != "") ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
    }

    /**
     * The public connect will redirect user to Google login page.
     * 
     * @return void
     */
    public function connect() {
        
        // Generate redirect url
        $authUrl = $this->client->createAuthUrl();
        
        // Redirect
        header('Location:' . $authUrl);
        
    }

    /**
     * The public method save will get access token.
     *
     * @param $token contains the token for some social networks
     * 
     * @return boolean true or false
     */
    public function save( $token = null ) {
        
        // Define the callback status
        $check = 0;
        
        // Verify if code exists
        if ( $this->CI->input->get('code', TRUE) ) {
            
            // Send the received code
            $this->client->authenticate( $this->CI->input->get('code', TRUE) );
            
            // Get access token
            $token = $this->client->getAccessToken();
            
            // Set access token
            $this->client->setAccessToken($token);
            
            // Decode response
            $token = json_decode($token);
            
            // Verify if token exists
            if ( @$token->access_token ) {
                
                // Get refresh token
                $refresh = $token->refresh_token;

                // Get access token
                $token = $token->access_token;
                
                // Set expires time
                $expires_in = '';
                
                $curl = curl_init();
                
                // Set some options - we are passing in a useragent too here
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://www.googleapis.com/oauth2/v3/userinfo?access_token=' . $token,
                    CURLOPT_HEADER => false
                ));
                
                // Send the request & save response to $resp
                $udata = curl_exec($curl);
                
                // Close request to clear up some resources
                curl_close($curl);
                
                // Veify if response is valid
                if ( $udata ) {
                    
                    // Decode response
                    $udecode = json_decode($udata);
                    
                    // Verify if account exists
                    if ( @$udecode->sub ) {
                        
                        // Get user_id
                        $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata ['username']);
                        
                        // Verify if account was already saved
                        if ( !$this->CI->networks->get_network_data('google_plus', $user_id, $udecode->sub) ) {
                            
                            // Save account
                            $this->CI->networks->add_network('google_plus', $udecode->sub, $token, $user_id, $expires_in, $udecode->name, $udecode->picture, $refresh);
                            
                            $check = 1;
                            
                        } else {
                            
                            $check = 2;
                            
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
     * The public method post publishes posts on Google Plus.
     *
     * @param array $args contains the post data.
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = null) {
        
        // Get user details
        if ( $user_id ) {
            
            // if the $user_id variable is not null, will be published a postponed post
            $con = $this->CI->networks->get_network_data(strtolower('google_plus'), $user_id, $args['account']);
            
        } else {
            
            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            $con = $this->CI->networks->get_network_data(strtolower('google_plus'), $user_id, $args['account']);
            
        }
        
        // Verify if account exists
        if ( $con ) {
            
            // Verify if secret exists
            if ( $con [0]->secret ) {
                
                try {
                    
                    // Get refresh token 
                    $this->client->refreshToken($con [0]->secret);
                    
                    // Get post value
                    $post = $args['post'];
                    
                    // Verify if url exists
                    if ( $args['url'] ) {
                        $post = str_replace($args['url'], ' ', $post) . ' ' . short_url($args['url']);
                    }   
                    
                    // Verify if title is not empty
                    if ( $args['title'] ) {
                        $post = $args['title'] . ' ' . $post;
                    }
                    
                    // Decode the response
                    $token = json_decode($this->client->getAccessToken());
                    
                    // Get new access token
                    $token = $token->access_token;
                    
                    // Publish the post
                    $headers = array(
                        'Authorization : Bearer ' . $token,
                        'Content-Type : application/json',
                    );
                    $post_data = array(
                        'object' => array('originalContent' => $post),
                        'access' => array(
                            'items' => array(
                                array('type' => 'domain')
                            ),
                            'domainRestricted' => true
                        )
                    );
                    $data_string = json_encode($post_data);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/plusDomains/v1/people/' . $con[0]->net_id . '/activities');
                    $published = curl_exec($ch);
                    curl_close($ch);
                    
                    // Verify if the post was published
                    if ( $published ) {
                        
                        // Decode the response
                        $status = json_decode($published);
                        
                        // Verify if the post was published
                        if ( @$status->error->errors[0]->message ) {
                            
                            // The post was't published
                            // Save the error
                            $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', $status->error->errors[0]->message );

                            // Then return false
                            return false;
                            
                        } else {
                            
                            // The post was published
                            return true;
                            
                        }
                        
                    }
                    
                } catch (Exception $e) {

                    // Save the error
                    $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', $e->getMessage());

                    // Then return false
                    return false;
            
                }
                
            }
            
        }
        
    }

    /**
     * The public get_info displays information about this class.
     * 
     * @return object with network data
     */
    public function get_info() {
        
        return (object) [
            'color' => '#dd4b39',
            'icon' => '<i class="fab fa-google-plus"></i>',
            'api' => array(
                'client_id',
                'client_secret',
                'api_key',
                'application_name'
            ),
            'types' => 'text, links',
            'categories' => false,
            'rss' => true,
            'post' => true,
            'insights' => false,
            'types' => array('post', 'rss')
        ];
        
    }

    /**
     * The public method preview generates a preview for Google Plus.
     *
     * @param $args contains the video or url.
     * 
     * @param object with html content
     */
    public function preview($args) {
    }

}
