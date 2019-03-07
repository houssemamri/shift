/*
 * Main javascript file
*/

/*
 * Create the main object
 */
var Main = new Object({
    translation: {},
    pagination: {},
    methods: {}
});

jQuery(document).ready( function ($) {
    'use strict';

    /*
     * Display alert
     */
    Main.popup_fon = function( cl, msg, ft, lt ) {

        // Add message
        $('<div class="md-message ' + cl + '"><i class="icon-bell"></i> ' + msg + '</div>').insertAfter('section');

        // Display alert
        setTimeout(function () {

            $( document ).find( '.md-message' ).animate({opacity: '0'}, 500);

        }, ft);

        // Hide alert
        setTimeout(function () {

            $( document ).find( '.md-message' ).remove();

        }, lt);

    };

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