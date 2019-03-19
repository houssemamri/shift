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
class Migration extends MY_Controller {
    
    /**
     * Class variables
     */   
    public $user_id, $user_role, $user_status, $socials = array();
    
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
        		
		// Load Options Model
        $this->load->model('settings_migration');
        
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
        
        // Get user language
        $user_lang = get_user_option('user_language');
        
        // Verify if user has selected a language
        if ( $user_lang ) {
            $this->config->set_item('language', $user_lang);
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_user_lang.php' ) ) {
            $this->lang->load( 'default_user', $this->config->item('language') );
        }
        
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php') ) {
            $this->lang->load( 'default_alerts', $this->config->item('language') );
        }
        
    }
	
	public function all_migration(){
		$this->check_session($this->user_role, 0);
        //$this->check_unconfirmed_account();
        
        $settings = '';        
        // Get setting template
        $this->body = 'user/migration_settings';
        
		 // Load the user layout
        $this->user_layout();
	}    
	
	public function showall_result($page, $order, $search = null){
		$this->check_session($this->user_role, 0);
		$limit = 10;        
        $page --;
        $total = $this->settings_migration->count_all_settings($search,$this->user_id);
		$all_settings = $this->settings_migration->get_settings($page * $limit, $limit, $order, $search,$this->user_id);
        if ( $all_settings ) {            
            $data = [
                'total' => $total,
                'settings' => $all_settings
            ];            
            echo json_encode($data);            
        }
	}
	
	 /**
     * The public method new setting
     * 
     * @return void
     */
    public function new_setting() {
        
        $this->check_session($this->user_role, 0);
        
        // Get new template
        $this->body = 'user/new-migration-setting';
        $this->user_layout();
    }
	
	public function save_setting(){
		
        $this->check_session($this->user_role, 0);
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            // Add form validation
            $this->form_validation->set_rules('opencart_websiteurl', 'Opencart web url', 'trim|required|callback_valid_urls');
			$this->form_validation->set_rules('opencart_database', 'Opencart database', 'trim|required');
			$this->form_validation->set_rules('opencart_dbuser', 'Opencart database user', 'trim|required');
			$this->form_validation->set_rules('opencart_dbpassword', 'Opencart database password', 'trim|required');
			$this->form_validation->set_rules('opencart_dbhost', 'Opencart database host', 'trim|required');
			$this->form_validation->set_rules('opencart_dbprefix', 'Opencart database prefix', 'trim|required');
			$this->form_validation->set_rules('opencart_admin', 'Opencart admin username', 'trim|required');
			$this->form_validation->set_rules('opencart_admin_password', 'Opencart admin password', 'trim|required');
			
			$this->form_validation->set_rules('magento_websiteurl', 'Magento web url', 'trim|required|callback_valid_urls');
			$this->form_validation->set_rules('magento_database', 'Magento database', 'trim|required');
			$this->form_validation->set_rules('magento_dbuser', 'Magento database user', 'trim|required');
			$this->form_validation->set_rules('magento_dbpassword', 'Magento database password', 'trim|required');
			$this->form_validation->set_rules('magento_dbhost', 'Magento database host', 'trim|required');
			$this->form_validation->set_rules('magento_dbprefix', 'Magento database prefix', 'trim|required');
			$this->form_validation->set_rules('magento_admin', 'Magento admin username', 'trim|required');
			$this->form_validation->set_rules('magento_admin_password', 'Magento admin password', 'trim|required');
			
            // Get data
            $opencart_websiteurl = $this->input->post('opencart_websiteurl');
            $opencart_database = $this->input->post('opencart_database');
            $opencart_dbuser = $this->input->post('opencart_dbuser');
            $opencart_dbpassword = $this->input->post('opencart_dbpassword');
            $opencart_dbhost = $this->input->post('opencart_dbhost');
			$opencart_dbprefix = $this->input->post('opencart_dbprefix');
			$opencart_admin = $this->input->post('opencart_admin');
			$opencart_admin_password = $this->input->post('opencart_admin_password');
			
            $magento_websiteurl = $this->input->post('magento_websiteurl');
            $magento_database = $this->input->post('magento_database');
            $magento_dbuser = $this->input->post('magento_dbuser');
			$magento_dbpassword = $this->input->post('magento_dbpassword');
			$magento_dbhost = $this->input->post('magento_dbhost');
			$magento_dbprefix = $this->input->post('magento_dbprefix');
			$magento_admin = $this->input->post('magento_admin');
			$magento_admin_password = $this->input->post('magento_admin_password');
			
			$action = $this->input->post('actionname');            
			
			$migration_id = $this->input->post('migration_id');
            // Check form validation
            if ( $this->form_validation->run() == false ) {
                
                echo json_encode('<div class="merror">'.validation_errors().$action.'</div>');
                
            } else {
                
				$checkopencart = $this->check_opencart($opencart_websiteurl);
                // Check if the password has less than six characters
               // if ( $checkopencart  ) {
               //     echo json_encode('<div class="merror">Web url is not opencart website</div>');
              //  } else {
				    $pieces = parse_url($magento_websiteurl);
					$domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
					if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
						$domainname = $regs['domain'];
					}else{
						$domainname = $magento_websiteurl;
					}
					$username = $this->session->userdata['username'];
					
					if($action == "save_settings" ){						
						$data = array(
								'user_id' => $this->user_id,
								'opencart_websiteurl' => $opencart_websiteurl,
								'opencart_database' => $opencart_database,
								'opencart_dbusername' => $opencart_dbuser,
								'opencart_dbpassword' => $opencart_dbpassword,
								'opencart_dbhost' => $opencart_dbhost,
								'opencart_dbprefix' => $opencart_dbprefix,
								'opencart_admin' => $opencart_admin,
								'opencart_admin_password' => $opencart_admin_password,
								'magento_websiteurl' => $magento_websiteurl,
								'magento_database' => $magento_database,
								'magento_dbusername' => $magento_dbuser,
								'magento_dbpassword' => $magento_dbpassword,
								'magento_dbhost' => $magento_dbhost,
								'magento_dbprefix' => $magento_dbprefix,
								'magento_admin' => $magento_admin,
								'magento_admin_password' => $magento_admin_password,
								);
						$lastid = $this->settings_migration->save_settings($data);
						
						$commanname = $username."_".$lastid;
						$createCategoryMapping = $this->settings_migration->createSettingTable($commanname);
						$createProductMapping = $this->settings_migration->createProductMappingTable($commanname);
						echo json_encode('<p class="msuccess">Migration settings saved successfully.</p>');
					}else if($action == "update_setting"){
						$data = array(
								'opencart_websiteurl' => $opencart_websiteurl,
								'opencart_database' => $opencart_database,
								'opencart_dbusername' => $opencart_dbuser,
								'opencart_dbpassword' => $opencart_dbpassword,
								'opencart_dbhost' => $opencart_dbhost,
								'opencart_dbprefix' => $opencart_dbprefix,
								'opencart_admin' => $opencart_admin,
								'opencart_admin_password' => $opencart_admin_password,
								'magento_websiteurl' => $magento_websiteurl,
								'magento_database' => $magento_database,
								'magento_dbusername' => $magento_dbuser,
								'magento_dbpassword' => $magento_dbpassword,
								'magento_dbhost' => $magento_dbhost,
								'magento_dbprefix' => $magento_dbprefix,
								'magento_admin' => $magento_admin,
								'magento_admin_password' => $magento_admin_password,
								);
						$update = $this->settings_migration->update_settings($migration_id, $this->user_id, $data);

						echo json_encode('<p class="msuccess">Migration settings updated successfully.</p>');
					}else{
						 echo json_encode('<div class="merror">Something is wrong</div>');
					}
            }
            
        }        
    }
	
	public function migration_info($id){
		 // Verify if session exists
        $this->check_session($this->user_role, 0);
        
        $getdata = $this->settings_migration->get_migration_info($id);
        
        if ( $getdata ) {
            
            echo json_encode([
                'msg' => $getdata,
                'idid' => $this->user_id
            ]);
            
        }
	}
	
	public function check_opencart($url){
		$url = '';
	}
	
	public function valid_urls($url)
	{
		if (!filter_var($url, FILTER_VALIDATE_URL))
		{
			$this->form_validation->set_message(  __FUNCTION__ , 'The %s field can not be valid url');
			return FALSE;
		}
		else
		{
			return TRUE;
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
