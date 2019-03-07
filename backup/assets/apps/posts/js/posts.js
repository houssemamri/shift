/*
 * Posts javascript file
*/

jQuery(document).ready( function ($) {
    'use strict';
    
    // Get home page url
    var url = $('.home-page-link').attr('href');
    
    /*******************************
    METHODS
    ********************************/
   
    /*
     * Quick schedule post
     * 
     * @param integer start
     * @param integer end
     * @param boolean allDay
     * 
     * @since   0.0.7.0
     */    
    Main.quickSchedule = function(start, end, allDay) {
        
        var dt = new Date( start._d );
        
        $( '.scheduler-quick-date' ).val( dt.getFullYear() + '-' + (((dt.getMonth() + 1) < 10) ? '0' : '') + (dt.getMonth() + 1) + '-' + ((dt.getDate() < 10) ? '0' : '') + dt.getDate() );
        
        $('#planner-quick-schedule-modal').modal({
            backdrop: 'static'
        });
        
        Main.planner_quick_schedule_load_medias(1);
        
        Main.quick_schedule = {
            medias_page: 1
        };
        
    };
    
    /*
     * Get content by url
     * 
     * @param string geturl contains the url
     * 
     * @since   0.0.7.0
     */ 
    Main.get_page_content_by_url = function(geturl) {
        
        var data = {
            url: geturl
        };

        data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call( url + 'user/content-from-url', 'POST', data, 'composer_display_url_preview');
        
    };
    
    /*
     * Verify if a text has urls
     * 
     * @param string text contains the text
     * 
     * @since   0.0.7.0
     */ 
    Main.verify_for_url = function(text) {
        
        var urlRegex = /(https?:\/\/[^\s]+)/g;

        return text.replace(urlRegex, function (url) {
            
            var links = '';

            var urls = url.split('http');
            
            for ( var d = 0; d < urls.length; d++ ) {
                
                var verify = urls[d].split('<br>');

                var link = verify[0];

                if ( link ) {
                    
                    links += 'http' + link + '<br>';
                    
                    if ( typeof verify[1] !== 'undefined' ) {
                        links += verify[1];
                    }

                    if (typeof Main.selected_post_url === 'undefined' && (d + 1) === urls.length ) {

                        Main.selected_post_url = 'http' + link;
                        Main.get_page_content_by_url('http' + link);

                    } else {

                        if ( Main.selected_post_url !== 'http' + link && (d + 1) === urls.length ) {
                            Main.selected_post_url = 'http' + link;
                            Main.get_page_content_by_url('http' + link);
                        }

                    }
                    
                }
                
            }
            
            return links;
            
        });

    };
    
    /*
     * Replace url with html content
     * 
     * @param string content contains full content
     * @param string url contains url to replace
     * @param string data contais the html
     * 
     * @since   0.0.7.0
     */
    Main.replace_url = function(content, url, data) {
        var new_exp_match = url;
        var new_content = content.replace(new_exp_match, data);
        return new_content;
    };
    
    /*
     * Display posts by page in the composer tab
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.0
     */
    Main.composer_all_posts = function (page) {
        
        var data = {
            action: 'composer_display_all_posts',
            key: $( '.composer-search-for-saved-posts' ).val(),
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'composer_display_all_posts');
        
    };
    
    /*
     * Display accounts by page in the insights tab
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.0
     */
    Main.insights_all_posts = function (page) {
        
        var data = {
            action: 'insights_display_all_posts',
            key: $( '.insights-search-for-posts' ).val(),
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_display_all_posts');
        
    };     
    
    /*
     * Display accounts by page in the insights tab
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.0
     */
    Main.insights_all_accounts = function (page) {
        
        var data = {
            action: 'insights_display_all_accounts',
            key: $( '.insights-search-for-accounts' ).val(),
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_display_all_accounts');
        
    };     
    
    /*
     * Display posts by page in the composer tab
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.0
     */
    Main.history_all_posts = function (page) {
        
        var data = {
            action: 'composer_display_all_posts',
            key: $( '.history-search-for-posts' ).val(),
            page: page
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'history_display_all_posts');
        
    };
    
    /*
     * Display medias in the quick schedule popup
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.0
     */
    Main.planner_quick_schedule_load_medias = function (page) {
        
        // Prepare data to send
        var data = {
            action: 'get_media',
            page: page
        };
        
        $.ajax({
            url: url + 'user/ajax/media',
            dataType: 'json',
            type: 'GET',
            data: data,
            success: function (data) {
                
                if ( data.success ) {
                    
                    if ( Main.quick_schedule.medias_page === page && page === 1 ) {
                        $( '.multimedia-gallery-quick-schedule ul' ).empty();
                    }
                    
                    var medias = '';
                    
                    for ( var m = 0; m < data.medias.length; m++ ) {
                        
                        medias += '<li>'
                                    + '<a href="#" data-url="' + data.medias[m].body + '" data-id="' + data.medias[m].media_id + '" data-type="' + data.medias[m].type + '">'
                                        + '<img src="' + data.medias[m].cover + '">'
                                        + '<i class="icon-check"></i>'
                                    + '</a>'
                                + '</li>';
                        
                    }
                    
                    $( '.multimedia-gallery-quick-schedule ul' ).append(medias);
                    
                    $( 'body .no-medias-found' ).css( 'display', 'none' );
                    
                    Main.quick_schedule.medias_page = page;
                    
                    if ( ( Main.quick_schedule.medias_page * 16 ) < data.total ) {
                        $( '.multimedia-gallery-quick-schedule-load-more-medias' ).css( 'display', 'flow-root' );
                    } else {
                        $( '.multimedia-gallery-quick-schedule-load-more-medias' ).css( 'display', 'none' );
                    }
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                $( '.multimedia-gallery-quick-schedule ul' ).empty();
                $( 'body .no-medias-found' ).css('display', 'flow-root');
            }
            
        });
        
    };
    
    /*
     * Display scheduled posts
     * 
     * @param integer start contains start date
     * @param integer end contains the end date
     * 
     * @since   0.0.7.0
     */
    Main.scheduled_events = function (start,end) {
        
        var data = {
            action: 'scheduler_display_all_posts',
            start: start,
            end: end
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'scheduler_display_all_posts');
        
    };
    
    /*
     * Load Posts content
     * 
     * @since   0.0.7.0
     */
    Main.load_posts_content = function () {
        
        if ( $('#nav-composer').length > 0 ) {
            Main.composer_all_posts(1);
        }

        if ( $('#scheduled-posts').length > 0 ) {
            $('#planner-posts-scheduled-modal').modal('hide');
            $('#calendar').fullCalendar('removeEventSources'); 
            var parsed_date = new Date();
            var new_date = new Date(Date.parse(parsed_date.getFullYear() + '-' + (parsed_date.getMonth() + 1) + '-01 00:00:00'));
            var start = new_date.getTime()/1000;

            Main.scheduled_events(start,(start+3456000)); 
            
        }

        if ( $('#nav-insights').length > 0 ) {
            Main.insights_all_posts(1);
            Main.insights_all_accounts(1);
        }

        if ( $('#nav-history').length > 0 ) {
            Main.history_all_posts(1);
        }
        
    };
    
    /*
     * Load RSS Feeds
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.4
     */
    Main.load_rss_feeds = function ( page ) {
        
        // Verify if the RSS's tab is enabled
        if ( $( '#nav-rss' ).length > 0 ) {
            
            var data = {
                action: 'load_rss_feeds',
                key: $('.search-for-rss-feeds').val(),
                page: page
            };
            
            data[$('.register-new-rss-feed').attr('data-csrf')] = $('input[name="' + $('.register-new-rss-feed').attr('data-csrf') + '"]').val();

            // Make ajax call
            Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'load_rss_feeds');
            
        }
        
    };    
    
    /*
     * Display Insights Graph
     * 
     * @since   0.0.7.0
     * 
     * @param string id contains id
     * @param array data contains the insights data
     */
    Main.display_insights_graph = function (id, data) {
        
        if ( typeof data === 'undefined' ) {
            return;
        }
        
        var densityCanvas = document.getElementById(id);
        
        var labels = [];
        
        var values = [];
        
        var backgrounds = [];
        
        var borders = [];
        
        if ( data.length > 0 ) {
            
            for ( var l = 0; l < data.length; l++ ) {
                
                // Add label
                labels.push(data[l].name);
                
                // Add values
                values.push(data[l].value);
                
                // Add color
                backgrounds.push(data[l].background_color);
                
                // Add color
                borders.push(data[l].border_color);
                
            }
            
        }

        var densityData = {
            label: 'Insights',
            data: values,
            backgroundColor: backgrounds,
            borderColor: borders,
            borderWidth: 0,
            hoverBorderWidth: 0
        };

        var chartOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        padding: 5,
                        fontColor: "rgba(0,0,0,0.7)",
                        font: "14px Arial",
                        beginAtZero: true,
                        suggestedMax: 10
                    },
                    gridLines: {
                        color: 'transparent'
                    },
                    categoryPercentage:.8,
                    offset:!0,
                    barPercentage: 0.7
                }],
                xAxes: [{
                    gridLines: {
                        zeroLineWidth: 0.3,
                        color: "rgba(0, 0, 0, 0.05)"
                    },
                    ticks: {
                        fontColor: "rgba(0,0,0,0.7)",
                        font: "14px Arial",
                        beginAtZero: true,
                        suggestedMax: 10,
                        zeroLineColor: "rgba(0, 0, 0, 0.05)"
                    },
                    barPercentage: 0.7
                }]
            },
            legend: {
                display: false
            },
            elements: {
                rectangle: {
                    borderSkipped: 'left'
                }
            }
        };
        
        Chart.plugins.register({
            beforeDraw: function (chartInstance) {
                var ctx = chartInstance.chart.ctx;
                ctx.fillStyle = "white";
                ctx.fillRect(0, 0, chartInstance.chart.width, chartInstance.chart.height);
            }
        });

        var barChart = new Chart(densityCanvas, {
            type: 'horizontalBar',
            data: {
                labels: labels,
                datasets: [densityData],
            },
            options: chartOptions
        });
        
    };
    
    /*
     * Display Reactions
     * 
     * @since   0.0.7.0
     * 
     * @param array all_reactions contains all reactions
     * @param integer network_id contains the network's id
     * @param array configuration contains the network configuration
     */
    Main.display_insights_reactions = function (all_reactions, network_id, configuration) {

        var get_reactions = all_reactions;

        // Get current time
        var date = new Date(); 
        var cdate = date.getTime()/1000;

        var reactions = '<div class="panel-footer">';

        var panel_footer_head = '';

        for( var h = 0; h < get_reactions.length; h++ ) {

            var status = '';
            var selected = 'false';

            if ( panel_footer_head === '' ) {
                status = ' active';
                selected = 'true';
            }

            panel_footer_head += '<li class="nav-item">'
                                    + '<a class="nav-link' + status + '" id="' + get_reactions[h].slug + '-' + get_reactions[h].post_id + '-nav-tab" data-toggle="tab" href="#' + get_reactions[h].slug + '-' + get_reactions[h].post_id + '-tab" role="tab" aria-controls="' + get_reactions[h].slug + '-' + get_reactions[h].post_id + '-tab" aria-selected="' + selected + '">'
                                        + get_reactions[h].name
                                    + '</a>'
                                + '</li>';

        }

        reactions += '<div class="row">'
                        + '<div class="col-xl-12">'
                            + '<ul class="nav nav-tabs" id="myTab" role="tablist">'
                                + panel_footer_head
                            + '</ul>'
                        + '</div>'
                    + '</div>';
            
        reactions += '<div class="tab-content" id="myTabContent">';

        for( var i = 0; i < get_reactions.length; i++ ) {

            var status = '';

            if ( i === 0 ) {
                status = ' show active';
            }
            
            reactions += '<div class="tab-pane fade' + status + '" id="' + get_reactions[i].slug + '-' + get_reactions[i].post_id + '-tab" role="tabpanel" aria-labelledby="' + get_reactions[i].slug + '-' + get_reactions[i].post_id + '-tab">';

            if ( Array.isArray( get_reactions[i].response ) === true ) {

                reactions += '<ul class="comments">';

                for ( var a = 0; a < get_reactions[i].response.length; a++ ) {

                    if ( get_reactions[i].response[a].created_time ) {

                        // Get post's time
                        var d = new Date(get_reactions[i].response[a].created_time); 
                        var new_date = d.getTime()/1000;

                        // Set time
                        var gettime = Main.calculate_time(new_date, cdate);

                    } else {

                        var gettime = '';

                    }

                    // Create the replies variable
                    var replies = '';
                    
                    if ( typeof get_reactions[i].response[a].replies !== 'undefined' ) {

                        if ( typeof get_reactions[i].response[a].replies !== 'undefined' ) {

                            replies += '<ul class="comments-replies">';

                            for( var s = 0; s < get_reactions[i].response[a].replies.length; s++ ) {

                                // Get post's time
                                var r = new Date(get_reactions[i].response[a].replies[s].created_time); 
                                var reply_date = r.getTime()/1000;

                                // Set time
                                var getreplytime = Main.calculate_time(reply_date, cdate);

                                var reply = '';

                                if (get_reactions[i].reply) {
                                    reply = '<a href="#" class="insights-posts-comments-reply" data-toggle="modal" data-target="#insights-reply-comments" data-type="' + get_reactions[i].slug + '" data-post-id="' + network_id + '" data-id="' + get_reactions[i].response[a].replies[s].id + '">' + configuration.words.reply + '</a>';
                                }

                                var delete_it = '';

                                if (get_reactions[i].delete) {
                                    delete_it = '<a href="#" class="insights-accounts-comments-delete" data-type="' + get_reactions[i].slug + '" data-post-id="' + network_id + '" data-id="' + get_reactions[i].response[a].replies[s].id + '">' + configuration.words.delete + '</a>';
                                }                                    

                                replies += '<li class="row">'
                                                + '<div class="col-xl-12">'
                                                    + '<img src="' + get_reactions[i].response[a].replies[s].from.user_picture + '" alt="User Avatar" class="img-circle" />'
                                                    + '<div class="comment-body">'
                                                        + '<strong><a href="' + get_reactions[i].response[a].replies[s].from.link + '" target="_blank">' + get_reactions[i].response[a].replies[s].from.name + '</a></strong>'
                                                        + '<small>'
                                                            + getreplytime
                                                        + '</small>'
                                                        + '<p>'
                                                            + get_reactions[i].response[a].replies[s].message
                                                        + '</p>'
                                                        + '<p>'
                                                            + reply
                                                            + delete_it
                                                        + '</p>'
                                                    + '</div>'
                                                + '</div>'
                                            + '</li>'                            

                            }

                            replies += '</ul>';

                        }
                    
                    }

                    var reply = '';

                    if (get_reactions[i].reply) {
                        reply = '<a href="#" class="insights-posts-comments-reply" data-toggle="modal" data-target="#insights-reply-comments" data-type="' + get_reactions[i].slug + '" data-post-id="' + network_id + '" data-id="' + get_reactions[i].response[a].id + '">' + configuration.words.reply + '</a>';
                    }

                    var delete_it = '';

                    if (get_reactions[i].delete) {
                        delete_it = '<a href="#" class="insights-accounts-comments-delete" data-type="' + get_reactions[i].slug + '" data-post-id="' + network_id + '" data-id="' + get_reactions[i].response[a].id + '">' + configuration.words.delete + '</a>';
                    }

                    reactions += '<li class="row">'
                                    + '<div class="col-xl-12">'
                                        + '<img src="' + get_reactions[i].response[a].from.user_picture + '" alt="User Avatar" class="img-circle" />'
                                        + '<div class="comment-body">'
                                            + '<strong><a href="' + get_reactions[i].response[a].from.link + '" target="_blank">' + get_reactions[i].response[a].from.name + '</a></strong>'
                                            + '<small>'
                                                + gettime
                                            + '</small>'
                                            + '<p>'
                                                + get_reactions[i].response[a].message
                                            + '</p>'
                                            + '<p>'
                                                + reply
                                                + delete_it
                                            + '</p>'
                                        + '</div>'
                                    + '</div>'
                                    + replies
                                + '</li>';

                }

                reactions += '</ul>';

            } else {

                reactions += '<p class="no-data-found">' + get_reactions[i].response + '</p>';

            }

            if (get_reactions[i].form) {

                reactions += '<div class="panel-sub-footer">'
                                + '<form method="post" class="insights-posts-reactions-post" data-type="' + get_reactions[i].slug + '" data-id="' + get_reactions[i].post_id + '">'
                                    + '<div class="input-group">'
                                        + '<textarea class="form-control input-sm reactions-msg" placeholder="' + get_reactions[i].placeholder + '"></textarea>'
                                        + '<span class="input-group-btn">'
                                            + '<button class="btn btn-warning btn-sm" type="submit" id="btn-chat">'
                                                + '<i class="icon-cursor"></i>'
                                            + '</button>'
                                        + '</span>'
                                    + '</div>'
                                + '</form>'
                            + '</div>';

            }

            reactions += '</div>';

        }
        
        reactions += '</div></div>';
            
        return reactions;
        
    };
    
    /*
     * Load network's accounts
     * 
     * @since   0.0.7.0
     * 
     * @param string type contains the tab name
     * 
     * @param string network contains the network's name
     */
    Main.account_manager_get_accounts = function (network, type) {
        
        var data = {
            action: 'account_manager_get_accounts',
            network: network,
            type: type
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'account_manager_get_accounts');
        
    };
    
    /*
     * Load available networks
     * 
     * @since   0.0.7.0
     */
    Main.account_manager_load_networks = function () {
        
        var data = {
            action: 'account_manager_load_networks'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'account_manager_load_networks');
        
    };
    
    /*
     * Reload accounts
     * 
     * @since   0.0.7.0
     */
    Main.reload_accounts = function () {
        
        var network = $('#nav-accounts-manager').find('.network-selected a').attr('data-network');
        
        $('.manage-accounts-all-accounts').empty();
        
        Main.account_manager_get_accounts(network, 'accounts_manager');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    };    
    
    /*
     * Load the accounts for composer
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.6
     */
    Main.composer_search_accounts = function (page) {
        
        var data = {
            action: 'composer_search_accounts',
            key: $('.main #nav-composer .composer-search-for-accounts').val(),
            page: page
        };
        
        // Set CSRF
        data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'composer_accounts_results_by_search');
        
    };
    
    /*
     * Load the groups for composer
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.6
     */
    Main.composer_search_groups = function (page) {
        
        var data = {
            action: 'composer_search_groups',
            key: $('.main #nav-composer .composer-search-for-groups').val(),
            page: page
        };

        // Set CSRF
        data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'composer_groups_results_by_search');
        
    };
    
    /*
     * Load the accounts for quick scheduler
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.6
     */
    Main.quick_scheduler_search_accounts = function (page) {
        
        var data = {
            action: 'composer_search_accounts',
            key: $( '#planner-quick-schedule-modal .quick-scheduler-search-for-accounts' ).val(),
            page: page
        };

        // Set CSRF
        data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();

        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'quick_scheduler_accounts_results_by_search');
        
    };    
    
    /*
     * Load the groups for quick scheduler
     * 
     * @param integer page contains the page number
     * 
     * @since   0.0.7.6
     */
    Main.quick_scheduler_search_groups = function (page) {
        
        var data = {
            action: 'composer_search_groups',
            key: $('#planner-quick-schedule-modal .quick-scheduler-search-for-groups').val(),
            page: page
        };
        
        // Set CSRF
        data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'quick_scheduler_groups_results_by_search');
        
    };
    
    /*******************************
    ACTIONS
    ********************************/
   
    /*
     * Add post title to preview
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.composer-title input[type="text"]', function () {
        
        // Add post title preview
        $( '.post-preview-title' ).html( '<div class="row">' + $(this).val() + '</div>' );
        
    });
    
    /*
     * Count characters in the quick schedule popup
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '#planner-quick-schedule-modal .quick-new-post', function () {
        
        // Verify if character count is enabled
        if ( $('#planner-quick-schedule-modal .numchar').length > 0 ) {
            $('#planner-quick-schedule-modal .numchar').text($(this).val().length);
        }
        
    });
    
    /*
     * Search for accounts in the composer tab
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.composer-search-for-accounts', function () {
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.composer-cancel-search-for-accounts' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.composer-cancel-search-for-accounts' ).fadeIn('slow');
            
        }
        
        // Load accounts
        Main.composer_search_accounts(1);
        
    });
    
    /*
     * Search for groups in the composer tab
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.composer-search-for-groups', function () {
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.composer-cancel-search-for-accounts' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.composer-cancel-search-for-accounts' ).fadeIn('slow');
            
        }
        
        Main.composer_search_groups(1);
        
    });    
    
    /*
     * Search for accounts in the quick scheduler popup
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.quick-scheduler-search-for-accounts', function () {
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.quick-scheduler-cancel-search-for-accounts' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.quick-scheduler-cancel-search-for-accounts' ).fadeIn('slow');
            
        }
        
        // Load accounts in the quick scheduler modal
        Main.quick_scheduler_search_accounts(1);
        
    });
    
    /*
     * Search for groups in the quick scheduler popup
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.quick-scheduler-search-for-groups', function () {
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.quick-scheduler-cancel-search-for-accounts' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.quick-scheduler-cancel-search-for-accounts' ).fadeIn('slow');
            
        }
        
        // Load groups
        Main.quick_scheduler_search_groups(1);
        
    });    
    
    /*
     * Search for posts in the insights tab
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.insights-search-for-posts', function () {
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.insights-cancel-search-for-posts' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.insights-cancel-search-for-posts' ).fadeIn('slow');
            
        }
        
        Main.insights_all_posts(1);
        
    });     
    
    /*
     * Search for accounts in the insights tab
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.insights-search-for-accounts', function () {
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.insights-cancel-search-for-accounts' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.insights-cancel-search-for-accounts' ).fadeIn('slow');
            
        }
        
        Main.insights_all_accounts(1);
        
    });     
    
    /*
     * Search for posts in the history tab
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.history-search-for-posts', function () {
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.history-cancel-search-for-posts' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.history-cancel-search-for-posts' ).fadeIn('slow');
            
        }
        
        Main.history_all_posts(1);
        
    });    
    
    /*
     * Search for saved posts
     * 
     * @since   0.0.7.0
     */
    $(document).on('keyup', '.composer-search-for-saved-posts', function () {
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.composer-cancel-search-for-posts' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.composer-cancel-search-for-posts' ).fadeIn('slow');
            
        }
        
        // Get posts by search
        Main.composer_all_posts(1);
        
    });
    
    /*
     * Search for accounts in the accounts manager popup
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */ 
    $( document ).on( 'keyup', 'main .accounts-manager-search-for-accounts', function (e) {
        e.preventDefault();
        
        // Verify if search is in the accounts tab
        if ( $(this).closest('.tab-pane').attr('id') === 'nav-accounts-manager' ) {
            
            // Get network
            var network = $('#nav-accounts-manager').find('.network-selected a').attr('data-network');
            
            // Get search keys
            var key = $('#nav-accounts-manager').find('.accounts-manager-search-for-accounts').val();
            
            // Display cancel search icon
            $(this).closest( '.row' ).find( '.cancel-accounts-manager-search' ).fadeIn( 'slow' );
            
            var data = {
                action: 'account_manager_search_for_accounts',
                network: network,
                key: key,
                type: 'accounts_manager'
            };
            
            // Set CSRF
            data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();

            // Make ajax call
            Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'account_manager_search_for_accounts');
            
        } else if ( $(this).closest('.tab-pane').attr('id') === 'nav-groups-manager' ) {
            
            // Get network
            var network = $('#nav-groups-manager').find('.network-selected a').attr('data-network');
            
            // Get search keys
            var key = $('#nav-groups-manager').find('.accounts-manager-search-for-accounts').val();
            
            // Display cancel search icon
            $(this).closest( '.row' ).find( '.cancel-accounts-manager-search' ).fadeIn( 'slow' );

            var data = {
                action: 'account_manager_search_for_accounts',
                network: network,
                key: key,
                type: 'groups_manager'
            };
            
            // Set CSRF
            data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();

            // Make ajax call
            Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'account_manager_search_for_accounts');
            
        }
        
    });
   
    /*
     * Search for RSS Feeds in the RSS's tab
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.4
     */ 
    $( document ).on( 'keyup', 'main .search-for-rss-feeds', function (e) {
        e.preventDefault();
        
        if ( $( this ).val() === '' ) {
            
            // Hide cancel search button
            $( '.rss-cancel-search-for-feeds' ).fadeOut('slow');
            
        } else {
         
            // Display cancel search button
            $( '.rss-cancel-search-for-feeds' ).fadeIn('slow');
            
        }
        
        Main.load_rss_feeds(1);
        
    });
    
    /*
     * Detect new post change
     * 
     * @since   0.0.7.0
     */
    $(document).on('change', '.new-post', function () {
        
        // Get content
        var content = $('.new-post').val();

        // Add links
        var post = Main.verify_for_url(content.replace(/\n/g, '<br>'));
        
        // Verify if a url was selected before
        if ( typeof Main.selected_post_url !== 'undefined' ) {

            if ( post.search(Main.selected_post_url) < 0 ) {
                
                delete Main.selected_post_url;
                
            }
            
        }

        // Add post body preview
        $('.post-preview-body').html('<div class="row">' + post + '</div>');

        // Verify if character count is enabled
        if ($('#nav-composer .numchar').length > 0) {
            $('#nav-composer .numchar').text(content.length);
        }
        
    });
    
    /*
     * Detect when accounts manager is closed
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */
    $('#accounts-manager-popup').on('hidden.bs.modal', function (e) {
        
        // Hide cancel search button
        $( '.composer-cancel-search-for-accounts' ).fadeOut('slow');        
        
        if ( $('.main #nav-composer .composer-search-for-groups').length > 0 ) {
            
            $('.main #nav-composer .composer-search-for-groups').val('');
        
            // Loads groups
            Main.composer_search_groups(1);
        
        } else {
            
            $('.main #nav-composer .composer-search-for-accounts').val('');

            // Load accounts
            Main.composer_search_accounts(1);
        
        }
        
        // Reload Insights accounts
        if ( $('#nav-insights').length > 0 ) {
            
            // Hide cancel search button
            $( '.insights-cancel-search-for-accounts' ).fadeOut('slow');              
            $('.insights-search-for-accounts').val('');
            Main.insights_all_accounts(1);
            
        }
        
        // Reload the quick scheduler accounts
        if ( $('#planner-quick-schedule-modal').length > 0 ) {
            
            // Empty the search input
            $( '#planner-quick-schedule-modal .quick-scheduler-search-for-accounts' ).val('');
            
            // Load accounts in the quick scheduler modal
            Main.quick_scheduler_search_accounts(1);
            
        }        
        
    });
    
    /*
     * Select account in the composer tab
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.composer-accounts-list li a', function (e) {
        e.preventDefault();
        
        // Verify if selected_post_accounts is defined
        if ( typeof Main.selected_post_accounts === 'undefined' ) {
            Main.selected_post_accounts = {};
        }
        
        // Get network
        var network = $( this ).attr( 'data-network' );
        
        // Get category option
        var category = $( this ).attr( 'data-category' );        
        
        // Get account's id
        var network_id = $( this ).attr( 'data-id' );
        
        // Get net's id
        var net_id = $( this ).attr( 'data-net' );

        // Verify if account was selected
        if ( $( this ).closest( 'li' ).hasClass( 'account-selected' ) ) {

            if ( typeof Main.categories !== 'undefined' ) {

                if ( typeof Main.categories[network_id] !== 'undefined' ) {

                    delete Main.categories[network_id];

                }
            
            }

            var post_accounts = JSON.parse(Main.selected_post_accounts[network]);

            if ( post_accounts.length ) {
                
                delete Main.selected_post_accounts[network];
                
                for (var d = 0; d < post_accounts.length; d++) {

                    if ( post_accounts[d] === network_id ) {
                        
                        var selected = $( '.post-preview-footer a[data-id="' + post_accounts[d] + '"]' );
                        
                        selected.closest( 'li' ).remove();
                        
                        delete post_accounts[d];
                        
                    } else {
                        
                        if ( typeof Main.selected_post_accounts[network] !== 'undefined' ) {

                            var extract = JSON.parse(Main.selected_post_accounts[network]);

                            if ( extract.indexOf(post_accounts[d]) < 0 ) {

                                extract[extract.length] = post_accounts[d];
                                Main.selected_post_accounts[network] = JSON.stringify(extract);

                            }

                        } else {

                            Main.selected_post_accounts[network] = JSON.stringify([post_accounts[d]]);

                        }
                        
                    }

                }

            }
            
            $( this ).closest( 'li' ).removeClass( 'account-selected' );
            
        } else {
            
            if ( category === 'true' ) {
                
                $('#composer-category-picker').attr('data-id', network_id);
                
                var data = {
                    action: 'composer_get_categories',
                    network: network,
                    account_id: net_id
                };

                // Make ajax call
                Main.ajax_call(url + 'user/ajax/categories', 'GET', data, 'composer_category_picker');       
        
                // Display loading animation
                $('.page-loading').fadeIn('slow');
                
            }

            if ( typeof Main.selected_post_accounts[network] !== 'undefined' ) {

                var extract = JSON.parse(Main.selected_post_accounts[network]);

                if ( extract.indexOf(network_id) < 0 ) {

                    extract[extract.length] = network_id;
                    Main.selected_post_accounts[network] = JSON.stringify(extract);
                    
                    $( '<li>' + $( this ).closest( 'li' ).html() + '</li>' ).appendTo( '.post-preview-footer ul' );

                }

            } else {

                Main.selected_post_accounts[network] = JSON.stringify([network_id]);
                
                $( '<li>' + $( this ).closest( 'li' ).html() + '</li>' ).appendTo( '.post-preview-footer ul' );

            }
                
            $( this ).closest( 'li' ).addClass( 'account-selected' ); 
            
        }
        
    });
    
    /*
     * Select group in the composer tab
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.composer-groups-list li a', function (e) {
        e.preventDefault();
        
        if ( $( this ).closest('li').hasClass('group-selected') ) {

            // Define $this
            var $this = $(this);

            // Remove selected group
            $this.closest( 'ul' ).find('li').removeClass( 'group-selected' );            
            
            // Empty selected group
            delete Main.selected_post_group;  
            
            $( '.post-preview-footer ul' ).empty();
            
        } else {
        
            // Get group's id
            var group_id = $( this ).attr( 'data-id' );

            // Define $this
            var $this = $(this);

            // Empty selected group
            Main.selected_post_group = {};

            // Remove selected group
            $this.closest( 'ul' ).find('li').removeClass( 'group-selected' );

            // Add group-selected class
            $this.closest( 'li' ).addClass('group-selected');

            // Add group's id
            Main.selected_post_group = $this.attr('data-id');

            $( '.post-preview-footer ul' ).empty();

            $( '<li>' + $this.closest( 'li' ).html() + '</li>' ).appendTo( '.post-preview-footer ul' );            
            
        }
        
    });    
    
    /*
     * Unselect account or group from the composer tab
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.post-preview-footer ul li a', function (e) {
        e.preventDefault();
        
        if ( $('.composer-search-for-groups').length > 0 ) {
        
            // Remove selected account
            $( this ).closest( 'li' ).remove();

             // Empty selected group
            Main.selected_post_group = {};

            // Remove selected group
            $( '.composer-groups-list li').removeClass( 'group-selected' );
        
        } else {
        
            // Get account's id
            var network_id = $( this ).attr( 'data-id' );

            // Get network
            var network = $( this ).attr( 'data-network' );

            // Remove selected account
            $( this ).closest( 'li' ).remove();

            // Get account from the list
            var selected = $( '.composer-accounts-list li a[data-id="' + network_id + '"]' );        

            // Verify if account was selected
            if ( selected.closest( 'li' ).length > 0 ) {

                selected.closest( 'li' ).removeClass( 'account-selected' );

            }
            
            if ( Main.categories !== 'undefined' ) {
            
                if ( Main.categories[network_id] !== 'undefined' ) {

                    delete Main.categories[network_id];

                }
            
            }

            var post_accounts = JSON.parse(Main.selected_post_accounts[network]);

            if (post_accounts.length) {

                delete Main.selected_post_accounts[network];

                for (var d = 0; d < post_accounts.length; d++) {

                    if (post_accounts[d] === network_id) {

                        var selected = $('.post-preview-footer a[data-id="' + post_accounts[d] + '"]');

                        selected.closest('li').remove();

                        delete post_accounts[d];

                    } else {

                        if (typeof Main.selected_post_accounts[network] !== 'undefined') {

                            var extract = JSON.parse(Main.selected_post_accounts[network]);

                            if (extract.indexOf(post_accounts[d]) < 0) {

                                extract[extract.length] = post_accounts[d];
                                Main.selected_post_accounts[network] = JSON.stringify(extract);

                            }

                        } else {

                            Main.selected_post_accounts[network] = JSON.stringify([post_accounts[d]]);

                        }

                    }

                }

            }
            
        }
        
    });
    
    /*
     * Select account in the quick schedule
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */
    $(document).on('click', '.categories-select', function () {
        
        // Verify if categories is defined
        if ( typeof Main.categories === 'undefined' ) {
            Main.categories = {};
        }
        
        var category = $('#selnet').val();
        Main.categories[$('#composer-category-picker').attr('data-id')] = category;
        
    });
    
    /*
     * Select account in the quick schedule
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.quick-scheduler-accounts-list li a', function (e) {
        e.preventDefault();

        // Verify if selected_post_accounts is defined
        if ( typeof Main.selected_quick_post_accounts === 'undefined' ) {
            Main.selected_quick_post_accounts = {};
        }
        
        // Get network
        var network = $( this ).attr( 'data-network' );
        
        // Get account's id
        var network_id = $( this ).attr( 'data-id' );

        // Verify if account was selected
        if ( $( this ).closest( 'li' ).hasClass( 'account-selected' ) ) {
            
            var post_accounts = JSON.parse(Main.selected_quick_post_accounts[network]);

            if ( post_accounts.length ) {
                
                delete Main.selected_quick_post_accounts[network];
                
                for (var d = 0; d < post_accounts.length; d++) {

                    if ( post_accounts[d] === network_id ) {
                        
                        var selected = $( '.quick-scheduler-selected-accounts a[data-id="' + post_accounts[d] + '"]' );
                        
                        selected.closest( 'li' ).remove();
                        
                        delete post_accounts[d];
                        
                    } else {
                        
                        if ( typeof Main.selected_quick_post_accounts[network] !== 'undefined' ) {

                            var extract = JSON.parse(Main.selected_quick_post_accounts[network]);

                            if ( extract.indexOf(post_accounts[d]) < 0 ) {

                                extract[extract.length] = post_accounts[d];
                                Main.selected_quick_post_accounts[network] = JSON.stringify(extract);

                            }

                        } else {

                            Main.selected_quick_post_accounts[network] = JSON.stringify([post_accounts[d]]);

                        }
                        
                    }

                }

            }
            
            $( this ).closest( 'li' ).removeClass( 'account-selected' );
            
        } else {

            if ( typeof Main.selected_quick_post_accounts[network] !== 'undefined' ) {

                var extract = JSON.parse(Main.selected_quick_post_accounts[network]);

                if ( extract.indexOf(network_id) < 0 ) {

                    extract[extract.length] = network_id;
                    Main.selected_quick_post_accounts[network] = JSON.stringify(extract);
                    
                    $( '<li>' + $( this ).closest( 'li' ).html() + '</li>' ).appendTo( '.quick-scheduler-selected-accounts ul' );

                }

            } else {

                Main.selected_quick_post_accounts[network] = JSON.stringify([network_id]);
                
                $( '<li>' + $( this ).closest( 'li' ).html() + '</li>' ).appendTo( '.quick-scheduler-selected-accounts ul' );

            }
                
            $( this ).closest( 'li' ).addClass( 'account-selected' ); 
            
        }
        
    });
    
    /*
     * Select group in the quick schedule
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.quick-scheduler-groups-list li a', function (e) {
        e.preventDefault();
        
        if ( $( this ).closest('li').hasClass('group-selected') ) {

            // Define $this
            var $this = $(this);

            // Remove selected group
            $this.closest( 'ul' ).find('li').removeClass( 'group-selected' );            
            
            // Empty selected group
            delete Main.selected_quick_post_group;  
            
            $( '.quick-scheduler-selected-accounts ul' ).empty();
            
        } else {
        
            // Get group's id
            var group_id = $( this ).attr( 'data-id' );

            // Define $this
            var $this = $(this);

            // Empty selected group
            Main.selected_quick_post_group = {};

            // Remove selected group
            $this.closest( 'ul' ).find('li').removeClass( 'group-selected' );

            // Add group-selected class
            $this.closest( 'li' ).addClass('group-selected');

            // Add group's id
            Main.selected_quick_post_group = $this.attr('data-id');

            $( '.quick-scheduler-selected-accounts ul' ).empty();

            $( '<li>' + $this.closest( 'li' ).html() + '</li>' ).appendTo( '.quick-scheduler-selected-accounts ul' );            
            
        }
        
    });
    
    /*
     * Unselect account from the quick schedule popup
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.quick-scheduler-selected-accounts ul li a', function (e) {
        e.preventDefault();
        
        if ( $( '.quick-scheduler-groups-list' ).length > 0 ) {

            // Define $this
            var $this = $(this);

            // Remove selected group
            $('.quick-scheduler-groups-list li').removeClass( 'group-selected' );            
            
            // Empty selected group
            delete Main.selected_quick_post_group;  
            
            $( '.quick-scheduler-selected-accounts ul' ).empty();
            
        } else {
        
            // Get account's id
            var network_id = $( this ).attr( 'data-id' );

            // Get network
            var network = $( this ).attr( 'data-network' );

            // Remove selected account
            $( this ).closest( 'li' ).remove();

            // Get account from the list
            var selected = $( '.quick-scheduler-accounts-list li a[data-id="' + network_id + '"]' );        

            // Verify if account was selected
            if ( selected.closest( 'li' ).length > 0 ) {

                selected.closest( 'li' ).removeClass( 'account-selected' );

            }

            var post_accounts = JSON.parse(Main.selected_quick_post_accounts[network]);

            if (post_accounts.length) {

                delete Main.selected_quick_post_accounts[network];

                for (var d = 0; d < post_accounts.length; d++) {

                    if (post_accounts[d] === network_id) {

                        var selected = $('.quick-scheduler-selected-accounts a[data-id="' + post_accounts[d] + '"]');

                        selected.closest('li').remove();

                        delete post_accounts[d];

                    } else {

                        if (typeof Main.selected_quick_post_accounts[network] !== 'undefined') {

                            var extract = JSON.parse(Main.selected_quick_post_accounts[network]);

                            if (extract.indexOf(post_accounts[d]) < 0) {

                                extract[extract.length] = post_accounts[d];
                                Main.selected_quick_post_accounts[network] = JSON.stringify(extract);

                            }

                        } else {

                            Main.selected_quick_post_accounts[network] = JSON.stringify([post_accounts[d]]);

                        }

                    }

                }

            }
            
        }
        
    });
    
    /*
     * Show title field in the composer tab
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '#nav-composer .show-title', function () {

        $('#nav-composer .composer-title').toggle('slow');
        
    });
    
    /*
     * Show title field in the quick schedule popup
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '#planner-quick-schedule-modal .show-title', function () {

        $('#planner-quick-schedule-modal .quick-scheduler-title').toggle('slow');
        
    });
    
    /*
     * Delete selected photos
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.btn-delete-selected-photos', function (e) {
        e.preventDefault();
        midrubGallery.deleteMedias();
    });
    
    /*
     * Delete selected post
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.btn-delete-post', function (e) {
        e.preventDefault();
        
        // Get post's id
        var post_id = $(this).attr('data-id');
        
        var data = {
            action: 'history_delete_post',
            post_id: post_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'history_post_delete_response');
        
    });    
    
    /*
     * Delete the post's media
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.btn-delete-post-media', function (e) {
        e.preventDefault();

        var id = $( this ).closest( 'div' ).attr( 'data-id' );
        $( this ).closest( 'div' ).remove();
        delete Main.selected_medias[id];
        
    }); 
    
    /*
     * Delete the post's url
     * 
     * @param object e with global object
    * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.btn-delete-post-url', function (e) {
        e.preventDefault();
        
        $( this ).closest( 'table' ).replaceWith(Main.selected_post_url);
        delete Main.selected_post_url;
        
    });    
    
    /*
     * Add in post the selected photos
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.btn-add-selected-photos', function (e) {
        e.preventDefault();
        
        if ( typeof Main.selected_medias === 'undefined' ) {
            Main.selected_medias = {};
        }

        var medias = Object.values(Main.medias);

        if (medias.length) {

            for (var d = 0; d < medias.length; d++) {

                Main.selected_medias[medias[d].id] = {
                    id: medias[d].id,
                    url: medias[d].url,
                    type: medias[d].type
                };                

            }

        }

        delete Main.medias;

        $( '.multimedia-gallery-selected-medias' ).hide();
        $( '.multimedia-gallery li a' ).removeClass('media-selected');
        
        // Remove default cover background
        $( '.post-preview-medias' ).css('background-color','#FFFFFF');
        
        var medias = Object.values(Main.selected_medias);

        if (medias.length) {
            
            $( '.post-preview-medias' ).empty();

            for (var d = 0; d < medias.length; d++) {
                
                // Add medias in the post preview
                if ( medias[d].type === 'image' ) {

                    $( '.post-preview-medias' ).append('<div data-id="' + medias[d].id + '" data-type="' + medias[d].type + '"><img src="' + medias[d].url + '"><a href="#" class="btn-delete-post-media"><i class="icon-close"></i></a><div>');
                
                } else {
                    
                    $( '.post-preview-medias' ).append('<div data-id="' + medias[d].id + '" data-type="' + medias[d].type + '"><video controls><source src="' + medias[d].url + '" type="video/mp4"></video><a href="#" class="btn-delete-post-media"><i class="icon-close"></i></a><div>');                    
                    
                }

            }

        }
        
    });
    
    /*
     * Add in post the uploaded photos
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('click', '.select-all-uploaded-media', function (e) {
        e.preventDefault();
        
        var uploaded_files = $( '.file-uploaded-box-files li' );
        
        if ( uploaded_files.length > 0 ) {
            
            for ( var u = 0; u < uploaded_files.length; u++ ) {
                
                var id = uploaded_files.eq(u).attr('data-id');
                
                $( '.multimedia-gallery li a[data-id="' + id + '"]' ).click();
                
            }
            
            setTimeout(function(){
                $('.btn-add-selected-photos').click();
                $('.file-uploaded-box-files').empty();
                $('#file-upload-box').modal('hide');                
            }, 1000);

        }
        
    });    

    /*
     * Show post details
     * 
     * @since   0.0.7.0
     */    
    $( document ).on( 'click', '.fc-h-event', function() {
        
        var data = {
            action: 'get_user_post',
            post_id: $(this).attr('ido')
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'scheduled_get_post_content');
        $('#planner-posts-scheduled-modal').modal({
            backdrop: 'static'
        });
        
    });

    /*
     * Cancel search for accounts in the composer tab
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.main #nav-composer .composer-cancel-search-for-accounts', function() {
        
        // Hide cancel search button
        $( '.composer-cancel-search-for-accounts' ).fadeOut('slow');        
        
        if ( $('.main #nav-composer .composer-search-for-groups').length > 0 ) {
        
            $('.main #nav-composer .composer-search-for-groups').val('');
        
            // Loads groups
            Main.composer_search_groups(1);
        
        } else {
            
            $('.composer-search-for-accounts').val('');

            // Load accounts
            Main.composer_search_accounts(1);

        }
        
    });
    
    /*
     * Cancel search for accounts in the quick scheduler popup
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.quick-scheduler-cancel-search-for-accounts', function() {
        
        // Hide cancel search button
        $( '.quick-scheduler-cancel-search-for-accounts' ).fadeOut('slow');        
        
        if ( $('#planner-quick-schedule-modal .quick-scheduler-search-for-groups').length > 0 ) {

            $( '#planner-quick-schedule-modal .quick-scheduler-search-for-groups' ).val('');
            
            // Load Groups
            Main.quick_scheduler_search_groups(1);
            
        } else {

            // Empty the search input
            $( '#planner-quick-schedule-modal .quick-scheduler-search-for-accounts' ).val('');
            
            // Load accounts in the quick scheduler modal
            Main.quick_scheduler_search_accounts(1);
        
        }
        
    });    
    
    /*
     * Cancel search for posts in the insights tab
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.insights-cancel-search-for-posts', function() {
        
        // Hide cancel search button
        $( '.insights-cancel-search-for-posts' ).fadeOut('slow');
        
        $( '.insights-search-for-posts' ).val('');        
        
        Main.insights_all_posts(1);
        
    });
    
    /*
     * Cancel search for accounts in the insights tab
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.insights-cancel-search-for-accounts', function() {
        
        // Hide cancel search button
        $( '.insights-cancel-search-for-accounts' ).fadeOut('slow');
        
        $( '.insights-search-for-accounts' ).val('');        
        
        Main.insights_all_accounts(1);
        
    });    
    
    /*
     * Cancel search for accounts in the history tab
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.history-cancel-search-for-posts', function() {
        
        // Hide cancel search button
        $( '.history-cancel-search-for-posts' ).fadeOut('slow');
        
        $( '.history-search-for-posts' ).val('');        
        
        Main.history_all_posts(1);
        
    });    
    
    /*
     * Cancel search for posts in the composer tab
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.composer-cancel-search-for-posts', function() {
        
        // Hide cancel search button
        $( '.composer-cancel-search-for-posts' ).fadeOut('slow');
        
        $( '.composer-search-for-saved-posts' ).val('');
        
        Main.composer_all_posts(1);
        
    });
    
    /*
     * Cancel search for RSS Feeds in the RSS's tab
     * 
     * @since   0.0.7.4
     */     
    $( document ).on( 'click', '.rss-cancel-search-for-feeds', function() {
        
        // Hide cancel search button
        $( '.rss-cancel-search-for-feeds' ).fadeOut('slow');
        
        $( '.search-for-rss-feeds' ).val('');
        
        Main.load_rss_feeds(1);
        
    });
    
    /*
     * Displays pagination by page click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */    
    $( document ).on( 'click', 'body .pagination li a', function (e) {
        e.preventDefault();
        
        // Get the page number
        var page = $(this).attr('data-page');
        
        // Display results
        switch ( $(this).closest('ul').attr('data-type') ) {
            
            case 'saved-posts':
                Main.composer_all_posts(page);
                break;
                
            case 'history-posts':
                Main.history_all_posts(page);
                break;
                
            case 'insights-posts':
                Main.insights_all_posts(page);
                break;                
            
            case 'insights-accounts':
                Main.insights_all_accounts(page);
                break;
                
            case 'rss-feeds':
                Main.load_rss_feeds(page);
                break;                
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Get post content in composer's tab
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '#saved-posts .getPost', function(e) {
        e.preventDefault();
        
        var data = {
            action: 'get_user_post',
            post_id: $(this).attr('data-id')
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'composer_get_post_content');
        
    });
    
    /*
     * Get post content in the history's tab
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.history-posts .history-post-details', function(e) {
        e.preventDefault();
        
        // Remove active class
        $( '.history-posts li' ).removeClass( 'history-post-details-active' );
        
        // Add active class
        $( this ).closest('li').addClass( 'history-post-details-active' );
        
        var data = {
            action: 'get_user_post',
            post_id: $(this).attr('data-id')
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'history_get_post_content');
        
    });
    
    /*
     * Get post insights in the insights tab
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.published-posts .insights-post-details', function(e) {
        e.preventDefault();
        
        // Remove active class
        $( '.published-posts li' ).removeClass( 'insights-post-details-active' );
        
        // Add active class
        $( this ).closest('li').addClass( 'insights-post-details-active' );
        
        // Add time
        $( '#insights-posts .insights-post-header h3 span' ).html($( this ).closest('li').find('p').html());
        
        // Get post's id
        var id = $( this ).attr('data-id');
        
        var data = {
            action: 'insights_display_post_details',
            meta_id: id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_display_post_details');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Get account insights in the insights tab
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.insights-accounts .insights-account-details', function(e) {
        e.preventDefault();
        
        // Remove active class
        $( '.insights-accounts li' ).removeClass( 'insights-post-details-active' );
        
        // Add active class
        $( this ).closest('li').addClass( 'insights-post-details-active' );
        
        // Get post's id
        var id = $( this ).attr('data-id');
        
        var data = {
            action: 'insights_display_account_details',
            id: id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_display_account_details');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Save post as draft
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.composer-draft-post', function(e) {
        e.preventDefault();
        
        Main.publish = 0;
        
        $('.send-post').submit();
        
    });
    
    /*
     * Schedule post
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.composer-schedule-post', function(e) {
        e.preventDefault();
        
        // Remove class add-date
        $('.midrub-calendar').find('a').removeClass('add-date');
        
        // Set hour
        $('.midrub-calendar-time-hour').val('08');

        // Set minutes
        $('.midrub-calendar-time-minutes').val('00');
        
        // Set period
        if ( $('.midrub-calendar-time-period').length > 0 ) {
            $('.midrub-calendar-time-period').val('AM');
        }
        
        // Hide calendar
        $('.midrub-planner').fadeOut('fast');
        
        $('.send-post').submit();
        
    });
    
    /*
     * Reply to comment
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.insights-posts-comments-reply', function(e) {
        e.preventDefault();
        
        // Get type
        var type = $(this).attr('data-type');
        
        // Get id
        var id = $(this).attr('data-post-id');
        
        // Get parent id
        var parent_id = $(this).attr('data-id');
        
        // Add data above to form reply
        $( '.insights-posts-reactions-post-reply' ).attr( 'data-type', type );
        $( '.insights-posts-reactions-post-reply' ).attr( 'data-id', id );
        $( '.insights-posts-reactions-post-reply' ).attr( 'data-parent', parent_id );
        
    });  
    
    /*
     * Delete a post's comment
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.insights-posts-comments-delete', function(e) {
        e.preventDefault();
        
        // Get type
        var type = $(this).attr('data-type');
        
        // Get id
        var id = $(this).attr('data-post-id');
        
        // Get parent
        var parent = $(this).attr('data-id');
        
        var data = {
            action: 'insights_display_delete_react',
            type: type,
            id: id,
            parent: parent
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_display_post_details');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Delete a post's comment from an account
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '.insights-accounts-comments-delete', function(e) {
        e.preventDefault();
        
        // Get type
        var type = $(this).attr('data-type');
        
        // Get id
        var id = $(this).attr('data-post-id');
        
        // Get parent
        var parent = $(this).attr('data-id');
        
        var data = {
            action: 'insights_accounts_delete_react',
            type: type,
            id: id,
            parent: parent
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_display_account_details');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });    
    
    /*
     * Delete a published post
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '#insights-posts .insights-post-delete-post', function(e) {
        e.preventDefault();
        
        // Get id
        var id = $('.insights-post-details').attr('data-id');
        
        var data = {
            action: 'insights_post_delete_post',
            id: id,
            type: 'post'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_post_delete_post');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Delete a post from an account
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '#insights-accounts .insights-delete-account-post', function(e) {
        e.preventDefault();
        
        // Get id
        var id = $( this ).closest( '.panel' ).attr('data-id');
        
        // Get account id
        var account = $( '.insights-accounts .insights-post-details-active .insights-account-details' ).attr('data-id');
        
        var data = {
            action: 'insights_account_delete_post',
            id: id,
            account: account,
            type: 'post'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_display_account_details');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Display post insights in accounts posts
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */     
    $( document ).on( 'click', '#insights-accounts .insights-accounts-get-post-insights', function(e) {
        e.preventDefault();
        
        // Get id
        var id = $( this ).closest( '.panel' ).attr('data-id');
        
        // Get account id
        var account = $( '.insights-accounts .insights-post-details-active .insights-account-details' ).attr('data-id');
        
        var data = {
            action: 'insights_account_display_post_insights',
            id: id,
            account: account,
            type: 'post'
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'insights_account_display_post_insights');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Select media in the quick schedule popup
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */ 
    $(document).on('click', '.multimedia-gallery-quick-schedule li a', function (e) {
        e.preventDefault();
        
        if ( typeof Main.quick_schedule.medias === 'undefined' ) {
            Main.quick_schedule.medias = {};
        }
        
        var id = $( this ).attr('data-id');
        
        if ( $( this ).hasClass( 'media-selected' ) ) {
            
            delete Main.quick_schedule.medias[id];
            
            $( this ).removeClass( 'media-selected' );
            
        } else {
            
            Main.quick_schedule.medias[id] = {
                id: id,
                url: $( this ).attr('data-url'),
                type: $( this ).attr('data-type')
            };
            
            $( this ).addClass( 'media-selected' );          
            
        }
        
    });
    
    /*
     * Load more medias in the quick schedule popup
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */ 
    $( document ).on( 'click', '.multimedia-gallery-quick-schedule-load-more-medias', function (e) {
        e.preventDefault();
                    
        Main.planner_quick_schedule_load_medias( ( Main.quick_schedule.medias_page + 1 ) );
        
    });
    
    /*
     * Load accounts by network
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', '.main .accounts-manager-available-networks li a', function (e) {
        e.preventDefault();
        
        var network = $(this).attr('data-network');
        
        if ( $('#nav-accounts-manager').hasClass('show') ) {
        
            $('.manage-accounts-all-accounts').empty();

            $('#nav-accounts-manager .accounts-manager-available-networks li').removeClass('network-selected');

            $(this).closest('li').addClass('network-selected');

            Main.account_manager_get_accounts(network, 'accounts_manager');
        
        } else {
            
            $( '.manage-accounts-groups-all-accounts' ).empty();
            
            $('#nav-groups-manager .accounts-manager-available-networks li').removeClass('network-selected');
            
            $(this).closest('li').addClass('network-selected');
            
            Main.account_manager_get_accounts(network, 'groups_manager');
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    }); 
    
    /*
     * Load available networks
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', 'main .composer-manage-members', function (e) {
        e.preventDefault();
        
        if ( $('.accounts-manager-search').length < 1 ) {
        
            Main.account_manager_load_networks();

            // Display loading animation
            $('.page-loading').fadeIn('slow');
        
        }
        
    });
    
    /*
     * Cancel accounts manager search
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', '.main .cancel-accounts-manager-search', function (e) {
        e.preventDefault();
            
        // Hide cancel search button
        $(this).closest('.tab-pane').find('.cancel-accounts-manager-search').fadeOut('slow');
        
        // Verify if search is in the accounts tab
        if ( $(this).closest('.tab-pane').attr('id') === 'nav-accounts-manager' ) {
        
            // Get network
            var network = $('#nav-accounts-manager').find('.network-selected a').attr('data-network');

            // Empty the search input
            $('#nav-accounts-manager').find('.accounts-manager-search-for-accounts').val('');
            
            var data = {
                action: 'account_manager_search_for_accounts',
                network: network,
                key: '',
                type: 'accounts_manager'
            };

            // Set CSRF
            data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();

            // Make ajax call
            Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'account_manager_search_for_accounts');            
            
        } else if ( $(this).closest('.tab-pane').attr('id') === 'nav-groups-manager' ) {
            
            // Get network
            var network = $('#nav-groups-manager').find('.network-selected a').attr('data-network');
            
            // Empty the search input
            $('#nav-groups-manager').find('.accounts-manager-search-for-accounts').val('');

            var data = {
                action: 'account_manager_search_for_accounts',
                network: network,
                key: '',
                type: 'groups_manager'
            };
            
            // Set CSRF
            data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();

            // Make ajax call
            Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'account_manager_search_for_accounts');
            
        }
        
    });
    
    /*
     * Delete accounts from the accounts manager popup
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', '.main .accounts-manager-active-accounts-list li a', function (e) {
        e.preventDefault();
            
        // Get the account's id
        var account_id = $(this).attr('data-id');

        var data = {
            action: 'account_manager_delete_accounts',
            account_id: account_id
        };

        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'account_manager_delete_accounts');
        
    });
    
    /*
     * Renew session
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', '.main .accounts-manager-expired-accounts-list li a', function (e) {
        e.preventDefault();
            
        // Get the account's id
        var account_id = $(this).attr('data-id');
        
        // Get network
        var network = $('#nav-accounts-manager').find('.network-selected a').attr('data-network');
        
        var popup_url = url + 'user/connect/' + network + '?account=' + account_id;
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - ((width/2) / 2)) + dualScreenLeft;
        var top = ((height / 2) - ((height/2) / 2)) + dualScreenTop;
        var expiredWindow = window.open(popup_url, 'Pixabay', 'scrollbars=yes, width=' + (width/2) + ', height=' + (height/1.3) + ', top=' + top + ', left=' + left);

        if (window.focus) {
            expiredWindow.focus();
        }
        
    });
    
    /*
     * Connect a new account
     * 
     * @since   0.0.7.0
     */ 
    $(document).on('click', '.main .manage-accounts-new-account', function() {
        
        // Verify if should be displayed hidden content
        if ( $( this ).hasClass('manage-accounts-display-hidden-content') ) {
            $( '.main .manage-accounts-hidden-content' ).fadeIn('slow');
        } 
        
        // Get network
        var network = $('#nav-accounts-manager').find('.network-selected a').attr('data-network');
        
        var popup_url = url + 'user/connect/' + network;
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - ((width/2) / 2)) + dualScreenLeft;
        var top = ((height / 1.3) - ((height/1.3) / 1.3)) + dualScreenTop;
        var networkWindow = window.open(popup_url, 'Connect Account', 'scrollbars=yes, width=' + (width/2) + ', height=' + (height/1.3) + ', top=' + top + ', left=' + left);

        if (window.focus) {
            networkWindow.focus();
        }
        
    });
    
    /*
     * Delete accounts from the accounts manager popup
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', 'main .accounts-manager-groups-select-group .dropdown-menu .dropdown-item', function (e) {
        e.preventDefault();
            
        // Get the group's id
        var group_id = $( this ).attr('data-id');
        
        // Add selected text
        $( 'main .accounts-manager-groups-select-group .btn-secondary' ).html( $( this ).text() );
        $( 'main .accounts-manager-groups-select-group .btn-secondary' ).attr( 'data-id', $( this ).attr('data-id') );
        
        // Remove active class
        $( 'main .accounts-manager-groups-select-group .dropdown-menu .dropdown-item' ).removeClass( 'active' );
        
        // Remove selected accounts
        $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li' ).removeClass( 'select-account-in-group' );
        
        // Add active class
        $( this ).addClass( 'active' );

        var data = {
            action: 'accounts_manager_groups_available_accounts',
            group_id: group_id
        };

        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'accounts_manager_groups_available_accounts');
        
    });
    
    /*
     * Delete accounts group
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', 'main .accounts-manager-groups-select-group .accounts-manager-delete-group', function (e) {
        e.preventDefault();
            
        // Get the group's id
        var group_id = $( 'main .accounts-manager-groups-select-group .btn-secondary' ).attr( 'data-id' );
        
        var data = {
            action: 'accounts_manager_groups_delete_group',
            group_id: group_id
        };

        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'accounts_manager_groups_delete_group');
        
    }); 
    
    /*
     * Add account to group
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', 'main .manage-accounts-groups-all-accounts li a', function (e) {
        e.preventDefault();
        
        // Get account id
        var account_id = $(this).attr('data-id');
        
        // Get the group's id
        var group_id = $( 'main .accounts-manager-groups-select-group .btn-secondary' ).attr( 'data-id' );
        
        var data = {
            action: 'account_manager_add_account_to_group',
            account_id: account_id,
            group_id: group_id
        };

        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'account_manager_add_account_to_group');
        
    });
    
    /*
     * Remove account from group
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */ 
    $( document ).on( 'click', 'main .create-new-group-form .accounts-manager-groups-available-accounts li a', function (e) {
        e.preventDefault();
        
        // Get account id
        var account_id = $(this).attr('data-id');
        
        // Get the group's id
        var group_id = $( 'main .accounts-manager-groups-select-group .btn-secondary' ).attr( 'data-id' );
        
        var data = {
            action: 'account_manager_remove_account_from_group',
            account_id: account_id,
            group_id: group_id
        };

        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'account_manager_remove_account_from_group');
        
    });
    
    /*
     * Save the VK token
     * 
     * @param object e with global object
     * 
     * @since   0.0.0.1
     */ 
    $( document ).on( 'click', 'main .save-token', function (e) {

        var $this = $(this);
        var network = $('#nav-accounts-manager').find('.network-selected a').attr('data-network');
        var token = $this.closest('.manage-accounts-hidden-content').find('.token').val();
        var encode = btoa(token);
        encode = encode.replace('/', '-');
        var cleanURL = encode.replace(/=/g, '');
        
        $.ajax({
            url: url + 'user/save-token/' + network + '/' + cleanURL,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                
                if (data === 1) {
                    
                    $this.closest('.manage-accounts-hidden-content').find('.token').val('');
                    
                    $( '.main .manage-accounts-hidden-content' ).fadeOut('fast');
                    
                    Main.reload_accounts();
                    
                } else {
                    
                    $this.closest('.manage-accounts-hidden-content').find('.token').val('');
                    
                    // Display alert
                    Main.popup_fon('sube', data, 1500, 2000);
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
            }
            
        });
        
    });
    
    /*
     * Detect all RSS selection
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.4
     */ 
    $( document ).on( 'click', 'main #rss-select-all-feeds', function (e) {
        
        setTimeout(function(){
            
            if ( $( 'main #rss-select-all-feeds' ).is(':checked') ) {

                $( '.rss-all-feeds li input[type="checkbox"]' ).prop('checked', true);

            } else {

                $( '.rss-all-feeds li input[type="checkbox"]' ).prop('checked', false);

            }
        
        },500);
        
    });
    
    /*
     * Delete RSS Feed
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.4
     */ 
    $( document ).on( 'click', 'main .rss-delete-rss-feed', function (e) {
        e.preventDefault();
        
        // Get RSS's ID
        var rss_id = $( this ).attr( 'data-id' );
        
        var data = {
            action: 'rss_delete_rss_feed',
            rss_id: rss_id
        };
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'GET', data, 'rss_delete_rss_feed');
        
    });
    
    /*
     * Execute action on RSS Feeds
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.4
     */ 
    $( document ).on( 'click', 'main .dropdown-menu-action a', function (e) {
        e.preventDefault();
        
        // Get the action to execute
        var action = $(this).attr('data-id');
        
        // Define the ids variable
        var ids = [];
        
        // Get selected RSS Feeds
        $('.rss-all-feeds li input[type="checkbox"]:checkbox:checked').each(function () {
            ids.push($(this).attr('data-id'));
        });
        
        // Create an object with form data
        var data = {
            action: 'rss_feeds_execute_mass_action',
            rss_action: action,
            rss_ids: ids
        };
        
        // Set CSRF
        data[$('.main .register-new-rss-feed').attr('data-csrf')] = $('input[name="' + $('.main .register-new-rss-feed').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'rss_feeds_execute_mass_action');
        
    });   
    
    /*
     * Detect accounts pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.6
     */ 
    $( document ).on( 'click', '.main #nav-composer .next-button, .main #nav-composer .back-button', function (e) {
        e.preventDefault();
        
        // Get page number
        var page = $(this).attr('data-page');
        
        if ( $('.main #nav-composer .composer-search-for-groups').length > 0 ) {
        
            // Loads groups
            Main.composer_search_groups(page);
            
        } else {

            // Load accounts
            Main.composer_search_accounts(page);
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Detect accounts pagination click
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.6
     */ 
    $( document ).on( 'click', '#planner-quick-schedule-modal .next-button, #planner-quick-schedule-modal .back-button', function (e) {
        e.preventDefault();

        // Get page number
        var page = $(this).attr('data-page');

        if ( $('#planner-quick-schedule-modal .quick-scheduler-search-for-groups').length > 0 ) {
        
            // Loads groups
            Main.quick_scheduler_search_groups(page);
            
        } else {

            // Load accounts
            Main.quick_scheduler_search_accounts(page);
            
        }
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*******************************
    RESPONSES
    ********************************/
   
    /*
     * Display accounts results in the composer tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.composer_accounts_results_by_search = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( $('.main #nav-composer .next-button').length > 0 ) {
            
                if ( data.page < 2 ) {
                    
                    $('.main #nav-composer .back-button').addClass('btn-disabled');
                    
                } else {
                    
                    $('.main #nav-composer .back-button').removeClass('btn-disabled');
                    $('.main #nav-composer .back-button').attr('data-page', (parseInt(data.page) - 1));
                    
                }
                
                if ( (parseInt(data.page) * 10 ) < data.total ) {
                    
                    $('.main #nav-composer .next-button').removeClass('btn-disabled');
                    $('.main #nav-composer .next-button').attr('data-page', (parseInt(data.page) + 1));
                    
                } else {
                    
                    $('.main #nav-composer .next-button').addClass('btn-disabled');
                    
                }
            
            }
            
            var accounts = '';
            
            // List all accounts
            for ( var f = 0; f < data.accounts_list.length; f++ ) {
                
                var icon = data.accounts_list[f].network_info.icon;
                
                var new_icon = icon.replace(' class', ' style="color: ' + data.accounts_list[f].network_info.color + '" class');
                
                var account_selected = '';
                
                if ( typeof Main.selected_post_accounts !== 'undefined' ) {
                
                    if (typeof Main.selected_post_accounts[data.accounts_list[f].network_name] !== 'undefined') {

                        var extract = JSON.parse(Main.selected_post_accounts[data.accounts_list[f].network_name]);

                        if (extract.indexOf(data.accounts_list[f].network_id) > -1) {
                            account_selected = ' class="account-selected"';
                        }

                    }
                
                }
                
                accounts += '<li' + account_selected + '>'
                                + '<a href="#" data-id="' + data.accounts_list[f].network_id + '" data-net="' + data.accounts_list[f].net_id + '" data-network="' + data.accounts_list[f].network_name + '" data-category="' + data.accounts_list[f].network_info.categories + '">'
                                    + new_icon
                                    + data.accounts_list[f].user_name
                                        + '<span><i class="icon-user"></i> ' + data.accounts_list[f].display_network_name + '</span>'
                                    + '<i class="icon-check"></i>'
                                + '</a>'
                            + '</li>';
                
            }
            
            $( '.composer-accounts-list ul' ).html( accounts );
            
        } else {
            
            $( '.composer-accounts-list ul' ).html( '<li class="no-accounts-found">' + data.message + '</li>' );
            
        }

    };
    
    /*
     * Display groups results in the composer tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.composer_groups_results_by_search = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( $('.main #nav-composer .next-button').length > 0 ) {
            
                if ( data.page < 2 ) {
                    
                    $('.main #nav-composer .back-button').addClass('btn-disabled');
                    
                } else {
                    
                    $('.main #nav-composer .back-button').removeClass('btn-disabled');
                    $('.main #nav-composer .back-button').attr('data-page', (parseInt(data.page) - 1));
                    
                }
                
                if ( (parseInt(data.page) * 10 ) < data.total ) {
                    
                    $('.main #nav-composer .next-button').removeClass('btn-disabled');
                    $('.main #nav-composer .next-button').attr('data-page', (parseInt(data.page) + 1));
                    
                } else {
                    
                    $('.main #nav-composer .next-button').addClass('btn-disabled');
                    
                }
            
            }
            
            var groups = '';
            
            // List all accounts
            for ( var f = 0; f < data.groups_list.length; f++ ) {
                
                var group_selected = '';
                
                if ( typeof Main.selected_post_group !== 'undefined' ) {

                    if ( Main.selected_post_group === data.groups_list[f].list_id ) {
                        group_selected = ' class="group-selected"';
                    }
                
                }
                
                groups += '<li' + group_selected + '>'
                                + '<a href="#" data-id="' + data.groups_list[f].list_id + '">'
                                    + '<i class="icon-folder-alt"></i>'
                                    + data.groups_list[f].name
                                    + '<i class="icon-check"></i>'
                                + '</a>'
                            + '</li>';
                
            }
            
            $( '.composer-groups-list ul' ).html( groups );
            
        } else {
            
            $( '.composer-groups-list ul' ).html( '<li class="no-groups-found">' + data.message + '</li>' );
            
        }

    };
    
     /*
     * Display category picker popup
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.composer_category_picker = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            $('#composer-category-picker').modal('show');
            
            var cats = '';

            for (var t = 0; t < data.categories.length; t++) {
                cats += data.categories[t];
            }

            $('#selnet').html(cats);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
     /*
     * Display accounts results in the quick scheduler
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.quick_scheduler_accounts_results_by_search = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( $('#planner-quick-schedule-modal .next-button').length > 0 ) {
            
                if ( data.page < 2 ) {
                    
                    $('#planner-quick-schedule-modal .back-button').addClass('btn-disabled');
                    
                } else {
                    
                    $('#planner-quick-schedule-modal .back-button').removeClass('btn-disabled');
                    $('#planner-quick-schedule-modal .back-button').attr('data-page', (parseInt(data.page) - 1));
                    
                }
                
                if ( (parseInt(data.page) * 10 ) < data.total ) {
                    
                    $('#planner-quick-schedule-modal .next-button').removeClass('btn-disabled');
                    $('#planner-quick-schedule-modal .next-button').attr('data-page', (parseInt(data.page) + 1));
                    
                } else {
                    
                    $('#planner-quick-schedule-modal .next-button').addClass('btn-disabled');
                    
                }
            
            }
            
            var accounts = '';
            
            // List all accounts
            for ( var f = 0; f < data.accounts_list.length; f++ ) {
                
                var icon = data.accounts_list[f].network_info.icon;
                
                var new_icon = icon.replace(' class', ' style="color: ' + data.accounts_list[f].network_info.color + '" class');
                
                var account_selected = '';
                
                if ( typeof Main.selected_quick_post_accounts !== 'undefined' ) {
                
                    if (typeof Main.selected_quick_post_accounts[data.accounts_list[f].network_name] !== 'undefined') {

                        var extract = JSON.parse(Main.selected_quick_post_accounts[data.accounts_list[f].network_name]);

                        if (extract.indexOf(data.accounts_list[f].network_id) > -1) {
                            account_selected = ' class="account-selected"';
                        }

                    }
                
                }
                
                accounts += '<li' + account_selected + '>'
                                + '<a href="#" data-id="' + data.accounts_list[f].network_id + '" data-network="' + data.accounts_list[f].network_name + '">'
                                    + new_icon
                                    + data.accounts_list[f].user_name
                                    + '<span>'
                                        + '<i class="icon-user"></i> '
                                        + data.accounts_list[f].display_network_name
                                    + '</span>'
                                    + '<i class="icon-check"></i>'
                                + '</a>'
                            + '</li>';
                
            }
            
            $( '.quick-scheduler-accounts-list ul' ).html( accounts );
            
        } else {
            
            $( '.quick-scheduler-accounts-list ul' ).html( '<li class="no-accounts-found">' + data.message + '</li>' );
            
        }

    };
    
     /*
     * Display groups results in the quick scheduler
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.quick_scheduler_groups_results_by_search = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( $('#planner-quick-schedule-modal .next-button').length > 0 ) {
            
                if ( data.page < 2 ) {
                    
                    $('#planner-quick-schedule-modal .back-button').addClass('btn-disabled');
                    
                } else {
                    
                    $('#planner-quick-schedule-modal .back-button').removeClass('btn-disabled');
                    $('#planner-quick-schedule-modal .back-button').attr('data-page', (parseInt(data.page) - 1));
                    
                }
                
                if ( (parseInt(data.page) * 10 ) < data.total ) {
                    
                    $('#planner-quick-schedule-modal .next-button').removeClass('btn-disabled');
                    $('#planner-quick-schedule-modal .next-button').attr('data-page', (parseInt(data.page) + 1));
                    
                } else {
                    
                    $('#planner-quick-schedule-modal .next-button').addClass('btn-disabled');
                    
                }
            
            }
            
            var groups = '';
            
            // List all accounts
            for ( var f = 0; f < data.groups_list.length; f++ ) {
                
                var group_selected = '';
                
                if ( typeof Main.selected_post_group !== 'undefined' ) {

                    if ( Main.selected_post_group === data.groups_list[f].list_id ) {
                        group_selected = ' class="group-selected"';
                    }
                
                }
                
                groups += '<li' + group_selected + '>'
                                + '<a href="#" data-id="' + data.groups_list[f].list_id + '">'
                                    + '<i class="icon-folder-alt"></i>'
                                    + data.groups_list[f].name
                                    + '<i class="icon-check"></i>'
                                + '</a>'
                            + '</li>';
                
            }
            
            $( '.quick-scheduler-groups-list ul' ).html( groups );
            
        } else {
            
            $( '.quick-scheduler-groups-list ul' ).html( '<li class="no-groups-found">' + data.message + '</li>' );
            
        }

    };
    
    /*
     * Display publish post status
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.composer_publish_post_status = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset the form
            $('.emojionearea-editor, .post-preview-medias, .post-preview-footer ul').empty();
            $('.composer-title input[type="text"], .new-post').val('');
            $('.post-preview-body').html('<div class="row">'
                                            + '<div class="col-xl-11"></div>'
                                        + '</div>'
                                        + '<div class="row">'
                                            + '<div class="col-xl-11"></div>'
                                        + '</div>'
                                        + '<div class="row">'
                                            + '<div class="col-xl-11"></div>'
                                        + '</div>'
                                        + '<div class="row">'
                                            + '<div class="col-xl-7"></div>'
                                        + '</div>');
                                
            $('.post-preview-title').html('<div class="row">'
                                            + '<div class="col-xl-8"></div>'
                                        + '</div>');
            $('.post-preview-medias').removeAttr('style');
            
            if ( $('.composer-accounts-list').length > 0 ) {
            
                $('.composer-accounts-list li').removeClass( 'account-selected' );
            
            } else {
                
                $('.composer-groups-list li').removeClass( 'group-selected' );
                
            }
            
            if ( typeof Main.selected_post_accounts !== 'undefined' ) {
                delete Main.selected_post_accounts;
            }
        
            // Set default status
            Main.publish = 1;

            // Empty datetime input
            $('.datetime').val('');
            
            // Load posts contents
            Main.load_posts_content();

            // Delete selected medias
            delete Main.selected_medias;

            // Set current date
            Main.ctime = new Date();

            // Set current months
            Main.month = Main.ctime.getMonth() + 1;

            // Set current day
            Main.day = Main.ctime.getDate();

            // Set current year
            Main.year = Main.ctime.getFullYear();

            // Set current year
            Main.cyear = Main.year;

            // Set date/hour format
            Main.format = 0;

            // Set selected_date
            Main.selected_date = '';

            // Set selected time
            Main.selected_time = '08:00';

            // Reset scheduler
            Main.show_calendar( Main.month, Main.day, Main.year, Main.format );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display publish post status for quick scheduler
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.quick_scheduler_publish_post_status = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Reset the form
            $( '.schedule-post .quick-scheduler-selected-accounts ul' ).empty();
            $( '.schedule-post .quick-scheduler-title, .schedule-post .quick-new-post' ).val( '' );
            $( '.multimedia-gallery-quick-schedule li a').removeClass( 'media-selected' );
            
            if ( $('.quick-scheduler-accounts-list').length > 0 ) {
            
                $( '.quick-scheduler-accounts-list li' ).removeClass( 'account-selected' );
                
                // Delete selected accounts
                delete Main.selected_quick_post_accounts;
            
            } else {
                
                $( '.quick-scheduler-groups-list li' ).removeClass( 'group-selected' );
                
            }
            
            // Delete selected medias
            delete Main.selected_medias;
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
        Main.load_posts_content();

    };    
    
    /*
     * Display post response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.history_post_delete_response = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            Main.load_posts_content();
            
            $( '.history-post-content' ).html( '<p class="no-post-selected">' + data.no_post_selected + '<p>' );
            $( '.history-profiles-list' ).html( '<p class="no-post-selected">' + data.no_post_selected + '<p>' );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }

    };
    
    /*
     * Display url preview
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.composer_display_url_preview = function ( status, data ) {
        
        if (data.error) {

            console.log(data.error);

        } else {
            
            var domain = '';
            
            if ( typeof data.domain !== 'undefined' ) {
                domain = data.domain.replace(/(<([^>]+)>)/ig,'');
            }
            
            var title = '';
            
            if ( typeof data.title !== 'undefined' ) {
                title = data.title.replace(/(<([^>]+)>)/ig,'');
            }            
            
            if ( data.img.search('no-image') > -1 ) {
                
                var data = '<table class="partial">'
                                + '<tbody>'
                                    + '<tr>'
                                        + '<td>'
                                            + '<img src="' + data.img + '">'
                                        + '</td>'
                                        + '<td>'
                                            + '<a href="#" class="btn-delete-post-url"><i class="icon-close"></i></a>'
                                            + '<h3>' + title + '</h3>'
                                            + '<a href="#" target="_blank">' + domain + '</a>'
                                            + '<p>' + data.description + '</p>'
                                        + '</td>'
                                    + '</tr>'
                                + '</tbody>'
                            + '</table>';
                
                var body = $( '.emojionearea-editor' ).html();
                    
                $( '.post-preview-body' ).html(Main.replace_url(body, Main.selected_post_url, data));
                
            } else {
                
                var data = '<table class="full">'
                                + '<tbody>'
                                    + '<tr>'
                                        + '<td>'
                                            + '<a href="#" class="btn-delete-post-url"><i class="icon-close"></i></a>'
                                            + '<img src="' + data.img + '">'
                                        + '</td>'
                                    + '</tr>'
                                    + '<tr>'
                                        + '<td>'
                                            + '<h3>' + title + '</h3>'
                                            + '<a href="#" target="_blank">' + domain + '</a>'
                                            + '<p>' + data.description + '</p>'
                                        + '</td>'
                                    + '</tr>'
                                + '</tbody>'
                            + '</table>';
                    
                var body = $( '.emojionearea-editor' ).html();
                    
                $( '.post-preview-body' ).html(Main.replace_url(body, Main.selected_post_url, data));
                
            }

        }

    };
    
    /*
     * Display all saved posts in the composer tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.composer_display_all_posts = function ( status, data ) {
        
        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var allposts = '';

            Main.pagination.page = data.page;
            Main.show_pagination('#saved-posts', data.total);

            for (var u = 0; u < data.posts.length; u++) {

                // Set date
                var date = data.posts[u].sent_time;

                // Set time
                var gettime = Main.calculate_time(date, data.date);

                // Set status
                var status = (data.posts[u].status == 1) ? '<span class="badge badge-success">' + Main.translation.mm130 + '</span>' : (data.posts[u].status == 2) ? (data.posts[u].status == 2 && date > data.date) ? '<span class="badge badge-warning">' + Main.translation.mm111 + '</span>' : '<span class="badge badge-danger">' + Main.translation.mm112 + '</span>' : '<span class="badge badge-secondary">' + Main.translation.mm113 + '</span>';

                // Set post content
                var text = data.posts[u].body.substring(0, 50) + ' ...';

                // Add post
                allposts += '<li class="getPost list-group-item" data-id="' + data.posts[u].post_id + '">'
                                + '<div class="row">'
                                    + '<div class="col-xl-7">'
                                        + text + ' ' + status
                                    + '</div>'
                                    + '<div class="col-xl-5 text-right">'
                                        + ' <span class="pull-right">'
                                            + gettime
                                        + '</span>'
                                    + '</div>'
                                + '</div>'
                            + '</li>';

            }

            $('.all-saved-posts').html(allposts);
            
        } else {
            
            $('#saved-posts .pagination').empty();
            
            $('.all-saved-posts').html('<li class="no-accounts-found">' + data.message + '</li>');
            
        }
        
    };
    
    /*
     * Display all saved posts in the insights tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.insights_display_all_posts = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var allposts = '';

            Main.pagination.page = data.page;
            Main.show_pagination('#insights-posts', data.total);

            for (var u = 0; u < data.posts.length; u++) {

                // Set date
                var date = data.posts[u].sent_time;

                // Set time
                var gettime = Main.calculate_time(date, data.date);

                // Set status
                var status = (data.posts[u].status == 1) ? '<span class="badge badge-success">' + Main.translation.mm130 + '</span>' : (data.posts[u].status == 2) ? (data.posts[u].status == 2 && date > data.date) ? '<span class="badge badge-warning">' + Main.translation.mm111 + '</span>' : '<span class="badge badge-danger">' + Main.translation.mm112 + '</span>' : '<span class="badge badge-secondary">' + Main.translation.mm113 + '</span>';

                // Set post content
                var text = data.posts[u].body.substring(0, 50);
                    
                // Add post
                allposts += '<li>'
                                + '<div class="row">'
                                    + '<div class="col-xl-8 col-6">'
                                        + '<h4>'
                                            + data.posts[u].icon
                                            + text
                                        + '</h4>'
                                        + '<p>' + gettime + '</p>'
                                    + '</div>'
                                    + '<div class="col-xl-4 col-6 text-right">'
                                        + '<a href="#" class="btn btn-outline-info insights-post-details" data-id="' + data.posts[u].meta_id + '"><i class="icon-graph"></i> ' + data.insights + '</a>'
                                    + '</div>'                                                            
                                + '</div>'
                            + '</li>';                    

            }

            $('.insights-posts-results').html( '<ul class="published-posts">' + allposts + '</ul>' );
            
        } else {
            
            $('#insights-posts .pagination').empty();
            
            $('.insights-posts-results').html('<p class="no-posts-found">' + data.message + '</p>');
            
        }
        
    };
    
    /*
     * Display post insights
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.insights_display_post_details = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( typeof data.message !== 'undefined' ) {
                
                // Display alert
                Main.popup_fon('subi', data.message, 1500, 2000);
                
            }
            
            var post = '';

            if ( data.content.title !== '' ) {
                
                post += '<div class="row">'
                            + '<div class="col-xl-12">'
                                + '<h3>' + data.content.title + '</h3>'
                            + '</div>'
                        + '</div>';

            }
            
            if ( data.content.body !== '' ) {
                
                post += '<div class="row">'
                            + '<div class="col-xl-12 mb-3">'
                                + data.content.body
                            + '</div>'
                        + '</div>';

            }
            
            if ( data.content.img.length > 0 ) {
                
                for ( var d = 0; d < data.content.img.length; d++ ) {
                 
                    post += '<div class="row">'
                                + '<div class="col-xl-12">'
                                    + '<div class="post-history-media">'
                                        + '<img src="' + data.content.img[d].body + '">'
                                    + '</div>'
                                + '</div>'
                            + '</div>';
                    
                }

            }
            
            if ( data.content.video.length > 0 ) {
                
                for ( var v = 0; v < data.content.video.length; v++ ) {
                 
                    post += '<div class="row">'
                                + '<div class="col-xl-12">'
                                    + '<div class="post-history-media">'
                                        + '<video controls><source src="' + data.content.video[v].body + '" type="video/mp4"></video>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';
                    
                }

            }
            
            
            var get_reactions = data.content.reactions;
            
            if ( get_reactions.length ) {
                
                var panel_footer_head = '';
                
                for( var h = 0; h < get_reactions.length; h++ ) {
                    
                    var status = '';
                    var selected = 'false';
                    
                    if ( panel_footer_head === '' ) {
                        status = ' active';
                        selected = 'true';
                    }
                    
                    panel_footer_head += '<li class="nav-item">'
                                            + '<a class="nav-link' + status + '" id="' + get_reactions[h].slug + '-nav-tab" data-toggle="tab" href="#' + get_reactions[h].slug + '-tab" role="tab" aria-controls="' + get_reactions[h].slug + '-tab" aria-selected="' + selected + '">'
                                                + get_reactions[h].name
                                            + '</a>'
                                        + '</li>';
                    
                }
                
                // Display panel footer tabs navigation
                $('#insights-posts .insights-post-footer .nav-tabs').html(panel_footer_head);
                
                // Get current time
                var date = new Date(); 
                var cdate = date.getTime()/1000;
                
                var reactions = '';
                
                for( var i = 0; i < get_reactions.length; i++ ) {
                    
                    var status = '';
                    
                    if ( reactions === '' ) {
                        status = ' show active';
                    }
                    
                    reactions += '<div class="tab-pane fade' + status + '" id="' + get_reactions[i].slug + '-tab" role="tabpanel" aria-labelledby="' + get_reactions[i].slug + '-tab">';

                    if ( Array.isArray( get_reactions[i].response ) === true ) {
                        
                        reactions += '<ul class="comments">';
                        
                        for ( var a = 0; a < get_reactions[i].response.length; a++ ) {
                            
                            if ( get_reactions[i].response[a].created_time ) {
                            
                                // Get post's time
                                var d = new Date(get_reactions[i].response[a].created_time); 
                                var new_date = d.getTime()/1000;

                                // Set time
                                var gettime = Main.calculate_time(new_date, cdate);
                            
                            } else {
                                
                                var gettime = '';
                                
                            }

                            // Create the replies variable
                            var replies = '';

                            if ( typeof get_reactions[i].response[a].replies !== 'undefined' ) {

                                replies += '<ul class="comments-replies">';

                                for( var s = 0; s < get_reactions[i].response[a].replies.length; s++ ) {

                                    // Get post's time
                                    var r = new Date(get_reactions[i].response[a].replies[s].created_time); 
                                    var reply_date = r.getTime()/1000;

                                    // Set time
                                    var getreplytime = Main.calculate_time(reply_date, cdate);
                                    
                                    var reply = '';
                                    
                                    if (get_reactions[i].reply) {
                                        reply = '<a href="#" class="insights-posts-comments-reply" data-toggle="modal" data-target="#insights-reply-comments" data-type="' + get_reactions[i].slug + '" data-post-id="' + data.meta_id + '" data-id="' + get_reactions[i].response[a].replies[s].id + '">' + data.content.configuration.words.reply + '</a>';
                                    }
                                    
                                    var delete_it = '';
                                    
                                    if (get_reactions[i].delete) {
                                        delete_it = '<a href="#" class="insights-posts-comments-delete" data-type="' + get_reactions[i].slug + '" data-post-id="' + data.meta_id + '" data-id="' + get_reactions[i].response[a].replies[s].id + '">' + data.content.configuration.words.delete + '</a>';
                                    }                                    

                                    replies += '<li class="row">'
                                                    + '<div class="col-xl-12">'
                                                        + '<img src="' + get_reactions[i].response[a].replies[s].from.user_picture + '" alt="User Avatar" class="img-circle" />'
                                                        + '<div class="comment-body">'
                                                            + '<strong><a href="' + get_reactions[i].response[a].replies[s].from.link + '" target="_blank">' + get_reactions[i].response[a].replies[s].from.name + '</a></strong>'
                                                            + '<small>'
                                                                + getreplytime
                                                            + '</small>'
                                                            + '<p>'
                                                                + get_reactions[i].response[a].replies[s].message
                                                            + '</p>'
                                                            + '<p>'
                                                                + reply
                                                                + delete_it
                                                            + '</p>'
                                                        + '</div>'
                                                    + '</div>'
                                                + '</li>'                            

                                }

                                replies += '</ul>';

                            }
                            
                            var reply = '';

                            if (get_reactions[i].reply) {
                                reply = '<a href="#" class="insights-posts-comments-reply" data-toggle="modal" data-target="#insights-reply-comments" data-type="' + get_reactions[i].slug + '" data-post-id="' + data.meta_id + '" data-id="' + get_reactions[i].response[a].id + '">' + data.content.configuration.words.reply + '</a>';
                            }

                            var delete_it = '';

                            if (get_reactions[i].delete) {
                                delete_it = '<a href="#" class="insights-posts-comments-delete" data-type="' + get_reactions[i].slug + '" data-post-id="' + data.meta_id + '" data-id="' + get_reactions[i].response[a].id + '">' + data.content.configuration.words.delete + '</a>';
                            }

                            reactions += '<li class="row">'
                                            + '<div class="col-xl-12">'
                                                + '<img src="' + get_reactions[i].response[a].from.user_picture + '" alt="User Avatar" class="img-circle" />'
                                                + '<div class="comment-body">'
                                                    + '<strong><a href="' + get_reactions[i].response[a].from.link + '" target="_blank">' + get_reactions[i].response[a].from.name + '</a></strong>'
                                                    + '<small>'
                                                        + gettime
                                                    + '</small>'
                                                    + '<p>'
                                                        + get_reactions[i].response[a].message
                                                    + '</p>'
                                                    + '<p>'
                                                        + reply
                                                        + delete_it
                                                    + '</p>'
                                                + '</div>'
                                            + '</div>'
                                            + replies
                                        + '</li>';
                            
                        }
                        
                        reactions += '</ul>';
                        
                    } else {
                        
                        reactions += '<p class="no-data-found">' + get_reactions[i].response + '</p>';
                        
                    }
                    
                    if (get_reactions[i].form) {

                        reactions += '<div class="panel-sub-footer">'
                                        + '<form method="post" class="insights-posts-reactions-post" data-type="' + get_reactions[i].slug + '" data-id="' + data.meta_id + '">'
                                            + '<div class="input-group">'
                                                + '<textarea class="form-control input-sm reactions-msg" placeholder="' + get_reactions[i].placeholder + '"></textarea>'
                                                + '<span class="input-group-btn">'
                                                    + '<button class="btn btn-warning btn-sm" type="submit" id="btn-chat">'
                                                        + '<i class="icon-cursor"></i>'
                                                    + '</button>'
                                                + '</span>'
                                            + '</div>'
                                        + '</form>'
                                    + '</div>';

                    }

                    reactions += '</div>';
                    
                }
                
                // Display post reactions
                $('#insights-posts .insights-post-footer .tab-content').html(reactions);  
                
            }          

            // Display post username
            $('#insights-posts .insights-post-content-username').text(data.content.user_name);
            
            // Display user's avatar
            $('#insights-posts .insights-post-header img').attr('src', data.content.user_picture);
            
            // Display post content
            $('#insights-posts .insights-post-content').html(post);
            
            // Display post
            $( '#insights-posts .col-xl-5 .panel' ).removeClass( 'no-selected-post' );
            
            // Empty reply textarea
            $('#insights-reply-comments .reactions-msg').val('');
            
            // Verify if post's insights are enabled
            if ( data.content.configuration.post_insights === true ) {
            
                // Verify if insights exists
                if ( typeof data.content.insights !== 'undefined' ) {

                    // Display insights graph
                    Main.display_insights_graph('insights-posts-graph', data.content.insights);

                    // Display insights area
                    $('#insights-posts > .row > .col-xl-4').show();

                } else {

                    // Hide insights area
                    $('#insights-posts > .row > .col-xl-4').hide();         

                }
            
            } else {
                
                // Hide insights area
                $('#insights-posts > .row > .col-xl-4').hide();                 
                
            }
            
            // Get post configuration and enable or disable options
            if ( data.content.configuration.post_deletion === true ) {
                $('#insights-posts .col-xl-5 .panel .dropdown').show();
            } else {
                $('#insights-posts .col-xl-5 .panel .dropdown').hide();
            }
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };    
    
    /*
     * Display all accounts in the insights tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.insights_display_all_accounts = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var allaccounts = '';

            Main.pagination.page = data.page;
            Main.show_pagination('#insights-accounts', data.total);

            for (var u = 0; u < data.accounts_list.length; u++) {
                
                var user_avatar = url + 'assets/img/avatar-placeholder.png';
                
                if ( data.accounts_list[u].user_avatar ) {
                    user_avatar = data.accounts_list[u].user_avatar;
                }
                    
                allaccounts += '<li>'
                                    + '<div class="row">'
                                        + '<div class="col-xl-8 col-6">'
                                            + '<h3>'
                                                + '<img src="' + user_avatar + '">'
                                                + data.accounts_list[u].user_name
                                            + '</h3>'
                                        + '</div>'
                                        + '<div class="col-xl-4 col-6 text-right">'
                                            + '<a href="#" class="btn btn-outline-info insights-account-details" data-id="' + data.accounts_list[u].network_id + '"><i class="icon-graph"></i> '
                                                + data.insights
                                            + '</a>'
                                        + '</div>'                                                            
                                    + '</div>'
                                + '</li>';

            }

            $( '.insights-accounts-results' ).html( '<ul class="insights-accounts">' + allaccounts + '</ul>' );
            
        } else {
            
            $( '#insights-posts .pagination' ).empty();
            
            $( '.insights-accounts-results' ).html('<p class="no-posts-found">' + data.message + '</p>');
            
        }
        
    };
    
    /*
     * Display all saved posts in the history tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.history_display_all_posts = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var allposts = '';

            Main.pagination.page = data.page;
            Main.show_pagination('#nav-history', data.total);

            for (var u = 0; u < data.posts.length; u++) {

                // Set date
                var date = data.posts[u].sent_time;

                // Set time
                var gettime = Main.calculate_time(date, data.date);

                // Set status
                var status = (data.posts[u].status == 1) ? '<span class="badge badge-success">' + Main.translation.mm130 + '</span>' : (data.posts[u].status == 2) ? (data.posts[u].status == 2 && date > data.date) ? '<span class="badge badge-warning">' + Main.translation.mm111 + '</span>' : '<span class="badge badge-danger">' + Main.translation.mm112 + '</span>' : '<span class="badge badge-secondary">' + Main.translation.mm113 + '</span>';

                // Set post content
                var text = data.posts[u].body.substring(0, 50);
                
                // Verify if text exists
                if ( !text ) {
                    text = data.posts[u].title.substring(0, 50);
                }
                    
                // Add post
                allposts += '<li>'
                                + '<div class="row">'
                                    + '<div class="col-xl-8 col-6">'
                                        + '<h4>'
                                            + '<i class="fas fa-history"></i>'
                                            + text
                                        + '</h4>'
                                        + '<p>' + gettime + '</p>'
                                    + '</div>'
                                    + '<div class="col-xl-4 col-6 text-right">'
                                        + '<a href="#" class="btn btn-outline-info history-post-details" data-id="' + data.posts[u].post_id + '"><i class="icon-info"></i> ' + data.details + '</a>'
                                    + '</div>'                                                            
                                + '</div>'
                            + '</li>';                    

            }

            $('.history-posts-results').html( '<ul class="history-posts">' + allposts + '</ul>' );
            
        } else {
            
            $('#history .pagination').empty();
            
            $('.history-posts-results').html('<p class="no-posts-found">' + data.message + '</p>');
            
        }
        
    };    
    
    /*
     * Display post's content in composer
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.composer_get_post_content = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {

            if (data) {
                
                $('.emojionearea-editor').html(data.content.body);

                $('.new-post').val(data.content.body);
                
                var content = $('.emojionearea-editor').html();
                
                // Add links
                var post = Main.verify_for_url( content.replace(/(<div)/igm, '<br').replace(/<\/div>/igm, '') );

                // Add post body preview
                $( '.post-preview-body' ).html( '<div class="row">' + post + '</div>' );

            }

            if (data.content.title !== '') {

                $('.composer-title').show();
                $('.composer-title input[type="text"]').val(data.content.title);
        
                // Add post title preview
                $( '.post-preview-title' ).html( '<div class="row">' + data.content.title + '</div>' );

            } else {

                $('.composer-title').hide();
                $('.composer-title input[type="text"]').val('');
                                
                $('.post-preview-title').html('<div class="row">'
                                                + '<div class="col-xl-8"></div>'
                                            + '</div>');

            }
            
            $('#saved-posts').modal('hide');
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display post's content in history tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.history_get_post_content = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var post = '';

            if ( data.content.title !== '' ) {
                
                post += '<div class="row">'
                            + '<div class="col-xl-12">'
                                + '<h3>' + data.content.title + '</h3>'
                            + '</div>'
                        + '</div>';

            }
            
            if ( data.content.body !== '' ) {
                
                post += '<div class="row">'
                            + '<div class="col-xl-12 mb-3">'
                                + data.content.body
                            + '</div>'
                        + '</div>';

            }

            if ( data.content.img.length > 0 ) {
                
                for ( var d = 0; d < data.content.img.length; d++ ) {
                 
                    post += '<div class="row">'
                                + '<div class="col-xl-12">'
                                    + '<div class="post-history-media">'
                                        + '<img src="' + data.content.img[d].body + '">'
                                    + '</div>'
                                + '</div>'
                            + '</div>';
                    
                }

            }
            
            if ( data.content.video.length > 0 ) {
                
                for ( var v = 0; v < data.content.video.length; v++ ) {
                 
                    post += '<div class="row">'
                                + '<div class="col-xl-12">'
                                    + '<div class="post-history-media">'
                                        + '<video controls><source src="' + data.content.video[v].body + '" type="video/mp4"></video>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';
                    
                }

            } 
            
            var profiles_list = '';
            
            if ( data.content.profiles.length > 0 ) {
                
                profiles_list += '<ul>'; 
                
                for ( var p = 0; p < data.content.profiles.length; p++ ) {
                    
                    var status = '<i class="icon-check"></i>';
                    
                    if ( data.content.profiles[p].status === '0' || data.content.profiles[p].status === '2' ) {
                        status = '<i class="icon-close"></i>';
                    }
                 
                    profiles_list += '<li>'
                                + '<div class="row">'
                                    + '<div class="col-xl-2 col-sm-2 text-center">'
                                        + data.content.profiles[p].icon
                                    + '</div>'
                                    + '<div class="col-xl-8 col-sm-8 clean">'
                                        + '<h3>' + data.content.profiles[p].user_name + '</h3>'
                                        + '<p><i class="icon-user"></i> ' + data.content.profiles[p].network_name + '</p>'
                                    + '</div>'                              
                                    + '<div class="col-xl-2 col-sm-2 text-center">'
                                        + status
                                    + '</div>'
                                + '</div>';
                        
                    if ( data.content.profiles[p].network_status ) {

                        profiles_list += '<div class="row">'
                                    + '<div class="col-xl-12 publish-error">'
                                        + '<div class="publish-error-status">'
                                            + '<div class="publish-error-status-header"></div>'
                                            + '<div class="publish-error-status-body">'
                                                + '<p>' + data.content.profiles[p].network_status + '</p>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>';                

                    }
                        
                    profiles_list += '</li>';
                    
                }
                
                profiles_list += '</ul>';

            }
            
            var time;

            if ( isNaN(data.content.datetime) ) {
                time = data.content.datetime;
            } else {
                time = Main.calculate_time(data.content.datetime, data.content.time);
            }

            var actions = '<div class="row">'
                            + '<div class="col-xl-12">'
                                + '<div class="history-status-actions">'
                                    + '<div class="row">'
                                        + '<div class="col-xl-6">'
                                            + '<p>' + time + '</p>'
                                        + '</div>'
                                        + '<div class="col-xl-6 text-right">'
                                            + '<button type="button" class="btn btn-delete-post" data-id="' + data.content.post_id + '"><i class="icon-trash"></i> '
                                                + data.content.delete_post
                                            + '</button>'
                                        + '</div>'            
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>';
            
            $('.history-profiles-list').html( actions + profiles_list );
            
            $('.history-post-content').html(post);
            
        } else {
            
        }
        
    };
    
    /*
     * Display post's content in scheduled tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.scheduled_get_post_content = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var post = '';

            if ( data.content.title !== '' || data.content.title !== null ) {
                
                post += '<div class="row">'
                            + '<div class="col-xl-12">'
                                + '<h3>' + data.content.title + '</h3>'
                            + '</div>'
                        + '</div>';

            }
            
            if ( data.content.body !== '' ) {
                
                post += '<div class="row">'
                            + '<div class="col-xl-12 mb-3">'
                                + data.content.body
                            + '</div>'
                        + '</div>';

            }
            
            if ( data.content.img.length > 0 ) {
                
                for ( var d = 0; d < data.content.img.length; d++ ) {
                 
                    post += '<div class="row">'
                                + '<div class="col-xl-12">'
                                    + '<div class="post-history-media">'
                                        + '<img src="' + data.content.img[d].body + '">'
                                    + '</div>'
                                + '</div>'
                            + '</div>';
                    
                }

            }
            
            if ( data.content.video.length > 0 ) {
                
                for ( var v = 0; v < data.content.video.length; v++ ) {
                 
                    post += '<div class="row">'
                                + '<div class="col-xl-12">'
                                    + '<div class="post-history-media">'
                                        + '<video controls><source src="' + data.content.video[v].body + '" type="video/mp4"></video>'
                                    + '</div>'
                                + '</div>'
                            + '</div>';
                    
                }

            } 
            
            var profiles_list = '';
            
            if ( data.content.profiles.length > 0 ) {
                
                profiles_list += '<ul>'; 
                
                for ( var p = 0; p < data.content.profiles.length; p++ ) {
                    
                    var status = '<i class="icon-check"></i>';
                    
                    if ( data.content.profiles[p].icon === '0' || data.content.profiles[p].icon === '2' ) {
                        status = '<i class="icon-close"></i>';
                    }
                 
                    profiles_list += '<li>'
                                + '<div class="row">'
                                    + '<div class="col-xl-2 col-sm-2 text-center">'
                                        + data.content.profiles[p].icon
                                    + '</div>'
                                    + '<div class="col-xl-8 col-sm-8 clean">'
                                        + '<h3>' + data.content.profiles[p].user_name + '</h3>'
                                        + '<p><i class="icon-user"></i> ' + data.content.profiles[p].network_name + '</p>'
                                    + '</div>'                              
                                    + '<div class="col-xl-2 col-sm-2 text-center">'
                                        + status
                                    + '</div>'
                                + '</div>'
                            + '</li>';
                    
                }
                
                profiles_list += '</ul>';

            }
            
            var time;

            if ( isNaN(data.content.datetime) ) {
                time = data.content.datetime;
            } else {
                time = Main.calculate_time(data.content.datetime, data.content.time);
            }

            var actions = '<div class="row">'
                            + '<div class="col-xl-12">'
                                + '<div class="scheduler-status-actions">'
                                    + '<div class="row">'
                                        + '<div class="col-xl-6">'
                                            + time
                                        + '</div>'
                                        + '<div class="col-xl-6 text-right">'
                                            + '<button type="button" class="btn btn-delete-post" data-id="' + data.content.post_id + '"><i class="icon-trash"></i> '
                                                + data.content.delete_post
                                            + '</button>'
                                        + '</div>'            
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>';
            
            $('.scheduler-preview-profiles-list').html( actions + profiles_list );
            
            $('.scheduler-preview-post-content').html(post);
            
        } else {
            
        }
        
    };
    
    /*
     * Display scheduled posts
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.scheduler_display_all_posts = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            $('#calendar').fullCalendar('removeEventSources'); 
            
            var events = [];

            if (data.posts.length) {

                for (var d = 0; d < data.posts.length; d++) {
                    
                    var body = data.posts[d].body;
                    
                    var img = '';
                    
                    if ( data.posts[d].img.length ) {
                        
                        img = '<p class="text-center">'
                                + '<img src="' + data.posts[d].img + '">'
                            + '</p>';
                        
                    } else if ( data.posts[d].video.length ) {
                        
                        img = '<p class="text-center">'
                                + '<img src="' + data.posts[d].video + '">'
                            + '</p>';
                        
                    }
                    
                    var icons = '';
                    
                    if ( data.posts[d].icons ) {
                        
                        var all_icons = data.posts[d].icons;
                        
                        for ( var e = 0; e < all_icons.length; e++ ) {
                            icons += all_icons[e];
                        }
                        
                    }
                    
                    var time = Main.calculate_time(data.posts[d].time, data.time);

                    events.push({
                        title: img
                            + '<p>' + body.substr(0, 30) + ' ... <span>' + time + '</span></p>'
                            + '<p>' + icons + '</p>',
                        start: data.posts[d].datetime,
                        ido: data.posts[d].post_id
                    });

                }

            }

            $('#calendar').fullCalendar('addEventSource', events);
            
        }
        
    };
    
    /*
     * Delete a post response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.insights_post_delete_post = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Hide insights area
            $('#insights-posts > .row > .col-xl-4').hide();
            
            // Hide post 
            $( '#insights-posts .col-xl-5 .panel' ).addClass( 'no-selected-post' );
            
            // Load Insights posts
            Main.insights_all_posts(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display a post insights response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.insights_account_display_post_insights = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display hidden canvas
            $('#insights-accounts-post-graph-' + data.post_id).show();
            
            // Display insights graph
            Main.display_insights_graph('insights-accounts-post-graph-' + data.post_id, data.insights);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };    
    
    /*
     * Get account insights for the insights tab
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.0
     */
    Main.methods.insights_display_account_details = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( typeof data.message !== 'undefined' ) {
                
                // Display alert
                Main.popup_fon('subi', data.message, 1500, 2000);
                
            }
            
            if ( Array.isArray( data.posts ) === true ) {
                
                var posts = '';
            
                for ( var p = 0; p < data.posts.length; p++ ) {

                    var reactions = Main.display_insights_reactions(data.posts[p].reactions, data.network_id, data.configuration);
                    
                    var insights = '';
                    
                    var insights_links = '';
                    
                    var post_deletion = '';
                    
                    // Verify if post's insights are enabled
                    if ( data.configuration.post_insights === true ) {
                        insights_links = '<a class="dropdown-item insights-accounts-get-post-insights" href="#">' + data.configuration.words.insights + '</a>';
                        insights = '<canvas id="insights-accounts-post-graph-' + data.posts[p].id + '" width="600" height="500"></canvas>';
                    }
                    
                    if ( data.configuration.post_deletion === true )  {
                        post_deletion = '<a class="dropdown-item insights-delete-account-post" href="#">' + data.configuration.words.delete_post + '</a>';
                    }
                    
                    var dropdown = '';
                    
                    if ( data.configuration.post_insights === true || data.configuration.post_deletion === true ) {
                    
                        var dropdown = '<div class="dropdown show">'
                                            + '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                                + '<i class="icon-arrow-down"></i>'
                                            + '</a>'
                                            + '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">'
                                                + insights_links
                                                + post_deletion
                                            + '</div>'
                                        + '</div>';
                                        
                    }

                    posts += '<div class="row">'
                                + '<div class="col-xl-12">'
                                    + '<div class="panel panel-primary" data-id="' + data.posts[p].id + '">'
                                        + '<div class="panel-heading" id="accordion">'
                                            + '<h3>'
                                                + '<img src="' + data.user_picture + '">'
                                                + '<a href="#">' + data.user_name + '</a>'
                                                + '<span>' + data.network_name + '</span>'
                                                + dropdown
                                            + '</h3>'                                                                        
                                        + '</div>'
                                        + '<div class="panel-body">'
                                            + data.posts[p].content
                                            + insights
                                        + '</div>'
                                        + reactions
                                    + '</div>'
                                + '</div>'
                            + '</div>';

                }

                // Display posts
                $( '#insights-accounts > .row > .col-xl-5' ).html( posts );

                // Display insights area
                $('#insights-accounts > .row > .col-xl-4').show();

                // Display insights graph
                Main.display_insights_graph('insights-accounts-graph', data.insights);
                
            } else {
                
                // Display insights area
                $('#insights-accounts > .row > .col-xl-4').hide();
                
                var posts = '<div class="row">'
                            + '<div class="col-xl-12">'
                                + '<div class="panel no-selected-post panel-primary">'
                                    + '<div class="panel-no-selected-post">'
                                        + '<p class="no-post-selected">' + data.configuration.words.no_posts_found + '</p>'
                                    + '</div>'
                                + '</div>'
                            + '</div>'
                        + '</div>';
                
                // Display posts
                $( '#insights-accounts > .row > .col-xl-5' ).html( posts );                
                
            }
            
            $('#insights-reply-comments .reactions-msg').val('');
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display network's accounts
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.account_manager_get_accounts = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( data.type === 'accounts_manager' ) {
                
                // Verify if hidden content exists
                if ( data.hidden ) {
                    $( '.main .manage-accounts-hidden-content' ).html(data.hidden);
                } else {
                    $( '.main .manage-accounts-hidden-content' ).empty();
                }
                
                $( '.main .manage-accounts-hidden-content' ).fadeOut('fast');
            
                // Display accounts
                $( '#accounts-manager-popup .manage-accounts-all-accounts' ).html(data.active);

                // Display network's instructions
                $( '#accounts-manager-popup .manage-accounts-network-instructions' ).html(data.instructions);

                // Display search form
                $( '#accounts-manager-popup .manage-accounts-search-form' ).html(data.search_form);
            
            } else {
                
                // Display accounts
                $( '#accounts-manager-popup .manage-accounts-groups-all-accounts' ).html(data.active);

                if ( $('.accounts-manager-groups-select-group .btn-secondary').attr('data-id') ) {
                    
                    // Remove selected accounts
                    $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li' ).removeClass( 'select-account-in-group' );
                    
                    var group_accounts = $('main .create-new-group-form .accounts-manager-groups-available-accounts li');

                    for ( var g = 0; g < group_accounts.length; g++ ) {
                        
                        $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li a[data-id="' + group_accounts.eq(g).find('a').attr('data-id') + '"]' ).closest( 'li' ).addClass( 'select-account-in-group' );
                        
                    }
                    
                }
                
            }
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display social networks
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.account_manager_load_networks = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            $( '#nav-accounts-manager' ).html( data.social_data );
            
            if ( $( '#nav-groups-manager' ).length > 0 ) {
                
                $( '#nav-groups-manager' ).html( data.groups_data );
            
            }
            
        }
        
    };
    
    /*
     * Display search results in accounts manager
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.account_manager_search_for_accounts = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            if ( data.type === 'accounts_manager' ) {

                $( document ).find( '#nav-accounts-manager .manage-accounts-all-accounts' ).html( data.social_data );
                
            } else {
                
                $( document ).find( '#nav-groups-manager .manage-accounts-groups-all-accounts' ).html( data.social_data );
                
            }
            
        } else {
            
            if ( $('#nav-accounts-manager').hasClass('show') ) {
                
                $( document ).find('#nav-accounts-manager .manage-accounts-all-accounts').html( data.message );
                
            } else {
                
                $( document ).find( '#nav-groups-manager .manage-accounts-groups-all-accounts' ).html( data.social_data );
                
            }         
            
        }
        
        if ( $('.accounts-manager-groups-select-group .btn-secondary').attr('data-id') ) {

            // Remove selected accounts
            $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li' ).removeClass( 'select-account-in-group' );

            var group_accounts = $('main .create-new-group-form .accounts-manager-groups-available-accounts li');

            for ( var g = 0; g < group_accounts.length; g++ ) {

                $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li a[data-id="' + group_accounts.eq(g).find('a').attr('data-id') + '"]' ).closest( 'li' ).addClass( 'select-account-in-group' );

            }

        }
        
    }; 
    
    /*
     * Display account deletion status
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.account_manager_delete_accounts = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);

            // Remove account from the list
            $('#nav-accounts-manager .accounts-manager-active-accounts-list li a[data-id="' + data.account_id + '"]').closest('li').remove();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display group creation status
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.account_manager_create_accounts_group = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Empty the group name field
            $('.accounts-manager-groups-enter-group-name').val('');
            
            // Get groups
            var groups = data.groups;
            
            var all_groups = '';
            
            for ( var w = 0; w < groups.length; w++ ) {
                
                all_groups += '<button class="dropdown-item" type="button" data-id="' + groups[w].list_id + '">'
                                + groups[w].name
                            + '</button>';
                
            }
            
            $( document ).find( '.create-new-group-form .dropdown-menu' ).html( all_groups );
            
            $( document ).find( '.create-new-group-form .dropdown-menu button[data-id="' + data.group_id + '"]' ).click();
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Gets all available group's accounts
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.accounts_manager_groups_available_accounts = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var accounts = '';

            for ( var a = 0; a < data.accounts.length; a++ ) {
                
                $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li a[data-id="' + data.accounts[a].network_id + '"]' ).closest( 'li' ).addClass( 'select-account-in-group' );
                
                accounts += '<li>'
                                + '<a href="#" data-id="' + data.accounts[a].network_id + '">' + data.accounts[a].user_name + ' <i class="icon-trash"></i></a>'
                            + '</li>';
                
            }
            
            // Display accounts
            $('.main #nav-groups-manager .accounts-manager-groups-available-accounts').html( accounts );
            
        } else {
            
            var accounts = '<li class="no-accounts-found">'
                                + data.message
                            + '</li>';
            
            // Display no accounts found message
            $('.main #nav-groups-manager .accounts-manager-groups-available-accounts').html( accounts );
            
        }
        
        $( '.main .accounts-manager-groups-select-group .col-xl-12' ).eq(1).fadeIn('slow');
        $( '.main .accounts-manager-groups-select-group .col-xl-12' ).eq(2).fadeIn('slow');
        
    };
    
    /*
     * Display group deletion status
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.accounts_manager_groups_delete_group = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Change the selector text
            $('.accounts-manager-groups-select-group .btn-secondary').text(data.select_group);
            $('.accounts-manager-groups-select-group .btn-secondary').removeAttr('data-id');
            
            // Remove active class
            $( 'main .accounts-manager-groups-select-group .dropdown-menu .dropdown-item' ).removeClass( 'active' );
            $( 'main .accounts-manager-groups-active-accounts li' ).removeClass( 'select-account-in-group' );
            
            // Hide accounts and deletion button area
            $('.accounts-manager-groups-select-group .accounts-manager-groups-available-accounts').empty();
            $( '.main .accounts-manager-groups-select-group .col-xl-12' ).eq(1).fadeOut('slow');
            $( '.main .accounts-manager-groups-select-group .col-xl-12' ).eq(2).fadeOut('slow');
            
            // Get groups
            var groups = data.groups;
            
            var all_groups = '';
            
            for ( var w = 0; w < groups.length; w++ ) {
                
                all_groups += '<button class="dropdown-item" type="button" data-id="' + groups[w].list_id + '">'
                                + groups[w].name
                            + '</button>';
                
            }
            
            $( document ).find( '.create-new-group-form .dropdown-menu' ).html( all_groups );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Display adding account to grup status
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.account_manager_add_account_to_group = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Remove selected accounts
            $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li' ).removeClass( 'select-account-in-group' );
            
            var accounts = '';
            
            for ( var a = 0; a < data.accounts.length; a++ ) {
                
                $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li a[data-id="' + data.accounts[a].network_id + '"]' ).closest( 'li' ).addClass( 'select-account-in-group' );
                
                accounts += '<li>'
                                    + '<a href="#" data-id="' + data.accounts[a].network_id + '">'
                                        + data.accounts[a].user_name + ' <i class="icon-trash"></i>'
                                    + '</a>'
                                + '</li>';
                
            }
            
            $( document ).find( '.create-new-group-form .accounts-manager-groups-available-accounts' ).html( accounts );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Removing account from a group response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.account_manager_remove_account_from_group = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            if (typeof data.accounts === 'string' || data.accounts instanceof String) {
                
                accounts = data.accounts;
                
            } else {
                
                // Remove selected accounts
                $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li' ).removeClass( 'select-account-in-group' );
            
                var accounts = '';

                for ( var a = 0; a < data.accounts.length; a++ ) {
                    
                    $( '.main #nav-groups-manager .accounts-manager-groups-active-accounts li a[data-id="' + data.accounts[a].network_id + '"]' ).closest( 'li' ).addClass( 'select-account-in-group' );

                    accounts += '<li>'
                                    + '<a href="#" data-id="' + data.accounts[a].network_id + '">'
                                        + data.accounts[a].user_name + ' <i class="icon-trash"></i>'
                                    + '</a>'
                                + '</li>';

                }
            
            }
            
            $( document ).find( '.create-new-group-form .accounts-manager-groups-available-accounts' ).html( accounts );
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Response for new rss save
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.2
     */
    Main.methods.rss_feeds_save_new_rss_feed = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Empty the input field
            $('.rss-feeds-enter-rss-url').val('');
            
            // Verify if last_id exists
            if ( data.last_id ) {
                
                // Get RSS's content
                var rss_content = data.rss_content;
                
                // Get the titles
                var title = rss_content.title;
                
                // Define the RSS's content
                var content = '';
                
                var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
                
                for ( var d = 0; d < title.length; d++ ) {
                    
                    content += '<div class="col-xl-12 rss-feeds-rss-content-single">';
                    
                        content += '<h3>' + title[d] + '</h3>';
                        
                        if ( rss_content.description ) {
                            
                            var new_preview = rss_content.description[d].replace(/\n/g, '</p><p>');
                            
                            content += '<p>' + new_preview + '</p>';
                            
                        }
                        
                        if ( rss_content.show ) {
                            
                            if ( regex.test( rss_content.show[d] ) ) {
                            
                                content += '<p><img src="' + rss_content.show[d] + '"></p>';

                            }
                            
                        }
                        
                        if ( rss_content.url ) {
                            
                            content += '<p><a href="' + rss_content.url[d] + '" target="_blank">' + rss_content.url[d] + '</a></p>';
                            
                        }
                    
                    content += '</div>';
                    
                }
                
                $('.rss-feeds-rss-content').html(content);
                
                setTimeout(function(){
                    
                    document.location.href = url + 'user/app/posts?q=rss&rss_id=' + data.last_id;
                    
                }, 1000);
                        
            }
            
        } else {

            // Display error
            var content = '<div class="col-xl-12 rss-feeds-rss-content-single">'
                            + '<h6>' + data.message + '</h6>';
                        + '</div>';

            $('.rss-feeds-rss-content').html(content);
            
        }
        
    };
    
    /*
     * Display RSS Feeds
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.4
     */
    Main.methods.load_rss_feeds = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            var rss_feeds = '';
            
            Main.pagination.page = data.page;
            Main.show_pagination('#nav-rss', data.total);
            
            for ( var r = 0; r < data.rss_feeds.length; r++ ) {
                
                var enabled = 'far';
                
                var selected = 0;

                if ( data.rss_feeds[r].enabled !== '0' ) {
                    enabled = 'fas';
                }
                
                if ( data.groups ) {
                    selected = (data.rss_feeds[r].group_id !== '0')?'1':'0';
                } else {
                    selected = data.rss_feeds[r].accounts;
                }
                
                rss_feeds += '<li>'
                                + '<div class="row">'
                                    + '<div class="col-xl-6 col-lg-6 col-md-5 col-sm-5 col-12">'
                                        + '<div class="checkbox-option-select">'
                                            + '<input id="rss-select-all-feeds-' + data.rss_feeds[r].rss_id + '" name="rss-select-all-feeds-' + data.rss_feeds[r].rss_id + '" type="checkbox" data-id="' + data.rss_feeds[r].rss_id + '">'
                                            + '<label for="rss-select-all-feeds-' + data.rss_feeds[r].rss_id + '"></label>'
                                        + '</div>'
                                        + '<h4><a href="' + data.rss_feeds[r].rss_url + '" target="_blank">' + data.rss_feeds[r].rss_name + '</a> <i class="' + enabled + ' fa-circle"></i></h4>'
                                        + '<p>' + data.rss_feeds[r].rss_description + '</p>'
                                    + '</div>'
                                    + '<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4 text-center">'
                                        + '<h4>' + data.rss_feeds[r].num + '</h4>'
                                        + '<p>' + data.published_posts + '</p>'                                     
                                    + '</div>'
                                    + '<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 text-center">'
                                        + '<h4>' + selected + '</h4>'
                                        + '<p>' + data.destination + '</p>'
                                    + '</div>'
                                    + '<div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-5 text-right">'
                                        + '<div class="btn-group dropup">'
                                            + '<a href="' + url + 'user/app/posts?q=rss&rss_id=' + data.rss_feeds[r].rss_id + '" class="btn btn-success"><i class="icon-login"></i> ' + data.manage + '</a>'
                                            + '<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">'
                                                + '<span class="fas fa-sort-down"></span>'
                                            + '</button>'
                                            + '<ul class="dropdown-menu" role="menu">'
                                                + '<li><a href="#" data-id="' + data.rss_feeds[r].rss_id + '" class="rss-delete-rss-feed">' + data.delete + '</a></li>'
                                            + '</ul>'
                                        + '</div>'
                                    + '</div>'
                                + '</div>'
                            + '</li>';
                
            }
            
            $( '.rss-all-feeds' ).html( rss_feeds );
            
        } else {
            
            $( '.rss-all-feeds' ).html( '<li class="no-rss-found">' + data.message + '</li>' );
            
        }
        
    };
    
    /*
     * Display the RSS Feed response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.4
     */
    Main.methods.rss_delete_rss_feed = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all RSS Feeds
            Main.load_rss_feeds(1);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };
    
    /*
     * Delete RSS Feeds response
     * 
     * @param string status contains the response status
     * @param object data contains the response content
     * 
     * @since   0.0.7.4
     */
    Main.methods.rss_feeds_execute_mass_action = function ( status, data ) {

        // Verify if the success response exists
        if ( status === 'success' ) {
            
            // Display alert
            Main.popup_fon('subi', data.message, 1500, 2000);
            
            // Load all RSS Feeds
            Main.load_rss_feeds(1);
            
            // Unselect all checkbox
            $( 'main #rss-select-all-feeds' ).prop('checked', false);
            
        } else {
            
            // Display alert
            Main.popup_fon('sube', data.message, 1500, 2000);
            
        }
        
    };    
    
    /*******************************
    FORMS
    ********************************/
   
    /*
     * Publish a post
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $('.send-post').submit(function (e) {
        e.preventDefault();

        // Set current time
        var currentdate = new Date();
        
        // Set date time
        var datetime = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + ' ' + currentdate.getHours() + ':' + currentdate.getMinutes() + ':' + currentdate.getSeconds();
        
        // Set post's title
        var post_title = $('.send-post .composer-title input[type="text"]').val();
        
        // set message
        var post = btoa(encodeURIComponent($('.new-post').val()));
        
        // Remove non necessary characters
        post = post.replace('/', '-');
        post = post.replace(/=/g, '');
        
        // Set post's publish date
        var date = $('.datetime').val();
        
        // Verify if user has scheduled the post
        if ( !date ) {
            date = datetime;
        }
        
        if ( typeof Main.selected_post_url !== 'undefined' ) {
            // Set url
            var post_url = Main.selected_post_url;
        } else {
            var post_url = '';
        }        
        
        if ( typeof Main.selected_post_accounts !== 'undefined' ) {
            // Set networks
            var networks = Main.selected_post_accounts;
        } else {
            var networks = [];
        }
        
        if ( typeof Main.selected_post_group !== 'undefined' ) {
            // Set group's id
            var group_id = Main.selected_post_group;
        } else {
            var group_id = [];
        }
        
        if ( typeof Main.selected_medias !== 'undefined' ) {
            // Set medias
            var medias = Object.values(Main.selected_medias);
        } else {
            var medias = [];
        }        

        // Set default status
        var status = 1;
        
        // Verify if status already exists
        if ( typeof Main.publish !== 'undefined' ) {
            status = Main.publish;
        }
        
        // Set default category value
        var category = {};
        
        // Verify if categories is defined
        if ( typeof Main.categories !== 'undefined' ) {
            category = Main.categories;
        }
        
        // Create an object with form data
        var data = {
            action: 'composer_publish_post',
            post: post,
            post_title: post_title,
            url: post_url,
            medias: medias,
            networks: networks,
            group_id: group_id,
            publish: status,
            date: date,
            current_date: datetime,
            category: category
        };
        
        // Set CSRF
        data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'composer_publish_post_status');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Quick schedule a post
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $('.schedule-post').submit(function (e) {
        e.preventDefault();
        
        // Get hour
        var hour = $('.schedule-post .midrub-calendar-time-hour').val();
        
        // Verify if time period exists
        if ( $('.schedule-post .midrub-calendar-time-period').length > 0 ) {
            
            // Get period
            var period = $('.schedule-post .midrub-calendar-time-period').val();
            
            if ( period === 'PM' ) {
                
                if ( hour >= 10 ) {
                    hour = 12 + parseInt(hour); 
                } else {
                    
                    hour = hour.replace('0', '');
                    
                    hour = 12 + parseInt(hour);
                }  
                
            }
            
        }
        
        // Set date time
        var schedtime = $( '.schedule-post .scheduler-quick-date' ).val() + ' ' + hour + ':' + $( '.schedule-post .midrub-calendar-time-minutes' ).val() + ':00';
        
        // Set current time
        var currentdate = new Date();
        
        // Set date time
        var datetime = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + ' ' + currentdate.getHours() + ':' + currentdate.getMinutes() + ':' + currentdate.getSeconds();
        
        // Set post's title
        var post_title = $('.schedule-post .quick-scheduler-title').val();
        
        // set message
        var post = $('.quick-new-post').val();
        
        Main.verify_for_url(post);
        
        if ( typeof Main.selected_post_url !== 'undefined' ) {
            
            // Set url
            var post_url = Main.selected_post_url;
            post = post.replace(post_url, '');
            
        } else {
            
            var post_url = '';
            
        }
        
        post = btoa(encodeURIComponent(post));
        
        // Remove non necessary characters
        
        post = post.replace('/', '-');
        post = post.replace(/=/g, '');
        
        if ( typeof Main.selected_quick_post_accounts !== 'undefined' ) {
            
            // Set networks
            var networks = Main.selected_quick_post_accounts;
            
        } else {
            
            var networks = [];
            
        }
        
        if ( typeof Main.selected_quick_post_group !== 'undefined' ) {
            
            // Set group's id
            var group_id = Main.selected_quick_post_group;
            
        } else {
            
            var group_id = [];
            
        }
        
        if ( typeof Main.quick_schedule.medias !== 'undefined' ) {
            
            // Set medias
            var medias = Object.values(Main.quick_schedule.medias);
            
        } else {
            
            var medias = [];
            
        }
       
        // Set default status
        var status = 1;
        
        // Create an object with form data
        var data = {
            action: 'composer_publish_post',
            post: post,
            post_title: post_title,
            url: post_url,
            medias: medias,
            networks: networks,
            group_id: group_id,
            publish: status,
            date: schedtime,
            current_date: datetime,
            category: {}
        };
        
        // Set CSRF
        data[$('.schedule-post').attr('data-csrf')] = $('input[name="' + $('.schedule-post').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'quick_scheduler_publish_post_status');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Publish a comment
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('submit', '#insights-posts .insights-posts-reactions-post', function (e) {
        e.preventDefault();
        
        // Get reactions type
        var type = $(this).attr('data-type');
        
        // Get reactions id
        var id = $(this).attr('data-id');
        
        // Get text message
        var msg = $(this).find('.reactions-msg').val();
        
        // Create an object with form data
        var data = {
            action: 'insights_display_send_react',
            type: type,
            id: id,
            msg: msg
        };
        
        // Set CSRF
        data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'insights_display_post_details');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Reply to a comment
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('submit', '.insights-posts-reactions-post-reply', function (e) {
        e.preventDefault();
        
        // Get reactions type
        var type = $(this).attr('data-type');
        
        // Get reactions id
        var id = $(this).attr('data-id');
        
        // Get parent id
        var parent = $(this).attr('data-parent');
        
        // Get text message
        var msg = $(this).find('.reactions-msg').val();
        
        if ( $('#insights-accounts').hasClass('active') ) {
            
            // Create an object with form data
            var data = {
                action: 'insights_accounts_send_react',
                type: type,
                id: id,
                msg: msg,
                parent: parent
            };

            // Set CSRF
            data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();
        
            // Make ajax call
            Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'insights_display_account_details');
            
        } else {
            
            // Create an object with form data
            var data = {
                action: 'insights_display_send_react',
                type: type,
                id: id,
                msg: msg,
                parent: parent
            };

            // Set CSRF
            data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();
        
            // Make ajax call
            Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'insights_display_post_details');
            
        }
        
        // Hide modal
        $('#insights-reply-comments').modal('hide');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });  
    
    /*
     * Publish a comment on online post
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.0
     */
    $(document).on('submit', '#insights-accounts .insights-posts-reactions-post', function (e) {
        e.preventDefault();
        
        // Get reactions type
        var type = $(this).attr('data-type');
        
        // Get account id
        var id = $( '.insights-accounts .insights-post-details-active .insights-account-details' ).attr('data-id');
        
        // Get text message
        var msg = $(this).find('.reactions-msg').val();
        
        // Get post id
        var parent = $(this).attr('data-id');
        
        // Create an object with form data
        var data = {
            action: 'insights_accounts_send_react',
            type: type,
            id: id,
            msg: msg,
            parent: parent
        };
        
        // Set CSRF
        data[$('.send-post').attr('data-csrf')] = $('input[name="' + $('.send-post').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'insights_display_account_details');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Create a group
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */
    $(document).on('submit', '.main .create-new-group-form', function (e) {
        e.preventDefault();
        
        // Get the group name
        var group_name = $('.main .accounts-manager-groups-enter-group-name').val();
        
        // Create an object with form data
        var data = {
            action: 'account_manager_create_accounts_group',
            group_name: group_name
        };
        
        // Set CSRF
        data[$('.main .create-new-group-form').attr('data-csrf')] = $('input[name="' + $('.main .create-new-group-form').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'account_manager_create_accounts_group');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });
    
    /*
     * Save a new RSS Feed
     * 
     * @param object e with global object
     * 
     * @since   0.0.7.2
     */
    $(document).on('submit', '.main .register-new-rss-feed', function (e) {
        e.preventDefault();
        
        // Get the rss's url
        var rss_url = $('.main .rss-feeds-enter-rss-url').val();
        
        // Create an object with form data
        var data = {
            action: 'rss_feeds_save_new_rss_feed',
            rss_url: rss_url
        };
        
        // Set CSRF
        data[$('.main .register-new-rss-feed').attr('data-csrf')] = $('input[name="' + $('.main .register-new-rss-feed').attr('data-csrf') + '"]').val();
        
        // Make ajax call
        Main.ajax_call(url + 'user/app-ajax/posts', 'POST', data, 'rss_feeds_save_new_rss_feed');
        
        // Display loading animation
        $('.page-loading').fadeIn('slow');
        
    });    
    
    /*******************************
    DEPENDENCIES
    ********************************/
    
    /*
     * Show emojis icon
     * 
     * @since   0.0.7.0
     */
    $( '.new-post' ).emojioneArea({
        pickerPosition: 'bottom',
        tonesStyle: 'bullet',
        attributes: {
            spellcheck : true,
            autocomplete   : 'on'
        }
        
    });
    
    // Verify if calendar is enabled
    if ( $( '#calendar' ).length > 0 ) {

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $('#calendar').fullCalendar('render');
        });

        $( '#calendar' ).fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            defaultView: 'basicWeek',
            navLinks: true,
            eventLimit: true,
            viewRender: function (view, element) {

                var parsed_date = new Date(Date.parse(view.calendar.currentDate._d));

                $('#calendar').fullCalendar('removeEventSources'); 

                switch(element[0].classList.value) {

                    case 'fc-view fc-month-view fc-basic-view':

                        var new_date = new Date(Date.parse(parsed_date.getFullYear() + '-' + (parsed_date.getMonth() + 1) + '-01 00:00:00'));
                        var start = new_date.getTime()/1000;
                        Main.scheduled_events(start,(start+3456000)); 

                        break;

                    case 'fc-view fc-basicWeek-view fc-basic-view':
                        var start = parsed_date.getTime()/1000;
                        Main.scheduled_events(start,(start+3456000)); 

                        break;  

                    case 'fc-view fc-basicDay-view fc-basic-view':
                        var start = parsed_date.getTime()/1000;
                        Main.scheduled_events(start,(start+86400)); 

                        break;                 

                }
            },
            events: [],
            eventRender: function (event, element, view) {
                var title = element.find('.fc-title');
                title.html(title.text());
                element.attr('ido',event.ido);
            },
            dayClick: function (start, end, allDay) {
                if ( !$(this).hasClass('fc-past') ) {
                    Main.quickSchedule(start, end, allDay);
                }
            }
        });

    }
    
    /*
     * Load methods by default 
     * 
     * @since   0.0.0.0
     */
    Main.load_posts_content();
    
    setTimeout(function(){
        Main.load_rss_feeds(1);
    }, 2000);
    
});