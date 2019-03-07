<?php
/**
 * Template
 *
 * PHP Version 5.6
 *
 * Template contains the Templates Model Helper
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Template class - gets, saves and deletes data from the table templates
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

class Template{
    public function __construct(){
        get_instance()->load->model('templates');
    }
    
    /**
     * The function create creates or updates a new template
     *
     * @param $n contains the template's name
     * @param $d contains the template's description
     * @param $c contains the campaign's ID
     */
    public function create($n,$d,$c,$p){
        $created = get_instance()->ecl('Instance')->mod('templates', 'save_template', [get_instance()->ecl('Instance')->user(),$c,'email',$n,$d]);
        if($created) {
            if($p < 1) {
                return display_mess(114);
            } else {
                return $created;
            }
        } else {
            if($p < 1) {
                return display_mess(115);
            } else {
                return false;
            }
        }
    }
    
    /**
     * The function get_templates gets template by Campaign ID
     *
     * @param $campaign_id contains the campaign's ID
     */
    public function get_templates($campaign_id){
        $templates = get_instance()->ecl('Instance')->mod('templates', 'get_templates', [get_instance()->ecl('Instance')->user(),$campaign_id]);
        if($templates){
            echo json_encode($templates);
        }
    }
    
    /**
     * The function get_template_title gets template's title
     *
     * @param $template_id contains the template's ID
     */
    public function get_template_title($template_id){
        if(!is_numeric($template_id)) {
            return false;
        }
        $templates = get_instance()->ecl('Instance')->mod('templates', 'get_template_title', [get_instance()->ecl('Instance')->user(),$template_id]);
        if($templates){
            return $templates;
        }
    }
    
    /**
     * The function get_template_body gets template's description
     *
     * @param $template_id contains the template's ID
     */
    public function get_template_body($template_id){
        if(!is_numeric($template_id)) {
            return false;
        }
        $templates = get_instance()->ecl('Instance')->mod('templates', 'get_template_body', [get_instance()->ecl('Instance')->user(),$template_id]);
        if($templates){
            return $templates;
        }
    }  
    
    /**
     * The function delete_template delete a template
     *
     * @param $template_id contains the template's ID
     */
    public function delete_template($val){
        if(get_instance()->ecl('Instance')->mod('templates', 'delete_template', [get_instance()->ecl('Instance')->user(),$val]))
        {
            echo 1;
        } else {
            echo 0;
        }
    }
}