<?php
/**
 * Bots Controller
 *
 * PHP Version 5.6
 *
 * Bots contains the Bots class for Email Bots
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
 * Bots class - contains all metods and pages for Email Bots
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Bots extends MY_Controller {
    
    /**
     * Class variables
     */
    public $user_id, $user_role;
    
    /**
     * Initialise the Bots controller
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
        
        // Load Plans Model
        $this->load->model('plans');
        
        // Load Urls Model
        $this->load->model('urls');
        
        // Load Networks Model
        $this->load->model('networks');
        
        // Load Notifications Model
        $this->load->model('notifications');
        
        // Load Options Model
        $this->load->model('options');
        
        // Load Botis Model
        $this->load->model('botis');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load Alerts Helper
        $this->load->helper('alerts_helper');
        
        // Load SMTP
        $config = smtp();
        
        // Load Sending Email Class
        $this->load->library('email', $config);
        
        // Check if session username exists
        if ( isset($this->session->userdata['username']) ) {
            
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
        
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php' ) ) {
                
            $this->lang->load( 'default_alerts', $this->config->item('language') );
        
        }
        
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_bot_lang.php' ) ) {
            
            $this->lang->load( 'default_bot', $this->config->item('language') );
            
        }
        
    }

    /**
     * The public method manage_bots displays the admin's bots page
     */
    public function manage_bots() {

        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Load Admin Helper
        $this->load->helper('admin_helper');
        
        // Load language
        if ( file_exists(APPPATH . 'language/' . $this->config->item('language') . '/default_admin_lang.php') ) {
            
            $this->lang->load('default_admin', $this->config->item('language'));
            
        }
        
        // Require the Bots interface
        require_once APPPATH . 'interfaces/Boots.php';
        
        // Get all available bots.
        $classes = [];
        
        foreach ( glob(APPPATH . 'bots/*.php') as $filename ) {
            
            // Require bots
            require_once $filename;
            
            // Set the class's name
            $className = str_replace([APPPATH . 'bots/', '.php'], '', $filename);
            
            // Define the checked variable
            $checked = '';
            
            // Verify if pot is enabled
            if ( get_option('bot_' . strtolower($className)) ) {
                
                $checked = ' checked="checked"';
                
            }
            
            // Add bot to the list
            $classes [] = '
                <li>
                    <button class="btn-tool-icon btn btn-default bots-button btn-xs pull-left" type="button"><i class="fas fa-thumbtack"></i></button>
                    <span class="netaccount">' . ucwords(str_replace('_', ' ', $className)) . '</span>
                    <div class="enablus bots-checker pull-right">
                        <input id="bot_' . strtolower($className) . '" class="setopt" name="bot_' . strtolower($className) . '" type="checkbox"' . $checked . '>
                        <label for="bot_' . strtolower($className) . '"></label>
                    </div>
                </li>';
            
        }
        
        // Get all available options
        $options = $this->options->get_all_options();
        
        // Define the bots page template
        $this->body = 'admin/bots';
        
        // Add content in the template's page
        $this->content = [
            'bots' => $classes,
            'options' => $options
        ];
        
        // Load layout
        $this->admin_layout();
        
    }
    
    /**
     * The public method bots displays the user bots page.
     * 
     * @param string $name contains the bot's name
     */
    public function bots($name = NULL) {

        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if user's account is unconfirmed
        $this->check_unconfirmed_account();
        
        // Load User Helper
        $this->load->helper('user_helper');
        
        // Verify if bot is enabled
        if ( $this->options->check_enabled('enable_bots_page') == false ) {
            
            // Display the 404 page 
            show_404();
            
        } else {
            
            // Require the bots interface
            require_once APPPATH . 'interfaces/Boots.php';
            
            if ( $name ) {
                
                $name = ucfirst($name);
                
                $content = 'No data found.';
                
                if ( file_exists(APPPATH . 'bots/' . $name . '.php') ) {
                    
                    require_once APPPATH . 'bots/' . $name . '.php';
                    
                    $get = new $name;
                    
                    $content = $get->content();
                    
                }
                
                // Load view/user/single-bots.php file
                $this->body = 'user/single-bots';
                
                $this->content = ['content' => $content];
                
                $this->user_layout();
                
            } else {
                
                // Get all available bots.
                $classes = [];
                
                foreach ( glob(APPPATH . 'bots/*.php') as $filename ) {
                    
                    require_once $filename;
                    
                    $className = str_replace([APPPATH . 'bots/', '.php'], '', $filename);
                    
                    $get = new $className;
                    
                    $info = $get->get_info();
                    
                    $classes[] = array(
                        'name' => $info->name,
                        'slug' => $info->slug,
                        'description' => $info->description
                    );
                    
                }
                
                $get_favourites = $this->user_meta->get_favourites($this->user_id);
                
                $favourites = '';
                
                if ( $get_favourites ) {
                    
                    $favourites = unserialize($get_favourites[0]->meta_value);
                    
                }
                
                // Get all options
                $options = $this->options->get_all_options();
                
                // Load view/user/bots.php file
                $this->body = 'user/bots';
                
                $this->content = array(
                    'bots' => $classes,
                    'favourites' => $favourites,
                    'options' => $options
                );
                
                $this->user_layout();
            }
            
        }
        
    }
    
    /**
     * The public method bot is used for http methods
     * 
     * @param string $name contains the bot's name
     */
    public function bot( $name ) {
        
        // Verify if current user's account is unconfirmed
        $this->check_unconfirmed_account();
        
        // Verify if bot is enabled
        if ( $this->options->check_enabled('enable_bots_page') == false ) {
            
            show_404();
            
        } else {
            
            // Require the Bots interface
            require_once APPPATH . 'interfaces/Boots.php';
            
            $name = ucfirst($name);
            
            $content = 'No data found.';
            
            if ( file_exists(APPPATH . 'bots/' . $name . '.php') ) {
                
                require_once APPPATH . 'bots/' . $name . '.php';
                
                $get = new $name;
                
                $action = $this->input->get('action', TRUE);
                
                if ( $action ) {
                    
                    $get->load($action);
                    
                } else {
                    
                    show_404();
                    
                }
                
            }
            
        }
        
    }
    
    /**
     * The public method bot_cron calls all bot's cron methods
     */
    public function bot_cron() {
        
        // Get a random user_id
        $user_id = $this->botis->check_random_user();
        
        if ( !is_numeric($user_id) ) {
            
            exit();
            
        }
        
        // Require the Boots interface
        require_once APPPATH . 'interfaces/Boots.php';
        
        // List all available bots
        foreach ( glob(APPPATH . 'bots/*.php') as $filename ) {
            
            // Require the bots file
            require_once $filename;
            
            // Set the class name file
            $className = str_replace([APPPATH . 'bots/', '.php'], '', $filename);
            
            // Call the class
            $get = new $className;
            
            // Load the cron methods
            $get->load_cron($user_id);
            
        }
        
    }
    
    /**
     * The protected method check_unconfirmed_account checks if the current user's account is confirmed
     */
    protected function check_unconfirmed_account() {
        
        // Verify if the user's account is unconfirmed
        if ( $this->user_status == 0 ) {
            
            redirect('/user/unconfirmed-account');
            
        }
        
    }
    
}

/* End of file Bots.php */
