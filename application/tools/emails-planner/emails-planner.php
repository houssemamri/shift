<?php
/**
 * Emails Planner
 *
 * PHP Version 5.6
 *
 * Plan your emails and decide when will be sent
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
include_once 'emails_helper.php';
/**
 * Emails_planner - allows to plan the sending of your emails
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Emails_planner implements Tools {
    
    use Emails_helper;
    
    /**
     * The function check_info get tool's information.
     */
    public function check_info() {
        return (object) ['name' => 'Emails Planner', 'full_name' => 'Emails Planner', 'logo' => '<button class="btn-tool-icon btn btn-default btn-xs  pull-left" type="button"><i class="fa fa-wrench"></i></button>', 'slug' => 'emails-planner'];
    }

    /**
     * The function page displays the main page of the tool.
     */
    public function page($args) {
        $CI = get_instance();
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tool_lang.php' ) ) {
            $CI->lang->load( 'default_tool', $CI->config->item('language') );
        }
        $nets = $this->get_socials();
        $netu = '';
        if($nets){
            foreach($nets as $net){
                $netu .= '<li><a href="'.strtolower($net[2]).'">'.ucwords(str_replace('_', ' ', $net[2])).'</a></li>';
            }
        }
        $display_form = '';
        if(get_user_option('display_planner_form_campaign')){
            $display_form = ' checked="checked"';
        }
        $notification_planner = '';
        if(get_user_option('send_notification_planne')){
            $notification_planner = ' checked="checked"';
        }        
        $act = (get_option('emails_planner_limit'))?get_option('emails_planner_limit'):'1';
        return (object) ['content' => $this->assets().'
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12 mess-stat">
                    <div class="col-xl-12 resent">
                        <div class="row">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <h3>
                                            <i class="icon-docs"></i> ' . $CI->lang->line('mu165') . '
                                        </h3>
                                    </div>
                                    <div class="col-xl-6">
                                        <ul class="nav navbar-nav navbar-right order-by-posts">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle display-by" data-toggle="dropdown" role="button" aria-expanded="false">' . $CI->lang->line('mt38') . '</a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li>
                                                        <a href="#" class="order-planned-posts" data-type="1">' . $CI->lang->line('mt38') . '</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="order-planned-posts" data-type="2">' . $CI->lang->line('mt39') . '</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="show-planner-options">' . $CI->lang->line('mt3') . '</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 post-plans">
                                <div class="list-group">
                                    <ul></ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <ul class="pagination"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12 mess-planner" data-act="'.$act.'">
                    <div class="col-xl-12 resent show-preview plan-add-action">
                        <div class="row">
                            <div class="panel-heading">
                               <div class="row">
                                    <div class="col-xl-6">
                                        <h3>
                                            <i class="icon-calendar"></i> ' . $CI->lang->line('mu190') . '
                                        </h3>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="btn-group pull-right">
                                            <button type="button" data-type="main" class="btn btn-default add-repeat">'
                                                . $CI->lang->line('mu189')
                                            . '</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 post-plans planner-list">
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 resent show-preview plan-shows-detail">
                        <div class="row">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <h3>
                                            <i class="icon-info"></i> ' . $CI->lang->line('mu191') . '
                                        </h3>
                                    </div>
                                    <div class="col-xl-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 post-plans">
                                <div class="list-group planner-schedules"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 resent show-preview netshow-list">
                        <div class="row">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <h3>
                                            <i class="fa fa-at"></i> ' . $CI->lang->line('mu146') . '
                                        </h3>
                                    </div>
                                    <div class="col-xl-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 post-plans">
                                <div class="list-group sellected-accounts list-group"><ul></ul></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <ul class="pagination"></ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 resent optionss-list">
                        <div class="row">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <h3>
                                            <i class="icon-settings"></i> ' . $CI->lang->line('mt3') . '
                                        </h3>
                                    </div>
                                    <div class="col-xl-6">
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="setrow row">
                            <div class="col-xl-10 col-sm-9 col-xs-9">'.$CI->lang->line('mt40').'</div>
                            <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                <div class="checkbox-option pull-right">
                                    <input id="display_planner_form_campaign" name="display_planner_form_campaign" class="setopt" type="checkbox"'.$display_form.'>
                                    <label for="display_planner_form_campaign"></label>
                                </div>
                            </div>
                        </div>
                        <div class="setrow row">
                            <div class="col-xl-10 col-sm-9 col-xs-9">'.$CI->lang->line('mt41').'</div>
                            <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                <div class="checkbox-option pull-right">
                                    <input id="send_notification_planne" name="send_notification_planne" class="setopt" type="checkbox"'.$notification_planner.'>
                                    <label for="send_notification_planne"></label>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        '];
    }
}
