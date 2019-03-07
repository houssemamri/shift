<?php
/**
 * Ticketsarea Controller
 *
 * PHP Version 5.6
 *
 * Ticketsarea contains the Ticketsarea class for System Tickets
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
 * Ticketsarea class - contains all methods and pages for System Tickets
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Ticketsarea extends MY_Controller {
    
    public $user_id, $user_role;
    
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
        
        // Load Faq Model
        $this->load->model('faq');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load Faq Helper
        $this->load->helper('faq_helper');
        
        // Load User Helper
        $this->load->helper('user_helper');
        
        // Load Admin Helper
        $this->load->helper('admin_helper');
        
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
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_tickets_lang.php' ) ) {
            
            $this->lang->load( 'default_tickets', $this->config->item('language') );
            
        }
        
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_user_lang.php' ) ) {
            
            $this->lang->load( 'default_user', $this->config->item('language') );
            
        }
        
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php' ) ) {
            
            $this->lang->load( 'default_alerts', $this->config->item('language') );
            
        }
        
        if ( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_admin_lang.php' ) ) {
            
            $this->lang->load( 'default_admin', $this->config->item('language') );
            
        }
        
    }
    
    /**
     * The function all_tickets displays the admin's tickets page
     * 
     * @param integer $ticket_id contains the ticket's id
     * 
     * @return void
     */
    public function all_tickets($ticket_id=NULL) {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        if ( $ticket_id ) {
            
            // Verify if the ticket exists and if the user is the owner of the ticket
            $ticket = $this->tickets->get_ticket( 0, $ticket_id);

            // Get last tickets
            $tickets = $this->tickets->get_all_tickets( 0, 0, 0, 10 );

            // Verify if the ticket exists
            if($ticket) {

                // Gets ticket's meta
                $metas = $this->tickets->get_metas($ticket_id);

                $this->body = 'admin/single-ticket';
                
                $this->content = array(
                    'ticket' => $ticket,
                    'id' => $ticket_id,
                    'metas' => $metas,
                    'tickets' => $tickets
                );

                $this->admin_layout();


            } else {

                show_404();

            }
            
        } else {
        
            // Get all categories
            $categories = $this->faq->get_categories();

            $this->body = 'admin/tickets';
            $this->content = array(
                'categories' => $categories
            );
            $this->admin_layout();
            
        }
        
    }

    /**
     * The function new_faq_article displays the page where admin can create new article
     * 
     * @return void
     */
    public function new_faq_article() {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Get all categories
        $categories = $this->faq->get_categories();
        
        $this->body = 'admin/new-faq-article';
        $this->content = array(
            'categories' => $categories
        );
        $this->admin_layout();
        
    }  
    
    /**
     * The function faq_articles displays the faq's article page
     * 
     * @param integer $article_id contains the article's id
     * 
     * @return void
     */
    public function faq_articles($article_id) {
        
        // Check if the session exists and if the login user is admin
        $this->check_session($this->user_role, 1);
        
        // Get all categories
        $categories = $this->faq->get_categories();
        
        // Get the faq article
        $article = $this->faq->get_faq_article($article_id);
        
        if ( !$article ) {
            
            show_404();
            
        }
        
        $this->body = 'admin/single-faq-article';
        
        $this->content = array(
            'categories' => $categories,
            'article' => $article
        );
        
        $this->admin_layout();
        
    }      
    
    /**
     * The function faq_article displays the faq's article page
     * 
     * @param integer $article_id contains the article's id
     * 
     * @return void
     */
    public function faq_article($article_id) {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->check_unconfirmed_account();
        
        // Get the faq article
        $article = $this->faq->get_faq_article($article_id);
        
        if ( !$article ) {
            
            show_404();
            
        }
        
        // Get current user's language
        $language = $this->config->item('language');
        
        $category_id = 0;
        
        if ( isset($article['categories'][0]) ) {
            
            $category_id = $article['categories'][0];
            
        }
        
        // Get all categories
        $categories = $this->faq->get_categories();
        
        // Get category's data
        $category = $this->faq->get_category_meta($category_id, $language);
        
        $parent = 0;
        
        if ( $category ) {
            
            $parent = $category[0]->parent;
            
        }
        
        $this->body = 'user/single-faq-article';
        
        $this->content = array(
            'categories' => $categories,
            'article' => $article,
            'category_id' => $category_id,
            'parent' => $parent
        );
        
        $this->user_layout();
        
    }
    
    /**
     * The public method faq_page displays the faq's page
     * 
     * @return void
     */
    public function faq_page() {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->check_unconfirmed_account();
        
        // Get all categories
        $categories = $this->faq->get_categories();
        
        // Load view/user/faq-page.php file
        $this->body = 'user/faq-page';
        $this->content = array(
            'categories' => $categories
        );
        $this->user_layout();
        
    }
    
    /**
     * The public method faq_categories displays the faq's category page
     * 
     * @return void
     */
    public function faq_categories($category_id) {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        
        // Verify if account is confirmed
        $this->check_unconfirmed_account();
        
        // Get current user's language
        $language = $this->config->item('language');
        
        // Get category's data
        $category = $this->faq->get_category_meta($category_id, $language);
        
        // Verify if category exists
        if ( !$category ) {
            
            show_404();
            
        }
        
        // Gets all articles by category
        $articles = $this->faq->get_faq_articles_by_category($category_id);

        // Get all categories
        $categories = $this->faq->get_categories();
        
        // Load view/user/faq-page.php file
        $this->body = 'user/faq-categories';
        $this->content = array(
            'categories' => $categories,
            'category_id' => $category_id,
            'parent' => $category[0]->parent,
            'articles' => $articles
        );
        $this->user_layout();
        
    }
    
    /**
     * The function ticket gets a ticket's data
     *
     * @param integer $ticket_id contains the ticket's id
     */
    public function ticket($ticket_id) {
        
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        $this->check_unconfirmed_account();
        
        // Load User Helper
        $this->load->helper('user_helper');
        
        // Verify if the ticket exists and if the user is the owner of the ticket
        $ticket = $this->tickets->get_ticket($this->user_id, $ticket_id);
        
        // Get last tickets
        $tickets = $this->tickets->get_all_tickets( 0, $this->user_id, 0, 10 );

        // Verify if the ticket exists
        if($ticket) {
            
            // Gets ticket's meta
            $metas = $this->tickets->get_metas($ticket_id);
            
            $this->body = 'user/single-ticket';
            
            $this->content = array(
                'ticket' => $ticket,
                'id' => $ticket_id,
                'metas' => $metas,
                'tickets' => $tickets
            );
            
            $this->user_layout();
            
            
        } else {
            
            show_404();
            
        }
        
    }
    
    /**
     * The function check_unconfirmed_account checks if the current user's account is confirmed
     * 
     * @return void
     */
    protected function check_unconfirmed_account() {
        
        if ($this->user_status === 0) {
            redirect('/user/unconfirmed-account');
        }
        
    }
    
}

/* End of file Tickets.php */
