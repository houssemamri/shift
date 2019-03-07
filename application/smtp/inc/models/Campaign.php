<?php
/**
 * Campaign
 *
 * PHP Version 5.6
 *
 * Campaign contains the Campaigns Model Helper
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Campaign class - gets, saves and deletes data from the campaigns table
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

class Campaign{
    
    public function __construct(){
        get_instance()->load->model('campaigns');
    }
    
    /**
     * The function if_user_is_owner_campaign verifies if the current user is the Campaign's owner
     *
     * @param $campaign_id contains the campaign's ID
     * @return boolean true or false
     */
    public function if_user_is_owner_campaign($campaign_id){
        if(get_instance()->ecl('Instance')->mod('campaigns', 'campaign_owner', [get_instance()->ecl('Instance')->user(),$campaign_id])) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * The function create creates a campaign
     *
     * @param $n contains the campaign's name
     * @param $d contains the campaign's description
     */
    public function create($n,$d){
        if(get_instance()->ecl('Instance')->mod('campaigns', 'save_campaign', [get_instance()->ecl('Instance')->user(),'email',$n,$d])) {
            display_mess(110);
        } else {
            display_mess(111);
        }
    }
    
    /**
     * The function create creates a campaign meta
     *
     * @param integer $campaign_id contains the campaign_id
     * @param string $smtp_option contains the meta name
     * @param string $field contains the meta field
     * @param string $value contains the meta value
     * @return boolean true or false
     */
    public function create_meta($campaign_id,$smtp_option,$field,$value){
        // Verify if user is owner of the campaign
        if($this->if_user_is_owner_campaign($campaign_id)) {
            if(get_instance()->ecl('Instance')->mod('campaigns', 'save_campaign_meta', [$campaign_id, $smtp_option, $field, $value])) {
                return true;
            } else {
                return false;
            }
        } else {
            echo json_encode($campaign_id);
            return false;
        }
    }
    
    /**
     * The function delete_campaign deletes campaign by ID
     *
     * @param $val contains the campaign's ID
     */    
    public function delete_campaign($val){
        if(get_instance()->ecl('Instance')->mod('campaigns', 'delete_campaign', [get_instance()->ecl('Instance')->user(),$val])) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * The function get_campaign_meta gets campaign's meta
     *
     * @param integer $campaign_id contains the campaign_id
     * @param string $smtp_option contains the meta name
     * @return object with campaign meta or false
     */
    public function get_campaign_meta($campaign_id, $smtp_option){
        $metas = get_instance()->ecl('Instance')->mod('campaigns', 'get_campaign_meta', [$campaign_id, $smtp_option]);
        if($metas) {
            return $metas;
        } else {
            return false;
        }
    }
}