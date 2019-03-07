<?php
/**
 * Wordpress Platform
 *
 * PHP Version 5.6
 *
 * Connect and Publish to Wordpress Platform
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
 * Wordpress class - allows users to connect to their Wordpress Account and publish posts.
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Wordpress_platform implements Autopost {

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
     * The public method check_availability doesn't check if Wordpress api was configured correctly.
     *
     * @return boolean true
     */
    public function check_availability() {
        
        return true;
        
    }

    /**
     * The public method connect will show a form where the user can add the Wordpress's username and password.
     * 
     * @return void
     */
    public function connect() {
        
       if ( $this->CI->input->post() ) {

            $this->CI->form_validation->set_rules('website_name', 'Website Name', 'trim|required');
            $this->CI->form_validation->set_rules('website_url', 'Website Url', 'trim|required');
            $this->CI->form_validation->set_rules('website_key', 'Website Key', 'trim|required');

            // Get data
            $website_name = $this->CI->input->post('website_name');
            $website_url = $this->CI->input->post('website_url');
            $website_key = $this->CI->input->post('website_key');

            if ( $this->CI->form_validation->run() == false ) {

                // Display the error message
                echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm44') . '</p>', false); 

            } else {

                $check = get($website_url . '?key-checker=' . $website_key);

                if ( @is_numeric($check) ) {

                    $this->CI->networks->add_network('wordpress_platform', $website_key, $website_key, $this->CI->user_id, '', $website_name, $website_url);

                    // Display the success message
                    echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-success">' . $this->CI->lang->line('your_blog_added') . '</p>', true);

                } else {

                    // Display the error message
                    echo $this->CI->ecl('Social_login_connect')->view($this->CI->lang->line('social_connector'), '<p class="alert alert-error">' . $this->CI->lang->line('mm99') . '</p>', false); 

                }

            }
            
            exit();

        }
        
        ?>
        <html>
            <head>
                <title>New Wordpress Account</title>
            </head>
            <body>
                <style>
                    body
                    {
                        background-color: #fafafa;    
                    }
                    form
                    {
                        width: 300px;
                        margin:auto;
                        background-color: #fff;
                        border: 1px solid #efefef;
                        padding:15px;
                    }
                    input[type="text"],input[type="password"]
                    {
                        display: block;
                        width: 100%;
                        height: 34px;
                        padding: 6px 12px;
                        font-size: 14px;
                        line-height: 1.428571429;
                        color: #555;
                        background-color: #fff;
                        background-image: none;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                        margin-bottom:20px;    
                        background: #fafafa;
                        border: solid 1px #dbdbdb;
                    }
                    button
                    {
                        color: #fff;
                        background-color: #5cb85c;
                        border-color: #4cae4c;
                        display: inline-block;
                        margin-bottom: 0;
                        font-weight: 400;
                        text-align: center;
                        vertical-align: middle;
                        cursor: pointer;
                        background-image: none;
                        border: 1px solid transparent;
                        white-space: nowrap;
                        padding: 6px 12px;
                        font-size: 14px;
                        line-height: 1.428571429;
                        border-radius: 4px;    
                    }
                </style>
                <?php echo form_open('user/connect/wordpress_platform', ['class' => 'add-wordpress']) ?>
                <div class="control-group">
                    <label class="control-label" for="user">Website Name:</label>
                    <div class="controls">
                        <input id="name" name="website_name" type="text" class="form-control" placeholder="Website Name" required="required">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="user">Website Address:</label>
                    <div class="controls">
                        <input id="address" name="website_url" type="text" class="form-control" placeholder="Ex: http://website.com/" required="required">
                    </div>                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="user">Api Key:</label>
                    <div class="controls">
                        <input id="key" name="website_key" type="text" class="form-control" placeholder="Enter the Api Key generated by plugin" required="required">
                    </div>                    
                </div>                
                <div class="control-group">
                    <label class="control-label" for="signin"></label>
                    <div class="controls">
                        <button id="checkin" type="submit" name="checkin" class="btn btn-success">Add Account</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </body>
        </html>
        <?php
    }

    /**
     * The public method save was added only to follow the interface.
     *
     * @param string $token contains the token for some social networks
     * 
     * @return void
     */
    public function save($token = null) {
        
    }

    /**
     * The public method post publishes posts on Wordpress.
     *
     * @param array $args contains the post data.
     * @param integer $user_id is the ID of the current user
     * 
     * @return boolean true if post was published
     */
    public function post($args, $user_id = null) {
        if ($user_id) {
            
            // if the $user_id variable is not null, will be published a postponed post
            $user_details = $this->CI->networks->get_network_data('wordpress_platform', $user_id, $args['account']);
            
        } else {
            
            // Get the user ID
            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            $user_details = $this->CI->networks->get_network_data('wordpress_platform', $user_id, $args['account']);
            
        }
        $title = $args['post'];
        $post = '';
        if (@$args['title']) {
            $title = $args['title'];
            $post = $args['post'];
        }
        $category = 0;
        $cat = json_decode($args['category']);
        if (@$cat->$args['account']) {
            $category = $cat->$args['account'];
        }
        $url = '';
        if (@$args['url']) {
            $post = str_replace($args['url'], ' ', $post);
            $url = short_url($args['url']);
        }
        $post = post($user_details[0]->user_avatar . '?pubkey=' . $user_details[0]->token, array('title' => $title, 'post' => $post, 'category' => $category, 'img' => @$args['img'][0]['body'], 'url' => @$args['url']));
        if ($post) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * The public method get_info displays information about this class.
     * 
     * @return network's data
     */
    public function get_info() {
        return (object) array(
            'color' => '#0090bb',
            'icon' => '<i class="fab fa-wordpress-simple"></i>',
            'rss' => true,
            'api' => array(),
            'types' => 'text, links, images',
            'categories' => true,
            'rss' => true,
            'post' => true,
            'insights' => false,
            'types' => array('post', 'rss')
        );
    }

    /**
     * The public method preview generates a preview for Wordpress.
     *
     * @param $args contains the img or url.
     * 
     * @return object with html content
     */
    public function preview($args) {}

}
