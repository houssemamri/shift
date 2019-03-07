<?php
/**
 * Pinterest Bot
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Pinterest Boards
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

use seregazhuk\PinterestBot\Factories\PinterestBot;

/**
 * Pinterest_bot class - allows users to connect to their Pinterest's Boards
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Pinterest_bot implements Autopost {

    /**
     * Class variables
     */    
    protected $CI, $check;
    
    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Require the vendor autoload
        include_once FCPATH . 'vendor/autoload.php';
        
    }
    
    /**
     * The public method check_availability for Pinterest's Boards will return always true
     *
     * @return boolean true or false
     */
    public function check_availability() {
            
        return true; 
        
    }
    
    /**
     * The public method connect will redirect user to login page
     * 
     * @return void
     */
    public function connect() {

        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->CI->form_validation->set_rules('password', 'Password', 'trim|required');

            // Get post data
            $email = $this->CI->input->post('email');
            $password = $this->CI->input->post('password');

            // Verify if form data is valid
            if ($this->CI->form_validation->run() == false) {

                // Display the error message
                echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm3') . '</p>', false);   

            } else {
                
                try {
                
                    $connect = PinterestBot::create();
                    $connect->auth->login($email, $password);
                    $profile = $connect->user->profile();

                    if ( @$profile['id'] ) {

                        // Get lists of your boards
                        $boards = $connect->boards->forUser($profile['id']);

                        if ( $boards ) {

                            foreach ( $boards as $board ) {

                                // Get the board name
                                $name = $board['name'];

                                // Get the board id
                                $id = $board['id'];

                                if ( !$this->CI->networks->get_network_data('pinterest_bot', $this->CI->user_id, $id) ) {

                                    $secret_key = $this->CI->session->userdata ['username'];
                                    $secret_iv = $this->CI->session->userdata ['username'] . $id;

                                    $output = false;
                                    $encrypt_method = "AES-256-CBC";
                                    $key = hash( 'sha256', $secret_key );
                                    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

                                    $output = base64_encode( openssl_encrypt( $password, $encrypt_method, $key, 0, $iv ) );

                                    $this->CI->networks->add_network('pinterest_bot', $id, $email, $this->CI->user_id, '', $name, '', $output);

                                }

                            }

                            // Display the success message
                            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . $this->CI->lang->line('all_boards_added') . '</p>', true); 

                        } else {

                            // Display the error message
                            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('no_boards_found') . '</p>', false);                        

                        }
                    }
                    
                } catch (Exception $e) {
                    
                    // Display the error message
                    echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('please_ensure_correct_credientials') . '</p>', false);                      
                    
                }

            }

            exit();

        }
        
        // Display the login form
        echo get_instance()->ecl('Social_login')->content('Email', 'Password', 'Connect', $this->get_info(), 'Pinterest_bot', '');
        
    }
    
    /**
     * The public method save will get access token.
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function save($token = null) {
 
    }
    
    /**
     * The public method post publishes posts on Pinterest's Boards
     *
     * @param array $args contains the post data.
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true or false
     */
    public function post($args, $user_id = null) {
        
        // Get user details
        if ( $user_id ) {
            
            // if the $user_id variable is not null, will be published a postponed post
            $con = $this->CI->networks->get_network_data(strtolower('pinterest_bot'), $user_id, $args ['account']);
            
        } else {
            
            $user_id = $this->CI->user_id;
            $con = $this->CI->networks->get_network_data(strtolower('pinterest_bot'), $user_id, $args ['account']);
            
        }
        
        // Verify if image exists
        if ( !$args['img'] ) {
            
            // Save the error
            $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', json_encode($this->CI->lang->line('a_photo_is_required_to_publish_here')));

            // Then return false
            return false;
            
        }
        
        // Verify if account exists
        if ( $con ) {
            
            // Verify if token exists
            if ( $con [0]->token ) {
                
                try {
                    
                    // Get post value
                    $post = $args['post'];
                    
                    // Verify if title is not empty
                    if ( $args['title'] ) {
                        
                        $post = $args['title'] . ' ' . $post;
                        
                    } 
                    
                    $connect = PinterestBot::create();
                    
                    $secret_key = $this->CI->session->userdata ['username'];
                    $secret_iv = $this->CI->session->userdata ['username'] . $con[0]->net_id;

                    $output = false;
                    $encrypt_method = "AES-256-CBC";
                    $key = hash( 'sha256', $secret_key );
                    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
                    $output = openssl_decrypt( base64_decode( $con[0]->secret ), $encrypt_method, $key, 0, $iv );

                    $connect->auth->login($con[0]->token, $output);
                    
                    // Verify if url exists
                    if ( $args['url'] ) {
                        
                        $post = str_replace($args['url'], ' ', $post);
                        
                        // Create a pin
                        $result = $connect->pins->create($args['img'][0]['body'], $con[0]->net_id, $post, short_url($args['url']));
                        
                    } else {
                        
                        // Create a pin
                        $result = $connect->pins->create($args['img'][0]['body'], $con[0]->net_id, $post);                        
                        
                    }
                        
                    // Verify if the post was published
                    if ( $result ) {
                        
                        // The post was published
                        return true;
                        
                    } else {
                        
                        // Save the error
                        $this->CI->user_meta->update_user_meta( $user_id, 'last-social-error', json_encode($result) );                        
                        
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
     * The public method get_info displays information about this class
     * 
     * @return object with network's data
     */
    public function get_info() {

        return (object) array(
            'color' => '#be000f',
            'icon' => '<i class="fab fa-pinterest"></i>',
            'rss' => true,
            'api' => array(),
            'types' => 'text, links, images',
            'categories' => false,
            'post' => true,
            'insights' => false,
            'types' => array('post', 'rss')
        );   
    }
    
    /**
     * This function generates a preview for Pinterest's Boards
     *
     * @param array $args contains the img or url.
     * 
     * @return object with html
     */
    public function preview($args) {
        
    }
    
}