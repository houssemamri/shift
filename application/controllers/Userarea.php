<?php
/**
 * Userarea Controller
 *
 * PHP Version 5.6
 *
 * Userarea contains the Userarea class for user account
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
 * Userarea class - contains all metods and pages for user account.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Userarea extends MY_Controller {

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
    
    /**
     * The public method apps loads the Midrub's apps
     * 
     * @param string $app contains the app's name
     * 
     * @return void
     */
    public function apps($app) {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->_check_unconfirmed_account();
        
        // Prepare the app
        $app = str_replace('-', '_', $app);

        // Verify if the app exists
        if ( is_dir( APPPATH . '/apps/collection/' . $app . '/' ) ) {
            
            if ( $app === 'dashboard' ) {
                
                // Get the user's plan
                $user_plan = get_user_option( 'plan' );
                
                // Verify if user has a plan, if no add default plan
                if ( !$user_plan ) {
                    $this->plans->change_plan(1, $this->user_id);
                    redirect('user/app/' . $app . '/');
                }

                // Get plan end
                $plan_end = get_user_option( 'plan_end', $this->user_id );

                $expired = 0;

                $expires_soon = 0;

                if ( $plan_end ) {

                    if ( strtotime($plan_end) < time() ) {

                        $expired = 1;
                        $this->plans->delete_user_plan($this->user_id);

                    } elseif ( strtotime($plan_end) < time() + 432000 ) {

                        $expires_soon = 1;

                    }

                }
                
            } 
            
            // Require the Apps class
            $this->load->file( APPPATH . '/apps/main.php' );

            // Call the apps class
            $apps = new MidrubApps\MidrubApps();
            
            // Call the user controller
            $red = $apps->user_init($app);
            
        } else {
            
            show_404();
            
        }
        
    }
    
    /**
     * The public method apps_ajax is universal caller for apps ajax calls
     * 
     * @param string $app contains the app's name
     * 
     * @return void
     */
    public function apps_ajax($app) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        // Prepare the app
        $app = str_replace('-', '_', $app);
        
        // Verify if the app exists
        if ( is_dir( APPPATH . '/apps/collection/' . $app . '/' ) ) {
            
            // Require the Apps class
            $this->load->file( APPPATH . '/apps/main.php' );

            // Call the apps class
            $apps = new MidrubApps\MidrubApps();
            
            // Call the ajax controller
            $apps->ajax_init($app);
            
        } else {
            
            show_error('App not found');
            
        }
        
    }

    /**
     * The public method ajax is universal caller for default user ajax calls
     * 
     * @param string $name contains the helper name
     * 
     * @return void
     */
    public function ajax($name) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        // Verify if helper exists
        if ( file_exists( APPPATH . '/helpers/' . $name . '_helper.php' ) ) {
            
            // Get action's get input
            $action = $this->input->get('action');

            if ( !$action ) {
                $action = $this->input->post('action');
            }

            try {

                // Load Helper
                $this->load->helper($name . '_helper');
                
                // Call the function
                $action();

            } catch (Exception $ex) {

                $data = array(
                    'success' => FALSE,
                    'message' => $ex->getMessage()
                );

                echo json_encode($data);

            }
            
        } else {
            
            show_error('Invalid parameters');
            
        }
        
    } 
    
    /**
     * The public method bots runs the Apps bots
     * 
     * @param string $app contains the app's name
     * 
     * @return void
     */
    public function bots($app) {
        
        // Prepare the app
        $app = str_replace('-', '_', $app);
        
        // Verify if the app exists
        if ( is_dir( APPPATH . '/apps/collection/' . $app . '/' ) ) {
            
            // Require the Apps class
            $this->load->file( APPPATH . '/apps/main.php' );

            // Call the apps class
            $apps = new MidrubApps\MidrubApps();
            
            // Call the ajax controller
            $apps->ajax_init($app);
            
        } else {
            
            show_error('App not found');
            
        }
        
    }

    /**
     * The public method activities displays information about Midrub's activities
     * 
     * @return void
     */
    public function activities() {
        
        // Verify if is a team's member
        if ( $this->session->userdata( 'member' ) && !get_user_option('display_activities') ) {
            redirect('user/app/dashboard');
        }
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->_check_unconfirmed_account();
        
        // Load view/user/activities.php file
        $this->body = 'user/activities';
        $this->user_layout();
    }

    /**
     * The public method tools displays the tools page.
     * 
     * @param string $name contains the tool's name
     * 
     * @return void
     */
    public function tools($name = NULL) {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->_check_unconfirmed_account();
        
        // Verify if the tool is enabled
        if ( $this->options->check_enabled('enable_tools_page') == false ) {
            
            show_404();
            
        }
        
        // Require the Tools interface
        require_once APPPATH . 'interfaces/Tools.php';
        
        if ( $name ) {
            
            if ( file_exists(APPPATH . 'tools' . '/' . $name . '/' . $name . '.php') ) {
                
                // Require the tool
                require_once APPPATH . 'tools' . '/' . $name . '/' . $name . '.php';
                
                // Call the class
                $class = ucfirst(str_replace('-', '_', $name));
                $get = new $class;
                
                
                $page = $get->page(['user_id' => $this->user_id]);
                
                $info = $get->check_info();
                
                // Load view/user/tool.php file
                $this->body = 'user/tool';
                $this->content = ['info' => $info, 'page' => $page];
                $this->user_layout();
                
            } else {
                
                echo display_mess(47);
                
            }
            
        } else {
            
            // Get all available tools.
            $classes = [];
            
            foreach (scandir(APPPATH . 'tools') as $dirname) {
                
                if ( is_dir(APPPATH . 'tools' . '/' . $dirname) && ($dirname != '.') && ($dirname != '..') ) {
                    
                    require_once APPPATH . 'tools' . '/' . $dirname . '/' . $dirname . '.php';
                    
                    $class = ucfirst(str_replace('-', '_', $dirname));
                    
                    $get = new $class;
                    
                    $classes[] = $get->check_info();
                    
                }
                
            }
            
            // Get favourites tools
            $get_favourites = $this->user_meta->get_favourites($this->user_id);
            
            $favourites = '';
            
            if ( $get_favourites ) {
                
                $favourites = unserialize($get_favourites[0]->meta_value);
                
            }
            
            // Get all options
            $options = $this->options->get_all_options();
            
            // Load view/user/tools.php file
            $this->body = 'user/tools';
            $this->content = ['tools' => $classes, 'favourites' => $favourites, 'options' => $options];
            $this->user_layout();
            
        }
        
    }

    /**
     * The public method Settings displays the Settings page.
     * 
     * @return void
     */
    public function settings() {
        
        // Verify if is a team's member
        if ( $this->session->userdata( 'member' ) ) {
            redirect('user/app/dashboard');
        }
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->_check_unconfirmed_account();
        
        // Load Team Model
        $this->load->model('team');
        
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_settings_lang.php') ) {
            $this->lang->load( 'default_settings', $this->config->item('language') );
        }
        
        // Get User Information
        $getdata = $this->user->get_user_info($this->user_id);

        // Get User's options
        $options = $this->user_meta->get_all_user_options($this->user_id);

        // display user data in settings page
        $this->content = array(
            'udata' => $getdata,
            'options' => $options
        );

        // Load view/user/settings.php file
        $this->body = 'user/settings';

        $this->user_layout();
        
    }

    /**
     * The public method notification displays the notifications page
     * 
     * @return void
     */
    public function notifications() {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->_check_unconfirmed_account();
        
        
        $notifications = $this->notifications->get_notifications($this->user_id);
        
        // Load view/user/notifications.php file
        $this->body = 'user/notifications';
        $this->content = ['notifications' => $notifications];
        $this->user_layout();
        
    }

    /**
     * The public method plans displays the plans page.
     * 
     * @return void
     */
    public function plans() {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->_check_unconfirmed_account();
        
        if ( $this->session->userdata( 'member' ) ) {
            show_404();
        }
        
        // Get all plans
        $get_plans = $this->plans->get_all_plans();
        
        // Get user plan
        $user_plan = $this->plans->get_user_plan($this->user_id);
        
        // Check if user plan expires soon
        $check_plan = $this->plans->check_if_plan_ended($this->user_id);
        
        $expires_soon = 0;
        
        if ( $check_plan ) {
            
            if ( $check_plan < time() + 432000 ) {
                
                $expires_soon = 1;
                
            }
            
        }
        
        $upgrade = '';
        
        if ( $this->session->flashdata('upgrade') ) {
            
            $upgrade = $this->session->flashdata('upgrade');
            
        }
        
        // Load view/user/plans.php file
        $this->body = 'user/plans';
        $this->content = ['plans' => $get_plans, 'user_plan' => $user_plan, 'expires_soon' => $expires_soon, 'upgrade' => $upgrade];
        $this->user_layout();
        
    }

    /**
     * The public method Upgrade change the user plan.
     *
     * @param integer $plan_id contains the id of the upgrading plan
     * @param string $pay contains the gateway's name
     * 
     * @return void
     */
    public function upgrade($plan_id, $pay = NULL ) {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Get plan price
        $price = $this->plans->get_plan_price($plan_id);
        
        if ($price[0]->plan_price > 0) {
        
            // Require the Payments interface
            require_once APPPATH . 'interfaces/Payments.php';
            
            // Verify if $pay is not null
            if ( $pay ) {
                
                $total_to_pay = $price[0]->plan_price;
                
                // Get discount if exists
                $discount = get_user_option( 'user_coupon_value' );
                
                if ( $discount ) {
                    
                    // Calculate total discount
                    $total = ( $discount / 100) * $price[0]->plan_price;   
                    
                    // Set new price
                    $total_to_pay = $total_to_pay - $total;
                    
                }
                
                
                if ( file_exists(APPPATH . 'payments/' . ucfirst($pay) . '.php') ) {

                    require_once APPPATH . 'payments/' . ucfirst($pay) . '.php';
                    
                    // Call the class
                    $pay_class = ucfirst(str_replace('-', '_', $pay));

                    $get = new $pay_class;
                    
                    $get->process( $plan_id, $total_to_pay, $price[0]->currency_code);

                } else {
                    
                    display_mess(47);

                }
                
            } else {
                
                // Delete the user coupon code
                $this->user->delete_user_option( $this->user_id, 'user_coupon_code' );

                // Delete the user discount value
                $this->user->delete_user_option( $this->user_id, 'user_coupon_value' );

                // Create the classes array variable
                $classes = [];

                // Get all available payments gateways
                foreach (glob(APPPATH . 'payments/*.php') as $filename) {

                    // Require the payments gateways
                    require_once $filename;

                    // Clean the class name
                    $className = str_replace([APPPATH . 'payments/', '.php'], '', $filename);

                    // Verify if the payment's gateway is enabled
                    if ( ($this->options->check_enabled(strtolower($className)) == FALSE) ) {

                        continue;

                    }

                    // Call the class name
                    $get = new $className();

                    // Get class info
                    $classes [] = $get->info();

                }

                // Set the layout
                $this->body = 'user/gateways';

                // Set the layout's content
                $this->content = [
                    'plan' => $plan_id,
                    'plann' => $price,
                    'payments' => $classes
                    ];

                // Call the layout
                $this->user_layout();

            }
            
        } else {
            
            if ( $this->plans->change_plan($plan_id, $this->user_id) ) {
                
                $this->session->set_flashdata('upgrade', display_mess(105));
                
            } else {
                
                $this->session->set_flashdata('upgrade', display_mess(106));
                
            }
            
            // go to plans page
            redirect('user/plans');
            
        }
        
    }

    /**
     * The function success_payment check the transaction if is valid and change the user plan.
     * 
     * @return void
     */
    public function success_payment() {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Require the Payments interface
        require_once APPPATH . 'interfaces/Payments.php';

        // Verify if the get param pay-return exits
        if ( get_instance()->input->get('pay-return', TRUE) ) {
            
            $pay = get_instance()->input->get('pay-return', TRUE);

            if ( file_exists(APPPATH . 'payments/' . ucfirst($pay) . '.php') ) {

                require_once APPPATH . 'payments/' . ucfirst($pay) . '.php';

                // Call the class
                $pay_class = ucfirst(str_replace('-', '_', $pay));

                $get = new $pay_class;

                $get->save();

            } else {

                display_mess(47);

            }
            
        }
                
    }

    /**
     * The public method get_notification displays a notification
     *
     * @param integer $notification_id is the id of the selected notification
     * 
     * @return void
     */
    public function get_notification($notification_id) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        // Get notification data by $notification_id
        $get_notification = $this->notifications->get_notification($notification_id, $this->user_id);
        
        if ( $get_notification ) {
            
            echo json_encode($get_notification);
            
        }
        
    }   

    /**
     * The public method del_notification deletes a notification
     *
     * @param integer $notification_id is the id of the selected notification
     * 
     * @return void
     */
    public function del_notification($notification_id) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        // delete notification by $notification_id and $this->user_id
        $del_notification = $this->notifications->del_notification($notification_id, $this->user_id);
        
        if ( !$del_notification ) {
            
            display_mess();
            
        } else {
            
            echo json_encode('');
            
        }
        
    }

    /**
     * The public method content_from_url gets contents from an url
     * 
     * @return void
     */
    public function content_from_url() {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        if ( $this->input->post() ) {
            
            // Add form validation
            $this->form_validation->set_rules('url', 'Url', 'trim|required');
            
            // Get the url
            $url = $this->input->post('url');
            
            if ( $this->form_validation->run() != false ) {

                echo json_encode( get_site($url) );
                
            }
            
        }
        
    }

    /**
     * The public method bookmark saves new tool to favourites
     *
     * @param string $tool contains the tool name
     * 
     * @return void
     */
    public function bookmark($tool) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        $tool = str_replace('-', '/', $tool);
        
        $tool = $this->security->xss_clean(base64_decode($tool));
        
        // Get favourites
        $get_favourites = $this->user_meta->get_favourites($this->user_id);
        
        if ( $get_favourites ) {
            
            // Get favorites
            $get_favourites = unserialize($get_favourites[0]->meta_value);
            
            if ( in_array($tool, $get_favourites) ) {
                
                unset($get_favourites[array_search($tool, $get_favourites)]);
                
            } else {
                
                array_push($get_favourites, $tool);
                
            }
            
            if ( $get_favourites ) {
                
                $set_favourites = serialize($get_favourites);
                
                if ( $this->user_meta->update_favourites($this->user_id, $set_favourites) ) {
                    
                    echo json_encode(1);
                    
                }
                
            } else {
                
                if ( $this->user_meta->delete_favourites($this->user_id) ) {
                    
                    echo json_encode(2);
                    
                }
                
            }
            
        } else {
            
            $tool = serialize([$tool]);
            
            if ( $this->user_meta->update_favourites($this->user_id, $tool) ) {
                
                echo json_encode(1);
                
            }
            
        }
        
    }

    /**
     * The public method set_option adds new value for an option
     *
     * @param string $option_name contains the name of option
     * 
     * @return void
     */
    public function set_option($option_name) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        if ( $option_name ) {
            
            // Enable or disable the $option_name option
            if ( $this->user_meta->enable_disable_user_option($this->user_id, $option_name) ) {
                
                echo json_encode(array(
                    'success' => TRUE,
                    'message' => $this->lang->line('option_enabled_successfully')
                ));                        

            } else {

                echo json_encode(array(
                    'success' => FALSE,
                    'message' => $this->lang->line('option_not_enabled_successfully')
                ));

            }
            
        }
        
    }

    /**
     * The public method connect redirects user to the login page
     *
     * @param string $networks contains the name of network
     * 
     * @return void
     */
    public function connect($network) {
        
        // Load plan features
        $limit_accounts = $this->plans->get_plan_features($this->user_id, 'network_accounts');
        
        // Get all accounts connected for social network
        $allaccounts = $this->networks->get_all_accounts($this->user_id, $network);
        
        if ( !$allaccounts ) {
            $allaccounts = array();
        }
        
        if ( $limit_accounts <= count($allaccounts) && !$this->input->get('account', TRUE) ) {
            
            // Display the error message
            echo $this->ecl('Social_login_connect')->view($this->lang->line('social_connector'), '<p class="alert alert-error">' . $this->lang->line('reached_maximum_number_allowed_accounts') . '</p>', false);
            exit();
            
        }
        
        // Connects user to his social account
        $this->check_session($this->user_role, 0);
        require_once APPPATH . 'interfaces/Autopost.php';
        
        if ( file_exists(APPPATH . 'autopost/' . ucfirst($network) . '.php') ) {
            
            require_once APPPATH . 'autopost/' . ucfirst($network) . '.php';
            
            $get = new $network;
            
            $get->connect();
            
        } else {
            
            display_mess(47);
            
        }
        
    }

    /**
     * The public method callback saves token from a social network
     *
     * @param string $network contains the network name
     * 
     * @return void
     */
    public function callback($network) {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Require the autopost?s interface
        require_once APPPATH . 'interfaces/Autopost.php';
        
        if ( file_exists(APPPATH . 'autopost/' . ucfirst($network) . '.php') ) {
            
            require_once APPPATH . 'autopost/' . ucfirst($network) . '.php';
            
            $get = new $network;
            
            $get->save();
            
        } else {
            
            display_mess(47);
            
        }
        
    }

    /**
     * The public method save_token saves token and user information from his social account
     *
     * @param string $network contains the network name
     * @param string $token contains the token
     * 
     * @return void
     */
    public function save_token($network, $token) {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Clean the token
        $token = str_replace('-', '/', $token);
        $clean_token = $this->security->xss_clean(base64_decode($token));

        // Require the autopost?s interface
        require_once APPPATH . 'interfaces/Autopost.php';
        
        if ( file_exists(APPPATH . 'autopost/' . ucfirst($network) . '.php') ) {
            
            require_once APPPATH . 'autopost/' . ucfirst($network) . '.php';
            
            $get = new $network;
            
            if ( $get->save($clean_token) ) {
                
                echo 1;
                
            } else {
                
                echo display_mess(1);
                
            }
            
        } else {
            
            echo display_mess(1);
            
        }
        
    }

    /**
     * The public method short redirects to original url
     *
     * @param string $param contains the param from url
     * 
     * @return void
     */
    public function short($param) {
        
        $un = $this->security->xss_clean(base64_decode(str_replace('-', '/', $param)));
        
        if ( is_numeric($un) ) {
            
            $original = $this->urls->get_original_url($un);
            
            if ( $original ) {
                
                redirect($original);
                
            } else {
                
                echo display_mess(47);
                
            }
            
        } else {
            
            show_404();
            
        }
        
    }
    
    /**
     * The public method tool loads the tool functions
     * 
     * @param string $name contains the tool's name
     * 
     * @return void
     */
    public function tool($name) {
        
        if ( $name ) {
            
            if ( file_exists(APPPATH . 'tools' . '/' . $name . '/functions.php') ) {
                
                require_once APPPATH . 'tools' . '/' . $name . '/functions.php';
                
            } else {
                
                echo display_mess(47);
                
            }
            
        }
        
    }

    /**
     * The public method delete_user_account deletes current user account
     * 
     * @return void
     */
    public function delete_user_account() {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        // Delete the user's data saved by apps
        $this->load->file(APPPATH . '/apps/main.php');

        // List all apps
        foreach (glob(APPPATH . 'apps/collection/*', GLOB_ONLYDIR) as $dir) {

            $app_dir = trim(basename($dir) . PHP_EOL);

            // Create an array
            $array = array(
                'MidrubApps',
                'Collection',
                ucfirst($app_dir),
                'Main'
            );

            // Implode the array above
            $cl = implode('\\', $array);

            // Delete user's data
            (new $cl())->delete_account($this->user_id);

        }
        
        // Delete connected social accounts
        $this->networks->delete_network('all', $this->user_id);
        
        // Delete campaigns
        $this->campaigns->delete_campaigns($this->user_id);
        
        // Delete templates
        $this->campaigns->delete_templates($this->user_id);
        
        // Delete lists
        $this->campaigns->delete_lists($this->user_id);
        
        // Delete schedules
        $this->campaigns->delete_schedules($this->user_id);
        
        // Load Fourth Helper
        $this->load->helper('fourth_helper');
        
        // Load Tickets Model
        $this->load->model('tickets');
        
        // Delete tickets
        $this->tickets->delete_tickets($this->user_id);
        
        // Load Botis Model
        $this->load->model('botis');
        
        // Delete all user's bots
        $this->botis->delete_user_bots($this->user_id);
        
        // Load Activity Model
        $this->load->model('activity');
        
        // Delete all user's activity
        $this->activity->delete_user_activity($this->user_id);
        
        // Load Media Model
        $this->load->model('media');
        
        // Get all user medias
        $getmedias = $this->media->get_user_medias($this->user_id, 0, 1000000);
      
        // Verify if user has media and delete them
        if ( $getmedias ) {
            
            // Load Media Helper
            $this->load->helper('media_helper');
            
            foreach( $getmedias as $media ) {
                delete_media($media->media_id, false);
            }
            
        }
        
        // Load Team Model
        $this->load->model('team');
        
        // Delete the user's team
        $this->team->delete_members( $this->user_id );
        
        // Load Activities Model
        $this->load->model('activities');
        
        // Delete the user's activities
        $this->activities->delete_activity( $this->user_id, 0 ); 
        
        // Delete user account
        if ( $this->user->delete_user($this->user_id) ) {
            
            // Deletes user's session
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('member');
            $this->session->unset_userdata('autodelete');
            
            echo json_encode(array(
                'success' => TRUE,
                'message' => $this->lang->line('mm64')
            ));  
            
        } else {
            
            echo json_encode(array(
                'success' => FALSE,
                'message' => $this->lang->line('mm65')
            )); 
            
        }
        
    }

    /**
     * The public method unconfirmed_account displays uncofirmed page
     * 
     * @return void
     */
    public function unconfirmed_account() {
        
        // Check if the current user is admin and if session exists
        $this->check_session();
        
        if ( $this->user_status == 1 ) {
            
            redirect('/user/app/dashboard');
            
        }
        
        // Show unconfirmed account page
        $this->load->view('user/unconfirmed-account');
        
    }
    
    /**
     * The private method _check_unconfirmed_account checks if the current user's account is confirmed
     * 
     * @return void
     */
    private function _check_unconfirmed_account() {
        
        if ( get_user_option('nonpaid') ) {
            
            redirect('/upgrade');
            
        }
        
        if ( $this->user_status == 0 ) {
            
            redirect('/user/unconfirmed-account');
            
        }
        
    }
    
    /**
     * The public method search_posts searches posts
     *
     * @param string $network displays accounts per network
     * @param integer $page is the number of page
     * @param string $search contains search key
     * 
     * @return void
     */
    public function show_accounts($network, $page, $search = null) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        $limit = 10;
        
        $page--;
        
        $total = $this->networks->count_all_accounts($this->user_id, $network, $search);
        
        $get_accounts = ($search) ? $this->networks->get_accounts($this->user_id, $network, $page * $limit, $search) : $this->networks->get_accounts($this->user_id, $network, $page * $limit);
        
        if ( $get_accounts ) {
            
            $data = ['total' => $total, 'accounts' => $get_accounts];
            echo json_encode($data);
            
        }
        
    }

    /**
     * The public method search_accounts searches accounts on database
     *
     * @param string $network is the network name
     * @param string $search is the search key
     * 
     * @return void
     */
    public function search_accounts($network, $search = null) {
        
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,0);
        
        $limit = 10;
        
        $page = 0;
        
        $search = str_replace('-', '/', $search);
        
        $search = $this->security->xss_clean(base64_decode($search));
        
        $total = $this->networks->count_all_accounts($this->user_id, $network, $search);
        
        $get_accounts = ($search) ? $this->networks->get_accounts($this->user_id, $network, 0, $search) : $this->networks->get_accounts($this->user_id, $network);
        
        if ( $get_accounts ) {
            
            $data = ['total' => $total, 'accounts' => $get_accounts];
            echo json_encode($data);
            
        }
        
    }
    
}

/* End of file Userarea.php */
