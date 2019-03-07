<?php
/**
 * Inc
 *
 * PHP Version 5.6
 *
 * Load methods, views and modules
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Inc class - loads the Email Marketing methods, views and modules
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

class Inc{
    
    /**
     * The function home loads the main page
     */
    public function home($val=NULL){
        return get_instance()->ecl('Home_load')->home();
    }
    
    /**
     * The function campaign loads the campaign's page
     *
     * @param $val contains the campaign's ID
     */
    public function campaign($val){
        return get_instance()->ecl('Campaign_load')->details($val);
    }
    
    /**
     * The function lists loads the list's page
     *
     * @param $val contains the List's ID
     */
    public function lists($val){
        return get_instance()->ecl('List_load')->details($val);
    }
    
    /**
     * The function schedules displays the scheduled templates
     *
     * @param $val contains the campaign's ID
     */
    public function schedules($val){
        get_instance()->ecl('Sched_load')->get($val);
    }
    
    /**
     * The function shistory gets the sent templates
     *
     * @param $val contains the campaign's ID
     */
    public function shistory($val){
        get_instance()->ecl('Sched_load')->sent($val,get_instance()->input->get('page', TRUE));
    }
    
    /**
     * The function dcompaign deletes a campaign by ID
     *
     * @param $val contains the campaign's ID
     */
    public function dcampaign($val){
        get_instance()->ecl('Campaign_load')->delete($val);
    }
    
    /**
     * The function dtemplate deletes a template by ID
     *
     * @param $val contains the template's ID
     */
    public function dtemplate($val){
        get_instance()->ecl('Template_load')->delete($val);
    }
    
    /**
     * The function stemplate gets a template's body by ID
     *
     * @param $val contains the template's ID
     */
    public function stemplate($val){
        get_instance()->ecl('Template_load')->template($val);
    }
    
    /**
     * The function dsched deletes a scheduled template
     *
     * @param $val contains the scheduled's ID
     */
    public function dsched($val){
        get_instance()->ecl('Sched_load')->delete($val);
    }
    
    /**
     * The function dlist deletes a list
     *
     * @param $val contains the list's ID
     */
    public function dlist($val){
        get_instance()->ecl('List_load')->delete($val);
    }
    
    /**
     * The function dlist deletes a list's meta
     *
     * @param $val contains the meta's ID
     */
    public function dmeta($val){
        // Delete Meta by ID and List
        get_instance()->ecl('List_load')->delete_meta($val,get_instance()->input->get('list', TRUE));
    }
    
    /**
     * The function template deletes or updates a template
     *
     * @param $val contains the template's ID
     */
    public function template($val){
        return get_instance()->ecl('Campaign_load')->template($val);
    }
    
    /**
     * The function upload uploads email addresses to the list
     *
     * @param $val contains the list's ID
     */
    public function upload($val){
        return get_instance()->ecl('List_load')->upload($val);
    }
    
    /**
     * The function sent gets receiver emails
     *
     * @param $val contains the scheduled's ID
     */
    public function sent($val){
        return get_instance()->ecl('Sched_load')->sents($val);
    }
    
    /**
     * The function unsubscribed gets unsubscribed emails
     *
     * @param $val contains the scheduled's ID
     */
    public function unsubscribed($val){
        return get_instance()->ecl('Sched_load')->unsubscribed($val);
    }
    
    /**
     * The function unread gets unread emails
     *
     * @param $val contains the scheduled's ID
     */
    public function unread($val){
        return get_instance()->ecl('Sched_load')->unread($val);
    }
    
    /**
     * The function opened gets opened emails
     *
     * @param $val contains the scheduled's ID
     */
    public function opened($val){
        return get_instance()->ecl('Sched_load')->opened($val);
    }
    
    /**
     * The function get_templates gets all saved templates
     *
     * @param $val contains the campaign's ID
     */
    public function get_templates($val){
        get_instance()->ecl('Template')->get_templates($val);
    }

    /**
     * The function load loads the methods
     *
     * @param $args contains the query
     * @param $val contains the query's value
     */
    public function load($args,$val=NULL){
        $q = ($args)?$args:'home';
        return $this->$q($val);
    }
}