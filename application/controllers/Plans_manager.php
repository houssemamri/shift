<?php
/**
 * Plans_manager Controller
 *
 * PHP Version 5.6
 *
 * Plans_manager contains the Plans class for the Midrub's Plans
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
 * Plans_manager class - contains all methods for the Midrub's Plans
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Plans_manager extends MY_Controller {
    
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
        
        // Load Plans Model
        $this->load->model('plans');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load Admin Helper
        $this->load->helper('admin_helper');
        
        // Load Fourth Helper
        $this->load->helper('fourth_helper');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
        // Load SMTP
        $config = smtp();
        
        // Load Sending Email Class
        $this->load->library('email', $config);
        
        if ( isset($this->session->userdata['username']) ) {
            
            // Set user_id
            $this->user_id = $this->user->get_user_id_by_username($this->session->userdata['username']);
            
            // Set user_role
            $this->user_role = $this->user->check_role_by_username($this->session->userdata['username']);
            
            // Set user_status
            $this->user_status = $this->user->check_status_by_username($this->session->userdata['username']);
            
        }
        
        // Verify if exist a customized language file
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php') ) {
            
            // load the alerts language file
            $this->lang->load( 'default_alerts', $this->config->item('language') );
            
        }
        
        // Verify if exist a customized language file
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_admin_lang.php') ) {
            
            // load the admin language file
            $this->lang->load( 'default_admin', $this->config->item('language') );
            
        }
        
    }
    
    /**
     * The public method admin_plans displays the plans page
     * 
     * @param integer $plan_id contains the plan's ID
     * 
     * @return void
     */
    public function admin_plans($plan_id = NULL) {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        if ( $plan_id ) {          
            
            // Get plans template
            $this->body = 'admin/plan';

            $this->content = array(
                'plan_id' => $plan_id
            );
            
            $this->admin_layout();
            
        } else {
        
            // Get all plans
            $get_plans = $this->plans->get_all_plans(1);

            // Get plans template
            $this->body = 'admin/plans';

            $this->content = array(
                'plans' => $get_plans
            );

            $this->admin_layout();
        
        }
        
    }  
    
}

/* End of file Plans_manager.php */
