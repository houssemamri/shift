<?php
/**
 * Instagram
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Instagram
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

// Limits the maximum execution time to unlimited
set_time_limit(0);

// Sets the default timezone used by all date/time functions
date_default_timezone_set('UTC');

/**
 * Instagram class - allows users to connect to their Instagram Account and publish posts.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Instagram implements Autopost {

    /**
     * Class variables
     */
    protected $CI, $instagram;

    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
        // Require the vendor autoload
        include_once FCPATH . 'vendor/autoload.php';
        
    }

    /**
     * The public method check_availability doesn't check if Instagram api was configured correctly.
     *
     * @return will be true
     */
    public function check_availability() {
        
        return true;
        
    }

    /**
     * The public method connect will show a form where the user can add the Instagram's username and password.
     * 
     * @return void
     */
    public function connect() {
        
        if ( $this->CI->input->post() ) {

            $this->CI->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->CI->form_validation->set_rules('password', 'Password', 'trim|required');
            $this->CI->form_validation->set_rules('proxy', 'Proxy', 'trim');

            // Get data
            $username = $this->CI->input->post('username');
            $password = $this->CI->input->post('password');
            $proxy = $this->CI->input->post('proxy');

            if ( $this->CI->form_validation->run() == false ) {

                // Display the error message
                echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm3') . '</p>', false);   

            } else {

                if ( file_exists(APPPATH . 'autopost/Instagram.php') ) {

                    require_once APPPATH . 'autopost/Instagram.php';

                    $get = new Instagram();

                    $check = new \InstagramAPI\Instagram(false, false);
                    
                    if ( $proxy ) {
                        
                        $check->setProxy($proxy);
                        
                    } else {
                        
                        $user_proxy = $this->CI->user->get_user_option($this->CI->user_id,'proxy');

                        if ( $user_proxy ) {

                            $check->setProxy($user_proxy);

                        } else {

                            $proxies = @trim(get_option('instagram_proxy'));

                            if ( $proxies ) {

                                $proxies = explode('<br>', nl2br($proxies, false));

                                $rand = rand(0, count($proxies));

                                if ( @$proxies[$rand] ) {

                                    $check->setProxy($proxies[$rand]);

                                }

                            }   

                        }
                        
                    }

                    try {

                        $check->login($username,$password);
                        
                        // Verify if account was already saved
                        if ( !$this->CI->networks->get_network_data('instagram', $this->CI->user_id, $username) ) {
                            
                            $this->CI->networks->add_network('instagram', $username, $password, $this->CI->user_id, '', $username, '', $proxy);

                            // Display the success message
                            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . strip_tags(display_mess(80)) . '</p>', true);

                        } else {

                            // Display the error message
                            echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . strip_tags(display_mess(79, 'twitter')) . '</p>', false);                             

                        }

                    } catch (Exception $e) {

                        $check = $e->getMessage();

                        if ( preg_match('/required/i', $check) ) {

                            // Display the error message
                            echo $this->CI->ecl('Social_login_connect')->view( $this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm140') . '</p>', false);

                        } else if ( preg_match('/password/i', $check) ) {

                            // Display the error message
                            echo $this->CI->ecl('Social_login_connect')->view( $this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm18') . '</p>', false);

                        } else {
                            
                            // Display the error message
                            echo $this->CI->ecl('Social_login_connect')->view( $this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $check . '</p>', false);
                            
                        }

                    }

                }

            }

        } else {
        
            // Display the login form
            echo get_instance()->ecl('Social_login')->content('Username', 'Password', 'Connect', $this->get_info(), 'instagram', $this->CI->lang->line('mu209'));
            
        }
        
    }

    /**
     * The public method save was added only to follow the interface.
     *
     * @param $token contains the token for some social networks
     * 
     * @return void
     */
    public function save($token = null) {
        
    }

    /**
     * The public method post publishes posts on Instagram.
     *
     * @param array $args contains the post data.
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = null) {
        
        // Get user details
        if ( $user_id ) {
            
            // If the $user_id variable is not null, will be published a postponed post
            $user_details = $this->CI->networks->get_network_data('instagram', $user_id, $args['account']);
            
        } else {
            
            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            $user_details = $this->CI->networks->get_network_data('instagram', $user_id, $args['account']);
            
        }
        
        // Verify if image exists
        if ( !$args['img'] ) {
            
            // Save the error
            $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', json_encode($this->CI->lang->line('a_photo_is_required_to_publish_here')));

            // Then return false
            return false;
            
        }
        
        // Verify if the image is loaded on server
        $im = explode(base_url(), $args['img'][0]['body']);
        
        // If image is on server
        if ( @$im[1] ) {
            
            // Get the path
            $filename = str_replace(base_url(), FCPATH, $args['img'][0]['body']);
            
            // Verify format
            if ( exif_imagetype($filename) != IMAGETYPE_JPEG ) {
                
                $in = get($args['img'][0]['body']);
                
                if ($in) {
                
                    $filename = FCPATH . 'assets/share/' . uniqid() . time() . '.jpg';
                    
                    file_put_contents($filename, $in);
                    
                    if ( file_exists($filename) ) {
                        
                        $file = $filename;
                        
                    } else {
                        
                        return false;
                        
                    }
                    
                } else {
                    
                    return false;
                    
                }
                
            }
            
            $file = $filename;
            
        } else {
            
            $in = get($args['img'][0]['body']);
            
            if ( $in ) {

                $filename = FCPATH . 'assets/share/' . uniqid() . time() . '.jpg';
                
                // Save image on server
                file_put_contents($filename, $in);
                
                // Verify if image was saved
                if ( file_exists($filename) ) {
                    
                    $file = $filename;
                    
                } else {
                    
                    return false;
                    
                }
                
            } else {
                
                return false;
                
            }
            
        }
        
        // Get the post content
        $post = $args['post'];
        
        // If title is not empty
        if ( $args['title'] ) {
            
            $post = $args['title'];
            
        }
        
        // Verify if url exists
        if ( $args['url'] ) {
            $post = str_replace($args['url'], ' ', $post) . ' ' . short_url($args['url']);
        }  
        
        // Set the photo
        $photo = $file;
        
        // Set the caption
        $caption = $post;
        
        // Call the Instagram class
        $check = new \InstagramAPI\Instagram(false, false);
        
        // Verify if for this account was added a proxy
        if ( trim($user_details[0]->secret) ) {
            
            //$check->setProxy($user_details[0]->secret);
            
        } else {
        
            // Get proxy if exists
            $user_proxy = $this->CI->user->get_user_option($user_id, 'proxy');

            // Veirify if proxy exists
            if ( $user_proxy ) {

                $check->setProxy($user_proxy);

            } else {

                // Get global proxy
                $proxies = @trim(get_option('instagram_proxy'));

                // Verify if proxy exists
                if ($proxies) {

                    $proxies = explode('<br>', nl2br($proxies, false));

                    $rand = rand(0, count($proxies));

                    if ( @$proxies[$rand] ) {

                        $check->setProxy($proxies[$rand]);

                    }

                }

            }
        
        }
        
        // Login
        $check->login($user_details[0]->net_id, $user_details[0]->token);
        
        $resizer = new \InstagramAPI\Media\Photo\InstagramPhoto($photo);
        
        // Upload the photo
        try {
            
            $myphoto = $check->timeline->uploadPhoto($resizer->getFile(), ['caption' => $caption]);
            
            if ( $myphoto ) {
            
                $moph = json_encode($myphoto);
                $str = explode('media_id":"', $moph);
                if ( @$str[1] ) {
                    
                    $rd = explode('"', $str[1]);
                    
                    sami($rd[0], $args['id'], $args['account'], 'instagram', $user_id);
                
                    
                }
                
                return true;
                
            } else {
                
                return false;
                
            }
            
        } catch (Exception $e) {
            
            try {
            
                $myphoto = $check->timeline->uploadPhoto($resizer->getFile(), ['caption' => $caption]);
                
                if ($myphoto) {
                
                    $moph = json_encode($myphoto);
                    
                    $str = explode('media_id":"', $moph);
                    
                    if (@$str[1]) {
                    
                        $rd = explode('"', $str[1]);
                        
                        sami($rd[0], $args['id'], $args['account'], 'instagram', $user_id);
                        
                    }
                    
                    return true;
                    
                } else {
                    
                    return false;
                    
                }
                
            } catch (Exception $e) {
                
                try {
                    
                    sleep(1);
                    
                    $myphoto = $check->timeline->uploadPhoto($resizer->getFile(), ['caption' => $caption]);
                    
                    if ( $myphoto ) {
                        
                        $moph = json_encode($myphoto);
                        
                        $str = explode('media_id":"', $moph);
                        
                        if ( @$str[1] ) {
                            
                            $rd = explode('"', $str[1]);
                            
                            sami($rd[0], $args['id'], $args['account'], 'instagram', $user_id);
                            
                        }
                        
                        return true;
                        
                    } else {
                        
                        return false;
                        
                    }
                    
                } catch (Exception $e) {
                    
                    try {
                        
                        sleep(1);
                        
                        $myphoto = $check->timeline->uploadPhoto($resizer->getFile(), ['caption' => $caption]);
                        
                        if ( $myphoto ) {
                            
                            $moph = json_encode($myphoto);
                            
                            $str = explode('media_id":"', $moph);
                            
                            if ( @$str[1] ) {
                                
                                $rd = explode('"', $str[1]);
                                
                                sami($rd[0], $args['id'], $args['account'], 'instagram', $user_id);
                                
                            }
                            
                            return true;
                            
                        } else {
                            
                            return false;
                            
                        }
                        
                    } catch (Exception $e) {

                        // Save the error
                        $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', $e->getMessage());

                        // Then return false
                        return false;
            
                    }
                    
                }
                
            }
            
        }
        
    }

    /**
     * The public method get_info displays information about this class.
     * 
     * @return object with network's data
     */
    public function get_info() {
        
        return (object) array(
            'color' => '#c9349a',
            'icon' => '<i class="icon-social-instagram"></i>',
            'api' => array('proxy'),
            'types' => 'text, links, images',
            'rss' => true,
            'post' => true,
            'insights' => false,
            'categories' => false,
            'types' => array('post', 'rss')
        );
        
    }

    /**
     * The public method preview generates a preview for Instagram.
     *
     * @param $args contains the img or url.
     * 
     * @return object with html
     */
    public function preview($args) {
    }

}
