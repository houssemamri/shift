<?php
/**
 * PayPal
 *
 * PHP Version 5.6
 *
 * Payment class for PayPal
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

/**
 * PayPal class - allows users to pay via PayPal
 *
 * @category Social
 * @package Midrub
 * @author Scrisoft <asksyn@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link https://www.midrub.com/
 */
class Paypal implements Payments {

    /**
     * Class variables
     */
    protected $CI;

    /**
     * Init the Paypal class
     */
    public function __construct() {

        // Get the CodeIgniter super object
        $this->CI = & get_instance();

        // Load Invoice Model
        $this->CI->load->model('invoice');
    }

    /**
     * The public method process process the payment
     *
     * @param integer $plan_id contains the plan_id
     * @param string $plan_price contains the payment price
     * @param string $currency_code contains the money currency
     * 
     * @return object with html coontent
     */
    public function process($plan_id, $plan_price, $currency_code) {
        // Verify if user can publish in the social network
        $period = $this->CI->plans->get_plan_period($plan_id);

        // Verify if PayPal is configured
        if (!get_option('Paypal-address') || !get_option('Paypal-identity-token')) {

            echo display_mess('103');

            exit();
        }

        // Redirects users to the PayPal payment page where the user will pay 
        $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';

        // Get PayPal address
        $paypal_id = get_option('Paypal-address');

        // Get the website logo
        $main_logo = get_option('main-logo');

        // Verify if logo exists
        if (!$main_logo):

            $main_logo = base_url() . 'assets/img/logo.png';

        endif;
        ?>
        <form action="<?php echo $paypal_url; ?>" method="post" name="paynow" id="sendform" style="display:none">
            <input type="hidden" name="business" value="<?php echo $paypal_id; ?>">
            <?php
            if (( get_option('Paypal-recurring-payments') != '' ) && ( get_option('Paypal-api-username') != '' ) && ( get_option('Paypal-api-password') != '' ) && ( get_option('Paypal-signature') != '' )) {

                $interval = 'M';

                if ($period > 300) {
                    $interval = 'Y';
                }
                ?>
                <input type="hidden" name="cmd" value="_xclick-subscriptions">
                <input type="hidden" name="a3" value="<?= $plan_price ?>">
                <input type="hidden" name="p3" value="1">
                <input type="hidden" name="t3" value="<?= $interval ?>">
                <input type="hidden" name="src" value="1">
                <input type="hidden" name="sra" value="1">
                <?php
            } else {
                ?>
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="amount" value="<?= $plan_price ?>">
                <?php
            }

            // Get the invoice description text
            $description_text = 'Upgrade Payment';

            if (get_option('invoice-description-text')) {

                $description_text = get_option('invoice-description-text');
            }
            ?>                
            <input type="hidden" name="item_name" value="<?= $description_text; ?>">
            <input type="hidden" name="item_number" value="<?= $plan_id ?>">
            <input type="hidden" name="cpp_header_image" value="<?= $main_logo ?>">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="currency_code" value="<?= $currency_code ?>">
            <input type="hidden" name="cancel_return" value="<?php echo site_url('user/plans') ?>">
            <input type="hidden" name="return" value="<?php echo site_url('user/success-payment') ?>?pay-return=paypal">
            <input type="image" src="<?= $main_logo ?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        </form>
        <script language="javascript">
            document.forms["paynow"].submit();
        </script>
        <?php
    }

    /**
     * The public method preview generates a preview for Midrub
     *
     * @param $args contains the image or url
     * 
     * @return object with html coontent
     */
    public function save() {

        // Check if returned transaction is valid and if the user has paid as you expected for the chosen plan
        $postdata = http_build_query(array('cmd' => '_notify-synch', 'tx' => get_instance()->input->get('tx', TRUE), 'at' => get_option('Paypal-identity-token')));

        $opts = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/json', 'content' => $postdata));

        $context = stream_context_create($opts);

        // Check if transaction exists
        $result = file_get_contents('https://www.paypal.com/cgi-bin/webscr', false, $context);

        // Get the user_id
        $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);

