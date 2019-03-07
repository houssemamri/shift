<?php
/**
 * Stripe
 *
 * PHP Version 5.6
 *
 * Payment class for Stripe
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
 * Stripe class - allows users to pay via Stripe
 *
 * @category Social
 * @package Midrub
 * @author Scrisoft <asksyn@gmail.com>
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License
 * @link https://www.midrub.com/
 */
class Stripe implements Payments {

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
        if ( !get_option('stripe-token') ) {

            echo display_mess('103');
            exit();

        }
        
       if ( $this->CI->input->post() ) {
           
            $this->CI->form_validation->set_rules('number', 'Card Number', 'trim|required');
            $this->CI->form_validation->set_rules('month', 'Month', 'trim|required');
            $this->CI->form_validation->set_rules('year', 'Year', 'trim|required');
            $this->CI->form_validation->set_rules('cvc', 'CVC', 'trim|required');
            $number = $this->CI->input->post('number');
            $month = $this->CI->input->post('month');
            $year = $this->CI->input->post('year');
            $cvc = $this->CI->input->post('cvc');
            
            // Get the user_id
            $user_id = $this->CI->user->get_user_id_by_username($this->CI->session->userdata['username']);
            
            if ( $this->CI->form_validation->run() != false ) {
                
                $result = [];
                
                require_once FCPATH.'vendor/stm/init.php';
                
                try{
                    
                    \Stripe\Stripe::setApiKey(get_option('stripe-token'));
                    
                    $myCard = array('number' => $number, 'exp_month' => $month, 'exp_year' => $year, 'cvc' => $cvc);
                    
                    $charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => $plan_price*100, 'currency' => $currency_code));
                    
                    if ( $charge ) {
                        
                        $data = json_decode(json_encode($charge));
                        
                        if ( @$data->id ) {
                            
                            $amount = number_format(($data->amount/100),2);
                            
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

                            $amount_value = $amount;

                            if ( $taxes_value ) {

                                $amount_value = number_format(($amount - (($taxes_value / 100) * $amount)), 2);

                            }

                            // If payment was done successfully
                            $invoice_id = $this->CI->invoice->create_invoice( $data->id, $plan_id, date('Y-m-d'), $user_id, $hello_text, $message, $amount_value, $currency_code, $taxes_value, $amount, date('Y-m-d'), get_user_option('plan_end'), 'Stripe' );

                            // Send invoice
                            sends_invoice($invoice_id);
                            
                            $result = ['value' => $amount, 'code' => $currency_code, 'plan_id' => $plan_id, 'tx' => $data->id];
                            
                        }
                        
                    }
                    
                } catch (Exception $ex) {
                    
                    echo $ex->getMessage();
                    exit();
                    
                }
                
