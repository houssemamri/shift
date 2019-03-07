<?php
/**
 * Oauth Controller
 *
 * PHP Version 5.6
 *
 * Oauth contains the Oauth Controller
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
 * Oauth class - runs all Midrub's api methods
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Oauth extends MY_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load User Model
        $this->load->model('user');
        
        // Load User Meta Model
        $this->load->model('user_meta');
        
        // Load Plans Model
        $this->load->model('plans');
        
        // Load SMTP
        $config = smtp();
        
        // Load Sending Email Class
        $this->load->library('email', $config);
        
    }
    
    /**
     * The public method authorize redirects user to the authorize endpoint
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    public function authorize() {
        
        $client_id = $this->input->get('client_id');
        $redirect_uri = $this->input->get('redirect_uri');
        $response_type = $this->input->get('response_type');
        
        if ( $client_id && $redirect_uri && $response_type ){
            

            
        } else {
            

            
        }

    }
    
    /**
     * The public method token generates a code
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    public function token() {
        
        $client_id = $this->input->get('client_id');
        $client_secret = $this->input->get('client_secret');
        $redirect_uri = $this->input->get('redirect_uri');
        $code = $this->input->get('code');
        $grant_type = $this->input->get('grant_type');
        
        if ( $client_id && $redirect_uri && $response_type ){
            

            
        } else {
            

            
        }

    }
    
    /**
     * The public method user returns a single user
     * 
     * @since 0.0.7.5
     * 
     * @return void
     */
    public function user() {
        
        $client_id = $this->input->get('client_id');
        $client_secret = $this->input->get('client_secret');
        $redirect_uri = $this->input->get('redirect_uri');
        $code = $this->input->get('code');
        $grant_type = $this->input->get('grant_type');
        
        if ( $client_id && $redirect_uri && $response_type ){
            

            
        } else {
            

            
        }

    }    
    
}

/* End of file Oauth.php */
