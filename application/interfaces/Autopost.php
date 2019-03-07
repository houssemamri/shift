<?php
/**
 * Autopost
 *
 * PHP Version 5.6
 *
 * Autopost Interface for Autopost Classes
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

interface Autopost
{
    public function check_availability();

    public function connect();

    public function save($token);

    public function post($args, $user_id);

    public function get_info();

    public function preview($args);
}
