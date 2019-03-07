<?php
/**
 * Linkedin
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Linkedin
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
 * Linkedin class - allows users to connect to their Linkedin Account and publish posts.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Linkedin implements Autopost {

    /**
     * Class variables
     */
    protected $CI, $connection, $redirect_uri, $client_id, $client_secret, $endpoint = 'https://www.linkedin.com/oauth/v2';

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Get the Linkedin's client_id
        $this->client_id = get_option('linkedin_client_id');
        
        // Get the Linkedin's client_secret
        $this->client_secret = get_option('linkedin_client_secret');
        
        // Set redirect_url
        $this->redirect_uri = base_url() . 'user/callback/linkedin';
        
        // Get account if exsts
        if ( $this->CI->input->get('account', TRUE) ) {
            
            // Verify if account is valid
            if ( is_numeric($this->CI->input->get('account', TRUE) ) ) {
                
                // Create the session account
                $_SESSION['account'] = $this->CI->input->get('account', TRUE);
                
            }
            
        }
        
    }

    /**
     * The public method check_availability checks if the Linkedin api is configured correctly.
     *
     * @return boolean true or false
     */
    public function check_availability() {
        
        // Verify if client_id or client_secret is empty
        if ( ($this->client_id != '') AND ( $this->client_secret != '') ) {
            
            return true;
            
        } else {
            
            return false;
            
        }
    }

    /**
     * The public method connect will redirect user to Linkedin login page.
     * 
     * @return void
     */
    public function connect() {
        
        // Set params
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'state' => time(),
            'scope' => 'w_share r_basicprofile r_liteprofile w_member_social'
        );
        
        // Get redirect url
        $url = $this->endpoint . '/authorization?' . http_build_query($params);
        
        // Redirect
        header('Location:' . $url);
            
    }

    /**
     * The public method save will get access token.
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function save( $token = null ) {
        
        // Verify if the code exists
        if ( $this->CI->input->get('code', TRUE) ) {
            
            // Set params
            $params = array(
                'grant_type' => 'authorization_code',
                'code' => $this->CI->input->get('code', TRUE),
                'redirect_uri' => $this->redirect_uri,
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret
            );
            
            
            
            // Get access token
            $response = json_decode(post($this->endpoint . '/accessToken', $params), true);

            // Verify if token exists
            if ( isset($response['access_token']) ) {
                
                // Get linkedin profile
                $profile = json_decode(get('https://api.linkedin.com/v2/me?oauth2_access_token=' . $response['access_token']), true);
                
                // Verify if data exists
                if ( isset($profile['firstName']['localized']['en_US']) ) {
                    
                    // Get first and last name
                    $name = $profile['firstName']['localized']['en_US'] . ' ' . $profile['lastName']['localized']['en_US'];
                    
                    // Get profile id
                    $id = $profile['id'];
                    
                    // Get exiration time
                    $expires = date('Y-m-d H:i:s', time() + $response['expires_in']);
                    
                    // Verify if we have to renew account
                    if ( isset($_SESSION['account']) ) {
                        
                        $acc = 0;
                        $act = $_SESSION['account'];
                        unset($_SESSION['account']);
                        
                        // Verify if account is valid
                        if ( !is_numeric($act) ) {
                            
                            exit();
                            
                        } else {
                            
                            // Get account's data
                            $gat = $this->CI->networks->get_account($act);
                            
                            if ($gat) {
                                
                                $acc = $gat[0]->net_id;
                                
                            }
                            
                        }
                        
                        // Verify if user is logged in correct account
                        if ( $id == $acc ) {
                            
                            // Refresh the token
                            if ($this->CI->networks->update_network($act, $this->CI->user_id, date('Y-m-d H:i:s', strtotime('+60 days')), $response['access_token'])) {
                                
                                // Display the success message
                                echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . strip_tags(display_mess(135)) . '</p>', true);
                                
                            } else {
                                
                                // Display the error message
                                echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . strip_tags( display_mess(136) ) . '</p>', false); 
                                
                            }
                        } else {

                            // Display the error message
                            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . strip_tags( display_mess(137) ) . '</p>', false);
                                
                        }
                        
                        exit();
                        
                    }
                    
                    // Verify if account was already saved
                    if ( !$this->CI->networks->get_network_data('linkedin', $this->CI->user_id, $id) ) {
                        
                        $this->CI->networks->add_network('linkedin', $id, $response['access_token'], $this->CI->user_id, $expires, $name, '', '');
                        
                        // Display the success message
                        echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . strip_tags(display_mess(80)) . '</p>', true);
                        
                    } else {
                        
                        // Display the error message
                        echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . strip_tags( display_mess(79, 'Linkedin')) . '</p>', false); 
                        
                    }
                    
                    exit();
                    
                }
                
            }
            
            // Display the error message
            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . strip_tags( display_mess(79, 'Linkedin')) . '</p>', false); 
            
        }
        
    }

    /**
     * The public method post publishes posts on Linkedin.
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
            $user_details = $this->CI->networks->get_network_data(strtolower('linkedin'), $user_id, $args['account']);
            
        } else {
            
            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            $user_details = $this->CI->networks->get_network_data(strtolower('linkedin'), $user_id, $args['account']);
            
        }
        
        // Get the post
        $post = $args['post'];
        
        // Verify if url exists
        if ( $args['url'] ) {
            $post = str_replace($args['url'], ' ', $post);
        }         
        
        if ( isset($args['img'][0]['body']) ) {

            $post = $post . ' ' . short_url($args['url']);

        }
        
        $new_post = mb_substr($post, 0, 699);
        
        try {
            
            // Set params
            $params = array(
                'author' => 'urn:li:person:' . $user_details[0]->net_id,
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => array(
                    'com.linkedin.ugc.ShareContent' => array(
                        'shareCommentary' => array(
                            'text' => $post,
                        ),
                        'shareMediaCategory' => 'ARTICLE',
                        'media' => array(
                            array(
                                'status' => 'READY'
                            ),
                        ),
                    ),
                ),
                'visibility' =>
                array(
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC',
                ),
            );
            
            if ( isset($args['title']) ) {
                
                $params['specificContent']['com.linkedin.ugc.ShareContent']['media'][0]['title']['text'] = $args['title'];
                
            }
            
            if ( isset($args['url']) ) {
                
                $params['specificContent']['com.linkedin.ugc.ShareContent']['media'][0]['originalUrl'] = short_url($args['url']);
                
            } 
            
            if ( isset($args['img'][0]['body']) ) {
                
                $params['specificContent']['com.linkedin.ugc.ShareContent']['media'][0]['originalUrl'] = $args['img'][0]['body'];
                
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_URL, 'https://api.linkedin.com/v2/ugcPosts');
            
            $headers = array(
                'Authorization: Bearer ' . $user_details[0]->token,
                'Cache-Control: no-cache',
                'X-RestLi-Protocol-Version: 2.0.0',
                'x-li-format: json',
                'Content-Type: application/json'
            );
            
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            $response = curl_exec($curl);
            
            curl_close($curl);

            if ( preg_match('/x-restli-id/i', $response) ) {

                $get_id = explode('urn:li:share:', $response);

                $clean_id = explode(' ', $get_id[1]);

                $id = trim($clean_id[0]);

                return true;

            } else {
                
                // Save the error
                $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', json_encode($response));

                // Then return falsed
                return false;
                
            }
            
        } catch (Exception $e) {

            // Save the error
            $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', $e->getMessage());

            // Then return falsed
            return false;
            
        }
    }

    /**
     * The public method get_info displays information about this class.
     * 
     * @return object with network's data
     */
    public function get_info() {
        
        // here you can add text that will be visible to user
        return (object) array(
            'color' => '#eddb11',
            'icon' => '<i class="fab fa-linkedin"></i>',
            'rss' => true,
            'api' => array('client_id', 'client_secret'),
            'types' => 'text, links',
            'post' => true,
            'insights' => false,
            'categories' => false,
            'types' => array('post', 'rss')
        );
        
    }

    /**
     * This function generates a preview for Linkedin.
     *
     * @param array $args contains the img or url.
     * 
     * @return object with html content
     */
    public function preview($args) {
    }

}
