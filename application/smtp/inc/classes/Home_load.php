<?php
/**
 * Home_load
 *
 * PHP Version 5.6
 *
 * Home_load contains the Home_load Class
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

/**
 * Home_load class - displays the main Email Marketing page
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */

class Home_load{
    /**
     * The function home loads the main Email Marketing page
     *
     * @param $val contains the template's ID
     */
    public function home(){
        get_instance()->efl('main');
        return temp();
    }

    /**
     * The function load loads the Home's methods
     *
     * @param $args contains the method
     */    
    public function load($args){
        $q = ($args)?$args:'home';
    }
}