<?php
/**
 * Auth Controller
 *
 * PHP Version 5.6
 *
 * Auth contains the Auth class for login, signup and password reset
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
class Auth extends CI_Controller {

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
        $this->load->model('options');
        
        // Load Networks Model
        $this->load->model('networks');
        
        // Load Notifications Model
        $this->load->model('notifications');
        
        // Load Plans Model
        $this->load->model('plans');
        
        // Load Guide Model
        $this->load->model('guide');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load Alerts Helper
        $this->load->helper('alerts_helper');
        
        // Load Frontend Helper
        $this->load->helper('frontend_helper');        
        
        // Load session library
        $this->load->library('session');
        
        // Load SMTP
        $config = smtp();
        
        // Load Sending Email Class
        $this->load->library('email', $config);
        
        // Load URL Helper
        $this->load->helper('url');
        
        if (isset($this->session->userdata['username'])) {
            
            // Set user_id
            $this->user_id = $this->user->get_user_id_by_username($this->session->userdata['username']);
            
            // Set user_role
            $this->user_role = $this->user->check_role_by_username($this->session->userdata['username']);
            
            // Set user_status
            $this->user_status = $this->user->check_status_by_username($this->session->userdata['username']);
            
            // Get user language
            $user_lang = get_user_option('user_language');

            // Verify if user has selected a language
            if ( $user_lang ) {
                $this->config->set_item('language', $user_lang);
            }
            
        }
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_auth_lang.php') ) {
            
            $this->lang->load('default_auth', $this->config->item('language'));
            
        }
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_user_lang.php' ) ) {
            $this->lang->load( 'default_user', $this->config->item('language') );
        }
        if( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php') ) {
            
            $this->lang->load('default_alerts', $this->config->item('language'));
            
        }
        
    }

    /**
     * The public method index displays the login page
     * 
     * @return void
     */
    public function index() {
        
        if ( defined('cron') ) {
            
            return false;
            
        }
        
        if ( get_option('disabled-frontend') ) {
            redirect('/members');
        }
        
        // Gets saved guides
        $all_guides = $this->guide->get_guides();
        
        // Get all plans
        $get_plans = $this->plans->get_all_plans();
        
        if ( !get_option('home-page-header-title') ) {
            $this->options->add_option_value('home-page-header-title', 'All your social media in one place');
            $this->options->add_option_value('home-page-header-description', 'Midrub provides the easier way to schedule posts, analyze performance, and manage all your accounts in one place.');
            $this->options->add_option_value('home-page-header-button', 'Get started NOW');
            $this->options->add_option_value('home-page-contact-us-title', 'Contact Us');
            $this->options->add_option_value('home-page-contact-us-description', 'If you have a question, we have an answer. If you need something, we\'ll help you. Contact us anytime.');
            $this->options->add_option_value('home-page-contact-us-button', 'Get In Touch With Us');
            $this->options->add_option_value('footer-description', '<p>What are you working on? Midrub is a social service to schedule and publish of your posts on the most popular social networks.</p>');
            $this->options->add_option_value('home-bg-color', '#0D9AC0');
        }
        
        // Load view/auth/index file
        $this->load->view('auth/index', [
            'guides' => $all_guides,
            'plans' => $get_plans
            ]);
        
        
    }
    
    /**
     * The public method plans displays frontend plans
     * 
     * @return void
     */
    public function plans() {
        
        // Check if session exists
        $this->check_session_auth();
        
        // Get all plans
        $get_plans = $this->plans->get_all_plans();
        
        if ( get_option( 'enable-registration' ) ) {
            
            // Load view/auth/plans file
            $this->load->view('auth/plans', ['plans' => $get_plans]);
            
        } else {
            
            show_404();
            
        }
        
    }
    
    /**
     * The public method uprade displays the frontend upgrade page
     * 
     * @return void
     */
    public function upgrade() {
        
        // Check if session exist
        if ( isset($this->session->userdata['username']) && get_user_option( 'nonpaid' ) ) {
        
            // Get the user id
            $user_id = $this->user->get_user_id_by_username($this->session->userdata['username']);

            // Get the user's plan
            $user_plan = get_user_option( 'plan' );

            // Get plan price
            $price = $this->plans->get_plan_price( $user_plan );

            // Delete the user coupon code
            $this->user->delete_user_option( $user_id, 'user_coupon_code' );

            // Delete the user discount value
            $this->user->delete_user_option( $user_id, 'user_coupon_value' );

            // Create the classes array variable
            $classes = [];

            // Require the Payments interface
            require_once APPPATH . 'interfaces/Payments.php';

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

            // Load view/auth/upgrade file
            $this->load->view('auth/upgrade', [
                        'plan' => $user_plan,
                        'plann' => $price,
                        'payments' => $classes
                        ]);
            
        } else {
            
            show_404();
            
        }

        
    }
    
    /**
     * The public method signin allows to login in user or admin account
     * 
     * @return void
     */
    public function members() {
        
        // Check if session exists
        $this->check_session_auth();
        
        // Get all available social networks.
        require_once APPPATH . 'interfaces/Login.php';
        
        $classes = [];
        
        // Get all options
        $options = $this->options->get_all_options();
        
        if ( isset($options['social-signup']) ) {
            
            // List all social login
            foreach (glob(APPPATH . 'login/*.php') as $filename) {
                
                require_once $filename;
                
                $className = str_replace([APPPATH . 'login/', '.php'], '', $filename);
                
                $get = new $className;
                
                if ($get->check_availability()) {
                    
                    $classes[] = '<div class="form-group">
                                     <a href="' . site_url() . 'login/' . strtolower($className) . '" class="btn btn-labeled btn-' . strtolower($className) . '">' . $get->icon . ' '.$this->lang->line('m44').' ' . ucfirst($className) . '</a>
                                 </div>';
                }
                
            }
            
        }
        
        // Load view/auth/auth file
        $this->load->view('auth/auth', ['data' => $classes, 'signup' => isset($options['enable-registration']) ? 1 : 0]);
        
    }    

    /**
     * The public method signin allows to login in user or admin account
     * 
     * @return void
     */
    public function signin() {
        
        // Check if user was blocked
        $this->check_block();
        
        // Load Team Model
        $this->load->model('team');
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            
            // Check if username and password is not empty
            if (($this->input->post('username') == '') || ($this->input->post('password') == '')) {
                
                display_mess(12);
                
            } else {
                
                // Add form validation
                $this->form_validation->set_rules('username', 'Username', 'trim|min_length[6]|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|required');
                $this->form_validation->set_rules('remember', 'Remember', 'integer');
                
                // Get data
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $remember = $this->input->post('remember');
                
                // Check form validation
                if ($this->form_validation->run() == false) {
                    
                    display_mess(13);
                    
                } else {
                    
                    // Verify if the user is member of a team
                    if ( preg_match( '/m_/i', $username ) ) {
                        
                        // Get the team's owner
                        $team_owner = $this->team->check($username, $password);

                        if ( $team_owner ) {
                            
                            // Verify if the member's account is enabled
                            if ( $team_owner['status'] ) {
                                
                                display_mess(156);
                                exit();
                                
                            }

                            // Create the session
                            $this->session->set_userdata( 'username', $team_owner['username'] );

                            // Create the team's member session
                            $this->session->set_userdata( 'member', $username );

                            // If remember me are unckecked the session will be deleted after two hours
                            if ($remember == 0) {

                                $this->session->set_userdata('autodelete', time() + 7200);

                            }

                            // If block session exists will be removed
                            if ($this->session->userdata('block_user')) {

                                $this->session->unset_userdata('block_user');

                            }

                            display_mess(14);

                        } else {

                            $this->block_count();
                            display_mess(15);

                        }
                        
                    } elseif ( preg_match( '/@/i', $username ) ) {
                        
                        // Get username by email
                        $username = $this->user->get_username_by_email($username);
                        
                        // Verify if the email was found in our system
                        if ( $username ) {
                        
                            // Check if user and password exists
                            if ($this->user->check($username, $password)) {

                                // First we check if the user account was blocked
                                if ($this->user->check_status_by_username(strtolower($username)) == 2) {

                                    display_mess(77);

                                } else {

                                    $this->session->set_userdata('username', strtolower($username));

                                    // If remember me are unckecked the session will be deleted after two hours
                                    if ($remember == 0) {

                                        $this->session->set_userdata('autodelete', time() + 7200);

                                    }

                                    if ($this->session->userdata('block_user')) {

                                        $this->session->unset_userdata('block_user');

                                    }

                                    display_mess(14);

                                }

                            } else {

                                $this->block_count();
                                display_mess(15);

                            }
                            
                        } else {

                            $this->block_count();
                            display_mess(157);

                        }
                        
                    } else {
                    
                        // Check if user and password exists
                        if ($this->user->check($username, $password)) {

                            // First we check if the user account was blocked
                            if ($this->user->check_status_by_username(strtolower($username)) == 2) {

                                display_mess(77);

                            } else {

                                $this->session->set_userdata('username', strtolower($username));

                                // If remember me are unckecked the session will be deleted after two hours
                                if ($remember == 0) {

                                    $this->session->set_userdata('autodelete', time() + 7200);

                                }

                                if ($this->session->userdata('block_user')) {

                                    $this->session->unset_userdata('block_user');

                                }

                                display_mess(14);

                            }

                        } else {

                            $this->block_count();
                            display_mess(15);

                        }
                        
                    }
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method about_us displays the page about us
     * 
     * @return void
     */
    public function about_us() {
        
        if ( get_option('disabled-frontend') ) {
            redirect('/members');
        }
        
        if ( get_option('enable-about-us') ) {
        
            // Load view/auth/about-us file
            $this->load->view('auth/about-us');
        
        } else {
        
            show_404();
        
        }
        
    }
    
    /**
     * The public method contact_us displays the page contact us
     * 
     * @return void
     */
    public function contact_us() {
        
        if ( get_option('disabled-frontend') ) {
            redirect('/members');
        }
        
        if ( get_option('enable-contact-us') ) {
            
            $msg = '';
            
            if ( $this->input->post() ) {

                // Add form validation
                $this->form_validation->set_rules('firstName', 'First Name', 'trim');
                $this->form_validation->set_rules('lastName', 'Last Name', 'trim');
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('phone', 'Phone', 'trim');
                $this->form_validation->set_rules('message', 'Message', 'trim|required');
                $this->form_validation->set_rules('g-recaptcha-response', 'Catcha', 'trim|required');

                // Get data
                $firstName = $this->input->post('firstName');
                $lastName = $this->input->post('lastName');
                $email = $this->input->post('email');
                $phone = $this->input->post('phone');
                $body = $this->input->post('message');
                $g_recaptcha_response = $this->input->post('g-recaptcha-response');

                // Check form validation
                if ( $this->form_validation->run() == false ) {

                    $msg = display_mess(25);

                } else {

                    // Check if the catcha code is valid
                    $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt(
                            $curl, CURLOPT_POSTFIELDS, [
                        'secret' => get_option('captcha-secret-key'),
                        'response' => $g_recaptcha_response
                            ]
                    );
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    $auth = curl_exec($curl);
                    $response = json_decode($auth);
                    $message = '';
                    
                    if ( $firstName ) {
                        
                        $message .= '<p>First Name: ' . $firstName . '</p>';
                        
                    }
                    
                    if ( $lastName ) {
                        
                        $message .= '<p>Last Name: ' . $lastName . '</p>';
                        
                    }
                    
                    if ( $email ) {
                        
                        $message .= '<p>Email: ' . $email . '</p>';
                        
                    }    
                    
                    if ( $phone ) {
                        
                        $message .= '<p>Phone: ' . $phone . '</p>';
                        
                    }  
                    
                    if ( $message ) {
                        
                        $message .= '<p>Message: ' . $body . '</p>';
                        
                    }                    

                    if ( @$response->success ) {

                        $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                        $this->email->to($this->config->item('notification_mail'));
                        $this->email->subject('Message from ' . $this->config->item('site_name'));
                        $this->email->message($message);

                        if ( $this->email->send() ) {

                            $msg = display_mess(155);

                        } else {

                            $msg = display_mess(25);

                        }

                    }

                }

            }
        
            // Load view/auth/contact-us file
            $this->load->view('auth/contact-us', ['msg' => $msg]);
        
        } else {
        
            show_404();
        
        }
        
    }    
    
    /**
     * The public method passwordreset displays the password reset page
     * 
     * @return void
     */
    public function passwordreset() {
        
        // Check if session exists
        $this->check_session_auth();
        
        // Load view/auth/password-resset file
        $this->load->view('auth/password-reset');
        
    }

    /**
     * The public method terms displays the terms pages
     * 
     * @return void
     */
    public function terms($page) {
        
        $data = [];
        
        switch ($page) {
            
            case 'conditions':
                
                $data = [
                    'title' => get_option('terms_page_title'),
                    'body' => get_option('terms_page_body') ];
                
                break;
            
            case 'policy':
                
                $data = [
                    'title' => get_option('policy_page_title'),
                    'body' => get_option('policy_page_body') ];
                
                break;  
            
            case 'cookies':
                
                $data = [
                    'title' => get_option('cookies_page_title'),
                    'body' => get_option('cookies_page_body') ];
                
                break; 
            
            default:
                
                show_404();
                
                break;
            
        }
        
        // Load view/auth/terms file
        $this->load->view('auth/terms', $data);
        
    }

    /**
     * The public method report_bug displays the report bug page
     * 
     * @return void
     */
    public function report_bug() {
        
        if ( get_option('disabled-frontend') ) {
            redirect('/members');
        }
        
        // Displays report a bug page
        $msg = '';
        
        if ( $this->input->post() ) {
            
            // Add form validation
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
            $this->form_validation->set_rules('description', 'description', 'trim|required');
            $this->form_validation->set_rules('g-recaptcha-response', 'Catcha', 'trim|required');
            
            // Get data
            $subject = $this->input->post('subject');
            $description = $this->input->post('description');
            $g_recaptcha_response = $this->input->post('g-recaptcha-response');
            
            // Check form validation
            if ( $this->form_validation->run() == false ) {
                
                $msg = display_mess(25);
                
            } else {
                
                // Check if the catcha code is valid
                $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt(
                        $curl, CURLOPT_POSTFIELDS, [
                    'secret' => get_option('captcha-secret-key'),
                    'response' => $g_recaptcha_response
                        ]
                );
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $auth = curl_exec($curl);
                $response = json_decode($auth);
                
                if ( @$response->success ) {
                    
                    $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                    $this->email->to($this->config->item('notification_mail'));
                    $this->email->subject($subject);
                    $this->email->message($description);
                    
                    if ( $this->email->send() ) {
                        
                        $msg = display_mess(51);
                        
                    } else {
                        
                        $msg = display_mess(25);
                        
                    }
                    
                }
                
            }
            
        }
        
        $this->load->view('auth/report-bug', ['msg' => $msg]);
        
    }

    /**
     * The public method password_reset will reset the password
     * 
     * @return void
     */
    public function password_reset() {
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            
            // Add form validation
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            
            // Get data
            $email = $this->input->post('email');
            
            if ( $this->form_validation->run() == false ) {
                
                display_mess(16);
                
            } else {
                
                // Check if email address exists in database
                if ( $this->user->check_email($email) ) {
                    
                    // Get username
                    $username = 'User';
                    $getUsername = $this->user->get_username_by_email($email);
                    
                    if ( $getUsername ) {
                        
                        $username = $getUsername;
                        
                    }
                    
                    $reset = time();
                    
                    $add_reset = $this->user->add_code($email, $reset, 'reset_code');
                    
                    // Send password reset confirmation email
                    if ( $add_reset ) {
                        
                        // Will be send the password-reset notification template to the current user
                        $args = ['[username]' => $username, '[site_name]' => $this->config->item('site_name'), '[reset_link]' => '<a href="' . $this->config->base_url() . 'new-password?reset=' . $reset . '&f=' . $add_reset . '">' . $this->config->base_url() . 'new-password?reset=' . $reset . '&f=' . $add_reset . '</a>', '[login_address]' => '<a href="' . $this->config->item('login_url') . '">' . $this->config->item('login_url') . '</a>', '[site_url]' => '<a href="' . $this->config->base_url() . '">' . $this->config->base_url() . '</a>'];
                        
                        $template = $this->notifications->get_template('password-reset', $args);
                        
                        // Check if the template exists
                        if ( $template ) {
                            
                            $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                            $this->email->to($email);
                            $this->email->subject($template['title']);
                            $this->email->message($template['body']);
                            
                            if ( $this->email->send() ) {
                                
                                display_mess(17);
                                
                            } else {
                                
                                display_mess(18);
                                
                            }
                            
                        } else {
                            
                            display_mess(18);
                            
                        }
                        
                    } else {
                        
                        display_mess(19);
                        
                    }
                    
                } else {
                    
                    display_mess(20);
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method new_password displays the change password page
     * 
     * @return void
     */
    public function new_password() {
        
        // Check if session exists
        $this->check_session_auth();
        
        $reset = $this->input->get('reset', true);
        
        $f = $this->input->get('f', true);
        
        $changed = false;
        
        if ( is_numeric($reset) AND is_numeric($f) ) {
            
            // Check if reset code is valid
            if ( !$this->user->check_reset_code($reset, $f) ) {
                
                echo display_mess(26);
                die();
                
            }
            
            $data = '';
            
            if ( $this->input->post() ) {
                
                // Add form validation
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                $password = trim($this->input->post('password'));
                $password2 = trim($this->input->post('password2'));
                
                if ( $password != $password2 ) {
                    
                    $data = display_mess(21);
                    
                } else {
                    
                    if ( ( strlen($password) < 6 ) || ( strlen($password) > 20 ) ) {
                        
                        $data = display_mess(22);
                        
                    } elseif ( preg_match('/\s/', $password) ) {
                        
                        $data = display_mess(23);
                        
                    } else {
                        
                        if ( $this->user->password_changed($password, $reset, $f) ) {
                            
                            $changed = true;
                            $data = display_mess(24);
                            
                        } else {
                            
                            $data = display_mess(25);
                            
                        }
                        
                    }
                    
                }
                
            }
            
            // Load view/auth/new-password file
            $this->load->view('auth/new-password', ['msg' => $data, 'changed' => $changed]);
            
        } else {
            
            echo display_mess(26);
            die();
            
        }
        
    }

    /**
     * The public method signup displays the signup page
     * 
     * @param integer $plan_id contains the plan's id
     * 
     * @return void
     */
    public function signup( $plan_id ) {
        
        $username = '';
        
        $data = '';

        // Check if session exists
        $this->check_session_auth();
        
        $this->session->set_userdata('plan_id', $plan_id);
        
        $userdata = $this->session->flashdata('userdata');
        
        if ( $userdata ) {
            
            if ( ( $userdata['id'] != '' ) AND ( $userdata['email'] != '' ) ) {
                
                // Check if username exists and login automatically
                if ( $this->user->check_username($userdata['id']) ) {
                    
                    if ( $this->user->get_user_id_by_username($userdata['id']) ) {
                        
                        $this->user->last_access($this->user->get_user_id_by_username($userdata['id']));
                        
                    }
                    
                    $this->session->set_userdata('username', $userdata['id']);
                    
                    $this->session->set_userdata('autodelete', time() + 7200);
                    
                    redirect('/user/app/dashboard');
                    
                }
                
                if ( !$this->user->check_email($userdata['email']) ) {
                    
                    $user_id = $this->user->signup($userdata['fullname'], '', $userdata['id'], $userdata['email'], time(), 1);
                    
                    if ( $user_id ) {
                        
                        if ( $this->user->get_user_id_by_username($userdata['id']) ) {
                            
                            $this->user->last_access($this->user->get_user_id_by_username($userdata['id']));
                            
                        }
                        
                        $plan_data = $this->plans->get_plan($plan_id);

                        if ( ( $plan_data[0]['plan_price'] > 0 ) && ( $plan_data[0]['trial'] < 1 ) ) {

                            // Save the error
                            $this->user_meta->update_user_meta($user_id, 'nonpaid', 1);

                        }

                        if ( $this->session->userdata('plan_id') ) {

                            $plan_id = $this->session->userdata('plan_id');
                            
                            // Set the user plan
                            $this->plans->change_plan($plan_id, $user_id);

                        } else {

                            // Set the user plan
                            $this->plans->change_plan($plan_id, $user_id);

                        }
                        
                        $this->session->set_userdata('username', $userdata['id']);
                        
                        $this->session->set_userdata('autodelete', time() + 7200);
                        
                        redirect('/user/app/dashboard');
                        
                    } else {
                        
                        $data = display_mess(27);
                        
                    }
                    
                } else {
                    
                    $data = display_mess(28);
                    
                }
                
            } else {
                
                if ( $userdata['id'] ) {
                    
                    if ( $this->user->check_username($userdata['id']) ) {
                        
                        if ( $this->user->get_user_id_by_username($userdata['id']) ) {
                            
                            $this->user->last_access($this->user->get_user_id_by_username($userdata['id']));
                            
                        }
                        
                        $this->session->set_userdata('username', $userdata['id']);
                        $this->session->set_userdata('autodelete', time() + 7200);
                        redirect('/user/app/dashboard');
                        
                    }
                    
                } else {
                    
                    $data = display_mess(29);
                    
                }
                
            }
            
            if ( $userdata['email'] == null ) {
                
                $data = display_mess(30);
                
            }
            
        }
        
        $error = $this->session->flashdata('error');
        
        if ( $error ) {
            
            $data = '<p class="merror block">' . $error . '</p>';
            
        }
        
        // Get all available social networks.
        require_once APPPATH . 'interfaces/Login.php';
        
        $classes = [];
        
        // Get all options
        $options = $this->options->get_all_options();
        
        if ( isset($options['social-signup']) ) {
            
            foreach ( glob(APPPATH . 'login/*.php') as $filename ) {
                
                require_once $filename;
                
                $className = str_replace([APPPATH . 'login/', '.php'], '', $filename);
                
                $get = new $className;
                
                if ( $get->check_availability() ) {
                    
                    $classes[] = '<div class="form-group">
                                     <a href="' . site_url() . 'login/' . strtolower($className) . '" class="btn btn-labeled btn-' . strtolower($className) . '">' . $get->icon . ' '.$this->lang->line('m44').' ' . ucfirst($className) . '</a>
                                 </div>';
                    
                }
                
            }
            
        }
        
        if ( isset($options['enable-registration']) ) {
            
            // Get all plans
            $get_plans = $this->plans->get_all_plans();
            
            // Load view/auth/signup file
            $this->load->view('auth/signup', array('msg' => $data, 'username' => $username, 'data' => $classes, 'plans' => $get_plans, 'plan_id' => $plan_id) );
            
        } else {
            
            show_404();
            
        }
        
    }

    /**
     * The public method register will save user data to database
     * 
     * @return void
     */
    public function register() {
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            
            // Check if ip and registration limit exists
            // If you want remove ip limit just remove the if bellow
            if ( $this->options->check_enabled('signup_limit') ) {
                
                if ( $this->user->check_ip_and_date() == 1 ) {
                    
                    display_mess(31);
                    exit();
                    
                }
                
            } else {
                
                if ( $this->user->check_ip_and_date() > 0 ) {
                    
                    display_mess(32);
                    exit();
                    
                }
                
            }
            
            // Add form validation
            $this->form_validation->set_rules('first_name', 'First Name', 'trim');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
            $this->form_validation->set_rules('plan_id', 'Plan ID', 'trim|required|integer');
            
            // Get data
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $plan_id = $this->input->post('plan_id');
            
            // Check form validation
            if ( $this->form_validation->run() == false ) {
                
                display_mess(33);
                
            } else {
                
                // Check if the password has less than six characters
                if ( ( strlen($username) < 6 ) || ( strlen($password) < 6 ) ) {
                    
                    display_mess(34);
                    
                } else if ( ( strlen($password) < 6 ) || ( strlen($password) > 20 ) ) {
                        
                    $data = display_mess(22);
                        
                } elseif ( preg_match('/\s/', $username) || preg_match('/\s/', $password) ) {
                    
                    // Check if the username or password contains white spaces
                    display_mess(35);
                    
                } elseif ( $this->user->check_email($email) ) {
                    
                    // Check if the email address are present in our database
                    display_mess(36);
                    
                } elseif ( $this->user->check_username($username) ) {
                    
                    // Check if the username are present in our database
                    display_mess(37);
                    
                } elseif ( !$this->plans->get_plan($plan_id) ) {
                    
                    // Verify if plan exists
                    display_mess(150); 
                    
                } else {
                    
                    // Register the user
                    $user_id = $this->user->signup( $first_name, $last_name, $username, $email, $password );
                    
                    $plan_data = $this->plans->get_plan($plan_id);
                    
                    if ( ( $plan_data[0]['plan_price'] > 0 ) && ( $plan_data[0]['trial'] < 1 ) ) {
                        
                        // Save the error
                        $this->user_meta->update_user_meta($user_id, 'nonpaid', 1);
                        
                    }
                    
                    if ( $user_id ) {
                        
                        if ( $this->session->userdata('plan_id') ) {

                            $plan_id = $this->session->userdata('plan_id');
                            
                            // Set the user plan
                            $this->plans->change_plan($plan_id, $user_id);

                        } else {

                            // Set the user plan
                            $this->plans->change_plan($plan_id, $user_id);

                        }
                        
                        // Check if admin want to receive a notification about new users
                        if ( $this->options->check_enabled('enable-new-user-notification') ) {
                            
                            // Get the new-user-notification notification template and send it
                            $args = ['[username]' => $username, '[site_name]' => '<a href="' . $this->config->base_url() . '">' . $this->config->item('site_name') . '</a>', '[login_address]' => '<a href="' . $this->config->item('login_url') . '">' . $this->config->item('login_url') . '</a>', '[site_url]' => '<a href="' . $this->config->base_url() . '">' . $this->config->base_url() . '</a>'];
                            
                            $template = $this->notifications->get_template('new-user-notification', $args);
                            
                            if ( $template ) {
                                
                                $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                                $this->email->to($this->config->item('notification_mail'));
                                $this->email->subject($template['title']);
                                $this->email->message($template['body']);
                                $this->email->send();
                                
                            }
                            
                        }
                        
                        // Check if sign up need confirm
                        if ( $this->options->check_enabled('signup_confirm') ) {
                            
                            $activate = time();
                            
                            // Save activation code in user's information from database
                            $add_activate = $this->user->add_code($email, $activate, 'activate');
                            
                            // Get the welcome-message-with-confirmation notification template and send it
                            $args = ['[username]' => $username, '[site_name]' => $this->config->item('site_name'), '[confirmation_link]' => '<a href="' . $this->config->base_url() . 'activate?code=' . $activate . '&f=' . $add_activate . '">' . $this->config->base_url() . 'activate?code=' . $activate . '&f=' . $add_activate . '</a>', '[login_address]' => '<a href="' . $this->config->item('login_url') . '">' . $this->config->item('login_url') . '</a>', '[site_url]' => '<a href="' . $this->config->base_url() . '">' . $this->config->base_url() . '</a>'];
                            
                            $template = $this->notifications->get_template('welcome-message-with-confirmation', $args);
                            
                            if ( $template ) {
                                
                                $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                                $this->email->to($email);
                                $this->email->subject($template['title']);
                                $this->email->message($template['body']);
                                
                                if ( $this->email->send() ) {
                                    
                                    display_mess(38);
                                    
                                } else {
                                    
                                    display_mess(18);
                                    
                                }
                                
                            } else {
                                
                                display_mess(18);
                                
                            }
                            
                        } else {
                            
                            // Display successfully message 
                            display_mess(39);
                            
                            // Get the welcome-message-no-confirmation notification template and send it
                            $args = ['[username]' => $username, '[site_name]' => $this->config->item('site_name'), '[login_address]' => '<a href="' . $this->config->item('login_url') . '">' . $this->config->item('login_url') . '</a>', '[site_url]' => '<a href="' . $this->config->base_url() . '">' . $this->config->base_url() . '</a>'];
                            
                            $template = $this->notifications->get_template('welcome-message-no-confirmation', $args);
                            
                            if ( $template ) {
                                
                                $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                                $this->email->to($email);
                                $this->email->subject($template['title']);
                                $this->email->message($template['body']);
                                $this->email->send();
                                
                            }
                            
                        }
                        
                    } else {
                        
                        display_mess(40);
                        
                    }
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method resend_confirmation resends the password reset link by email
     * 
     * @return void
     */
    public function resend_confirmation() {
        
        // This function will resend confirmation code
        // Check if resend code was sent recently
        if ( $this->session->userdata('resend') ) {
            
            if ( $this->session->userdata('resend') > time() ) {
                
                display_mess(41);
                die();
                
            }
            
        }
        
        if ( $this->session->userdata('username') ) {
            
            // Get the email
            $email = $this->user->get_email_by('username', $this->session->userdata('username'));
            
            if ( $email ) {
                
                $activate = time();
                
                $add_activate = $this->user->add_code($email, $activate, 'activate');
                
                if ( $add_activate ) {
                    
                    // Will be send the resend-confirmation-email notification template to the current user
                    $args = ['[username]' => $this->session->userdata('username'), '[site_name]' => $this->config->item('site_name'), '[confirmation_link]' => '<a href="' . $this->config->base_url() . 'activate?code=' . $activate . '&f=' . $add_activate . '">' . $this->config->base_url() . 'activate?code=' . $activate . '&f=' . $add_activate . '</a>', '[login_address]' => '<a href="' . $this->config->item('login_url') . '">' . $this->config->item('login_url') . '</a>', '[site_url]' => '<a href="' . $this->config->base_url() . '">' . $this->config->base_url() . '</a>'];
                    
                    $template = $this->notifications->get_template('resend-confirmation-email', $args);
                    
                    if ( $template ) {
                        
                        $this->email->from($this->config->item('contact_mail'), $this->config->item('site_name'));
                        $this->email->to($email);
                        $this->email->subject($template['title']);
                        $this->email->message($template['body']);
                        
                        if ( $this->email->send() ) {
                            
                            $this->session->set_userdata('resend', time() + 3600);
                            display_mess(42);
                            
                        } else {
                            
                            display_mess(43);
                            
                        }
                        
                    } else {
                        
                        display_mess(43);
                        
                    }
                    
                } else {
                    
                    display_mess(43);
                    
                }
                
            } else {
                
                display_mess(43);
                
            }
            
        } else {
            
            display_mess(43);
            
        }
        
    }

    /**
     * The public method activate will activate user's account
     * 
     * @return void
     */
    public function activate() {
        
        // Get the code
        $code = $this->input->get('code', true);
        
        $f = $this->input->get('f', true);
        
        if ( is_numeric($code) AND is_numeric($f) ) {
            
            // Check if reset code is valid
            if ( !$this->user->check_activation_code($code, $f) ) {
                
                echo display_mess(26);
                die();
                
            } else {
                
                // This function will activate the user account
                $activate_account = $this->user->activate_account($f);
                
                if ( $activate_account ) {
                    
                    display_mess(44);
                    
                    // Check if user session exists
                    if ( isset($CI->session->userdata['username']) ) {
                        
                        echo '<script language="javascript">document.location.href = "' . site_url() . '";</script>';
                        
                    }
                    
                    if ( $this->user->get_username_by_id($f) ) {
                        
                        $this->user->last_access($f);
                        $this->session->set_userdata('username', strtolower($this->user->get_username_by_id($f)));
                        $this->session->set_userdata('autodelete', time() + 7200);
                        echo '<script language="javascript">document.location.href = "' . site_url() . '"; </script>';
                        
                    } else {
                        
                        display_mess(45);
                        die();
                        
                    }
                    
                } else {
                    
                    display_mess(45);
                    die();
                    
                }
                
            }
            
        } else {
            
            echo display_mess(26);
            die();
            
        }
        
    }

    /**
     * The public method login displays login options via social networks
     *
     * @param string $network is the network's name
     * 
     * @return void
     */
    public function login( $network ) {
        
        require_once APPPATH . 'interfaces/Login.php';
        
        if ( file_exists(APPPATH . 'login/' . ucfirst($network) . '.php') ) {
            
            require_once APPPATH . 'login/' . ucfirst($network) . '.php';
            
            $get = new $network;
            
            $get->sign_in();
            
        } else {
            
            display_mess(47);
            
        }
        
    }

    /**
     * The public method callback will save user token
     *
     * @param string $network is the network's name
     * 
     * @return void
     */
    public function callback( $network ) {
        
        require_once APPPATH . 'interfaces/Login.php';
        
        if ( file_exists(APPPATH . 'login/' . ucfirst($network) . '.php') ) {
            
            require_once APPPATH . 'login/' . ucfirst($network) . '.php';
            
            $get = new $network;
            
            $get->get_token();
            
        } else {
            
            display_mess(47);
            
        }
        
    }

    /**
     * The public method check_session_auth checks if session exists
     * 
     * @return void
     */
    public function check_session_auth() {
        
        // Check if session exist
        if ( isset($this->session->userdata['username']) ) {
            
            // Check if user checked remember me checkbox
            if ( isset($this->session->userdata['autodelete']) ) {
                
                if ( $this->session->userdata['autodelete'] < time() ) {
                    
                    // Delete session and redirect to home page
                    $this->session->unset_userdata('username');
                    $this->session->unset_userdata('member');
                    $this->session->unset_userdata('autodelete');
                    
                } else {
                    
                    redirect('user/app/dashboard');
                    
                }
                
            } else {
                
                redirect('user/app/dashboard');
                
            }
            
        }
        
    }

    /**
     * The public method block_count will block user
     * 
     * @return void
     */
    public function block_count() {
        
        if ( $this->session->userdata('block_user') ) {
            
            $get_count = $this->session->userdata('block_user');
            
            if ( ( $get_count['time'] > time() - 3600 ) AND ( $get_count['tried'] == 1 ) ) {
                
                $this->session->unset_userdata('block_user');
                $session_data = ['time' => time(), 'tried' => 2];
                $this->session->set_userdata('block_user', $session_data);
                
            } elseif ( ( $get_count['time'] > time() - 3600 ) AND ( $get_count['tried'] == 2 ) ) {
                
                $this->session->unset_userdata('block_user');
                $session_data = ['time' => time(), 'tried' => 3];
                $this->session->set_userdata('block_user', $session_data);
                
            } elseif ( ( $get_count['time'] > time() - 3600 ) AND ( $get_count['tried'] == 3 ) ) {
                
                $this->session->unset_userdata('block_user');
                $session_data = ['time' => time(), 'tried' => 4];
                $this->session->set_userdata('block_user', $session_data);
                
            } elseif ( ( $get_count['time'] > time() - 3600 ) AND ( $get_count['tried'] == 4 ) ) {
                
                $this->session->unset_userdata('block_user');
                $session_data = ['time' => time(), 'tried' => 5];
                $this->session->set_userdata('block_user', $session_data);
                display_mess(48);
                die();
                
            } else {
                
                $this->session->unset_userdata('block_user');
                $session_data = ['time' => time(), 'tried' => 1];
                $this->session->set_userdata('block_user', $session_data);
                
            }
            
        } else {
            
            $session_data = ['time' => time(), 'tried' => 1];
            $this->session->set_userdata('block_user', $session_data);
            
        }
        
    }

    /**
     * The public method block_count checks if the user is already blocked
     * 
     * @return void
     */
    public function check_block() {
        
        if ( $this->session->userdata('block_user') ) {
            
            $get_count = $this->session->userdata('block_user');
            
            if ( ($get_count['time'] > time() - 3600) AND ( $get_count['tried'] == 5) ) {
                
                display_mess(48);
                die();
                
            } else {
                
                if ( ($get_count['time'] < time() - 3600) ) {
                    
                    $this->session->unset_userdata('block_user');
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method logout will delete user's session
     * 
     * @return void
     */
    public function logout() {
        
        // This function will delete all active session
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('member');
        $this->session->unset_userdata('autodelete');
        
        // Delete all user's sessions from database
        $this->user->delete_all_sessions();
        redirect('/');
        
    }

}

/* End of file Auth.php */
