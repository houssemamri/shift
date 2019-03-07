/*
 * Auth javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get the login url
    var url = $('.logourl').attr('href');
    
    // Sign in
    $('.signin').submit(function (e) {
        e.preventDefault();
        
        var remember = 0;
        
        // Check if remember checkbox is checked
        if ( $('#remember').is(':checked') ) {    
            remember = 1;
        }
        
        var name = $('input[name="csrf_test_name"]').val();
        
        // Create an object with form data
        var data = {
            username: $('.username').val(),
            password: $('.password').val(),
            remember: remember,
            csrf_test_name: name
        };
        
        // Submit data via ajax
        $.ajax({
            url: url + 'auth/',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                
                $('.btn-sign').after(data);
                $('.merror').fadeIn(1000).delay(3000).fadeOut(1000, function () {
                    
                    $('.merror').remove();
                    
                });
                
                $('.msuccess').fadeIn(1000).delay(3000).fadeOut(1000, function () {
                    
                    $('.msuccess').remove();
                    document.location.href = url + 'user/app/dashboard';
                    
                });
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed:' + textStatus);
                
            }
            
        });
        
    });
    
    $('.signup').submit(function (e) {
        e.preventDefault();
        
        // Get csrf data
        var name = $('input[name="csrf_test_name"]').val();
        
        // Create an object with form data
        var data = {
            first_name: $('.first-name').val(),
            last_name: $('.last-name').val(),
            username: $('.username').val(),
            password: $('.password').val(),
            email: $('.email').val(),
            plan_id: $('.midrub-plan-id').val(),
            csrf_test_name: name
        };
        
        // Submit data via ajax
        $.ajax({
            url: url + 'register/',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                
                $('.btn-signup').after(data);
                $('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    
                    $('.merror').remove();
                    
                });
                
                $('.msuccess').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    
                    $('.msuccess').remove();
                    document.location.href = url + 'auth/members';
                    
                });
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed:' + textStatus);
                
            }
            
        });
        
    });
    
    $('.reset').submit(function (e) {
        e.preventDefault();
        
        var name = $('input[name="csrf_test_name"]').val();
        
        // submit data via ajax
        var data = {
            email: $('.email').val(),
            csrf_test_name: name
        };
        
        $.ajax({
            url: url + 'password-reset/',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                console.log(data);
                $('.btn-recover').after(data);
                
                $('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    $('.merror').remove();
                });
                
                $('.msuccess').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    $('.msuccess').remove();
                });
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed:' + textStatus);
                
            }
            
        });
        
    });
    
    $('.password').on('click',function () {
        $('.rem').fadeIn('slow');
    });
    
    $('.resend-confirmation').click(function (e) {
        e.preventDefault();
        
        var name = $('input[name="csrf_test_name"]').val();
        
        var url = $(this).attr('data-url');
        
        // Resend confirmation link
        $.ajax({
            url: url + 'resend-confirmation/',
            type: 'POST',
            dataType: 'json',
            data: {'csrf_test_name': name},
            success: function (data) {
                
                $('.resend-confirmation').after(data);
                $('.alert-danger').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    $('.alert-danger').remove();
                });
                
                $('.alert-info').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    $('.alert-info').remove();
                });
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
            }
        });
    });
    
    function setCookie(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }
    
    if ( getCookie('cookie-agree') ) {

        $('.cookie-window').hide();

    } else {
        
        $('.cookie-window').show();
        
    }
    
    $('.cookie-button').on('click',function (e) {
        e.preventDefault();
        setCookie('cookie-agree', 1);
        $('.cookie-window').hide();
    });

});