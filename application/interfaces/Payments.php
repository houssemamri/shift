<?php
/**
 * Payments
 *
 * PHP Version 5.6
 *
 * Payments Interface for Payments Classes
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
    
interface Payments {
    
    public function process( $plan_id, $plan_price, $currency_code );
    public function save();
    public function info();
    public function cancel($subscription_id);
    
}
