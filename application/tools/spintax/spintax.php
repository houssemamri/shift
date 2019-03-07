<?php
/**
 * Ebay_feed_creator
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
include_once 'spintax_helper.php';
/**
 * Ebay_feed_creator - allows to generate a Feed RSS from url
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Spintax implements Tools {
    
    use Spintax_helper;
    
    /**
     * The function check_info get tool's information.
     */
    public function check_info() {
        return (object) ['name' => 'Spintax', 'full_name' => 'Spintax', 'logo' => '<button class="btn-tool-icon btn btn-default btn-xs  pull-left" type="button"><i class="fa fa-wrench"></i></button>', 'slug' => 'spintax'];
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
        $prev = '';
        if((get_user_option('display_preview_box') == 1)) {
            $prev = ' checked="true"';
        }
        $dipos = '';
        if((get_user_option('use_spintax_posts') == 1)) {
            $dipos = ' checked="true"';
        }
        $dirss = '';
        if((get_user_option('use_spintax_rss') == 1)) {
            $dirss = ' checked="true"';
        }
        $diemails = '';
        if((get_user_option('use_spintax_emails') == 1)) {
            $diemails = ' checked="true"';
        }
        $options = '';
        if (get_option('rss_feeds') == 1) {
            $options .= '<div class="row">
                            <div id="general" class="tab-pane active">
                                <div class="setrow row">
                                    <div class="col-xl-10 col-sm-9 col-xs-9">' . $CI->lang->line('mt22') . '</div>
                                    <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                        <div class="checkbox-option pull-right">
                                            <input id="use_spintax_rss" name="use_spintax_rss" class="setopt" type="checkbox"' . $dirss . '>
                                            <label for="use_spintax_rss"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }
        if(get_option('email_marketing') && (plan_feature('sent_emails') > 0)){
            $options .= '<div class="row">
                            <div id="general" class="tab-pane active">
                                <div class="setrow row">
                                    <div class="col-xl-10 col-sm-9 col-xs-9">' . $CI->lang->line('mt23') . '</div>
                                    <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                        <div class="checkbox-option pull-right">
                                            <input id="use_spintax_emails" name="use_spintax_emails" class="setopt" type="checkbox"' . $diemails . '>
                                            <label for="use_spintax_emails"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        }
        $act = (get_option('posts_planner_limit'))?get_option('posts_planner_limit'):'1';
        return (object) ['content' => $this->assets().'
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mess-stat">
                    <div class="col-lg-12 resent">
                        <div class="row">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <h3>
                                            <i class="icon-globe-alt"></i> ' . $CI->lang->line('mt20') . '
                                        </h3>
                                    </div>
                                    <div class="col-xl-6">
                                        <ul class="nav navbar-nav navbar-right order-by-posts">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle display-by" data-toggle="dropdown" role="button" aria-expanded="false">'
                                                    . $CI->lang->line('mt25')
                                                    . ' <span class="caret"></span>'
                                                . '</a>'
                                                . '<ul class="dropdown-menu" role="menu">'
                                                    . '<li>'
                                                        . '<a href="#" data-toggle="modal" data-target="#new-group" class="order-planned-posts" data-type="1">'
                                                                .$CI->lang->line('mt26')
                                                        . '</a>'
                                                    . '</li>'
                                                    . '<li>'
                                                        . '<a href="#" class="show-planner-options">'
                                                            . $CI->lang->line('mt3')
                                                        .'</a>'
                                                    . '</li>'
                                                . '</ul>'
                                            . '</li>'
                                        . '</ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 post-plans">
                                <div class="list-group">
                                    <ul class="words-list"></ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mess-planner" data-act="'.$act.'">
                    <div class="col-lg-12 resent show-preview plan-add-action" style="display: none;">
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
                            <div class="col-lg-12 post-plans planner-list">
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 resent show-preview plan-shows-detail" style="display: none;">
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
                            <div class="col-lg-12 post-plans">
                                <div class="list-group planner-schedules">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 resent show-preview netshow-list" style="display: none;">
                        <div class="row">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <h3>
                                            <i class="fa fa-language"></i> ' . $CI->lang->line('mt28') . '
                                        </h3>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="btn-group pull-right">
                                            <button type="button" data-toggle="modal" data-target="#new-contu" data-type="main" class="btn btn-default new-contu">'
                                                . $CI->lang->line('mt29')
                                            .'</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 post-plans">
                                <div class="list-group sellected-accounts">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 resent optionss-list">
                        <div class="row">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <h3>
                                            <i class="fa fa-sliders" aria-hidden="true"></i> ' . $CI->lang->line('mt3') . '
                                        </h3>
                                    </div>
                                    <div class="col-xl-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="general" class="tab-pane active">
                                <div class="setrow row">
                                    <div class="col-xl-10 col-sm-9 col-xs-9">' . $CI->lang->line('mt21') . '</div>
                                    <div class="col-xl-2 col-sm-3 col-xs-3 text-right">
                                        <div class="checkbox-option pull-right">
                                            <input id="use_spintax_posts" name="use_spintax_posts" class="setopt" type="checkbox"' . $dipos . '>
                                            <label for="use_spintax_posts"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ' . $options . '
                    </div>                    
                </div>
            </div>',
            'modals' => '<div class="modal fade" id="new-contu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            '.form_open('#', ['class' => 'add-synonym']).'
                                <div class="form-group multiple-form-group input-group">
                                    <input type="text" name="" placeholder="'.$CI->lang->line('mt33').'" class="form-control synonym">
                                    <div class="input-group-btn input-group-select">
                                        <button type="submit" class="btn btn-default">
                                            ' . $CI->lang->line('mu181') . '
                                        </button>
                                    </div>
                                </div>
                            '.form_close().'
                        </div>
                    </div>
                </div>
            </div>
             <div class="modal fade" id="new-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                        '.form_open('#', ['class' => 'add-word']).'
                            <div class="form-group multiple-form-group input-group">
                                <input type="text" placeholder="'.$CI->lang->line('mt27').'" class="form-control word-pal">
                                <div class="input-group-btn input-group-select">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="concept">'.$CI->lang->line('mt15').'</span>
                                    </button>
                                </div>
                            </div>
                        '.form_close().'
                        </div>
                    </div>
                </div>
            </div>'];
    }

}
