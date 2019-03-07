<?php
/**
 * Amazon_feed_creator
 *
 * PHP Version 5.6
 *
 * Generate a feed RSS from an eBay's page
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
include_once 'parse_amazon.php';
include_once 'rss_show.php';
/**
 * Amazon_feed_creator - allows to generate a Feed RSS from url
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Amazon_feed_creator implements Tools {
    
    use Parse_amazon, RSS_ashow;
    
    /**
     * The function check_info get tool's information.
     */
    public function check_info() {
        return (object) array(
            'name' => 'Amazon RSS Creator',
            'full_name' => 'Amazon RSS Creator',
            'logo' => '<button class="btn-tool-icon btn btn-default btn-xs  pull-left" type="button"><i class="fa fa-wrench"></i></button>',
            'slug' => 'amazon-feed-creator'
        );
    }

    /**
     * The function page displays the main page of the tool.
     */
    public function page($args) {
        if(isset($args['rss-url']))
        {
            $content = $this->generate(base64_decode($args['rss-url']));
            if($content)
            {
                return $content;
            }
            else{
                return false;
            }
            exit();
        }
        $CI =& get_instance();
        $content = '<p class="no-results-found">' . $CI->lang->line('mu60') . '</p>' . $CI->lang->line('mu119');
        $url = '';
        $title = '';
        $show = '';
        
        // Check if data was submitted
        if ($CI->input->post()) {
            
            // Add form validation
            $CI->form_validation->set_rules('feed-url', 'Feed URL', 'trim|required');
            $CI->form_validation->set_rules('title', 'Title', 'trim');
            $CI->form_validation->set_rules('curl', 'Url', 'trim');
            
            // Get data
            $feed_url = $CI->input->post('feed-url');
            $title = $CI->input->post('title');
            $curl = $CI->input->post('curl');
            
            if ($CI->form_validation->run() == false) {
                return false;
            } else {
                $url = $feed_url;
            }
            
            if ($url) {
                $get_content = $this->parse($url);
                if (@$get_content['feed']) {
                    $content = $get_content['feed'];
                }
                if (@$get_content['title']) {
                    $show = ' style="display: inline-block;"';
                    $title = $get_content['title'];
                } elseif($get_content){
                    $parse = parse_url($url);
                    $title = $parse['host'];
                }
                
                if ( isset($get_content['rss_description']) ) {
                    $rss_description = stripslashes($get_content['rss_description']);
                } else {
                    $rss_description = '';
                }
                
            }
            
            if ((@$curl == @$url) && (@$title != '')) {
                
                $check = '';
                
                // Get the user plan
                $plan_id = get_user_option('plan', $CI->user_id);

                // Then verify how many posts can publish the user for the current plan
                $rss_limit = plan_feature('publish_posts', $plan_id);
                
                $CI->db->select('*');
                $CI->db->from('rss');
                $CI->db->where(array('user_id' => $CI->user_id));
                $query = $CI->db->get();
                $all_rss = $query->result();
                
                if(($all_rss?count($all_rss):0) < $rss_limit) {
                    
                    $data = array(
                        'user_id' => $CI->user_id,
                        'rss_name' => $title,
                        'rss_description' => $rss_description,
                        'rss_url' => site_url('user/tools/amazon-feed-creator').'?rss-url='.base64_encode($url).'&tool='.$this->check_info()->slug,
                        'added' => date('Y-m-d H:i:s')
                    );

                    $CI->db->insert('rss', $data);
        
                    if ( $CI->db->affected_rows() ) {
                        $response = $CI->db->insert_id();
                    } else {
                        $response = 0;
                    }
                    
                } else {
                    $response = 0;
                }
                
                if ($response == 1) {
                    $check = 'Main.popup_fon(\'sube\', \'' . $CI->lang->line('mu113') . '\', 1500, 2000);';
                } elseif ($response > 3) {
                    $check = 'Main.popup_fon(\'subi\', \'' . $CI->lang->line('mu114') . '\', 1500, 2000);';
                } elseif ($response == 3) {
                    $check = 'Main.popup_fon(\'sube\', \'' . $CI->lang->line('mu115') . '\', 1500, 2000);';
                } elseif ($response == 0) {
                    $check = 'Main.popup_fon(\'sube\', \'' . $CI->lang->line('mu211') . '\', 1500, 2000);';
                }
                
                return (object) ['content' => '
                                <script language="javascript">window.onload = function() {' . $check . ' document.location.href="' . site_url('user/app/posts') . '";}</script>
                                <div class="row">
                                    <div class="col-xl-12">
                                            <ul>
                                                <li>
                                                    <div class="col-xl-12 clean">
                                                    ' . form_open('user/tools/amazon-feed-creator') . '
                                                        <div class="input-group search">
                                                            <input type="text" name="feed-url" placeholder="' . $CI->lang->line('mu116') . '" value="' . $url . '" class="form-control rss-url" required="true">
                                                            <input type="hidden" name="title" value="' . $title . '">
                                                            <input type="hidden" name="curl" value="' . $url . '">
                                                            <span class="input-group-btn search-m">
                                                                <button class="btn save-rss" type="submit" type=""' . $show . '><i class="fas fa-save"></i></button>
                                                                <button class="btn parse" type="submit"><i class="icon-cloud-download"></i></button>
                                                            </span>
                                                        </div>
                                                        ' . form_close() . '
                                                    </div>
                                                </li>
                                            </ul>
                                            <ul class="feed-rss">
                                                ' . $content . '
                                            </ul>
                                    </div>
                                </div>                        
                    '];
            }
        }
        return (object) ['content' => '
            <div class="row">
                <div class="col-xl-12">
                    <ul>
                        <li>
                            <div class="col-xl-12 clean">
                            ' . form_open('user/tools/amazon-feed-creator') . '
                                <div class="input-group search">
                                    <input type="text" name="feed-url" placeholder="' . $CI->lang->line('mu116') . '" value="' . $url . '" class="form-control rss-url" required="true">
                                    <input type="hidden" name="title" value="' . $title . '">
                                    <input type="hidden" name="curl" value="' . $url . '">
                                    <span class="input-group-btn search-m">
                                        <button class="btn save-rss" type="submit" type=""' . $show . '><i class="fas fa-save"></i></button>
                                        <button class="btn parse" type="submit"><i class="icon-cloud-download"></i></button>
                                    </span>
                                </div>
                                ' . form_close() . '
                            </div>
                        </li>
                    </ul>
                    <ul class="feed-rss">
                        ' . $content . '
                    </ul>
                </div>
            </div>                    
        '];
    }

}
