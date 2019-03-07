<?php
/**
 * Planner Controller
 *
 * PHP Version 5.6
 *
 * Planner contains the Planner Class
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

/**
 * Planner Class - contains all methods for the Midrub's Statistics
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Planner extends MY_Controller {
    
    /**
     * Class variables
     */   
    private $user_id, $user_role;
    
    /**
     * Initialise the Statistics controller
     */
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
        
        // Load Tickets Model
        $this->load->model('tickets');
        
        // Load Networks Model
        $this->load->model('networks');
        
        // Load Posts Model
        $this->load->model('posts');
        
        // Load Scheduled Model
        $this->load->model('scheduled');
        
        // Load Templates Model
        $this->load->model('templates');
        
        // Load Campaigns Model
        $this->load->model('campaigns');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
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
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_user_lang.php' ) ) {
            $this->lang->load( 'default_user', $this->config->item('language') );
        }
        if( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php' ) ) {
            $this->lang->load( 'default_alerts', $this->config->item('language') );
        }
        
    }
    
    /**
     * The public display_planner displays the planner's page
     * 
     * @return void
     */
    public function display_planner() {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        $this->check_unconfirmed_account();
        
        $campaigns = '';
        
        // Get all user's campaigns
        $all_campaigns = $this->campaigns->get_user_campaigns($this->user_id);
        
        // Verify if user has email's campaigns
        if ($all_campaigns) {
            
            $campaigns = $all_campaigns;
            
        }
        
        // Get planner template
        $this->body = 'user/planner';
        
        $this->content = ['campaigns' => $campaigns];
        
        // Load the user layout
        $this->user_layout();
        
    }
    
    /**
     * The public get_email_data gets the scheduled email data
     * 
     * @param integer $email_id contains the email's id
     * 
     * @return void
     */
    public function get_email_data($email_id) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        // Get schedule data by user id and schedule id
        $get_schedule = $this->scheduled->get_schedule($this->user_id, $email_id);
        
        if ($get_schedule) {
            
            echo json_encode($get_schedule);
            
        }
        
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

/* End of file Planner.php */
