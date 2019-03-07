<?php
/**
 * 2Checkout
 *
 * PHP Version 5.6
 *
 * Payment class for 2Checkout
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
 * 2Checkout class - allows users to pay via 2Checkout
 *
 * @category Social
 * @package Midrub
 * @author Scrisoft <asksyn@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link https://www.midrub.com/
 */
class Checkout implements Payments {

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
    public function process( $plan_id, $plan_price, $currency_code ) {
        
        // Verify if PayPal is configured
        if ( !get_option('Checkout-account-number') || !get_option('Checkout-secret-word') ) {

            echo display_mess('103');

        }
        
        // Redirects users to the 2Checkout payment page where the user will pay 
        ?>
        <form action="https://www.2checkout.com/checkout/spurchase" method="post" name="paynow" id="sendform" style="display:none">
            <input type="hidden" name="sid" value="<?= get_option('Checkout-account-number') ?>" />
            <input type="hidden" name="mode" value="2CO" />
            <input type="hidden" name="li_0_type" value="product" />
            <input type="hidden" name="li_0_name" value="Upgrade Payment" />
            <input type="hidden" name="currency_code" value="<?= $currency_code ?>">
            <input type="hidden" name="li_0_price" value="<?= $plan_price ?>" />
            <input type="hidden" name="plan_id" value="<?= $plan_id ?>" />
            <input type="hidden" name="x_receipt_link_url" value="<?php echo site_url('user/success-payment') ?>?pay-return=checkout" />
            <input name="btnsubmit" type="submit" value="Checkout" />
        </form>
        <script language="javascript">
            setTimeout(function(){
                document.forms['paynow'].submit();
            },500);
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
        
        // Get the transaction ID
        $sid = $this->CI->input->get('sid', TRUE);
        
        // Get the currency code
        $currency_code = $this->CI->input->get('currency_code', TRUE);
        
        // Get total paid
        $total = $this->CI->input->get('total', TRUE);
        
        // Get plan
        $plan_id = $this->CI->input->get('plan_id', TRUE);
        
        // Get the order number
        $order_number = $this->CI->input->get('order_number', TRUE);
        
        // Get the key
        $key = $this->CI->input->get('key', TRUE);
        
        // Get the plan price
        $price = $this->CI->plans->get_plan_price($plan_id);
        
        // Get the user_id
        $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);

        if ( $price ) {
            
            $hashSecretWord = get_option('Checkout-secret-word'); //2Checkout Secret Word
            $hashSid = $sid; //2Checkout account number
            $hashTotal = $total; //Sale total to validate against
            $hashOrder = $order_number; //2Checkout Order Number
            $StringToHash = strtoupper(md5($hashSecretWord . $hashSid . $hashOrder . $hashTotal));
            if ( $StringToHash == $key ) {
                
                if ( ($price[0]->plan_price == $total) && ($price[0]->currency_code == $currency_code) ) {
                    
                    if ( $this->CI->plans->check_payment($total, $currency_code, $plan_id, $order_number, $user_id, '2checkout') ) {
                        
                        // Get the invoice hello text
                        $hello_text = 'Hello [username]';

                        if ( get_option( 'invoice-hello-text' ) ) {

                            $hello_text = get_option( 'invoice-hello-text' );

                        }

                        // Get the invoice message
                        $message = 'Thanks for using using our services.';

                        if ( get_option( 'invoice-message' ) ) {

                            $message = get_option( 'invoice-message' );

                        }

                        // Get the invoice taxes value
                        $taxes_value = '';

                        if ( get_option( 'invoice-taxes-value' ) ) {

                            $taxes_value = get_option( 'invoice-taxes-value' );

                        }

                        $amount_value = $total;

                        if ( $taxes_value ) {

                            $amount_value = number_format(($total - (($taxes_value / 100) * $total)), 2);

                        }

                        // If payment was done successfully
                        $invoice_id = $this->CI->invoice->create_invoice( $order_number, $plan_id, date('Y-m-d'), $user_id, $hello_text, $message, $amount_value, $currency_code, $taxes_value, $total, date('Y-m-d'), get_user_option('plan_end'), '2checkout' );

                        // Send invoice
                        sends_invoice($invoice_id);
                        
                        $this->CI->session->set_flashdata('upgrade', display_mess(105));
                        
                    } else {
                        
                        $this->CI->session->set_flashdata('upgrade', display_mess(106));
                        
                    }
                    
                    redirect('user/plans');
                    
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
            'name' => '2Checkout',
            'slug' => 'checkout',
            'color' => '#6772e5',
            'icon' => base_url() . 'assets/img/2co.png',
            'settings' => [[
                'type' => 'text',
                'label' => '2Checkout account number',
                'class' => 'account-number'
            ],[
                'type' => 'text',
                'label' => '2Checkout secret word',
                'class' => 'secret-word'
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
    public function cancel($subscription_id) {}

}
