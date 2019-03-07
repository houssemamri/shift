<?php
/**
 * Campaign_load
 *
 * PHP Version 5.6
 *
 * Campaign_load contains the Campaign_load class
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Campaign_load class - gets, saves and deletes data from the table campaigns
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

class Campaign_load{
    
    /**
     * The function details displays the campaign's page
     *
     * @param $val contains the campaign's ID
     */
    public function details($val){
        get_instance()->efl('campaign');
        return temp($val);
    }


    public function delete($val){
        get_instance()->ecl('Campaign')->delete_campaign($val);
    }
    
    /**
     * The function template loads template
     *
     * @param $val contains the template's ID
     */    
    public function template($val){
        get_instance()->efl('template');
        return temp($val);
    }
}