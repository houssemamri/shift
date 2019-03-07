<?php
/**
 * Marketing Controller
 *
 * PHP Version 5.6
 *
 * Marketing contains the Marketing class for Email Marketing
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
 * Marketing class - contains all metods and pages for Email Marketing
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Marketing extends MY_Controller {
    
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
        
        // Load Campaigns Model
        $this->load->model('campaigns');
        
        // Load Lists Model
        $this->load->model('lists');
        
        // Load Scheduled Model
        $this->load->model('scheduled');
        
        // Load session library
        $this->load->library('session');
        
        // Load URL Helper
        $this->load->helper('url');
        
        // Load Main Helper
        $this->load->helper('main_helper');
        
        // Load RSS Helper
        $this->load->helper('fifth_helper');
        
        // Load Alerts Helper
        $this->load->helper('alerts_helper');
        
        // Load User Helper
        $this->load->helper('user_helper');
        
        // Load Smtp Helper
        $this->load->helper('smtp_helper');
        
        // Load Gshorter library
        $this->load->library('gshorter');
        
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
        
        if( file_exists( APPPATH . 'language/' . $this->config->item('language') . '/default_alerts_lang.php' ) ) {
            
            $this->lang->load( 'default_alerts', $this->config->item('language') );
            
        }
        
    }

    /**
     * The function emails displays the emails page
     */
    public function emails($args=NULL,$var=NULL) {
        // Check if the current user is admin and if session exists
        $this->check_session($this->user_role, 0);
        $this->check_unconfirmed_account();
        if (file_exists(APPPATH . 'smtp/Smtp.php')) {
            include_once APPPATH . 'smtp/Smtp.php';
            $smtp = new Smtp();
            $content = $smtp->connect($args,$var);
        } else{
            $content = strip_tags(display_mess(103));
        }
        if(get_option('email_marketing') && (plan_feature('sent_emails') > 0)){
            $this->body = 'user/emails';
            $this->content = ['res' => $content];
            $this->user_layout();
        } else {
            show_404();
        }
    }
    
    /**
     * The function show_campaigns gets campaigns from the database
     *
     * @param $page contains the page number
     * @param $type contains the campaign type
     */
    public function show_campaigns($page,$type) {
        // Check if the current user is admin and if session exists
        $this->check_session();
        if ($this->user_role == 1) {
            return false;
        }
        $limit = 10;
        $page--;
        $total = $this->campaigns->get_campaigns($this->user_id, 1, $type);
        $getres = $this->campaigns->get_campaigns($this->user_id, $page * $limit, $type, $limit);
        if ($getres) {
            $data = ['total' => $total, 'date' => time(), 'campaigns' => $getres];
            echo json_encode($data);
        }
    } 
    
    
    /**
     * The function show_lists gets lists from the database
     *
     * @param $page contains the page number
     * @param $type contains the campaign type
     */
    public function show_lists($page,$type) {
        // Check if the current user is admin and if session exists
        $this->check_session();
        if ($this->user_role == 1) {
            return false;
        }
        $limit = 10;
        $page--;
        $total = $this->lists->get_lists($this->user_id, 1, $type);
        $getres = $this->lists->get_lists($this->user_id, $page * $limit, $type, $limit);
        if ($getres) {
            $data = ['total' => $total, 'date' => time(), 'lists' => $getres];
            echo json_encode($data);
        }
    }
    
    /**
     * The function show_lists_meta gets list's meta from the database
     *
     * @param $page contains the page number
     * @param $list contains the List's ID
     * @param $un contains an number(if 1 will be displayed unactive emails)
     */
    public function show_lists_meta($page,$list,$un=NULL) {
        // Check if the current user is admin and if session exists
        $this->check_session();
        if ($this->user_role == 1) {
            return false;
        }
        $limit = 10;
        $page--;
        if(!$un)
        {
            $un = 2;
        }
        $total = $this->lists->get_lists_meta($this->user_id, 1, $list, $un);
        $getres = $this->lists->get_lists_meta($this->user_id, $page * $limit, $list, $un, $limit);
        if ($getres) {
            $data = ['total' => $total, 'date' => time(), 'emails' => $getres];
            echo json_encode($data);
        }
    }
    
    /**
     * The function schedules get schedules meta
     *
     * @param $type contains the meta type
     * @param $sched_id contains the scheduled ID
     * @param $page contains the page number
     * @param $export if is not null, the emails addresses will be exported
     */
    public function schedules($type,$sched_id,$page,$export=NULL) {
        // Check if the current user is admin and if session exists
        $this->check_session();
        if ($this->user_role == 1) {
            return false;
        }
        $limit = 10;
        $page--;
        $total = $this->scheduled->get_scheduled_stats($this->user_id, $type, $sched_id);
        $getres = $this->scheduled->get_scheduled_stats($this->user_id, $type, $sched_id, $page * $limit, $limit);
        if($export){
            if($total)
            {
                header('Content-type: text/csv');
                header('Content-disposition: attachment;filename='.$type.'-emails.csv');
                header('Cache-Control: max-age=1');
                header ('Expires: '.gmdate('D, d M Y H:i:s',time()-120).' GMT');
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
                header ('Cache-Control: cache, must-revalidate');
                header ('Pragma: public');
                $v = '';
                foreach ($total as $fields) {
                    $v .= $fields->body.PHP_EOL;
                }
                file_put_contents('php://output', $v, FILE_APPEND);
                echo file_get_contents('php://output');                
            }
            exit();
        }
        if ($getres) {
            $data = ['total' => count($total), 'date' => time(), 'emails' => $getres];
            echo json_encode($data);
        }
    }   
    
    /**
     * The function send_mail sends scheduled templates
     */
    public function send_mail() {
        $scheduled = $this->scheduled->get_templates_to_send();
        if($scheduled){
            $list = get_list_by_id($scheduled[0]->list_id,$scheduled);
            $template = get_template_by_id($scheduled[0]->template_id);
            if($this->scheduled->update_send($scheduled[0]->scheduled_id)) {
                send_smtp($template,$list,$scheduled);
            }
        }
    }
    
    /**
     * The function mail marks as seen am email
     * 
     * @param $scheduled_id contains the scheduled_id
     * @param $meta_id contains the meta_id
     */
    public function mail($scheduled_id,$meta_id) {
        echo get(site_url('assets/img/view.png'));
        $body = $this->lists->get_lists_body($meta_id);
        if($body) {
            $this->scheduled->update_view($scheduled_id,$body);
        }
    }    
    
    /**
     * The function unsubscribe unsubscribes an email address from a campaign
     *
     * @param $campaign_id contains the Campaign's ID
     * @param $email_id contains the Email's ID
     * @param $scheduled_id contain's the scheduled's ID
     */
    public function unsubscribe($campaign_id,$email_id,$scheduled_id) {
        $body = $this->lists->get_lists_body($email_id);
        if($body) {
            if($this->scheduled->unsubscribe($campaign_id,$scheduled_id,$body)) {
                echo $this->lang->line('mu282');
            } else {
                echo $this->lang->line('mu283');
            }
        }
    }
    
    /**
     * The function check_unconfirmed_account checks if the current user's account is confirmed
     */
    protected function check_unconfirmed_account() {
        if ($this->user_status == 0) {
            redirect('/user/unconfirmed-account');
        }
    }
}

/* End of file Marketing.php */
