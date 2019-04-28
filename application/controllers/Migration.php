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
            $this->form_validation->set_rules('opencart_website_url', 'Opencart web url', 'trim|required|callback_valid_urls');
			$this->form_validation->set_rules('opencart_database_name', 'Opencart database', 'trim|required');
			$this->form_validation->set_rules('opencart_database_username', 'Opencart database user', 'trim|required');
			$this->form_validation->set_rules('opencart_database_password', 'Opencart database password', 'trim');
			$this->form_validation->set_rules('opencart_database_host', 'Opencart database host', 'trim|required');
			$this->form_validation->set_rules('opencart_database_prefix', 'Opencart database prefix', 'trim');
			$this->form_validation->set_rules('opencart_website_admin_username', 'Opencart admin username', 'trim|required');
			$this->form_validation->set_rules('opencart_website_admin_password', 'Opencart admin password', 'trim|required');

			$this->form_validation->set_rules('magento_website_url', 'Magento web url', 'trim|required|callback_valid_urls');
			$this->form_validation->set_rules('magento_database_name', 'Magento database', 'trim|required');
			$this->form_validation->set_rules('magento_database_username', 'Magento database user', 'trim|required');
			$this->form_validation->set_rules('magento_database_password', 'Magento database password', 'trim');
			$this->form_validation->set_rules('magento_database_host', 'Magento database host', 'trim|required');
			$this->form_validation->set_rules('magento_database_prefix', 'Magento database prefix', 'trim');
			$this->form_validation->set_rules('magento_website_admin_username', 'Magento admin username', 'trim|required');
			$this->form_validation->set_rules('magento_website_admin_password', 'Magento admin password', 'trim|required');

            // Get data
            $opencart_website_url = $this->input->post('opencart_website_url');
            $opencart_database_name = $this->input->post('opencart_database_name');
            $opencart_database_username = $this->input->post('opencart_database_username');
            $opencart_database_password = $this->input->post('opencart_database_password');
            $opencart_database_host = $this->input->post('opencart_database_host');
			$opencart_database_prefix = $this->input->post('opencart_database_prefix');
			$opencart_website_admin = $this->input->post('opencart_website_admin_username');
			$opencart_website_admin_password = $this->input->post('opencart_website_admin_password');

            $magento_website_url = $this->input->post('magento_website_url');
            $magento_database_name = $this->input->post('magento_database_name');
            $magento_database_username = $this->input->post('magento_database_username');
			$magento_database_password = $this->input->post('magento_database_password');
			$magento_database_host = $this->input->post('magento_database_host');
			$magento_database_prefix = $this->input->post('magento_database_prefix');
			$magento_website_admin_username = $this->input->post('magento_website_admin_username');
			$magento_website_admin_password = $this->input->post('magento_website_admin_password');

			$action = $this->input->post('actionname');

			$migration_id = $this->input->post('migration_id');
            // Check form validation
            if ( $this->form_validation->run() == false ) {

                echo json_encode('<div class="merror">'.validation_errors().$action.'</div>');

            } else {

				$checkopencart = $this->check_opencart($opencart_website_url);
                // Check if the password has less than six characters
               // if ( $checkopencart  ) {
               //     echo json_encode('<div class="merror">Web url is not opencart website</div>');
              //  } else {
				    $pieces = parse_url($magento_website_url);
					$domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
					if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
						$domainname = $regs['domain'];
					}else{
						$domainname = $magento_website_url;
					}
					$username = $this->session->userdata['username'];

					if($action == "save_settings" ){
						$data = array(
								'user_id' => $this->user_id,
								'opencart_website_url' => $opencart_website_url,
								'opencart_database_name' => $opencart_database_name,
								'opencart_database_username' => $opencart_database_username,
								'opencart_database_password' => $opencart_database_password,
								'opencart_database_host' => $opencart_database_host,
								'opencart_database_prefix' => $opencart_database_prefix,
								'opencart_website_admin_username' => $opencart_website_admin,
								'opencart_website_admin_password' => $opencart_website_admin_password,
								'magento_website_url' => $magento_website_url,
								'magento_database_name' => $magento_database_name,
								'magento_database_username' => $magento_database_username,
								'magento_database_password' => $magento_database_password,
								'magento_database_host' => $magento_database_host,
								'magento_database_prefix' => $magento_database_prefix,
								'magento_website_admin_username' => $magento_website_admin_username,
								'magento_website_admin_password' => $magento_website_admin_password,
								);
						$lastid = $this->settings_migration->save_settings($data);

						$commanname = $username."_".$lastid;
						$createCategoryMapping = $this->settings_migration->createSettingTable($commanname);
						$createProductMapping = $this->settings_migration->createProductMappingTable($commanname);
						echo json_encode('<p class="msuccess">Migration settings saved successfully.</p>');
					}else if($action == "update_setting"){
						$data = array(
								'opencart_website_url' => $opencart_website_url,
								'opencart_database_name' => $opencart_database_name,
								'opencart_database_username' => $opencart_database_username,
								'opencart_database_password' => $opencart_database_password,
								'opencart_database_host' => $opencart_database_host,
								'opencart_database_prefix' => $opencart_database_prefix,
								'opencart_website_admin_username' => $opencart_website_admin,
								'opencart_website_admin_password' => $opencart_website_admin_password,
								'magento_website_url' => $magento_website_url,
								'magento_database_name' => $magento_database_name,
								'magento_database_username' => $magento_database_username,
								'magento_database_password' => $magento_database_password,
								'magento_database_host' => $magento_database_host,
								'magento_database_prefix' => $magento_database_prefix,
								'magento_website_admin_username' => $magento_website_admin_username,
								'magento_website_admin_password' => $magento_website_admin_password,
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
