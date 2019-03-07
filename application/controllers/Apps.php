<?php
/**
 * Apps Controller
 *
 * PHP Version 5.6
 *
 * Apps contains the Apps class for the Midrub's Apps
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
 * Apps class - contains all methods for the Midrub's Apps
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Apps extends MY_Controller {
    
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
        
        // Verify if exist a customized language file
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_apps_lang.php') ) {
            
            // load the apps language file
            $this->lang->load( 'default_apps', $this->config->item('language') );
            
        }
        
    }
    
    /**
     * The public method admin_apps displays the apps page
     * 
     * @param string $app contains the app's name
     * 
     * @return void
     */
    public function admin_apps($app = NULL) {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Prepare the app
        $app = str_replace('-', '_', $app);
        
        if ( $app ) {
            
            // Verify if app exists
            if ( is_dir( APPPATH . 'apps/collection/' . $app ) ) {
                
                // Require the Apps class
                $this->load->file( APPPATH . '/apps/main.php' );

                // Call the apps class
                $apps = new MidrubApps\MidrubApps();

                // Call the admin options
                $admin_options = $apps->options($app, 'admin');
                
                // Get apps template
                $this->body = 'admin/app';

                $this->content = array(
                    'options' => $admin_options
                );

                $this->admin_layout();
                
            } else {
                show_error('App not found');
            }
            
        } else {
        
            $apps = array();

            // List all apps
            foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

                $apps[] = basename($dir).PHP_EOL;

            }

            // Get apps template
            $this->body = 'admin/apps';

            $this->content = array(
                'apps' => $apps
            );

            $this->admin_layout();
        
        }
        
    }  
    
}

/* End of file Apps.php */
