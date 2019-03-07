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
include_once 'mailchimp_helper.php';

/**
 * Emails_planner - allows to plan the sending of your emails
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Mailchimp_importer implements Tools {

    use Mailchimp_helper;

    /**
     * The function check_info get tool's information.
     */
    public function check_info() {
        // This function returns the main CodeIgniter object
        $CI = get_instance();
        
        // Load Tool Language file
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tool_lang.php' ) ) {
            $CI->lang->load( 'default_tool', $CI->config->item('language') );
        }
        
        return (object) ['name' => $CI->lang->line('mt79'), 'full_name' => $CI->lang->line('mt79'), 'logo' => '<button class="btn-tool-icon btn btn-default btn-xs  pull-left" type="button"><i class="fa fa-wrench"></i></button>', 'slug' => 'mailchimp-importer'];
    }

    /**
     * The function page displays the main page of the tool.
     */
    public function page($args) {
        
        // This function returns the main CodeIgniter object
        $CI = get_instance();
        
        // Get all user email lists
        $lists = $this->get_lists();
        
        // Load Tool Language file
        if ( file_exists( APPPATH . 'language/' . $CI->config->item('language') . '/default_tool_lang.php' ) ) {
            $CI->lang->load( 'default_tool', $CI->config->item('language') );
        }
        
        // Returns the tool content
        return (object) ['content' => $this->assets() . '
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12 offset-xl-3">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="panel-heading details">
                                <h3><i class="fab fa-mailchimp"></i>' . $CI->lang->line('mt79') . '</h3>
                            </div>
                        </div>
                        <div class="row">
                            '.form_open('#', ['class' => 'mailchimp-panel']).'                                                                                 
                                <div class="col-xl-12">
                                    <input type="text" placeholder="' . $CI->lang->line('mt76') . '" class="mailchimp-input apikey">
                                </div>
                                <div class="col-xl-12 clicks-tracking">
                                    <input type="text" placeholder="' . $CI->lang->line('mt77') . '" class="mailchimp-input data-center">
                                </div>                                
                                <div class="col-xl-12 clicks-tracking">
                                    <select class="mailchimp-input mailchimp-list"></select>
                                </div>
                                <div class="col-xl-12 clicks-tracking">
                                    <select class="mailchimp-input my-list">
                                    ' . $lists . '
                                    </select>
                                </div>
                                <div class="col-xl-12">
                                    <img src="' . base_url() . 'assets/img/pageload.gif" class="pull-left pageload">
                                    <button class="pull-right btn btn-next" type="submit">' . $CI->lang->line('mt78') . '</button>
                                </div>
                            '.form_close().'
                        </div>
                    </div>
                </div>
            </div>
        '];
    }

}
