<?php
/**
 * User Controller
 *
 * This file loads the Posts app in the user panel
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */

// Define the page namespace
namespace MidrubApps\Collection\Posts\Controllers;

defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use MidrubApps\Collection\Posts\Helpers as MidrubAppsCollectionPostsHelpers;

/*
 * User class loads the Posts app loader
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.7.0
 */
class User {
    
    /**
     * Class variables
     *
     * @since 0.0.7.0
     */
    protected $CI, $accounts_list, $groups_list, $total;

    /**
     * Initialise the Class
     *
     * @since 0.0.7.0
     */
    public function __construct() {
        
        // Get codeigniter object instance
        $this->CI =& get_instance();
        
        // Load language
        if ( file_exists( MIDRUB_POSTS_APP_PATH . '/language/' . $this->CI->config->item('language') . '/posts_user_lang.php' ) ) {
            $this->CI->lang->load( 'posts_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_POSTS_APP_PATH . '/' );
        }
        
    }
    
    /**
     * The public method view loads the app's template
     * 
     * @since 0.0.7.0
     * 
     * @return void
     */
    public function view() {
        
        $this->CI->user_header = user_header();
        
        // Making temlate and send data to view.
        if ( $this->CI->input->get('q') ) {
            
            switch ( $this->CI->input->get('q') ) {
                
                case 'pixabay':
                    
                    // Making temlate and send data to view.
                    $this->CI->template['header'] = $this->CI->load->view('user/layout/header', array('app_styles' => $this->assets_css(), 'title' => $this->CI->lang->line('pixabay')), true);
                    $this->CI->template['left'] = '';
                    $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_POSTS_APP_PATH .  '/views', 'pixabay', array(), true);
                    $this->CI->template['footer'] = $this->CI->load->view('user/layout/footer', array('app_scripts' => $this->assets_js()), true);
                    $this->CI->load->ext_view( MIDRUB_POSTS_APP_PATH . '/views/layout', 'index', $this->CI->template);            
                    
                    break;
                
                case 'post':
                    
                    // Get post id
                    $post_id = $this->CI->input->get('post_id');
                    
                    // Get post data by user id and post id
                    $get_post = $this->CI->posts_model->get_post($this->CI->user_id, $post_id);
                    
                    if ( $get_post ) {
                        
                        // Get image
                        $img = unserialize($get_post['img']);

                        // Get video
                        $video = unserialize($get_post['video']);

                        // Verify if image exists
                        if ( $img ) {
                            $images = get_post_media_array($this->CI->user_id, $img );
                            if ($images) {
                                $img = $images;
                            }
                        }

                        // Verify if video exists
                        if ( $video ) {
                            $videos = get_post_media_array($this->CI->user_id, $video );
                            if ($videos) {
                                $video = $videos;
                            }
                        }
                    
                        // Making temlate and send data to view.
                        $this->CI->template['header'] = $this->CI->load->view('user/layout/header', array('app_styles' => $this->assets_css(), 'title' => $this->CI->lang->line('posts')), true);
                        $this->CI->template['left'] = $this->CI->load->view('user/layout/left', array('app' => 'posts'), true);
                        $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_POSTS_APP_PATH .  '/views', 'post', array('post' => $get_post, 'images' => $img, 'videos' => $video), true);
                        $this->CI->template['footer'] = $this->CI->load->view('user/layout/footer', array('app_scripts' => $this->assets_js()), true);
                        $this->CI->load->ext_view( MIDRUB_POSTS_APP_PATH . '/views/layout', 'index', $this->CI->template);
                        
                    } else {
                        
                        show_404();
                        
                    }
                    
                    break;
                    
                case 'rss':
                    
                    // Load language
                    if ( file_exists( MIDRUB_POSTS_APP_PATH . '/language/' . $this->CI->config->item('language') . '/rss_user_lang.php' ) ) {
                        $this->CI->lang->load( 'rss_user', $this->CI->config->item('language'), FALSE, TRUE, MIDRUB_POSTS_APP_PATH . '/' );
                    }
                    
                    // Load RSS Helper
                    $this->CI->load->helper('fifth_helper');
                    
                    // Get rss id
                    $rss_id = $this->CI->input->get('rss_id');
                    
                    // Get rss_data by rss_id
                    $rss_data = $this->CI->rss_model->get_rss($rss_id, $this->CI->user_id);

                    if ( $rss_data ) {
                        
                        // Try to get RSS content
                        $get_content = parse_rss_feed($rss_data[0]->rss_url);
                        
                        // Get selected accounts
                        $selected_accounts = plan_feature('publish_accounts');
                        
                        // Get publish limit
                        $published_limit = plan_feature('publish_posts');
                        
                        $body = array(
                            'rss_content' => $get_content,
                            'selected_accounts' => $selected_accounts,
                            'refferal' => trim($rss_data[0]->refferal),
                            'period' => trim($rss_data[0]->period),
                            'include' => trim($rss_data[0]->include),
                            'exclude' => trim($rss_data[0]->exclude),
                            'enabled' => $rss_data[0]->enabled,
                            'publish_description' => $rss_data[0]->publish_description,
                            'publish_url' => $rss_data[0]->publish_url,
                            'rss_id' => $rss_data[0]->rss_id,
                            'published' => 0,
                            'limit' => $published_limit,
                            'publish_way' => $rss_data[0]->pub,
                            'type' => $rss_data[0]->type
                        );

                        // Verify if user wants groups instead accounts
                        if ( get_user_option('settings_display_groups') ) {

                            // Load Lists Model
                            $this->CI->load->model('lists');
                            
                            // Get the user lists
                            $groups_list = $this->CI->lists->get_lists( $this->CI->user_id, 0, 'social', 10 );

                            // Get total number of accounts
                            $body['total'] = $this->CI->lists->get_lists( $this->CI->user_id, 0, 'social');
                            
                            $body['groups_list'] = $groups_list;

                        } else {
                            
                            // Get accounts list
                            $accounts_list = (new MidrubAppsCollectionPostsHelpers\Accounts)->list_accounts_for_composer($this->CI->networks_model->get_accounts( $this->CI->user_id, 0, 10 ));

                            // Get total number of accounts
                            $body['total'] = $this->CI->networks_model->get_accounts( $this->CI->user_id, 0, 0);
                            
                            $body['accounts_list'] = $accounts_list;

                        }
                        
                        $body['title'] = $get_content['rss_title'];
                    
                        // Making temlate and send data to view.
                        $this->CI->template['header'] = $this->CI->load->view('user/layout/header', array(
                            'app_styles' => $this->assets_css(),
                            'title' => $get_content['rss_title']
                        ), true);
                        $this->CI->template['left'] = $this->CI->load->view('user/layout/left', array('app' => 'posts'), true);
                        $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_POSTS_APP_PATH .  '/views', 'rss', $body, true);
                        $this->CI->template['footer'] = $this->CI->load->view('user/layout/footer', array('app_scripts' => $this->assets_js()), true);
                        $this->CI->load->ext_view( MIDRUB_POSTS_APP_PATH . '/views/layout', 'index', $this->CI->template);
                        
                    } else {
                        
                        show_404();
                        
                    }
                    
                    break;
                
                default:
                    
                    show_404();
                    
                    break;
                    
            }
            
        } else {
            
            // Define the accounts list valiable
            $accounts_list = '';
            
            // Define the groups list variable
            $groups_list = '';
           
            // Define the rss feeds variable
            $rss_feeds = '';
            
            // Define the total rss feeds variable
            $rss_feeds_total = 0;
            
            // Define the total accounts variable
            $total = 0;
            
            // Verify if user wants groups instead accounts
            if ( get_user_option('settings_display_groups') ) {

                // Load Lists Model
                $this->CI->load->model('lists');
                
                // Get the user lists
                $groups_list = $this->CI->lists->get_lists( $this->CI->user_id, 0, 'social', 10 );
                
                // Get total number of accounts
                $total = $this->CI->lists->get_lists( $this->CI->user_id, 0, 'social');
                
                // Set groups list value
                $this->groups_list = $groups_list;
                
            } else {
                
                // Get accounts list
                $accounts_list = (new MidrubAppsCollectionPostsHelpers\Accounts)->list_accounts_for_composer($this->CI->networks_model->get_accounts( $this->CI->user_id, 0, 10 ));
                
                // Get total number of accounts
                $total = $this->CI->networks_model->get_accounts( $this->CI->user_id, 0, 0);

                // Set accounts list value
                $this->accounts_list = $accounts_list;                
                
            }
            
            $this->total = $total;
            
            // Set body's data
            $body = array(
                'accounts_list' => $accounts_list,
                'groups_list' => $groups_list,
                'total' => $total
            );
        
            // Making temlate and send data to view.
            $this->CI->template['header'] = $this->CI->load->view('user/layout/header', array(
                'app_styles' => $this->assets_css(),
                'title' => $this->CI->lang->line('posts')
            ), true);
            $this->CI->template['left'] = $this->CI->load->view('user/layout/left', array('app' => 'posts'), true);
            $this->CI->template['body'] = $this->CI->load->ext_view( MIDRUB_POSTS_APP_PATH .  '/views', 'main', $body, true);
            $this->CI->template['footer'] = $this->CI->load->view('user/layout/footer', array('app_scripts' => $this->assets_js()), true);
            $this->CI->load->ext_view( MIDRUB_POSTS_APP_PATH . '/views/layout', 'index', $this->CI->template);
            
        }
        
    }
    
    /**
     * The private method assets_css contains the app's css links
     * 
     * @since 0.0.7.0
     * 
     * @return string with css links
     */
    public function assets_css() {
        
        if ( $this->CI->input->get('q') ) {
            
            switch ( $this->CI->input->get('q') ) {
                
                case 'pixabay':
                    
                    $data = '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/apps/posts/styles/css/pixabay.css?ver=' . MD_VER . '" media="all"/> ';
                    $data .= "\n";

                    return $data;
                
                case 'post':
                    
                    $data = '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/apps/posts/js/emojionearea-master/dist/emojionearea.min.css?ver=' . MD_VER . '" media="all"/> ';
                    $data .= "\n";
                    $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/apps/posts/styles/css/posts.css?ver=' . MD_VER . '" media="all"/> ';
                    $data .= "\n";

                    return $data;
                    
                case 'rss':
                    
                    $data = '<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css?ver=' . MD_VER . '" media="all"/> ';
                    $data .= "\n";
                    $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/apps/posts/styles/css/rss.css?ver=' . MD_VER . '" media="all"/> ';
                    $data .= "\n";

                    return $data;                    
                    
            }
            
        } else {
        
            $data = '<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/apps/posts/js/emojionearea-master/dist/emojionearea.min.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";
            $data .= '<link rel="stylesheet" type="text/css" href="' . base_url() . 'assets/apps/posts/styles/css/posts.css?ver=' . MD_VER . '" media="all"/> ';
            $data .= "\n";

            return $data;
        
        }
        
    }
    
    /**
     * The private method assets_js contains the app's javascript links
     * 
     * @since 0.0.7.0
     * 
     * @return string with javascript links
     */
    public function assets_js() {
        
        if ( $this->CI->input->get('q') ) {
            
            switch ( $this->CI->input->get('q') ) {
                
                case 'pixabay':
                    
                    $data = '<script src="' . base_url() . 'assets/apps/posts/js/pixabay.js?ver=' . MD_VER . '"></script>';
                    $data .= "\n";

                    return $data;
                    
                case 'post':
                    
                    $data = '<script src="' . base_url() . 'assets/apps/posts/js/emojionearea-master/dist/emojionearea.min.js?ver=' . MD_VER . '"></script>';
                    $data .= "\n";

                    return $data;
                    
                case 'rss':
                    
                    $data = '<script src="' . base_url() . 'assets/apps/posts/js/rss.js?ver=' . MD_VER . '"></script>';
                    $data .= "\n";

                    return $data;                    
                    
            }
            
        } else {
        
            $scheduler_time = '<select class="midrub-calendar-time-hour">';
            $scheduler_time .= "\n";
                $scheduler_time .= '<option value="01">01</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="02">02</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="03">03</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="04">04</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="05">05</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="06">06</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="07">07</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="08" selected>08</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="09">09</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="10">10</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="11">11</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="12">12</option>';
                $scheduler_time .= "\n";
            if ( get_user_option('24_hour_format') ) {
                $scheduler_time .= '<option value="13">13</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="14">14</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="15">15</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="16">16</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="17">17</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="18">18</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="19">19</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="20">20</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="21">21</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="22">22</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="23">23</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="00">00</option>';
                $scheduler_time .= "\n";
            }
            $scheduler_time .= '</select>';
            $scheduler_time .= "\n";
            $scheduler_time .= '<select class = "midrub-calendar-time-minutes">';
            $scheduler_time .= "\n";
                $scheduler_time .= '<option value="00">00</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="10">10</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="20">20</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="30">30</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="40">40</option>';
                $scheduler_time .= "\n";
                $scheduler_time .= '<option value="50">50</option>';
                $scheduler_time .= "\n";
            $scheduler_time .= '</select>';
            $scheduler_time .= "\n";

            if ( !get_user_option('24_hour_format') ) {
                $scheduler_time .= '<select class = "midrub-calendar-time-period">';
                $scheduler_time .= "\n";
                    $scheduler_time .= '<option value="AM">AM</option>';
                    $scheduler_time .= "\n";
                    $scheduler_time .= '<option value="PM">PM</option>';
                    $scheduler_time .= "\n";
                $scheduler_time .= '</select>';
                $scheduler_time .= "\n";
            }


            $data = '<script src="' . base_url() . 'assets/apps/posts/js/emojionearea-master/dist/emojionearea.min.js?ver=' . MD_VER . '"></script>';
            $data .= "\n";
            $data .= '<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>';     
            $data .= "\n";
            $data .= '<script src="//www.chartjs.org/dist/2.7.2/Chart.js"></script>';
            $data .= "\n";
            $data .= '<script src="//www.chartjs.org/samples/latest/utils.js"></script>';        
            $data .= "\n";        
            $data .= '<script src="' . base_url() . 'assets/apps/posts/js/posts.js?ver=' . MD_VER . '"></script>';
            $data .= "\n";
            $data .= '<script src="' . base_url() . 'assets/user/js/media.js?ver=' . MD_VER . '"></script>';
            $data .= "\n";
            if ( get_option('app_posts_enable_dropbox') ) {
                $data .= '<script type="text/javascript" src="//www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="' . get_option('app_posts_dropbox_app_key') . '"></script>';
                $data .= "\n";
            }
            $data .= '<!-- Modal -->';
            $data .= "\n";
            $data .= '<div class="modal fade" id="saved-posts" tabindex="-1" role="dialog" aria-labelledby="saved-posts" aria-hidden="true">';
            $data .= "\n";
                $data .= '<div class="modal-dialog modal-lg modal-dialog-centered history-saved-posts" role="document">';
                $data .= "\n";
                    $data .= '<div class="modal-content">';
                    $data .= "\n";
                        $data .= '<div class="modal-header">';
                        $data .= "\n";
                            $data .= '<h5 class="modal-title">' . $this->CI->lang->line('posts') . '</h5>';
                            $data .= "\n";
                            $data .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            $data .= "\n";
                                $data .= '<span aria-hidden="true">&times;</span>';
                                $data .= "\n";
                            $data .= '</button>';
                            $data .= "\n";
                        $data .= '</div>';
                        $data .= "\n";
                        $data .= '<div class="modal-body">';
                        $data .= "\n";
                            $data .= '<div class="input-group mb-3">';
                            $data .= "\n";
                                $data .= '<div class="input-group-append">';
                                $data .= "\n";
                                    $data .= '<span class="input-group-text" id="basic-addon2">';
                                    $data .= "\n";
                                        $data .= '<i class="icon-magnifier"></i>';
                                        $data .= "\n";
                                    $data .= '</span>';
                                    $data .= "\n";
                                $data .= '</div>';
                                $data .= "\n";
                                $data .= '<input type="text" class="form-control composer-search-for-saved-posts" placeholder="' . $this->CI->lang->line('search_for_posts') . '" aria-label="' . $this->CI->lang->line('search_for_posts') . '" aria-describedby="basic-addon2">';
                                $data .= "\n";
                                $data .= '<div class="input-group-append">';
                                $data .= "\n";
                                    $data .= '<button type="button" class="composer-cancel-search-for-posts">';
                                    $data .= "\n";
                                        $data .= '<i class="icon-close"></i>';
                                        $data .= "\n";
                                    $data .= '</button>';
                                    $data .= "\n";
                                $data .= '</div>';
                                $data .= "\n";                            
                            $data .= '</div>';
                            $data .= "\n";
                            $data .= '<ul class="list-group all-saved-posts">';
                            $data .= "\n";
                            $data .= '</ul>';
                            $data .= "\n";
                        $data .= '</div>';
                        $data .= "\n";
                        $data .= '<div class="modal-footer">';
                        $data .= "\n";
                            $data .= '<nav aria-label="Page navigation example">';
                            $data .= "\n";
                                $data .= '<ul class="pagination" data-type="saved-posts">';
                                $data .= "\n";
                                $data .= '</ul>';
                                $data .= "\n";
                            $data .= '</nav>';
                            $data .= "\n";
                        $data .= '</div>';
                        $data .= "\n";
                    $data .= '</div>';
                    $data .= "\n";
                $data .= '</div>';
                $data .= "\n";
            $data .= '</div>';
            $data .= "\n";

            if ( get_option('app_posts_enable_scheduled') ) {

                $data .= '<!-- Modal -->';
                $data .= "\n";
                $data .= '<div class="modal fade" id="planner-posts-scheduled-modal" tabindex="-1" role="dialog" aria-labelledby="planner-posts-scheduled-modal" aria-hidden="true">';
                $data .= "\n";
                    $data .= '<div class="modal-dialog file-upload-box modal-xl modal-dialog-centered" role="document">';
                    $data .= "\n";
                        $data .= '<div class="modal-content">';
                        $data .= "\n";
                            $data .= '<div class="modal-header">';
                            $data .= "\n";
                                $data .= '<h5 class="modal-title">' . $this->CI->lang->line('post_preview') . '</h5>';
                                $data .= "\n";
                                $data .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                $data .= "\n";
                                    $data .= '<span aria-hidden="true">&times;</span>';
                                    $data .= "\n";
                                $data .= '</button>';
                                $data .= "\n";
                            $data .= '</div>';
                            $data .= "\n";
                            $data .= '<div class="modal-body">';
                                $data .= "\n";
                                $data .= '<div class="row">';
                                $data .= "\n";
                                    $data .= '<div class="col-lg-6 scheduler-preview-post-content"></div>';
                                    $data .= "\n";
                                    $data .= '<div class="col-lg-6 scheduler-preview-profiles-list"></div>';
                                    $data .= "\n";
                                $data .= '</div>';
                                $data .= "\n";
                            $data .= '</div>';
                            $data .= "\n";
                        $data .= '</div>';
                        $data .= "\n";
                    $data .= '</div>';
                    $data .= "\n";
                $data .= '</div>';
                $data .= "\n";

                $count = '';

                if ( get_user_option('settings_character_count') ) {
                    $count = '<div class="numchar">0</div>';
                }

                $data .= '<!-- Modal -->';
                $data .= "\n";
                $data .= '<div class="modal fade" id="planner-quick-schedule-modal" tabindex="-1" role="dialog" aria-labelledby="planner-quick-schedule-modal" aria-hidden="true">';
                $data .= "\n";
                    $data .= '<div class="modal-dialog file-upload-box modal-xl modal-dialog-centered" role="document">';
                    $data .= "\n";
                        $data .= '<div class="modal-content">';
                        $data .= "\n";
                            $data .= '<div class="modal-header">';
                            $data .= "\n";
                                $data .= '<h5 class="modal-title">' . $this->CI->lang->line('quick_schedule') . '</h5>';
                                $data .= "\n";
                                $data .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                                $data .= "\n";
                                    $data .= '<span aria-hidden="true">&times;</span>';
                                    $data .= "\n";
                                $data .= '</button>';
                                $data .= "\n";
                            $data .= '</div>';
                            $data .= "\n";
                            $data .= '<div class="modal-body">';
                                $data .= "\n";
                                $data .= form_open('user/app/posts', ['class' => 'schedule-post', 'data-csrf' => $this->CI->security->get_csrf_token_name()]);
                                $data .= "\n";
                                    $data .= '<div class="row">';
                                    $data .= "\n";
                                        $data .= '<div class="col-xl-6 col-lg-6">';
                                        $data .= "\n";
                                            $data .= '<div class="col-xl-12 post-destionation">';
                                            $data .= "\n";
                                                $data .= '<div class="row">';
                                                $data .= "\n";
                                                    $data .= '<div class="col-xl-12 input-group quick-scheduler-accounts-search">';
                                                    $data .= "\n";
                                                        $data .= '<div class="input-group-prepend">';
                                                        $data .= "\n";
                                                            $data .= '<i class="icon-magnifier"></i>';
                                                            $data .= "\n";
                                                        $data .= '</div>';
                                                        $data .= "\n";
                                                        
                                                        if ( get_user_option('settings_display_groups') ) {
                                                            
                                                            $data .= '<input type="text" class="form-control quick-scheduler-search-for-groups" placeholder="' . $this->CI->lang->line('search_for_groups') . '">';
                                                            
                                                        } else {
                                                            
                                                            $data .= '<input type="text" class="form-control quick-scheduler-search-for-accounts" placeholder="' . $this->CI->lang->line('search_for_accounts') . '">';
                                                            
                                                        }
                                                        
                                                        $data .= "\n";
                                                        $data .= '<button type="button" class="quick-scheduler-cancel-search-for-accounts">';
                                                        $data .= "\n";
                                                            $data .= '<i class="icon-close"></i>';
                                                            $data .= "\n";
                                                        $data .= '</button>';
                                                        $data .= "\n";
                                                        
                                                        
                                                        
                                                        if ( $this->total < 11 ) {
                                                            $bactive = ' btn-disabled'; 
                                                        } else {
                                                            $bactive = '" data-page="2'; 
                                                        }

                                                        if ( get_user_option('settings_social_pagination') ) {
                                                            $data .= '<button type="button" class="back-button btn-disabled">';
                                                            $data .= "\n";
                                                                $data .= '<span class="fc-icon fc-icon-left-single-arrow"></span>';
                                                                $data .= "\n";
                                                            $data .= '</button>';
                                                            $data .= "\n";
                                                            $data .= '<button type="button" class="next-button' . $bactive . '">';
                                                            $data .= "\n";
                                                                $data .= '<span class="fc-icon fc-icon-right-single-arrow"></span>';
                                                                $data .= "\n";
                                                            $data .= '</button>';
                                                            $data .= "\n";
                                                        }
                                                        
                                                    $data .= '</div>';
                                                    $data .= "\n";
                                                $data .= '</div>';
                                                $data .= "\n";
                                                $data .= '<div class="row">';
                                                $data .= "\n";
                                                
                                                    if ( get_user_option('settings_display_groups') ) {
                                                        
                                                        $data .= '<div class="col-xl-12 quick-scheduler-groups-list">';
                                                        $data .= "\n";
                                                            $data .= '<ul>' . (new MidrubAppsCollectionPostsHelpers\Accounts)->get_groups_list( $this->groups_list ) . '</ul>';
                                                            $data .= "\n";
                                                        $data .= '</div>';
                                                        $data .= "\n";                                                          

                                                    } else {
                                                        
                                                        $data .= '<div class="col-xl-12 quick-scheduler-accounts-list">';
                                                        $data .= "\n";
                                                            $data .= '<ul>' . (new MidrubAppsCollectionPostsHelpers\Accounts)->get_accounts_list( $this->accounts_list ) . '</ul>';
                                                            $data .= "\n";
                                                        $data .= '</div>';
                                                        $data .= "\n";                                                        
                                                        
                                                    }
                                                    
                                                $data .= '</div>';
                                                $data .= "\n";
                                            $data .= '</div>';
                                            $data .= "\n";
                                        $data .= '</div>';
                                        $data .= "\n";
                                        $data .= '<div class="col-xl-6 col-lg-6">';
                                        $data .= "\n";
                                            $data .= '<input type="text" class="quick-scheduler-title" placeholder="' . $this->CI->lang->line('enter_post_title') . '">';
                                            $data .= "\n";
                                            $data .= '<textarea class="quick-new-post" placeholder="' . $this->CI->lang->line('share_what_new') . '"></textarea>';
                                            $data .= "\n";
                                            $data .= '<div class="post-scheduler-buttons">';
                                            $data .= "\n";
                                                $data .= '<div class="col-xl-12">';
                                                $data .= "\n";
                                                    $data .= '<button type="button" class="btn show-title">';
                                                    $data .= "\n";
                                                        $data .= '<i class="fas fa-text-width"></i>';
                                                        $data .= "\n";
                                                    $data .= '</button>';
                                                    $data .= "\n";
                                                    $data .= $count;
                                                    $data .= "\n";
                                                $data .= '</div>';
                                                $data .= "\n";
                                            $data .= '</div>';
                                            $data .= "\n";
                                            $data .= '<div class="multimedia-gallery-quick-schedule">';
                                            $data .= "\n";
                                                $data .= '<ul></ul>';
                                                $data .= "\n";
                                                $data .= '<a href="#" class="multimedia-gallery-quick-schedule-load-more-medias" data-page="1">' . $this->CI->lang->line('load_more') . '</a>';
                                                $data .= "\n";
                                                $data .= '<p class="no-medias-found" style="display: none;">' . $this->CI->lang->line('no_photos_videos_uploaded') . '</p>';
                                                $data .= "\n";
                                            $data .= '</div>';
                                            $data .= "\n";
                                            $data .= '<div class="quick-scheduler-selected-accounts">';
                                            $data .= "\n";
                                                $data .= "<ul>";
                                                $data .= "\n";
                                                $data .= "</ul>";
                                                $data .= "\n";                                    
                                            $data .= "\n";
                                            $data .= '</div>';
                                            $data .= "\n";
                                            $data .= '<div class="scheduler-status-actions">';
                                            $data .= "\n";
                                                $data .= '<div class="row">';
                                                $data .= "\n";
                                                    $data .= '<div class="col-xl-8">';
                                                    $data .= "\n";
                                                    $data .= '<input type="text" class="scheduler-quick-date">';
                                                    $data .= "\n";
                                                        $data .= $scheduler_time;
                                                    $data .= '</div>';
                                                    $data .= "\n";
                                                    $data .= '<div class="col-xl-4">';
                                                    $data .= "\n";
                                                        $data .= '<button type="submit" class="btn btn-schedule-post"><i class="icon-share-alt"></i> ' . $this->CI->lang->line('schedule') . '</button>';
                                                        $data .= "\n";
                                                    $data .= '</div>';
                                                    $data .= "\n";
                                                $data .= '</div>';
                                                $data .= "\n";
                                            $data .= '</div>';
                                            $data .= "\n";
                                        $data .= '</div>';
                                        $data .= "\n";
                                    $data .= '</div>';
                                    $data .= "\n";
                                $data .= form_close();
                                $data .= "\n";                            
                            $data .= '</div>';
                            $data .= "\n";
                        $data .= '</div>';
                        $data .= "\n";
                    $data .= '</div>';
                    $data .= "\n";
                $data .= '</div>';
                $data .= "\n";

            }

            $data .= '<div class="midrub-planner">';
            $data .= "\n";
                $data .= '<div class="row">';
                $data .= "\n";
                    $data .= '<div class="col-xl-12">';
                    $data .= "\n";
                        $data .= '<table class="midrub-calendar iso">';
                        $data .= "\n";
                            $data .= '<thead>';
                            $data .= "\n";
                                $data .= '<tr>';
                                $data .= "\n";
                                    $data .= '<th class="text-center"><a href="#" class="go-back"><i class="icon-arrow-left"></i></a></th>';
                                    $data .= "\n";
                                    $data .= '<th colspan="5" class="text-center year-month"></th>';
                                    $data .= "\n";
                                    $data .= '<th class="text-center"><a href="#" class="go-next"><i class="icon-arrow-right"></i></a></th>';
                                    $data .= "\n";
                                $data .= '</tr>';
                                $data .= "\n";
                            $data .= '</thead>';
                            $data .= "\n";
                            $data .= '<tbody class="calendar-dates">';
                            $data .= "\n";

                            $data .= '</tbody>';
                            $data .= "\n";
                        $data .= '</table>';
                        $data .= "\n";
                    $data .= '</div>';
                    $data .= "\n";
                $data .= '</div>';
                $data .= "\n";
                $data .= '<div class="row">';
                $data .= "\n";
                    $data .= '<div class="col-xl-12 text-center">';
                    $data .= "\n";
                        $data .= $scheduler_time;
                    $data .= '</div>';
                    $data .= "\n";
                $data .= '</div>';
                $data .= "\n";
                $data .= '<div class="row">';
                $data .= "\n";
                    $data .= '<div class="col-xl-12 text-center">';
                    $data .= "\n";
                        $data .= '<button type="btn" class="btn composer-schedule-post">' . $this->CI->lang->line('schedule') . '</button>';
                        $data .= "\n";
                    $data .= '</div>';
                    $data .= "\n";
                $data .= '</div>';
                $data .= "\n";
            $data .= '</div>';
            $data .= "\n";

            $data .= '<!-- Modal -->';
            $data .= "\n";
            $data .= '<div class="modal fade" id="insights-reply-comments" tabindex="-1" role="dialog" aria-labelledby="insights-reply-comments" aria-hidden="true">';
            $data .= "\n";
                $data .= '<div class="modal-dialog modal-dialog-centered" role="document">';
                $data .= "\n";
                    $data .= '<div class="modal-content">';
                    $data .= "\n";
                        $data .= '<div class="modal-header">';
                        $data .= "\n";
                            $data .= '<h5 class="modal-title">' . $this->CI->lang->line('reply') . '</h5>';
                            $data .= "\n";
                            $data .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                            $data .= "\n";
                                $data .= '<span aria-hidden="true">&times;</span>';
                                $data .= "\n";
                            $data .= '</button>';
                            $data .= "\n";
                        $data .= '</div>';
                        $data .= "\n";
                        $data .= '<div class="modal-body">';
                            $data .= "\n";
                            $data .= '<div class="row">';
                            $data .= "\n";
                                $data .= '<div class="col-xl-12">';
                                $data .= "\n";
                                    $data .= '<form method="post" class="insights-posts-reactions-post-reply">';
                                        $data .= "\n";
                                        $data .= '<div class="input-group">';
                                        $data .= "\n";
                                            $data .= '<textarea class="form-control input-sm reactions-msg" placeholder="' . $this->CI->lang->line('enter_reply') . '"></textarea>';
                                            $data .= "\n";
                                            $data .= '<span class="input-group-btn">';
                                            $data .= "\n";
                                                $data .= '<button class="btn btn-warning btn-sm" type="submit" id="btn-chat">';
                                                $data .= "\n";
                                                    $data .= '<i class="icon-cursor"></i>';
                                                    $data .= "\n";
                                                $data .= '</button>';
                                                $data .= "\n";
                                            $data .= '</span>';
                                            $data .= "\n";
                                        $data .= '</div>';
                                        $data .= "\n";
                                    $data .= '</form>';
                                    $data .= "\n";
                                $data .= '</div>';
                                $data .= "\n";
                            $data .= '</div>';
                            $data .= "\n";
                        $data .= '</div>';
                        $data .= "\n";
                    $data .= '</div>';
                    $data .= "\n";
                $data .= '</div>';
                $data .= "\n";
            $data .= '</div>';
            $data .= "\n"; 

            return $data;
            
        }
        
    }

}
