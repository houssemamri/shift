<?php
/**
 * Telegram Groups
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Telegram Groups
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if ( !defined('BASEPATH')) {
    
    exit('No direct script access allowed');
    
}

/**
 * Telegram_groups class - allows users to connect to their Telegram Groups and publish posts.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Telegram_groups implements Autopost {

    /**
     * Class variables
     */
    protected $CI;
    
    /**
     * Load networks and user model.
     */
    public function __construct() {
        
        // Get the CodeIgniter super object
        $this->CI = & get_instance();
        
    }
    
    /**
     * The public method check_availability checks if the Telegram api is configured correctly.
     *
     * @return boolean true or false
     */
    public function check_availability() {
        
        return true;
        
    }
    
    /**
     * The public method connect will redirect user to Telegram login page.
     * 
     * @return void
     */
    public function connect() {
        
        // Check if data was submitted
        if ($this->CI->input->post()) {

            // Add form validation
            $this->CI->form_validation->set_rules('api_key', 'App Key', 'trim|required');

            // Get post data
            $app_key = $this->CI->input->post('api_key');

            // Verify if form data is valid
            if ($this->CI->form_validation->run() == false) {

                // Display the error popup
                echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm3') . '</p>', false);
                

            } else {
                
                $data = get('https://api.telegram.org/bot' . $app_key . '/getUpdates');

                if ( $data ) {
                    
                    $data = json_decode($data);

                    foreach ( $data->result as $result ) {
                        
                        $chat_id = @$result->message->chat->id;
                        
                        $title = @$result->message->chat->title;

                        if ( $chat_id && $title ) {
                
                            // Verify if account was already added
                            if ( !$this->CI->networks->check_account_was_added('telegram_groups', $chat_id, $this->CI->user_id) ) {
                                
                                $this->CI->networks->add_network('telegram_groups', $chat_id, $app_key, $this->CI->user_id, '', $title, '', '');
                                
                                
                            }
                            
                        }
                        
                    }
                    
                    // Display the success message
                    echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . $this->CI->lang->line('mm221') . '</p>', true);                    
                    
                } else {
                    
                    // Display the error popup
                    echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('no_groups_found') . '</p>', false);
                    
                }

            }

        } else {
            
            // Display the login form
            echo $this->CI->ecl('Social_login')->content('Api Key', '', 'Connect', $this->get_info(), 'telegram_groups', $this->CI->lang->line('mm3'));            
            
        }
        
    }
    
    /**
     * The public method save will get access token.
     *
     * @param string $token contains the token for some social networks
     * 
     * @return boolean true or false
     */
    public function save($token = null) {
        
    }
    
    /**
     * The public method post publishes posts on Telegram Groups.
     *
     * @param array $args contains the post data.
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = null) {
        
        // Get user details
        if ( $user_id ) {
            
            // if the $user_id variable is not null, will be published a scheduled post
            $user_details = $this->CI->networks->get_network_data('telegram_groups', $user_id, $args['account']);
            
        } else {
            
            // Get the user ID
            $user_id = $this->CI->user_id;
            $user_details = $this->CI->networks->get_network_data('telegram_groups', $user_id, $args['account']);
            
        }
        
        // Get post's data
        $post = str_replace(
            array('<b>', '</b>', '<strong>', '</strong>', '<i>', '</i>', '<em>', '</em>', '<code>', '</code>', '<pre>', '</pre>'),
            array('*', '*', '*', '*', '_', '_', '`', '`', '```', '```', '```', '```'),
            $args['post']
        );
        
        // Verify if title is not empty
        if( $args['title'] ) {
            
            $post = $args['title']. ' '. $post;
            
        }
        
        // Verify if url is empty
        if ( trim($args['url']) ) {
            
            $post = str_replace($args['url'], '', $post) . ' ' . short_url($args['url']);

        }
        
        if ( $args['img'] ) {
            
            // Publish details
            $params = [
                'chat_id' => $user_details[0]->net_id,
                'photo' => $args['img'][0]['body'],
                'caption' => $post,
                'parse_mode' => 'Markdown'
            ];        

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . $user_details[0]->token . '/sendPhoto?' . http_build_query($params),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: text/xml; charset=utf-8"
                ),
                CURLOPT_RETURNTRANSFER => true
            ));
            
            $result = curl_exec($curl);
            
            curl_close($curl);
        
        } else {
            
            // Publish details
            $params = [
                'chat_id' => $user_details[0]->net_id,
                'text' => $post,
                'parse_mode' => 'Markdown'
            ];        

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.telegram.org/bot' . $user_details[0]->token . '/sendMessage?' . http_build_query($params),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: text/xml; charset=utf-8"
                ),
                CURLOPT_RETURNTRANSFER => true
            ));
            
            $result = curl_exec($curl);
            
            curl_close($curl);
            
        }
        
        // Decode response
        $publish = json_decode($result);

        if ( $publish->ok ) {
            
            return true;
            
        } else {
            
            // Save the error
            $this->CI->user_meta->update_user_meta($user_id, 'last-social-error', json_encode($publish) );
            
        }
        
    }
    
    /**
     * The public method get_info displays information about this class.
     * 
     * @return object with network's data
     */
    public function get_info() {
        
        return (object) array(
            'color' => '#5682a3',
            'icon' => '<i class="fab fa-telegram-plane"></i>',
            'api' => array(),
            'types' => 'text, links, images',
            'categories' => false,
            'rss' => true,
            'post' => true,
            'insights' => false,
            'types' => array('post', 'rss')
        );
        
    }
    
    /**
     * The public method preview generates a preview for Telegram Groups.
     *
     * @param $args contains the img or url.
     * 
     * @return object with html content
     */
    public function preview($args) {}
    
}