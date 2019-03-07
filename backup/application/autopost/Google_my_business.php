<?php
/**
 * Google My Business
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Google My Business
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
 * Google_my_business class - allows users to connect to their Google My Business Account and publish posts
 *
 * @category Social
 * @package Midrub
 * @author Scrisoft <asksyn@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link https://www.midrub.com/
 */
class Google_my_business implements Autopost {

    /**
     * Class variables
     */
    protected $connect, $client, $CI, $clientId, $clientSecret, $apiKey, $gmbService;

    /**
     * Load networks and user model.
     */
    public function __construct() {

        // Get the CodeIgniter super object
        $this->CI = & get_instance();

        // Get the Google's client_id
        $this->clientId = get_option('google_my_business_client_id');

        // Get the Google's client_secret
        $this->clientSecret = get_option('google_my_business_client_secret');

        // Get the Google's api key
        $this->apiKey = get_option('google_my_business_api_key');

        // Get the Google's application name
        $appName = get_option('google_my_business_application_name');
        
        // Require the vendor autoload
        include_once FCPATH . 'vendor/autoload.php';
        
        // Google Plus Callback
        $scriptUri = base_url() . 'user/callback/google_my_business';

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
        $this->client->setScopes(array(
            "https://www.googleapis.com/auth/plus.business.manage"
        ));
        
    }

    /**
     * The public method check_availability checks if the Google My Business api is configured correctly.
     *
     * @return boolean true or false
     */
    public function check_availability() {

        // Verify if clientId, clientSecret and apiKey exists
        if (($this->clientId != "") AND ( $this->clientSecret != "") AND ( $this->apiKey != "")) {
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
    public function save($token = null) {

        // Verify if code exists
        if ($this->CI->input->get('code', TRUE)) {
            
            // Send the received code
            $this->client->authenticate($this->CI->input->get('code', TRUE));
            
            // Get access token
            $token = $this->client->getAccessToken();

            // Set access token
            $this->client->setAccessToken($token);  

            // Verify if token exists
            if ( @$token['access_token'] ) {

                // Get refresh token
                $refresh = $token['refresh_token'];

                // Get access token
                $token = $token['access_token'];
                
                // Get user_id
                $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);

                // Set expires time
                $expires_in = '';
        
               $this->gmbService = new \Google_Service_MyBusiness($this->client);  

                $accounts = $this->gmbService->accounts;
                $locations = $this->gmbService->accounts_locations;
                $accountsList = $accounts->listAccounts()->getAccounts();

                // Veify if response is valid
                if ( $accountsList ) {

                    $locationsList = $locations->listAccountsLocations($accountsList[0]->name)->getLocations(); 

                    if ( $locationsList ) {
                        
                        foreach ( $locationsList as $list ) {

                            // Verify if account was already added
                            if ( !$this->CI->networks->check_account_was_added('google_my_business', $list->name, $user_id) ) {
                                
                                $this->CI->networks->add_network('google_my_business', $list->name, $token, $user_id, $expires_in, $list->locationName, '', $refresh);
                                
                            }

                        }      
                        
                    }
                    
                    // Display the success message
                    echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . $this->CI->lang->line('all_locations_was_saved') . '</p>', true); 
                    
                }
                
            }
            
        } else {
            
            // Display the error message
            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm3') . '</p>', false);             
            
        }
        
    }

    /**
     * The public method post publishes posts on Google My Business
     *
     * @param array $args contains the post data.
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = null) {

        // Get user details
        if ($user_id) {

            // if the $user_id variable is not null, will be published a postponed post
            $con = $this->CI->networks->get_network_data(strtolower('google_my_business'), $user_id, $args ['account']);
            
        } else {

            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            $con = $this->CI->networks->get_network_data(strtolower('google_my_business'), $user_id, $args ['account']);
            
        }

        // Verify if account exists
        if ($con) {

            // Verify if secret exists
            if ($con [0]->secret) {

                try {

                    // Get refresh token 
                    $this->client->refreshToken($con [0]->secret);

                    // Decode the response
                    $token = $this->client->getAccessToken();
                    
                    // Set access token
                    $this->client->setAccessToken($token); 
                    
                    $this->gmbService = new \Google_Service_MyBusiness($this->client);  
                    
                    // Verify if image exists
                    if ( $args['img'] ) {
                        
                        $mediaItem = new \Google_Service_MyBusiness_MediaItem();
                        $mediaItem->setMediaFormat('PHOTO');
                        $mediaItem->setSourceUrl($args['img'][0]['body']);

                    }  
                    
                    // Verify if url exists
                    if ( $args['url'] ) {
                        
                        $callToAction = new \Google_Service_MyBusiness_CallToAction();
                        $callToAction->setActionType('LEARN_MORE');
                        $callToAction->setUrl( $args['url'] );
                        
                    }
                   
                    $localPost = new \Google_Service_MyBusiness_LocalPost();
                    $localPost->setLanguageCode('en-US');
                    
                    // Verify if title is not empty
                    if ( $args['title'] ) {
                    
                        $localPost->setName( $args['title'] );
                        
                    }
                    
                    $localPost->setSummary($args['post']);
                    
                    // Verify if url exists
                    if ( $args['url'] ) {
                     
                        $localPost->setCallToAction($callToAction);
                        
                    }
                    
                    // Verify if image exists
                    if ( $args['img'] ) {
                        
                        $localPost->setMedia($mediaItem);
                        
                    }
                    
                    $response = $this->gmbService->accounts_locations_localPosts->create($con[0]->net_id, $localPost);

                    // Verify if the post was published
                    if ( @$response->name ) {
                        
                        return true;
                        
                    } else {
                        
                        // Save the error
                        $this->CI->user_meta->update_user_meta( $user_id, 'last-social-error', json_encode($response) );  
                        return false;
                        
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
            'icon' => '<i class="fab fa-google"></i>',
            'api' => [
                'client_id',
                'client_secret',
                'api_key',
                'application_name'
            ],
            'types' => 'text, links, images',
            'rss' => true,
            'rss' => true,
            'post' => true,
            'categories' => false,
            'types' => array('post', 'rss')
        ];
        
    }

    /**
     * The public method preview generates a preview for Google My Business.
     *
     * @param $args contains the image or url.
     * 
     * @param object with html content
     */
    public function preview($args) {
    }

}
