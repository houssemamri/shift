<?php
/**
 * Login
 *
 * PHP Version 5.6
 *
 * Autopost Interface for Login Classes
 *
 * @category Social
 * @package  Midrub
 * @author   Scrisoft <asksyn@gmail.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link     https://www.midrub.com/
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

interface Login
{
    public function check_availability();

    public function sign_in();

    public function get_token();
}
