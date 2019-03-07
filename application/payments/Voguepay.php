<?php
/**
 * Voguepay
 *
 * PHP Version 5.6
 *
 * Payment class for Voguepay
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
 * Voguepay class - allows users to pay via Voguepay
 *
 * @category Social
 * @package Midrub
 * @author Scrisoft <asksyn@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link https://www.midrub.com/
 */
class Voguepay implements Payments {

    /**
     * Class variables
     */
    protected $CI;

    /**
     * Init the Voguepay class
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

        // Verify if Voguepay is configured
        if (!get_option('Voguepay-merchant-id')) {

            echo display_mess('103');

            exit();
        }
        
        $merchant_id = get_option('Voguepay-merchant-id');
        
        $main_logo = get_option('main-logo');
        
        if ( !$main_logo ) {
            
            $main_logo = base_url() . 'assets/img/logo.png';
            
        }
        
        if ( $this->CI->plans->book_payment($this->CI->user_id, 'voguepay', $plan_id ) ) {
            
            ?>
            <style type="text/css">
            .form-style-1 {
                margin:10px auto;
                max-width: 400px;
                padding: 20px 12px 10px 20px;
                font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
            }
            .form-style-1 li {
                padding: 0;
                display: block;
                list-style: none;
                margin: 10px 0 0 0;
            }
            .form-style-1 label{
                margin:0 0 3px 0;
                padding:0px;
                display:block;
                font-weight: bold;
            }
            .form-style-1 input[type=text], 
            .form-style-1 input[type=date],
            .form-style-1 input[type=datetime],
            .form-style-1 input[type=number],
            .form-style-1 input[type=search],
            .form-style-1 input[type=time],
            .form-style-1 input[type=url],
            .form-style-1 input[type=email],
            textarea, 
            select{
                box-sizing: border-box;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                border:1px solid #BEBEBE;
                padding: 7px;
                margin:0px;
                -webkit-transition: all 0.30s ease-in-out;
                -moz-transition: all 0.30s ease-in-out;
                -ms-transition: all 0.30s ease-in-out;
                -o-transition: all 0.30s ease-in-out;
                outline: none;
                margin-bottom: 15px;
                resize: none;
            }
            .form-style-1 input[type=text]:focus, 
            .form-style-1 input[type=date]:focus,
            .form-style-1 input[type=datetime]:focus,
            .form-style-1 input[type=number]:focus,
            .form-style-1 input[type=search]:focus,
            .form-style-1 input[type=time]:focus,
            .form-style-1 input[type=url]:focus,
            .form-style-1 input[type=email]:focus,
            .form-style-1 textarea:focus, 
            .form-style-1 select:focus{
                -moz-box-shadow: 0 0 8px #88D5E9;
                -webkit-box-shadow: 0 0 8px #88D5E9;
                box-shadow: 0 0 8px #88D5E9;
                border: 1px solid #88D5E9;
            }
            .form-style-1 .field-divided{
                width: 49%;
            }

            .form-style-1 .field-long{
                width: 100%;
            }
            .form-style-1 .field-select{
                width: 100%;
            }
            .form-style-1 .field-textarea{
                height: 100px;
                width: 93.4%;
            }
            .form-style-1 input[type=submit], .form-style-1 input[type=button]{
                background: #4B99AD;
                padding: 8px 15px 8px 15px;
                border: none;
                color: #fff;
                width: 93.4%;
            }
            .form-style-1 input[type=submit]:hover, .form-style-1 input[type=button]:hover{
                background: #4691A4;
                box-shadow:none;
                -moz-box-shadow:none;
                -webkit-box-shadow:none;
            }
            .form-style-1 .required{
                color:red;
            }
            </style>
            <form method="POST" action="https://voguepay.com/pay/" class="form-style-1" name="paynow">
                <input type="text" name="name" value="" placeholder="Enter your name" required />
                <input type="text" name="phone" value="" placeholder="Enter your phone" required />
                <input type="text" name="email" value="" placeholder="Enter your email" required />
                <input type="text" name="address" value="" placeholder="Enter your address" required />
                <input type="hidden" name="total" value="<?php echo $plan_price; ?>" />
                <input type="hidden" name="v_merchant_id" value="<?php echo $merchant_id ?>" />
                <textarea name="memo" class="field-textarea">Upgrade Payment</textarea>
                <input type="hidden" name="notify_url" value="<?php echo site_url('user/success-payment?pay-return=voguepay') ?>" />
                <input type="hidden" name="success_url" value="<?php echo site_url('user/success-payment?pay-return=voguepay') ?>" />
                <input type="hidden" name="fail_url" value="<?php echo site_url('user/success-payment?pay-return=voguepay') ?>" />
                <input type="submit" value="Submit">
                <input type="image" src="<?php $main_logo; ?>" alt="Submit" style="display: none" />
            </form>
            <?php
            
        } else {
            
            display_mess(45);
            
        }
        
    }

    /**
     * The public method preview generates a preview for Midrub
     *
     * @param $args contains the image or url
     * 
     * @return object with html coontent
     */
    public function save() {

        $request = $this->CI->security->xss_clean($_REQUEST);
        
        if( isset($request['transaction_id']) )  {
            
            $rd = get('https://voguepay.com/?v_transaction_id=' . $request['transaction_id'] . '&type=json&demo=true');
            
            if ( $rd ) {
                
                $rd = json_decode($rd);
                
                if ( @$rd->total_paid_by_buyer ) {
                    
                    if ($this->CI->plans->trans( $this->CI->user_id,$request['transaction_id'],$rd->total_paid_by_buyer ) ) {
                        
                        $transaction = $this->CI->plans->check_transaction($request['transaction_id']);
                        
                        if ( $transaction ) {

                            if($this->CI->plans->payment_done($this->CI->user_id, 'voguepay')) {

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

                                $amount_value = $transaction[0]->payment_amount;

                                if ($taxes_value) {

                                    $amount_value = number_format(($transaction[0]->payment_amount - (($taxes_value / 100) * $transaction[0]->payment_amount)), 2);
                                }

                                // If payment was done successfully
                                $invoice_id = $this->CI->invoice->create_invoice($request['transaction_id'], $transaction[0]->plan_id, date('Y-m-d'), $this->CI->user_id, $hello_text, $message, $transaction[0]->payment_amount, $rd->cur, $taxes_value, $transaction[0]->payment_amount, date('Y-m-d'), get_user_option('plan_end'), 'Voguepay');

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
                        
                    } else {
                        
                        $this->CI->session->set_flashdata('upgrade', display_mess(106));
                        redirect('user/plans');
                        
                    }
                    
                }   
                
            }
            
        } else {
            
            $this->CI->session->set_flashdata('upgrade', display_mess(106));
            redirect('user/plans');
            
        }

    }

    /**
     * The public method save verifies if the transaction was done successfully and saves it in the database
     * 
     * @return void
     */
    public function info() {

        return [
            'name' => 'Voguepay',
            'slug' => 'voguepay',
            'color' => '#2CA7F0',
            'icon' => base_url() . 'assets/img/voguepay.png',
            'settings' => [[
                    'type' => 'text',
                    'label' => 'Merchant ID',
                    'class' => 'merchant-id'
                ]
            ]
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
    }

}
