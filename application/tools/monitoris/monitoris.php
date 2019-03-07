<?php
/**
 * Monitoris
 *
 * PHP Version 5.6
 *
 * Monitoris - universal chat for social networks
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
require_once 'constants.php';
require_once 'Load.php';

/**
 * Monitoris - universal chat for social networks
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
class Monitoris implements Tools {
    
    /**
     * The function check_info get tool's information.
     */
    public function check_info() {
        return (object) ['name' => 'Monitoris', 'full_name' => 'Monitoris', 'logo' => '<button class="btn-tool-icon btn btn-default btn-xs  pull-left" type="button"><i class="fa fa-wrench"></i></button>', 'slug' => 'monitoris'];
    }
    
    /**
     * The function page displays the main page of the tool.
     */
    public function page($args) {
        $load = new Load();
        return (object) ['content' => $load->show()];
    }

}
