<?php
/**
 * Guides Controller
 *
 * PHP Version 5.6
 *
 * Guides contains the Guides class for Admin Guides
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
 * Guides class - contains all methods for Admin Guides
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Guides extends MY_Controller {
    
    /**
     * Class variables
     */   
    private $user_id, $user_role;
    
    /**
     * Initialise the Coupons controller
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
        
        // Load Guide Model
        $this->load->model('guide');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load Admin Helper
        $this->load->helper('admin_helper');
        
        // Load Fourth Helper
        $this->load->helper('fourth_helper');
        
        // Load Alerts Helper
        $this->load->helper('alerts_helper');
        
        // Load Frontend Helper
        $this->load->helper('frontend_helper');  
        
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
        
        // Load language
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_auth_lang.php') ) {
            
            $this->lang->load('default_auth', $this->config->item('language'));
            
        }
        
    }
    
    /**
     * The public method all_guides displays the guides list
     * 
     * @return void
     */
    public function all_guides() {
        
        
        // Check if data was submitted
        if ( $this->input->post() ) {
            
            // Verify if session exists and if the user is admin
            $this->if_session_exists($this->user_role,1);
            
            // Add form validation
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('short', 'Short', 'trim|required');
            $this->form_validation->set_rules('body', 'Body', 'trim');
            $this->form_validation->set_rules('guide', 'Guide', 'trim');
            
            // get data
            $title = $this->input->post('title');
            $short = $this->input->post('short');
            $body = $this->input->post('body');
            $guide = $this->input->post('guide');
            
            if ( $this->form_validation->run() == false ) {
                
                display_mess(152);
                
            } else {
                
                // Save the guide's data
                $save_guide = $this->guide->save_guide( $title, $short, $body, $guide );
                
                if ( $save_guide ) {
                    
                    display_mess(151);
                    
                } else {
                    
                    display_mess(152);
                    
                }
                
            }
            
        } else {
            
            // Deletes the guide option if exists
            delete_option( 'guide-cover' );
        
            // Check if the session exists and if the login user is admin
            $this->check_session($this->user_role, 1);
            
            // Gets saved guides
            $all_guides = $this->guide->get_guides();

            $this->body = 'admin/guides';

            $this->content = [
                'guides' => $all_guides
            ];

            $this->admin_layout();
        
        }
        
    } 
    
    /**
     * The public method get_guides gets all saved guides
     * 
     * @return void
     */
    public function get_guides() {
            
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);

        // Gets saved guides
        $all_guides = $this->guide->get_guides();

        if ( $all_guides ) {
            
            echo json_encode([
                'guides' => $all_guides,
                'time' => time()
            ]);
            
        }
        
    }
    
    /**
     * The public method guides displays the guides page
     * 
     * @param integer $guide_id contains the guide's id
     * 
     * @return void
     */
    public function guides( $guide_id = NULL ) {
        
        if ( get_option('disabled-frontend') ) {
            redirect('/members');
        }
        
        if ( $guide_id ) {
            
            // Get guide data by guide_id
            $get_guide = $this->guide->get_guide( $guide_id );
            
            // Verify if the guide exists
            if ( $get_guide ) {
            
                // Load view/auth/guide file
                $this->load->view('auth/single-guide', [
                    'guide' => $get_guide
                ]);
            
            } else {
                
                show_404();
                
            }
            
        } else {
        
            
            if ( get_option('enable-guides') ) {

                // Gets saved guides
                $all_guides = $this->guide->get_guides();        

                // Load view/auth/guides file
                $this->load->view('auth/guides', [
                    'guides' => $all_guides
                ]);

            } else {

                show_404();

            }
        
        }
        
    }
    
    /**
     * The public method get_guide gets a guide
     * 
     * @param integer $guide_id contains the guide's id
     * 
     * @return void
     */
    public function get_guide($guide_id) {
            
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);

        // Get guide data by guide_id
        $get_guide = $this->guide->get_guide( $guide_id );
        
        if ( $get_guide ) {
            
            echo json_encode($get_guide);
            
        }
        
    } 
    
    /**
     * The public method del_guide deletes a guide
     * 
     * @param integer $guide_id contains the guide's id
     * 
     * @return void
     */
    public function del_guide($guide_id) {
            
        // Verify if session exists and if the user is admin
        $this->if_session_exists($this->user_role,1);

        // Delete guide data by guide_id
        $guide = $this->guide->delete_guide($guide_id);
                        
        if ( $guide ) {

            display_mess(153);

        } else {

            display_mess(154);

        }
        
    }    
 
}

/* End of file Guides.php */
