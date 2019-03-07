/*
 * Gateways javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.home-page-link').attr('href');
    
    /*
     * Verify if a coupon code is valid
     */
    $('.verify-coupon-code').submit(function (e) {
        e.preventDefault();
        
        // Set code
        var code = $( '.code' ).val();
        
        if ( $('.gateways').length > 0 ) {
        
            // Set the plan price
            var plan_price = $( '.gateways' ).attr( 'data-price' );       
        
        } else {
        
            // Set the plan price
            var plan_price = $( '.gateways-page .container-fluid' ).attr( 'data-price' );
            
        }
        
        $.ajax({
            url: url + 'user/verify-coupon/' + code,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                
                if ( data ) {
                    
                    // Set discount
                    var discount = plan_price/100*data;
                    
                    // Calculate discount
                    var result = plan_price - discount;
                    
                    // Set new price
                    $( '.plan-price' ).text( result.toFixed(2) );
                    
                    // Set the discount
                    $( '.discount-price' ).text( '(-' + data + '%)' );
                    
                    // Empty current coupon code field
                    $( '.code' ).val( '' );
                    
                    // Display success alert
                    Main.popup_fon('subi', Main.translation.mm217, 1500, 2000);                    
                    
                } else {
                    
                    // Display error alert
                    Main.popup_fon('sube', Main.translation.mm216, 1500, 2000);
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed: ' + textStatus);
                
                // Display error alert
                Main.popup_fon('sube', Main.translation.mm216, 1500, 2000);
                
            }
            
        });
        
    });
 
});