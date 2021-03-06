<?php
/**
 * Facebook Pages
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Facebook Pages
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
 * Facebook_pages class - allows users to connect to their Facebook Pages and publish posts.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Facebook_pages implements Autopost {

    /**
     * Class variables
     */
    public $CI, $fb, $app_id, $app_secret;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Get the Facebook App ID
        $this->app_id = get_option('facebook_pages_app_id');
        
        // Get the Facebook App Secret
        $this->app_secret = get_option('facebook_pages_app_secret');
        
        // Load the Vendor dependencies
        require_once FCPATH . 'vendor/autoload.php';
                
        try {

            // Load the Facebook Class
            $this->fb = new Facebook\Facebook(
                [
                    'app_id' => $this->app_id,
                    'app_secret' => $this->app_secret,
                    'default_graph_version' => 'v3.0',
                    'default_access_token' => '{access-token}',
                ]
            );

        } catch ( Facebook\Exceptions\FacebookResponseException $e ) {

            // When Graph returns an error
            $this->CI->session->set_flashdata('error', 'Graph returned an error: ' . $e->getMessage());

        } catch ( Facebook\Exceptions\FacebookSDKException $e ) {

            // When validation fails or other local issues
            $this->CI->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());

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
            if ( !get_option('facebook_pages_api_key') ) {
                
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
        
        // Redirect use to the login page
        $helper = $this->fb->getRedirectLoginHelper();
                    
        // Permissions to request
        $permissions = array(
            'manage_pages',
            'publish_pages'
        );
        
        if ( get_option( 'app_posts_enable_insights' ) ) {
            $permissions[] = 'read_insights';
        };
        
        if ( get_option( 'app_inbox_enable' ) ) {
            $permissions[] = 'read_page_mailboxes';
        };        
        
        // Get redirect url
        $loginUrl = $helper->getLoginUrl($this->CI->config->base_url() . 'user/callback/facebook_pages', $permissions);
        
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
        
        // Define the callback status
        $check = 0;

        // Obtain the user access token from redirect
        $helper = $this->fb->getRedirectLoginHelper();
        
        // Get the user access token
        $access_token = $helper->getAccessToken(base_url() . 'user/callback/facebook_pages');
        
        // Convert it to array
        $access_token = (array) $access_token;
        
        // Get array value
        $access_token = array_values($access_token);
        
        // Get user data
        $response = json_decode(get('https://graph.facebook.com/me/accounts?limit=500&access_token=' . @$access_token[0]), true);

        // Verify if access token exists
        if ( isset($response['data'][0]['access_token']) ) {
            
            // Verify if user has pages
            if ( isset($response['data'][0]['id']) ) {
                
                // Get user_id
                $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
                
                // Calculate expire token period
                $expires = '';
                
                // Save page
                for ( $y = 0; $y < count($response['data']); $y++ ) {
                    
                    if ( !isset($_SESSION['app_id']) ) {
                        
                        $this->CI->networks->add_network('facebook_pages', $response['data'][$y]['id'], $access_token[0], $user_id, $expires, $response['data'][$y]['name'], '', $response['data'][$y]['access_token']);
                        
                    } else {
                        
                        $this->CI->networks->add_network('facebook_pages', $response['data'][$y]['id'], $access_token[0], $user_id, $expires, $response['data'][$y]['name'], '', $response['data'][$y]['access_token'], $_SESSION['app_id'], $_SESSION['app_secret']);
                        
                    }
                    
                }
                
                $check++;
                
            }
            
        }
        
        if ( $check > 0 ) {
            
            // Display the success message
            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . $this->CI->lang->line('mm76') . '</p>', true); 
            
        } else {
            
            // Display the error message
            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm3') . '</p>', false);             
            
        }
        
    }

    /**
     * The public method post publishes posts on Facebook Groups.
     *
     * @param array $args contains the post data
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = null) {
        
        // Get user details
        if ($user_id) {
            
            // if the $user_id variable is not null, will be published a postponed post
            $user_details = $this->CI->networks->get_network_data(strtolower('facebook_pages'), $user_id, $args['account']);
            
        } else {
            
            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            $user_details = $this->CI->networks->get_network_data(strtolower('facebook_pages'), $user_id, $args['account']);
            
        }
        
        try {
                
            $token = $user_details[0]->secret;

            // Get post content 
            $post = $args['post'];

            // Verify if the title is not empty
            if ( $args['title'] ) {

                $post = $args['title'] . ' ' . $post;

            }

            // Verify if token exists
            if ( $token ) {

                // Set access token
                $this->fb->setDefaultAccessToken($token);

                // Verify if image exists
                if ( $args['img'] ) {
                    
                    $photos = array();
                    
                    // Verify if url exists
                    if ( $args['url'] ) {

                        $post = str_replace($args['url'], ' ', $post) . ' ' . short_url($args['url']);

                    }
                    
                    $photos['message'] = $post;
                    
                    $e = 0;
                    
                    foreach ( $args['img'] as $img ) {
                        
                        // Try to upload the image
                        $status = $this->fb->post('/' . $user_details[0]->net_id . '/photos', array('url' => $img['body'], 'published' => FALSE), $token);
                        
                        if ( @$status->getDecodedBody() ) {
                            
                            $stat = $status->getDecodedBody();
                            
                            $photos['attached_media[' . $e . ']'] = '{"media_fbid":"' . $stat['id'] . '"}';
                            $e++;
                            
                        }
                        
                    }
                    


                    // Decode the response
                    if ( $photos ) {

                        $post = $this->fb->post('/' . $user_details[0]->net_id . '/feed', $photos, $token);

                    }

                } elseif ( $args['video'] ) {

                    // Verify if url exists
                    if ( $args['url'] ) {

                        $post = str_replace($args['url'], ' ', $post) . ' ' . short_url($args['url']);

                    }

                    // Publish the post
                    $post = $this->fb->post('/' . $user_details[0]->net_id . '/videos',  array( 'description' => $post, 'source' => $this->fb->videoToUpload(str_replace(base_url(), FCPATH, $args['video'][0]['body']))));

                } elseif ( $args['url'] ) {

                    // Create post content
                    $linkData = array(
                        'link' => short_url($args['url']),
                        'message' => str_replace($args['url'], ' ', $post)
                    );

                    // Publish the post
                    $post = $this->fb->post('/' . $user_details[0]->net_id . '/feed', $linkData, $token);

                } else {

                    // Create post content
                    $linkData = array('message' => $post);

                    // Create post content
                    $post = $this->fb->post('/' . $user_details[0]->net_id . '/feed', $linkData, $token);

                }

                // Decode the post response
                if ($post->getDecodedBody()) {

                    $mo = $post->getDecodedBody();

                    if (@$mo['id'] && @$args['id']) {

                        sami($mo['id'], $args['id'], $args['account'], 'facebook_pages',$user_id);

                    }

                    return $mo['id'];

                } else {

                    return false;

                }

            } else {

                return false;

            }
            
        } catch (Exception $e) {
            
            // Save the error
            $this->CI->user_meta->update_user_meta( $user_id, 'last-social-error', $e->getMessage() );
            
            // Then return false
            return false;
            
        }
        
    }

    /**
     * The public method get_info displays information about this class
     * 
     * @return object with network data
     */
    public function get_info() {
        
        return (object) array(
            'color' => '#3b5998',
            'icon' => '<i class="icon-social-facebook"></i>',
            'api' => array('app_id', 'app_secret'),
            'types' => 'text, links, images, videos',
            'categories' => false,
            'rss' => true,
            'post' => true,
            'insights' => true,
            'types' => array('post', 'insights', 'rss', 'inbox')
        );
        
    }

    /**
     * The public method preview generates a preview for facebook groups
     *
     * @param $args contains the img or url
     * 
     * @return object with html content
     */
    public function preview($args) {}

}