                if ( @$result['value'] ) {
                    
                    if ( $this->CI->plans->check_payment($result['value'], $result['code'], $result['plan_id'], $result['tx'], $user_id,'Stripe') ) {
                        
                        $this->CI->session->set_flashdata('upgrade', display_mess(105));
                        
                    } else {
                        
                        $this->CI->session->set_flashdata('upgrade', display_mess(106));
                        
                    }
                    
                    redirect('user/plans');
                    
                } else{
                    
                    $this->CI->session->set_flashdata('upgrade', display_mess(106));
                    redirect('user/plans');
                    
                }
                
            } else {
                
                $this->CI->session->set_flashdata('upgrade', display_mess(106));
                redirect('user/plans');
                
            }
            
        } else {
        
        ?>
                <style>
                    @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600);
                    body {
                        background-color: #fafafa;
                    }
                    .col-xs-2 {
                        width: 16.66666667%;
                        float: left;
                        position: relative;
                        min-height: 1px;
                        padding-right: 15px;
                        padding-left: 15px;
                    }
                    .col-xs-2.small {
                        width: 17.9%;    
                    }
                    .col-xs-3 {
                        width: 25%;
                        float: left;
                        position: relative;
                        min-height: 1px;
                        padding-right: 15px;
                        padding-left: 15px;
                    }
                    .col-xs-5 {
                        width: 41.66666667%;
                        float: left;
                        position: relative;
                        min-height: 1px;
                        padding-right: 15px;
                        padding-left: 15px;
                    }
                    .col-xs-offset-3 {
                        margin-left: 25%;
                        float: left;
                        position: relative;
                        min-height: 1px;
                        padding-right: 15px;
                        padding-left: 15px;
                    }

                    .col-xs-9 {
                        width: 75%;
                        float: left;
                        position: relative;
                        min-height: 1px;
                        padding-right: 15px;
                        padding-left: 15px;
                    }
                    @media (min-width: 1200px) {
                        .col-lg-offset-4 {
                            margin-left: 33.33333333%;
                        }
                    }
                    @media (min-width: 1200px) {
                        .col-lg-4 {
                            width: 33.33333333%;
                        }
                    }
                    .form-group {
                        min-height: 30px;
                    }
                    .form-group {
                        margin-bottom: 15px;
                    }
                    #payment-form{
                        margin-top: 50px;
                        font-family: 'Source Sans Pro', sans-serif;
                        font-weight: 600;
                        font-size: 14px;
                        background-color: #ffffff;
                        border: 1px solid #e0e0e0;
                        padding: 40px 15px 70px;
                        padding-left: 15%;
                    }
                    .form-control {
                        display: block;
                        width: 100%;
                        height: 34px;
                        padding: 6px 12px;
                        font-size: 14px;
                        line-height: 1.42857143;
                        color: #555;
                        background-color: #fff;
                        background-image: none;
                        border: 1px solid #ccc;
                        border-radius: 4px;
                        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                    }
                    #payment-form button {
                        border: none;
                        border-radius: 4px;
                        outline: none;
                        text-decoration: none;
                        color: #fff;
                        background: #32325d;
                        white-space: nowrap;
                        display: inline-block;
                        height: 40px;
                        line-height: 40px;
                        padding: 0 14px;
                        box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
                        border-radius: 4px;
                        font-size: 15px;
                        font-weight: 600;
                        letter-spacing: 0.025em;
                        text-decoration: none;
                        -webkit-transition: all 150ms ease;
                        transition: all 150ms ease;
                        float: left;
                        margin-top: 31px;
                    }
                </style>
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4">
                        <?= form_open(base_url().'user/upgrade/' . $plan_id . '/stripe', ['id' => 'payment-form']) ?>
                            <div class="form-group">
                                <label class="col-xs-3 control-label"><?= $this->CI->lang->line('mu95'); ?></label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" name="fullName" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label"><?= $this->CI->lang->line('mu96'); ?></label>
                                <div class="col-xs-5">
                                    <input type="text" class="form-control" maxlength="16" name="number" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label"><?= $this->CI->lang->line('mu97'); ?></label>
                                <div class="col-xs-2 small">
                                    <input type="text" class="form-control" placeholder="<?= $this->CI->lang->line('mu100'); ?>" maxlength="2" name="month" required />
                                </div>
                                <div class="col-xs-2 small">
                                    <input type="text" class="form-control" placeholder="<?= $this->CI->lang->line('mu101'); ?>" maxlength="4" name="year" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-xs-3 control-label"><?= $this->CI->lang->line('mu98'); ?></label>
                                <div class="col-xs-2">
                                    <input type="text" class="form-control" maxlength="4" name="cvc" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-9 col-xs-offset-3">
                                    <button type="submit" class="btn btn-primary"><?= $this->CI->lang->line('mu99'); ?></button>
                                </div>
                            </div>

                        <?= form_close() ?>
                    </div>
                </div>
            <?php
        }

    }
    
    /**
     * The public method save verifies if the transaction was done successfully and saves it in the database
     * 
     * @return void
     */
    public function save() {
        
    }    

    /**
     * The public method info provides information about the class
     * 
     * @return array with information
     */
    public function info() {
        
        return [
            'name' => 'Stripe',
            'slug' => 'stripe',
            'color' => '#4186cd',
            'icon' => base_url() . 'assets/img/stripe.png',
            'settings' => [[
                'type' => 'text',
                'label' => 'Stripe Secret Key',
                'class' => 'token'
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
