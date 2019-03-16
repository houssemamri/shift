<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Settings extends MY_Controller {
	public $user_id, $user_role, $user_status, $socials = array();

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
        
        // Load Posts Model
        $this->load->model('posts');
        
        // Load Plans Model
        $this->load->model('plans');
        
        // Load Urls Model
        $this->load->model('urls');
        
        // Load Networks Model
        $this->load->model('networks');
        
        // Load Campaigns Model
        $this->load->model('campaigns');
        
        // Load Notifications Model
        $this->load->model('notifications');
        
        // Load Options Model
        $this->load->model('options');
		
		// Load Settings Model
        $this->load->model('Settings_migration');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load User Helper
        $this->load->helper('user_helper');
        
        // Load Alerts Helper
        $this->load->helper('alerts_helper');
        
        // Load SMTP
        $config = smtp();
        
        // Load Sending Email Class
        $this->load->library('email', $config);
        
        // Load Gshorter library
        $this->load->library('gshorter');
        
        // Check if session username exists
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
        
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php') ) {
            $this->lang->load( 'default_alerts', $this->config->item('language') );
        }
        
    }
	
	 
	
	public function index($page){
		//echo "123";exit;
		// Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        $this->check_unconfirmed_account();
        
        $settings = '';
        
        $limit = 10;
        $page--;
        $total = $this->Settings_migration->get_settings($this->user_id, 1);
        $all_settings = $this->Settings_migration->get_settings($this->user_id, $page * $limit, $type, $limit);
        
        if ($all_settings) {            
            $settings = $all_settings;            
        }
        
        // Get setting template
        $this->body = 'user/migration_settings';
        
		 // Load the user layout
        $this->user_layout();
	}
	

	
	
	protected function check_unconfirmed_account() {
        
        // This function verifies if user has a confirmed account
        if ($this->user_status == 0) {
            
            redirect('/user/unconfirmed-account');
            
        }
        
    }
}
?>