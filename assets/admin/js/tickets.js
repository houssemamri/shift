/*
 * Tickets javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.navbar-brand').attr('href');
    
    /*******************************
    METHODS
    ********************************/
   
    /*
     * Load all faq articles
     * 
     * @param integer page contains the page number
     * @param string type contains the request's type
     * 
     * @since   0.0.7.5
     */    
    Main.load_all_faq_articles =  function (page, type) {
        
        var data = {
            action: 'load_all_faq_articles',
            page: page,
            type: type
        };
        
        data[$('#new-category .create-category').attr('data-csrf')] = $('input[name="' + $('#new-category .create-category').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'load_all_faq_articles');
        
    };
    
    /*
     * Load tickets
     * 
     * @param integer page contains the page number
     * @param string type contains the request's type
     * 
     * @since   0.0.7.5
     */    
    Main.load_tickets =  function (page, type) {
        
        var data = {
            action: 'load_tickets',
            page: page,
            type: type
        };
        
        data[$('#new-category .create-category').attr('data-csrf')] = $('input[name="' + $('#new-category .create-category').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'load_tickets');
        
    };   
    
    /*
     * Load the ticket's replies
     * 
     * @since   0.0.7.5
     */
    Main.load_ticket_replies = function () {
        
        var data = {
            action: 'load_ticket_replies',
            ticket_id: $('.submit-ticket-reply').find('.reply-ticket-id').val()
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'GET', data, 'load_ticket_replies');
        
    };
   
    /*******************************
    RESPONSES
    ********************************/ 
   
    /*
     * Display category creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.create_category = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Display categories
            $('.tickets .categories-list').html(data.categories);
            
            // Reset Form
            $('#new-category form')[0].reset();
            
            var categories = '<option value="0">'
                                + data.select_category
                            + '</option>';
            
            if ( typeof data.categories_list !== 'undefined' ) {
            
                for ( var c = 0; c < data.categories_list.length; c++ ) {
                    
                    if ( data.categories_list[c].parent > 0 ) {
                        continue;
                    }

                    categories += '<option value="' + data.categories_list[c].category_id + '">'
                                    + data.categories_list[c].name
                                + '</option>';

                }
            
            }
            
            $('#new-category select').html(categories);
            
            $( '#faq-select-all-categories' ).prop('checked', false);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display category deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.delete_categories = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Display categories
            $('.tickets .categories-list').html(data.categories);
            
            var categories = '<option value="0">'
                                + data.select_category
                            + '</option>';
            
            if ( typeof data.categories_list !== 'undefined' ) {
            
                for ( var c = 0; c < data.categories_list.length; c++ ) {
                    
                    if ( data.categories_list[c].parent > 0 ) {
                        continue;
                    }

                    categories += '<option value="' + data.categories_list[c].category_id + '">'
                                    + data.categories_list[c].name
                                + '</option>';

                }
            
            }
            
            $('#new-category select').html(categories);
            
            $( '#faq-select-all-categories' ).prop('checked', false);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display article creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.create_new_faq_article = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            var langs = $(document).find('.tab-content .tab-pane');

            for (var e = 0; e < langs.length; e++) {
                $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote('code', '');
            }
            
            $('.new-faq-article .msg-body').val('');
            
            $('.new-faq-article .msg-title').val('');
            
            $( '.new-faq-article .categories-list input[type="checkbox"]' ).prop('checked', false);
            
            $('.new-faq-article .article-status').val(1)
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display article update response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.update_faq_article = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };    
    
    /*
     * Display all faq articles
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.load_all_faq_articles = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            Main.pagination.page = data.page;
            Main.show_pagination('#' + data.type + '-articles', data.total);
            
            var all_articles = '';
            
            for ( var a = 0; a < data.articles.length; a++ ) {
                
                if ( data.articles[a].status < 1 ) {
                    
                    var status = '<span class="ticket-unactive">'
                                    + data.draft
                                + '</span>';
                    
                } else {
                    
                    var status = '<span class="ticket-active">'
                                    + data.published
                                + '</span>';                    
                    
                }
                
                all_articles += '<tr>'
                                    + '<td class="text-center">'
                                        + '<div class="checkbox-option-select">'
                                            + '<input id="faq-' + data.type + '-article-' + data.articles[a].article_id + '" name="faq-' + data.type + '-article-' + data.articles[a].article_id + '" data-id="' + data.articles[a].article_id + '" type="checkbox">'
                                            + '<label for="faq-' + data.type + '-article-' + data.articles[a].article_id + '"></label>'
                                        + '</div>'
                                    + '</td>'
                                    + '<td>'
                                        + '<a href="' + url + 'admin/users#' + data.articles[a].user_id + '">'
                                            + data.articles[a].username
                                        + '</a>'
                                    + '</td>'
                                    + '<td>'
                                        + '<p>'
                                            + '<a href="' + url + 'admin/faq-articles/' + data.articles[a].article_id + '">'
                                                + data.articles[a].title
                                            + '</a>'
                                        + '</p>'
                                    + '</td>'
                                    + '<td class="text-right">'
                                        + status
                                    + '</td>'
                                + '</tr>';
                
            }
            
            // Remove no found class
            $('.tickets #' + data.type + '-articles table').removeClass('no-articles-found');  
            
            // Display faq articles
            $('.tickets #' + data.type + '-articles tbody').html(all_articles);
            
        } else {
            
            var message = '<tr>'
                            + '<td colspan="4">'
                                + '<p>'
                                    + data.message
                                + '</p>'
                            + '</td>'
                        + '</tr>';
                
            // Empty the pagination
            $('.tickets #' + data.type + '-articles .pagination').html('');     

            // Add no found class
            $('.tickets #' + data.type + '-articles table').addClass('no-articles-found');  
            
            // Display no faq articles message
            $('.tickets #' + data.type + '-articles tbody').html(message);            
            
        }

    };
    
    /*
     * Display faq article deletion response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.delete_faq_articles = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Uncheck all
            $( '.tickets #faq-articles-all-articles-select' ).prop('checked', false);
            
            // Reload all articles
            Main.load_all_faq_articles(1, 'all');
            Main.load_all_faq_articles(1, 'unpublished');
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display tickets response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.load_tickets = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            Main.pagination.page = data.page;
            Main.show_pagination('#' + data.type + '-tickets', data.total);
            
            var all_tickets = '';
            
            for ( var a = 0; a < data.tickets.length; a++ ) {
                
                if ( parseInt(data.tickets[a].status) === 0 ) {
                    
                    var status = '<span class="ticket-closed">'
                                    + data.closed
                                + '</span>';    
                    
                } else if ( parseInt(data.tickets[a].status) === 1 ) {
                    
                    var status = '<span class="ticket-active">'
                                    + data.unanswered
                                + '</span>';                    
                    
                } else {
                    
                    var status = '<span class="ticket-unactive">'
                                    + data.answered
                                + '</span>';
                    
                }
                
                var font = '';
                
                if ( parseInt(data.tickets[a].important) === 1 ) {
                    
                    font = ' class="font-weight-bold"';
                    
                }
                
                all_tickets += '<tr>'
                                    + '<td class="text-center">'
                                        + '<div class="checkbox-option-select">'
                                            + '<input id="' + data.type + '-ticket-' + data.tickets[a].ticket_id + '" name="' + data.type + '-ticket-' + data.tickets[a].ticket_id + '" data-id="' + data.tickets[a].ticket_id + '" type="checkbox">'
                                            + '<label for="' + data.type + '-ticket-' + data.tickets[a].ticket_id + '"></label>'
                                        + '</div>'
                                    + '</td>'
                                    + '<td>'
                                        + '<a href="' + url + 'admin/users#' + data.tickets[a].user_id + '">'
                                            + data.tickets[a].username
                                        + '</a>'
                                    + '</td>'
                                    + '<td' + font + '>'
                                        + '<p>'
                                            + '<a href="' + url + 'admin/tickets/' + data.tickets[a].ticket_id + '">'
                                                + data.tickets[a].subject
                                            + '</a>'
                                        + '</p>'
                                    + '</td>'
                                    + '<td class="text-right">'
                                        + status
                                    + '</td>'
                                + '</tr>';
                
            }
            
            // Remove no found class
            $('.tickets #' + data.type + '-tickets table').removeClass('no-tickets-found');  
            
            // Display faq articles
            $('.tickets #' + data.type + '-tickets tbody').html(all_tickets);
            
        } else {
            
            var message = '<tr>'
                            + '<td colspan="4" style="width: 100%;">'
                                + '<p>'
                                    + data.message
                                + '</p>'
                            + '</td>'
                        + '</tr>';
                
            // Empty the pagination
            $('.tickets #' + data.type + '-tickets .pagination').html('');     

            // Add no found class
            $('.tickets #' + data.type + '-tickets table').addClass('no-tickets-found');  
            
            // Display no tickets found message
            $('.tickets #' + data.type + '-tickets tbody').html(message);            
            
        }

    }; 
    
    /*
     * Display important mark response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.mark_as_important = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Load all tickets
            Main.load_tickets(1, 'all');
            
            // Load unanswered tickets
            Main.load_tickets(1, 'unanswered');  

            // Load important tickets
            Main.load_tickets(1, 'important');  
            
            // Uncheck all checkboxes
            $( '.tickets input[type="checkbox"]' ).prop('checked', false);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
     /*
     * Display ticket's replies response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.load_ticket_replies = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
        
            var replies = '';

            for ( var e = 0; e < data.content.length; e++ ) {

                var username = data.content[e].username;

                if ( (data.content[e].first_name !== '') || (data.content[e].last_name !== '') ) {

                    username = data.content[e].first_name + ' ' + data.content[e].last_name;

                }

                // Set time
                var gettime = Main.calculate_time(data.content[e].created, data.cdate);

                replies += '<div class="ticket-reply">'
                                + '<div class="reply_people">'
                                    + '<div class="reply_img">'
                                        + '<img src="' + data.content[e].avatar + '" alt="avatar">'
                                    + '</div>'
                                    + '<div class="reply">'
                                        + '<h5>' + username + ' <span>' + gettime + '</span></h5>'
                                        + '<p>'
                                            + data.content[e].body
                                        + '</p>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';

            }

            // Add replies
            $('.ticket-replies').html(replies);
        
        } else {
            
            // Add no replies message
            $('.ticket-replies').html('<p>' + data.message + '</p>');            
            
        } 
        
    };
    
     /*
     * Display reply creation response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.create_ticket_reply = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset form
            $('.submit-ticket-reply').find('.reply-body').val('');
            
            // Reload ticket's replies
            Main.load_ticket_replies();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }    

    };
    
     /*
     * Display ticket status change response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.5
     */
    Main.methods.set_ticket_status = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Set the text
            $( '.single-ticket .ticket-status' ).text( data.status );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        } 
        
    }; 
   
    /*******************************
    ACTIONS
    ********************************/
   
    /*
     * Detect category deletion
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */
    $(document).on('click', '.tickets .delete-categories', function (e) {
        e.preventDefault();

        // Get all categories
        var categories = $('.tickets .categories-list input[type="checkbox"]');
        
        var selected = [];
        
        // List all categories
        for ( var d = 0; d < categories.length; d++ ) {

            if ( categories[d].checked ) {
                selected.push($(categories[d]).attr('data-id'));
            }
            
        }
        
        var data = {
            action: 'delete_categories',
            categories: Object.entries(selected)
        };
        
        data[$('#new-category .create-category').attr('data-csrf')] = $('input[name="' + $('#new-category .create-category').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'delete_categories');
        
    });
    
    /*
     * Detect all categories selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets #faq-select-all-categories', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.tickets #faq-select-all-categories' ).is(':checked') ) {

                $( '.tickets .categories-list input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.tickets .categories-list input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });
    
    /*
     * Detect all tickets selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets #tickets-select-all', function (e) {

        setTimeout(function(){
            
            if ( $( '.tickets #tickets-select-all' ).is(':checked') ) {

                $( '.tickets #all-tickets tbody input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.tickets #all-tickets tbody input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });    
    
    /*
     * Detect all faq articles selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets #faq-articles-all-articles-select', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.tickets #faq-articles-all-articles-select' ).is(':checked') ) {

                $( '.tickets #all-articles tbody input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.tickets #all-articles tbody input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    }); 
    
    /*
     * Detect all unanswered tickets selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets #tickets-select-unanswered', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.tickets #tickets-select-unanswered' ).is(':checked') ) {

                $( '.tickets #unanswered-tickets tbody input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.tickets #unanswered-tickets tbody input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });  
    
    /*
     * Detect all important tickets selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets #tickets-select-important', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.tickets #tickets-select-important' ).is(':checked') ) {

                $( '.tickets #important-tickets tbody input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.tickets #important-tickets tbody input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    }); 
    
    /*
     * Detect unpublished faq articles selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets #faq-articles-unpublishhed-articles-select', function (e) {
        
        setTimeout(function(){
            
            if ( $( '.tickets #faq-articles-unpublishhed-articles-select' ).is(':checked') ) {

                $( '.tickets #unpublished-articles tbody input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.tickets #unpublished-articles tbody input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });     
   
    /*
     * Delete faq article
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets .delete-faq-articles', function (e) {
        e.preventDefault();
        
        var data = {
            action: 'delete_faq_articles'
        };
        
        // Get all faq articles
        var faq_articles = $(this).closest('.tab-pane').find('tbody input[type="checkbox"]');
        
        var selected = [];
        
        // List all faq articles
        for ( var d = 0; d < faq_articles.length; d++ ) {

            if ( faq_articles[d].checked ) {
                selected.push($(faq_articles[d]).attr('data-id'));
            }
            
        }

        data['articles'] = selected;
        
        data[$('.create-category').attr('data-csrf')] = $('input[name="' + $('.create-category').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'delete_faq_articles');
        
    });
    
    /*
     * Mark tickets as important
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets .mark-as-important', function (e) {
        e.preventDefault();
        
        var data = {
            action: 'mark_as_important'
        };
        
        // Get all tickets
        var tickets = $(this).closest('.tab-pane').find('tbody input[type="checkbox"]');
        
        var selected = [];
        
        // List all tickets
        for ( var d = 0; d < tickets.length; d++ ) {

            if ( tickets[d].checked ) {
                selected.push($(tickets[d]).attr('data-id'));
            }
            
        }

        data['tickets'] = selected;
        
        data[$('.create-category').attr('data-csrf')] = $('input[name="' + $('.create-category').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'mark_as_important');
        
    }); 
    
    /*
     * Remove important mark
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */ 
    $( document ).on( 'click', '.tickets .remove-important-mark', function (e) {
        e.preventDefault();
        
        var data = {
            action: 'remove_important_mark'
        };
        
        // Get all tickets
        var tickets = $(this).closest('.tab-pane').find('tbody input[type="checkbox"]');
        
        var selected = [];
        
        // List all tickets
        for ( var d = 0; d < tickets.length; d++ ) {

            if ( tickets[d].checked ) {
                selected.push($(tickets[d]).attr('data-id'));
            }
            
        }

        data['tickets'] = selected;
        
        data[$('.create-category').attr('data-csrf')] = $('input[name="' + $('.create-category').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'mark_as_important');
        
    });     
    
    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'all-tickets':
                Main.load_tickets(page, 'all');
                break;     
            
            case 'unanswered-tickets':
                Main.load_tickets(page, 'unanswered');
                break; 
            
            case 'important-tickets':
                Main.load_tickets(page, 'important');  
                break;             
            
            case 'all-faq-articles':
                Main.load_all_faq_articles(page, 'all');
                break;    
            
            case 'unpublished-articles':
                Main.load_all_faq_articles(page, 'unpublished');
                break;             
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Change the ticket status
     * 
     * @since   0.0.7.5
     */
    $(document).on('click', '.single-ticket .change-ticket-status a', function (e) {
        e.preventDefault();
        
        // Get the ticket's status
        var status = $(this).attr('data-id');
        
        var data = {
            action: 'set_ticket_status',
            ticket_id: $('.submit-ticket-reply').find('.reply-ticket-id').val(),
            status: status
        };
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'GET', data, 'set_ticket_status');
        
    });
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Create a new plan
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */
    $('#new-category .create-category').submit(function (e) {
        e.preventDefault();
        
        // Get category's parent
        var parent = $(this).find('.category-parent').val();
        
        var data = {
            action: 'create_category',
            parent: parent
        };
        
        // Get all categories
        var categories = $('#new-category .category-name');
        
        // List all categories
        for ( var d = 0; d < categories.length; d++ ) {
            data[$(categories[d]).attr('data-lang')] = $(categories[d]).val();
        }
        
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'create_category');
        
    });
    
    /*
     * Create a faq article
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */
    $('.new-faq-article .create-new-faq-article').submit(function (e) {
        e.preventDefault();
        
        // Get all categories
        var categories = $('.new-faq-article .categories-list input[type="checkbox"]');
        
        var cats = [];
        
        // List all categories
        for ( var d = 0; d < categories.length; d++ ) {

            if ( categories[d].checked ) {
                cats.push($(categories[d]).attr('data-id'));
            }
            
        }
        
        var data = {
            action: 'create_new_faq_article',
            cats: cats,
            status: $('.new-faq-article .article-status').val()
        };
        
        // Get all editors
        var editors = $('.new-faq-article .tab-all-editors > .tab-pane');
        
        // List all categories
        for ( var d = 0; d < editors.length; d++ ) {
            
            data[$(editors[d]).attr('id')] = {
                'title': $(editors[d]).find('.msg-title').val(),
                'body': $(editors[d]).find('#summernote').summernote('code')
            };
            
        }

        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'create_new_faq_article');
        
    });
    
    /*
     * Update a faq article
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */
    $('.single-faq-article .update-faq-article').submit(function (e) {
        e.preventDefault();
        
        // Get all categories
        var categories = $('.single-faq-article .categories-list input[type="checkbox"]');
        
        var cats = [];
        
        // List all categories
        for ( var d = 0; d < categories.length; d++ ) {

            if ( categories[d].checked ) {
                cats.push($(categories[d]).attr('data-id'));
            }
            
        }
        
        var data = {
            action: 'update_faq_article',
            cats: cats,
            status: $('.single-faq-article .article-status').val(),
            article_id: $('.single-faq-article .save-article').attr('data-id')
        };
        
        // Get all editors
        var editors = $('.single-faq-article .tab-all-editors > .tab-pane');
        
        // List all categories
        for ( var d = 0; d < editors.length; d++ ) {
            
            data[$(editors[d]).attr('id')] = {
                'title': $(editors[d]).find('.msg-title').val(),
                'body': $(editors[d]).find('#summernote').summernote('code')
            };
            
        }

        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'update_faq_article');
        
    });
    
    /*
     * Create a ticket's reply
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.5
     */
     $(document).on('submit', '.submit-ticket-reply', function (e) {
        e.preventDefault();
        
        // Create an object with form data
        var data = {
            action: 'create_ticket_reply',
            body: $(this).find('.reply-body').val(),
            ticket_id: $(this).find('.reply-ticket-id').val()
        };
        
        // Set CSRF
        data[$(this).attr('data-csrf')] = $('input[name="' + $(this).attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'admin/ajax/faq', 'POST', data, 'create_ticket_reply');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    }); 
    
    /*******************************
    DEPENDENCIES
    ********************************/
   
    if ($('#new-category').length > 0) {
        
        // Load all tickets
        Main.load_tickets(1, 'all');
        
        // Load unanswered tickets
        Main.load_tickets(1, 'unanswered');  
        
        // Load important tickets
        Main.load_tickets(1, 'important');         

        // Load all faq articles
        Main.load_all_faq_articles(1, 'all');

        // Load unpublished faq articles
        Main.load_all_faq_articles(1, 'unpublished');

    } else if ($('.new-faq-article').length > 0) {

        var langs = $(document).find('.tab-content .tab-pane');

        for (var e = 0; e < langs.length; e++) {

            $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote();

        }

    } else if ($('.single-faq-article').length > 0) {

        var langs = $(document).find('.tab-content .tab-pane');

        for (var e = 0; e < langs.length; e++) {

            $('.' + $(langs[e]).find('.summernote-body').attr('data-dir')).summernote('code', $(langs[e]).find('.msg-body').val());

        }

    } else if ($('.single-ticket').length > 0) {

        Main.load_ticket_replies();

    }
 
});