        if ($result) {

            if (( get_option('Paypal-recurring-payments') != '' ) && ( get_option('Paypal-api-username') != '' ) && ( get_option('Paypal-api-password') != '' ) && ( get_option('Paypal-signature') != '' )) {

                $ed = explode('transaction_subject', $result);
            } else {

                $ed = explode('mc_gross=', $result);
            }


            if (trim($ed[0]) == 'SUCCESS') {

                // Now we check if the transaction already exists in our database
                if ( is_numeric(get_instance()->input->get('item_number', TRUE)) ) {

                    if (( get_option('Paypal-recurring-payments') != '' ) && ( get_option('Paypal-api-username') != '' ) && ( get_option('Paypal-api-password') != '' ) && ( get_option('Paypal-signature') != '' )) {
                        $money = explode('mc_gross=', $result);
                        $value = explode('charset=', $money[1]);
                        $value = trim($value[0]);
                        $currency = explode('mc_currency=', $result);
                        $code = explode('business=', $currency[1]);
                        $code = trim($code[0]);
                        $subscr_id = explode('subscr_id=', $result);
                        $subscr_id = explode('last_name', $subscr_id[1]);
                        $tx = trim($subscr_id[0]);
                    } else {
                        $money = explode('mc_gross=', $result);
                        $value = explode('protection_eligibility', $money[1]);
                        $value = str_replace('=', '', trim($value[0]));
                        $currency = explode('mc_currency=', $result);
                        $code = explode('item_number', $currency[1]);
                        $code = explode('mc_currency=', trim($code[0]));
                        $code = $code[0];
                        $tx = get_instance()->input->get('tx', TRUE);
                    }

                    if (($value) AND ( $code) AND ( get_instance()->input->get('item_number', TRUE)) AND ( $tx != '')) {

                        $check_payment = ['value' => $value, 'code' => $code, 'plan_id' => get_instance()->input->get('item_number', TRUE), 'tx' => $tx];

                        if ($check_payment) {

                            if ($this->CI->plans->check_payment($check_payment['value'], $check_payment['code'], $check_payment['plan_id'], $tx, $user_id, 'PayPal')) {

                                // Get the invoice hello text
                                $hello_text = 'Hello [username]';

                                if (get_option('invoice-hello-text')) {

                                    $hello_text = get_option('invoice-hello-text');
                                }

                                // Get the invoice message
                                $message = 'Thanks for using using our services.';

                                if (get_option('invoice-message')) {

                                    $message = get_option('invoice-message');
                                }

                                // Get the invoice taxes value
                                $taxes_value = '';

                                if (get_option('invoice-taxes-value')) {

                                    $taxes_value = get_option('invoice-taxes-value');
                                }

                                $amount_value = $check_payment['value'];

                                if ($taxes_value) {

                                    $amount_value = number_format(($check_payment['value'] - (($taxes_value / 100) * $check_payment['value'])), 2);
                                }

                                // If payment was done successfully
                                $invoice_id = $this->CI->invoice->create_invoice($tx, get_instance()->input->get('item_number', TRUE), date('Y-m-d'), $user_id, $hello_text, $message, $amount_value, $code, $taxes_value, $check_payment['value'], date('Y-m-d'), get_user_option('plan_end'), 'PayPal');

                                // Send invoice
                                sends_invoice($invoice_id);

                                $this->CI->session->set_flashdata('upgrade', display_mess(105));
                            } else {

                                $this->CI->session->set_flashdata('upgrade', display_mess(106));
                            }

                            redirect('user/plans');
                        } else {

                            $this->CI->session->set_flashdata('upgrade', display_mess(106));
                            redirect('user/plans');
                        }
                    }
                }
            }
        }
    }

    /**
     * The public method save verifies if the transaction was done successfully and saves it in the database
     * 
     * @return void
     */
    public function info() {

        return [
            'name' => 'PayPal',
            'slug' => 'paypal',
            'color' => '#139ad6',
            'icon' => base_url() . 'assets/img/paypal.png',
            'settings' => [[
            'type' => 'text',
            'label' => 'Identity Token',
            'class' => 'identity-token'
                ], [
                    'type' => 'text',
                    'label' => 'PayPal Email',
                    'class' => 'address'
                ], [
                    'type' => 'option',
                    'label' => 'Recurring Payments',
                    'class' => 'recurring-payments'
                ], [
                    'type' => 'text',
                    'label' => 'API username',
                    'class' => 'api-username'
                ], [
                    'type' => 'text',
                    'label' => 'API password',
                    'class' => 'api-password'
                ], [
                    'type' => 'text',
                    'label' => 'Signature',
                    'class' => 'signature'
                ]]
        ];
    }

    /**
     * The public method cancel deletes a subscription
     * 
     * @param integer $subscription_id contains the subscription's id
     * 
     * @return void
     */
    public function cancel($subscription_id) {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_URL, 'https://api-3t.paypal.com/nvp');
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(array(
            'USER' => get_option('Paypal-api-username'),
            'PWD' => get_option('Paypal-api-password'),
            'SIGNATURE' => get_option('Paypal-signature'),
            'VERSION' => '108',
            'METHOD' => 'ManageRecurringPaymentsProfileStatus',
            'PROFILEID' => $subscription_id,
            'ACTION' => 'Cancel'
        )));

        $response = curl_exec($curl);

        curl_close($curl);
    }

}
