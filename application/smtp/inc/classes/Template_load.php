<?php
/**
 * Template_load
 *
 * PHP Version 5.6
 *
 * Template_load contains the Templates Model Helper
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Template_load class - gets, saves and deletes data from the templates table
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

class Template_load{
    
    /**
     * The function delete deletes an template
     *
     * @param $val contains the template's ID
     */
    public function delete($val){
        get_instance()->ecl('Template')->delete_template($val);
    }
  
    /**
     * The function details gets template's data
     *
     * @param $val contains the template's ID
     */
    public function template($val){
        if(get_instance()->ecl('Template')->get_template_title($val)) {
            echo json_encode([get_instance()->ecl('Template')->get_template_title($val),get_instance()->ecl('Template')->get_template_body($val)]);
        }
    }
}