<?php
/**
 * Sched
 *
 * PHP Version 5.6
 *
 * Sched contains the Scheduled Model Helper
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Sched class - gets, saves and deletes data from the table lists and lists_meta
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Sched{
    /**
     * Load the Scheduled model
     */
    public function __construct(){
        get_instance()->load->model('scheduled');
    }

    /**
     * The function schedule_template schedules a template
     *
     * @param $first_template contains the first template
     * @param $first_list contains the first list
     * @param $first_condition contains the condition
     * @param $second_template contains the second template
     * @param $datetime contains the datetime
     */
    public function schedule_template($campaign_id,$first_template,$first_list,$first_condition,$second_template,$datetime){
        if(get_instance()->ecl('Instance')->mod('scheduled', 'schedule_template', [get_instance()->ecl('Instance')->user(),'email',$campaign_id,$first_list,$first_template,$first_condition,$second_template,$datetime]))
        {
            display_mess(121);
        } else {
            display_mess(122);
        }
    }
    
    /**
     * The function get_scheduled gets scheduleds from database by campaign's ID
     *
     * @param $campaign_id contains the campaign's ID
     */
    public function get_scheduleds($campaign_id){
        $schedules = get_instance()->ecl('Instance')->mod('scheduled', 'get_scheduleds', [get_instance()->ecl('Instance')->user(),'email',$campaign_id]);
        if($schedules) {
            echo json_encode($schedules);
        } else {
            echo json_encode('');
        }
        exit();
    }
    
    /**
     * The function get_sent gets sent templates from database by campaign's ID
     *
     * @param $campaign_id contains the campaign's ID
     * @param $page contains the page number
     */
    public function get_sent($campaign_id,$page){
        $schedules = get_instance()->ecl('Instance')->mod('scheduled', 'get_sent', [get_instance()->ecl('Instance')->user(),'email',$campaign_id,$page]);
        if($schedules) {
            $total = get_instance()->ecl('Instance')->mod('scheduled', 'get_sent', [get_instance()->ecl('Instance')->user(),'email',$campaign_id]);
            echo json_encode(['total' => COUNT($total), 'scheds' => $schedules]);
        } else {
            echo json_encode('');
        }
        exit();
    }
    
    /**
     * The function get_stats gets statistics from database by campaign's ID
     *
     * @param $campaign_id contains the campaign's ID
     */
    public function get_stats($campaign_id){
        $schedules = get_instance()->ecl('Instance')->mod('scheduled', 'get_stats', [get_instance()->ecl('Instance')->user(),'email',$campaign_id]);
        if($schedules) {
            return $schedules;
        } else {
            return false;
        }
    }

    /**
     * The function delete_template deletes a Schedules
     *
     * @param $val contains the scheduled's ID
     */
    public function delete_schedules($val){
        if(get_instance()->ecl('Instance')->mod('scheduled', 'delete_schedules', [get_instance()->ecl('Instance')->user(),$val]))
        {
            echo 1;
        } else {
            echo 0;
        }
    }
}