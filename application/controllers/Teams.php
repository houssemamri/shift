<?php
/**
 * Teams Controller
 *
 * PHP Version 5.6
 *
 * Teams contains the Teams Controller
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
 * Teams class - contains all methods for Teams
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Teams extends MY_Controller {
    
    public $user_id, $user_role;
    
    public function __construct() {
        parent::__construct();
        
        // Load form helper library
        $this->load->helper('form');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Load User Model
        $this->load->model('user');
        
        // Load User Meta Model
        $this->load->model('user_meta');
        
        // Load Team Model
        $this->load->model('team');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load Fourth Helper
        $this->load->helper('fourth_helper');
        
        // Load Alerts Helper
        $this->load->helper('alerts_helper');
        
        // Load Team Helper
        $this->load->helper('team_helper');
        
        // Load User Helper
        $this->load->helper('user_helper');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
        // Load SMTP
        $config = smtp();
        
        // Load Sending Email Class
        $this->load->library('email', $config);
        
        if (isset($this->session->userdata['username'])) {
            
            // Set user_id
            $this->user_id = $this->user->get_user_id_by_username($this->session->userdata['username']);
            
            // Set user_role
            $this->user_role = $this->user->check_role_by_username($this->session->userdata['username']);
            
            // Set user_status
            $this->user_status = $this->user->check_status_by_username($this->session->userdata['username']);
            
        }
        
        // Get user language
        $user_lang = get_user_option('user_language');
        
        // Verify if user has selected a language
        if ( $user_lang ) {
            $this->config->set_item('language', $user_lang);
        }
        
        // Verify if exist a customized language file
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php' ) ) {
            
            // load the alerts language file
            $this->lang->load( 'default_alerts', $this->config->item('language') );
            
        }
        
        // Verify if exist a customized language file
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_user_lang.php' ) ) {
            
            // load the admin language file
            $this->lang->load( 'default_user', $this->config->item('language') );
            
        }
        
    }
    
    /**
     * The public method team displays the user's team
     * 
     * @param integer $period contains the period of time
     * 
     * @return void
     */
    public function team() {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        $this->check_unconfirmed_account();
        
        // Verify if is a team's member
        if ( $this->session->userdata( 'member' ) ) {
            redirect('user/app/dashboard');
        }
        
        // Get statistics template
        $this->body = 'user/teams';
        $this->user_layout();
        
    }
    
    /**
     * The function check_unconfirmed_account checks if the current user's account is confirmed
     * 
     * @return void
     */
    protected function check_unconfirmed_account() {
        
        // This function verifies if user has a confirmed account
        if ($this->user_status == 0) {
            
            redirect('/user/unconfirmed-account');
            
        }
        
    }
}

/* End of file Teams.php */
