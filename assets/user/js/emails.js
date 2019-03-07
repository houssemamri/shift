jQuery(document).ready( function ($) {
    'use strict';

    var url = $('.home-page-link').attr('href');
    var emails = {
        publish: 1,
        edit: 0,
    },lists = {
        list_id: 0,
        fcon: 0,
        selist: 0,
        templates: []
    },composer = {
        paragraph: '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam pretium risus sapien, vel mollis neque lobortis et. Morbi consectetur elementum risus eu dignissim.</p>',
        header: '<h3 style="margin: 0;">Praesent ornare dui id enim tempor auctor</h3>',
        table: '<table cellpadding="0" data-rows="1" data-columns="2" data-border="0" data-border-color="" data-first-column="50" data-second-column="50" data-third-column="" data-fourth-column=""><tr><td width="50%"></td><td width="50%"></td></tr></table>',
        list: '<ol><li style="font-size:14px;color:#333333;">Lorem ipsum dolor sit amet.</li><li style="font-size:14px;color:#333333;">Consectetur adipiscing elit.</li><li style="font-size:14px;color:#333333;">Nullam pretium risus sapien.</li></ol>',
        button: '<a href="" class="tab-button" style="color:#333333;display: inline-block;background-color:#ffffff;border: 1px solid #cccccc;padding: 6px 12px;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;border-radius: 4px;">Button</a>',
        photo: '<button class="insert-image-in-template"><i class="icon-picture"></i></button>',
        space: '<div class="tab-space" style="width:100%;height:40px;"></div>',
        line: '<hr style="height: 20px;border: 0;border-top: 1px solid #eeeeee;">',
        html: '<div class="html"><button class="insert-html-in-template"><i class="fa fa-code"></i></button></div>',
    },medias = {
        ipage:1,
    },stats = {
        time: 30,
        template_id: 0
    };
    if($('#show-emails').length > 0) {
        Main.pagination.limit = 20;
    }
    $('.add-repeat').click(function(){
        
        if ( $('.post-plans>div>.list-group-item').length >= $('.planner').attr('data-act') ) {
            $('.planner .add-repeat').addClass('active');
            return;
        }        
        
        if ( $('.post-plans>div>p').length > 0 ) {
            $('.post-plans>div').empty();
        }
        
        var plan = '<div class="list-group-item"><div class="row"><div class="col-xl-2"><select class="days"><option value="1">' + Main.translation.mu193 + '</option><option value="2">' + Main.translation.mu194 + '</option><option value="3">' + Main.translation.mu195 + '</option><option value="4">' + Main.translation.mu196 + '</option><option value="5">' + Main.translation.mu197 + '</option><option value="6">' + Main.translation.mu198 + '</option><option value="7">' + Main.translation.mu199 + '</option></select></div><div class="col-xl-3 clean"><select class="plan-time"><option value="00:00">00:00</option><option value="01:00">01:00</option><option value="02:00">02:00</option><option value="03:00">03:00</option><option value="04:00">04:00</option><option value="05:00">05:00</option><option value="06:00">06:00</option><option value="07:00">07:00</option><option value="08:00">08:00</option><option value="09:00">09:00</option><option value="10:00">10:00</option><option value="11:00">11:00</option><option value="12:00">12:00</option><option value="13:00">13:00</option><option value="14:00">14:00</option><option value="15:00">15:00</option><option value="16:00">16:00</option><option value="17:00">17:00</option><option value="18:00">18:00</option><option value="19:00">19:00</option><option value="20:00">20:00</option><option value="21:00">21:00</option><option value="22:00">22:00</option><option value="23:00">23:00</option></select></div><div class="col-xl-3 "><select class="when"><option value="1">' + Main.translation.mu200 + '</option><option value="2">' + Main.translation.mu201 + '</option><option value="3">' + Main.translation.mu202 + '</option><option value="4">' + Main.translation.mu203 + '</option></select></div><div class="col-xl-2 clean"><select class="repeat"><option value="1">1 ' + Main.translation.mu204 + '</option><option value="2">2 ' + Main.translation.mu205 + '</option><option value="3">3 ' + Main.translation.mu205 + '</option><option value="4">4 ' + Main.translation.mu205 + '</option><option value="5">5 ' + Main.translation.mu205 + '</option><option value="6">6 ' + Main.translation.mu205 + '</option><option value="7">7 ' + Main.translation.mu205 + '</option><option value="8">8 ' + Main.translation.mu205 + '</option><option value="9">9 ' + Main.translation.mu205 + '</option><option value="10">10 ' + Main.translation.mu205 + '</option><option value="11">11 ' + Main.translation.mu205 + '</option><option value="12">12 ' + Main.translation.mu205 + '</option><option value="13">13 ' + Main.translation.mu205 + '</option><option value="14">14 ' + Main.translation.mu205 + '</option><option value="15">15 ' + Main.translation.mu205 + '</option><option value="16">16 ' + Main.translation.mu205 + '</option><option value="17">17 ' + Main.translation.mu205 + '</option><option value="18">18 ' + Main.translation.mu205 + '</option><option value="19">19 ' + Main.translation.mu205 + '</option><option value="20">20 ' + Main.translation.mu205 + '</option><option value="21">21 ' + Main.translation.mu205 + '</option><option value="22">22 ' + Main.translation.mu205 + '</option><option value="23">23 ' + Main.translation.mu205 + '</option><option value="24">24 ' + Main.translation.mu205 + '</option><option value="25">25 ' + Main.translation.mu205 + '</option><option value="26">26 ' + Main.translation.mu205 + '</option><option value="27">27 ' + Main.translation.mu205 + '</option><option value="28">28 ' + Main.translation.mu205 + '</option><option value="29">29 ' + Main.translation.mu205 + '</option><option value="30">30 ' + Main.translation.mu205 + '</option></select></div><div class="col-xl-2 text-right"><a href="#" class="delete-planner-rule">' + Main.translation.mm133 + '</a></div></div></div>';
        $('.post-plans>div').append(plan);
        
    });
    
    $(document).on('click', '.delete-planner-rule', function (e) {
        e.preventDefault();
        
        if ( $('.post-plans>div>.list-group-item').length <= $('.planner').attr('data-act') ) {
            $('.planner .add-repeat').removeClass('active');
        }  
        
        $(this).closest('.list-group-item').remove();
        
        if ( $('.post-plans>div>.list-group-item').length < 1 ){
            $('.post-plans>div').html('<p>' + Main.translation.mm190 + '</p>');
        }
        
    });
    $('.email-marketing>.nav-tabs>li>a').click(function(){
        if($(this).attr('href') === '#campaigns') {
            $('.email-marketing .btn-primary').show();
            $('.email-marketing .btn-success').hide();
        } else if($(this).attr('href') === '#lists') {
            $('.email-marketing .btn-success').show();
            $('.email-marketing .btn-primary').hide();
        } else{
            $('.email-marketing .btn-primary').hide();
            $('.email-marketing .btn-success').hide();
        }
    });
    $('.create-campaign').submit(function(e){
        e.preventDefault();
        // Create a new Campaign
        var name = $('#campaign-name').val();
        var desc = $('#campaign-description').val();
        
        $('#newCampaign').modal('toggle');
        
        // Create an object with form data
        var data = {'campaign': name, 'description': desc};
        
        data[$('.create-campaign').attr('data-csrf')] = $('input[name="' + $('.create-campaign').attr('data-csrf') + '"]').val();
        
        $.ajax({
            url: url + 'user/emails/query',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                campaigns_results(1);
                if (data.search('msuccess') > 0) {
                    
                    // Reset form
                    $('.create-campaign')[0].reset();
                    Main.popup_fon('subi', $(data).text(), 1500, 2000);
                    
                } else {
                    Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
                Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
            }
        });
    });
    $('.create-list').submit(function(e){
        e.preventDefault();
        
        // Create a New List
        var name = $('#list-name').val();
        var desc = $('#list-description').val();
        
        $('#newList').modal('toggle');
        
        // Create an object with form data
        var data = {'list': name, 'description': desc};
        
        data[$('.create-list').attr('data-csrf')] = $('input[name="' + $('.create-list').attr('data-csrf') + '"]').val();
        
        $.ajax({
            url: url + 'user/emails/query',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                lists_results(1);
                if (data.search('msuccess') > 0) {
                    // Reset form
                    $('.create-list')[0].reset();
                    Main.popup_fon('subi', $(data).text(), 1500, 2000);
                } else {
                    Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
                Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
            }
        });
    });
    $('.schedule-campaign').submit(function(e){
        e.preventDefault();
        // Schedule a template
        var all_planns = [];
        $('.post-plans .days').each(function (index) {
            var day = $('.post-plans .days').eq(index).val();
            var plan_date = $('.post-plans .plan-time').eq(index).val();
            var when = $('.post-plans .when').eq(index).val();
            var repeat = $('.post-plans .repeat').eq(index).val();
            if((day > 0) && (day < 8) && (plan_date !== '') && (when > 0) && (when < 5) && (repeat > 0) && (repeat < 31)) {
                all_planns.push([day,plan_date,when,repeat]);
            }
        });
        var currentdate = new Date();
        var datetime = currentdate.getFullYear() + '-' + (currentdate.getMonth() + 1) + '-' + currentdate.getDate() + ' ' + currentdate.getHours() + ':' + currentdate.getMinutes() + ':' + currentdate.getSeconds();
        var first_template = $('.template-editor').html();
        first_template = first_template.replace('style>','syle>');
        var first_list = lists.list_id;
        var first_condition = lists.fcon;
        var second_template = lists.selist;
        var campaign_id = $('.campaign-page').attr('data-id');
        var date = $('.datetime').val();
        var template_title = $('.post-title').val();
        all_planns = JSON.stringify(all_planns);
        if(emails.publish > 0) {
            if(lists.list_id === 0) {
                Main.popup_fon('sube', Main.translation.mu285, 1500, 2000);
                return;
            }
        }
        if(!date) {
            date = datetime;
        }
        if(!template_title) {
            Main.popup_fon('sube', Main.translation.mu286, 1500, 2000);
            return;
        }        
        if(!first_template) {
            Main.popup_fon('sube', Main.translation.mu146, 1500, 2000);
            return;
        }
        
        // Create an object with form data
        var data = {'publish': emails.publish, 'template_title': template_title, 'campaign_id': campaign_id, 'first_template': first_template, 'first_list': first_list, 'first_condition': first_condition, 'second_template': second_template, 'date': date, 'datetime': datetime, 'all_planns': all_planns};
        
        data[$('.upim').attr('data-csrf')] = $('input[name="' + $('.upim').attr('data-csrf') + '"]').val();
        
        $.ajax({
            url: url + 'user/emails/query',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data.search('msuccess') > 0) {
                    Main.popup_fon('subi', $(data).text(), 1500, 2000);
                    setTimeout(function () {
                        schedules();
                        document.getElementsByClassName('schedule-campaign')[0].reset();
                        $('.msuccess').remove();
                    }, 3000);
                    $('.emails-page .select-list.active').text(Main.translation.mu42);
                    $('.emails-page .select-list.active').removeClass('active');
                    $('.emails-page .show-advanced.active').removeClass('active');
                    $('.template-editor').html('<div class="template-builder" style="background-color: #f8f8f8;"><div style="width:80%;min-height:auto;margin:30px auto 70px;"><div class="email-template-header ui-droppable ui-sortable" style="width:100%;min-height:50px;background-color:#ffffff;padding:15px;"></div><div class="email-template-body ui-droppable ui-sortable" style="width:100%;margin:20px 0;min-height:350px;background-color:#ffffff;padding:15px;"></div><div class="email-template-footer ui-droppable ui-sortable" style="width:100%;min-height:70px;background-color:#ffffff;padding:15px;"></div></div></div>');
                    relod();
                    $('.post-title').val('');
                    $('.emails-page .socials').hide();
                    
                    // Empty datetime input
                    $('.datetime').val('');

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
                    
                    lists.list_id = 0;
                    lists.fcon = 0;
                    lists.selist = 0;
                    lists.templates = [];
                    
                } else {
                    Main.popup_fon('sube', $(data).text(), 1500, 2000);
                }
                show_template_lists();
                shistory(1);
            },
            complete: function () {
                $('img.display-none').fadeOut('slow');
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
                Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
            }
        });
        emails.publish = 1;
    });
    $(document).on('click', '.emails-page .select-list', function () {
        if (!$(this).hasClass('active')) {
            $('.emails-page .select-list.active').text(Main.translation.mu42);
            $('.emails-page .select-list.active').removeClass('active');
            $(this).addClass('active');
            $(this).text(Main.translation.mm120);
            lists.list_id = $(this).closest('.netsel').attr('data-id');
            lists.fcon = 0;
            lists.selist = 0;
            var index = $('.emails-page ul li.netsel').index($(this).closest('.netsel'));
            $('.emails-page ul li.socials').eq(index).find('.first-condition').val(0);
            $('.emails-page ul li.socials').eq(index).find('.non-mod-select').hide();
        }
    });
    $(document).on('click', '.emails-page .select-list.active', function () {
        if ($(this).hasClass('active')) {
            $(this).text(Main.translation.mu42);
            $(this).removeClass('active');
            lists.list_id = 0;
            lists.fcon = 0;
            lists.selist = 0;            
        }
    });
    $(document).on('click', '.emails-page .show-advanced', function () {
        // Display advanced options to send a template
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            var index = $('.emails-page ul li.netsel').index($(this).closest('.netsel'));
            $('.emails-page ul li.socials').eq(index).fadeOut('slow');
        } else {
            $(this).addClass('active');
            var index = $('.emails-page ul li.netsel').index($(this).closest('.netsel'));
            $('.emails-page ul li.socials').eq(index).fadeIn('slow');
        }
    });
    $(document).on('click', '.emails-page .besan', function (e) {
        // save smtp options
        var id = $(this).attr('id');
        var field = '';
        var val = 0;
        if(id === 'smtp-enable') {
            field = 'meta_val1';
            if ($('#smtp-enable').is(':checked')) {
                val = 1;
            }
        } else if(id === 'smtp-ssl') {
            field = 'meta_val6';
            if ($('#smtp-ssl').is(':checked')) {
                val = 1;
            }
        } else if(id === 'smtp-tls') {
            field = 'meta_val7';
            if ($('#smtp-tls').is(':checked')) {
                val = 1;
            }
        }
        
        // Create an object with form data
        var data = {'smtp_option': 'smtp_options', 'field': field, 'value': val, 'campaign_id': $('.campaign-page').attr('data-id')};
        
        data[$('.upim').attr('data-csrf')] = $('input[name="' + $('.upim').attr('data-csrf') + '"]').val();
        
        $.ajax({
            url: url + 'user/emails/query',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                Main.popup_fon('subi', Main.translation.mm2, 1500, 2000);
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
                Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
            },
        });
    });
    $(document).on('keyup', '.emails-page .pappio', function (e) {
        
        // Save smtp options
        var id = $(this).attr('id');
        var field = '';
        var val = $(this).val();
        if(id === 'smtp-host') {
            field = 'meta_val2';
        } else if(id === 'smtp-port') {
            field = 'meta_val3';
        } else if(id === 'smtp-username') {
            field = 'meta_val4';
        } else if(id === 'smtp-password') {
            field = 'meta_val5';
        } else if(id === 'smtp-protocol') {
            field = 'meta_val8';
        } else if(id === 'smtp-sender-name') {
            field = 'meta_val9';
        } else if(id === 'smtp-sender-email') {
            field = 'meta_val10';
        } else if(id === 'smtp-priority') {
            field = 'meta_val11';
        }
        
        // Create an object with form data
        var data = {'smtp_option': 'smtp_options', 'field': field, 'value': val, 'campaign_id': $('.campaign-page').attr('data-id')};
        
        data[$('.upim').attr('data-csrf')] = $('input[name="' + $('.upim').attr('data-csrf') + '"]').val();
        
        $.ajax({
            url: url + 'user/emails/query',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                Main.popup_fon('subi', Main.translation.mm2, 1500, 2000);
            },
            error: function (data, jqXHR, textStatus) {
                if ( data.statusText != 'OK' ) {
                    console.log(data);
                    Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
                }
            }
        });
    });
    
    $(document).on('click', '.draft-save', function (e) {
        // save the template as a draft
        e.preventDefault();
        emails.publish = 0;
        $('.schedule-campaign').submit();
    });
    
    $(document).on('click', '.composer-schedule-post', function (e) {
        
        // Send template
        e.preventDefault();
        
        // Hide calendar
        $('.midrub-planner').fadeOut('fast');
        
        emails.publish = 1;
        
        $('.schedule-campaign').submit();
        
    }); 
    
    $(document).on('click', '.new-campaign-email', function (e) {
        // New Template
        e.preventDefault();
        $('.template-editor').html('<div class="template-builder" style="background-color: #f8f8f8;"><div style="width:80%;min-height:auto;margin:30px auto 70px;"><div class="email-template-header ui-droppable ui-sortable" style="width:100%;min-height:50px;background-color:#ffffff;padding:15px;"></div><div class="email-template-body ui-droppable ui-sortable" style="width:100%;margin:20px 0;min-height:350px;background-color:#ffffff;padding:15px;"></div><div class="email-template-footer ui-droppable ui-sortable" style="width:100%;min-height:70px;background-color:#ffffff;padding:15px;"></div></div></div>');
        relod();
        emails.edit = 0;
    }); 
    
    $('.create-template').submit(function(e){
        e.preventDefault();
        var name = btoa(encodeURIComponent($('.msg-title').val()));
        var desc = btoa(encodeURIComponent($('.msg-body').val()));
        var campaign_id = $('.campaign_id').val();
        var template_id = $('.template_id').val();
        
        // Load gif loading icon
        $('img.display-none').fadeIn('slow');
        
        // Create an object with form data
        var data = {'template_title': name, 'template_body': desc, 'campaign_id': campaign_id, 'template_id': template_id };
        
        data[$('.upim').attr('data-csrf')] = $('input[name="' + $('.upim').attr('data-csrf') + '"]').val();
        
        $.ajax({
            url: url + 'user/emails/query',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data.search('msuccess') > 0) {
                    Main.popup_fon('subi', $(data).text(), 1500, 2000);
                    $('.msg-title').val('');
                    $('.msg-body').val('');
                    setTimeout(function(){history.go(-1);},5000);           
                } else {
                    Main.popup_fon('sube', $(data).text(), 1500, 2000);
                }
            },
            complete: function () {
                $('img.display-none').fadeOut('slow');
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
            },
        });
    });
    $(document).on('click', '#nav-campaigns .pagination li a,#nav-lists .pagination li a,#nav-show-emails .pagination li a,#sent-emails .pagination li a,#nav-unactive-emails .pagination li a,#nav-history .pagination li a', function (e) {
        e.preventDefault();
        if($(this).closest('.tab-pane').attr('id') === 'nav-campaigns') {
            emails.page = $(this).attr('data-page');
            campaigns_results($(this).attr('data-page'));
        } else if($(this).closest('.tab-pane').attr('id') === 'nav-show-emails') {
            lists.page = $(this).attr('data-page');
            emails_results($(this).attr('data-page'));
        } else if($(this).closest('.tab-pane').attr('id') === 'temp_bac') {
            emails.page = $(this).attr('data-page');
            shistory($(this).attr('data-page'));
        } else if($(this).closest('.tab-pane').attr('id') === 'sent-emails') {
            emails.page = $(this).attr('data-page');
            sehistory($(this).attr('data-page'));            
        } else if($(this).closest('.tab-pane').attr('id') === 'nav-unactive-emails') {
            lists.page = $(this).attr('data-page');
            unactive_emails_results($(this).attr('data-page'));            
        } else {
            lists.page = $(this).attr('data-page');
            lists_results($(this).attr('data-page'));              
        }
    });
    $('.first-condition').change(function(){
        
        if ( $(this).val() > 0 ) {
            
            $(this).closest('li').find('.non-mod-select').show();
            
            var sed = ' ';
            
            if ( lists.templates ) {
                
                var temps = lists.templates;
                
                for(var f = 0; f < temps.length; f++) {
                    
                    sed += '<option value="' + temps[f][0] + '">' + temps[f][1] + '</option>';
                    
                }
                
            }
            
            $(this).closest('li').find('.second-template').html(sed);
            
        } else {
            
            $(this).closest('li').find('.non-mod-select').hide();
            
        }
        
        if($(this).closest('li').attr('data-id') === lists.list_id) {
            
            lists.fcon = $(this).val();
            lists.selist = $(this).closest('li').find('.second-template').val();

        }
        
    });
    $('#dropdownMenu1').click(function () {
        var sed = ' ';
        if(lists.templates) {
            var temps = lists.templates;
            for(var f = 0; f < temps.length; f++) {
                sed += '<a href="#" class="dropdown-item" data-id="' + temps[f][0] + '">' + temps[f][1] + '</a>'
            }
        }
        $(document).find('.sort-stats-by-template').html(sed);
    });
    $('.select-range').click(function(){
        // Display statistics per time
        $('.emails-page .select-range').removeClass('active');
        $(this).addClass('active');
    });
    $('.get-campaign-statistics').click(function(){
        // Display Campaign Statistics
        $('#rations').empty();
        gets_stats_for(stats.template_id,stats.time);
    });
    $(document).on('click', '.sort-stats-by-template a', function(e){
        e.preventDefault();
        // Display stats per template
        $('#rations').empty();
        stats.template_id = $(this).attr('data-id');
        gets_stats_for(stats.template_id,stats.time);
    });
    $(document).on('click', '.emails-page .select-range', function(e){
        e.preventDefault();
        // Display stats per date
        $('#rations').empty();
        stats.time = $(this).attr('data-value');
        gets_stats_for(stats.template_id,stats.time);
    });    
    $('.second-template').change(function() {
        if($(this).closest('li').attr('data-id') === lists.list_id) {
            lists.selist = $(this).val();
        }
    });    
    $('.delete-campaign,.del-list').click(function () {
        // Try to delete a Campaign
        $('.confirm').fadeIn('slow');
    });
    $(document).on('click', '.confirm .no', function (e) {
        e.preventDefault();
        $('.confirm').fadeOut('slow');
    });
    $(document).on('click', '.delete-cam', function (e) {
        // Deletes a campaign
        e.preventDefault();
        if($('.delete-campaign').length > 0) {
            var uri = $('.delete-campaign').attr('data-id');
            var te = 0;
        } else {
            var uri = $(this).attr('data-id');
            var te = 1;
        }
        $.ajax({
            url: url + 'user/emails/dcampaign/' + uri,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data == 1) {
                    Main.popup_fon('subi', Main.translation.mm147, 1500, 2000);
                    if(te === 0) {
                        setTimeout(function(){document.location.href = url+'user/emails';},2000);
                    } else {
                        campaigns_results(1);
                    }
                } else {
                    Main.popup_fon('sube', Main.translation.mm148, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                Main.popup_fon('sube', Main.translation.mm148, 1500, 2000);
            },
        });
    });
    $(document).on('click','.delete-email',function(e) {
        e.preventDefault();
        // Delete an email address from list
        var $this = $(this);
        var list = $this.attr('data-list');
        var meta = $this.attr('data-meta');
        // create an object with form data
        $.ajax({
            url: url + 'user/emails/dmeta/'+meta+'/?list='+list,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var table = $this.closest('table');
                if(data == 1){
                    $this.closest('tr').remove();
                } else{
                    Main.popup_fon('sube', Main.translation.mm149, 1500, 2000);
                }
                if(table.find('tr').length < 1) {
                    table.find('.list-emails').html('<tr><td>'+Main.translation.mm150+'</td></tr>');
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
                Main.popup_fon('sube', Main.translation.mm151, 1500, 2000);
            },
        });
    });
    $(document).on('click', '.delete-list', function (e) {
        // Deletes a list
        e.preventDefault();
        if($('.del-list').length > 0) {
            var uri = $('.del-list').attr('data-id');
            var te = 0;
        } else {
            var uri = $(this).attr('data-id');
            var te = 1;
        }
        $.ajax({
            url: url + 'user/emails/dlist/' + uri,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if (data == 1) {
                    Main.popup_fon('subi', Main.translation.mm152, 1500, 2000);
                    if(te === 0) {
                        setTimeout(function(){document.location.href = url+'user/emails';},2000);
                    } else {
                        lists_results(1);
                    }
                } else {
                    Main.popup_fon('sube', Main.translation.mm153, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log(data);
                Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
            },
        });
    });    
    $(document).on('click', '.emails-page .deleteTemplate', function () {
        // this function deletes templates from database
        var templateId = $(this).attr('data-id');
        var $this = $(this);
        $.ajax({
            url: url + 'user/emails/dtemplate/' + templateId,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data === 1){
                    $this.closest('li').remove();
                    Main.popup_fon('subi', Main.translation.mm193, 1500, 2000);
                    if($('.deleteTemplate').length < 1) {   
                        $('.show-templates-lists-here>ul').html('<p class="no-results-found">' + Main.translation.mm154 + '</p>');
                    }
                } else {
                    Main.popup_fon('sube', Main.translation.mm194, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                Main.popup_fon('sube', Main.translation.mm194, 1500, 2000);
                console.log('Request failed: ' + textStatus);
            },
        });
    });
    $(document).on('click', '.emails-page .select-temp', function () {
        // this function get template body
        var templateId = $(this).attr('data-id');
        var $this = $(this);
        $.ajax({
            url: url + 'user/emails/stemplate/' + templateId,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data) {
                    var conte = data[1];
                    conte = conte.replace('syle>','style>');
                    $('.post-title').val(data[0]);
                    $('.template-editor').html(conte);
                    $('#campaign-tab-send-mail').addClass('active');
                    $('#campaign-tab-templates').removeClass('active');
                    $('.campaign-menu>li').eq(1).removeClass('active');
                    $('.campaign-menu>li').eq(0).addClass('active');
                    var attrs = $(document).find('.email-template-header').attr('style');
                    if(attrs) {
                        var res = parse_styles(attrs, 'padding:', 3, '');
                        if(res) {
                            var pad = res[1];
                            pad = pad.replace('px','');
                            $('.header-padding').val(pad);
                        }
                    }
                    var attrs = $(document).find('.email-template-body').attr('style');
                    if(attrs) {
                        var res = parse_styles(attrs, 'padding:', 3, '');
                        if(res) {
                            var pad = res[1];
                            pad = pad.replace('px','');
                            $('.body-padding').val(pad);
                        }
                    }
                    var attrs = $(document).find('.email-template-footer').attr('style');
                    if(attrs) {
                        var res = parse_styles(attrs, 'padding:', 3, '');
                        if(res) {
                            var pad = res[1];
                            pad = pad.replace('px','');
                            $('.footer-padding').val(pad);
                        }
                    }
                    relod();
                    emails.edit = templateId;
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
            }
        });
    });    
    $(document).on('click', '.select-csv', function (e) {
        // Select a CSV File
        e.preventDefault();
        $('.load-csv').click();
    });
    $('.load-csv').on('change',function(){
        if($('.load-csv').val()) {
            $('.alert-msg').html('<p class="msuccess block">'+Main.translation.mm155+'</p>');
        }
    });
    $(document).on('click', '.schedule-submit', function (e) {
        // Submit Schedule Form
        e.preventDefault();
        $('.schedule-campaign').submit();
    });
    $(document).on('click', '#popup_lists_edit .delete-item-tem-lists', function (e) {
        // Delete item from lists
        $(this).closest('.panel-default').remove();
    });    
    $(document).on('click', '.get-csv-sent', function (e) {
        // Export sent email in a CSV file
        e.preventDefault();
        var sched_id = $('.sent-info').attr('data-id');
        var type = $('.sent-info').attr('data-type');
        window.open(url + 'user/schedules/' + type + '/' + sched_id + '/1/1');
    });    
    $(document).on('click', '.delete-schedules', function (e) {
        // Delete a Schedules
        e.preventDefault();
        var scheduledId = $(this).attr('data-id');
        var $this = $(this);
        $.ajax({
            url: url + 'user/emails/dsched/' + scheduledId,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                Main.popup_fon('subi', Main.translation.scheduled_template_deleted_successfully, 1500, 2000);
                shistory(1);
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
            }
        });
    });
    var type = '';
    var jos = 1;
    function relod() {
        $(document).find('.template-tools .tab-content .general-elements li').draggable({
            helper: 'clone',
            start: function (e, ui) {
                $(ui.helper).css({'position':'absolute','z-index':'9999'});
                type = $(this).data('type');
                    $(document).find('td').droppable({
                        over: function (event, ui) {
                            $(this).addClass('active');
                            jos = 2;
                        },
                        out: function( event, ui ) {
                            $(this).removeClass('active');
                            jos = 1;
                        },
                        drop: function( event, ui ) {
                            $(this).removeClass('active');
                            var data = '';
                            switch(type) {
                                case 'paragraph':
                                    data = composer.paragraph+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>';
                                    break;
                                case 'header':
                                    data = composer.header+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>';
                                    break;
                                case 'list':
                                    data = composer.list+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>';
                                    break;
                                case 'button':
                                    data = composer.button+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>';
                                    break;
                                case 'photo':
                                    data = composer.photo+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>';
                                    break;
                                case 'space':
                                    data = composer.space+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>';
                                    break;
                                case 'line':
                                    data = composer.line+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>';
                                    break;
                                case 'html':
                                    data = composer.html+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>';
                                    break;
                            }
                            if(data) {
                                $(this).append('<div class="tem-item">' + data + '</div>');
                            }
                            type = '';
                        }
                    });
            }
        });
        $(document).find('.email-template-header,.email-template-body,.email-template-footer').droppable({
            over: function (event, ui) {
                $(this).addClass('active');
            },
            out: function( event, ui ) {
                $(this).removeClass('active');
            },
            drop: function( event, ui ) {
                $(this).removeClass('active');
                var data = '';
                switch(type) {
                    case 'paragraph':
                        data = composer.paragraph;
                        break;
                    case 'header':
                        data = composer.header;
                        break;
                    case 'table':
                        data = composer.table;
                        break;
                    case 'list':
                        data = composer.list;
                        break;
                    case 'button':
                        data = composer.button;
                        break;
                    case 'photo':
                        data = composer.photo;
                        break;
                    case 'space':
                        data = composer.space;
                        break;
                    case 'line':
                        data = composer.line;
                        break;
                    case 'html':
                        data = composer.html;
                        break;
                }

                if(data) {
                    if(jos === 1) {
                        $(this).append('<div class="tem-item">' + data + '</div>');
                        type = '';
                    } else {
                        jos = 1;
                    }
                }
            }
        });
        $(document).find('.email-template-header,.email-template-body,.email-template-footer').sortable();
        var content = $(document).find('.only-css-here').html();
        if(content) {
            content = $(document).find('.only-css-here').html();
            var coni = content.replace('<syle>','');
            coni = coni.replace('</syle>','');
            $('.for-css-template textarea').val(coni);
        }
    }
    $(document).on('change', '.temp-bg-color', function() {
        // Change template background color
        var newColor = $(this).val();
        if(newColor) {
            $('.emails-page .template-builder').css({'background-color':newColor});
            $('.emails-page .template-builder').css({'padding':'15px'});
        }
    });
    $(document).on('change', '.temp-header-bg-color', function() {
        // Change template's header background color
        var newColor = $(this).val();
        if(newColor) {
            $('.emails-page .email-template-header').css({'background-color':newColor});
        }
    });
    $(document).on('change', '.temp-body-bg-color', function() {
        // Change template's body background color
        var newColor = $(this).val();
        if(newColor) {
            $('.emails-page .email-template-body').css({'background-color':newColor});
        }
    });
    $(document).on('change', '.temp-footer-bg-color', function() {
        // Change template's footer background color
        var newColor = $(this).val();
        if(newColor) {
            $('.emails-page .email-template-footer').css({'background-color':newColor});
        }
    });
    $(document).on('click', '#temp_disable_header', function() {
        if($('#temp_disable_header').is(':checked')) {
            $('.email-template-header').hide();
        } else {
            $('.email-template-header').show();
        }
    });
    $(document).on('click', '#temp_disable_footer', function() {
        if($('#temp_disable_footer').is(':checked')) {
            $('.email-template-footer').hide();
        } else {
            $('.email-template-footer').show();
        }
    });
    // Show edit button on hover
    $(document).on('mouseenter','.emails-page td>.tem-item', function() {
        var width = $(this).width()/2;
        var height = $(this).height()/2;
        $(this).find('.edit-this-temp-item').css({'margin-left':(width-15)+'px','margin-top':'-'+(height+15)+'px','display':'block'});
    });
    // Hide edit button on hover
    $(document).on('mouseleave','.emails-page td>.tem-item', function() {
        $(document).find('.edit-this-temp-item').hide();
    });    
    $(document).on('click', '.media-gallery-images .show-image-preview', function () {
        $('.media-gallery-images ul li.show-preview').fadeOut('slow');
        var index = $('.media-gallery-images ul li').index($(this).closest('li'));
        index++;
        if(index !== medias.media_img) {
            var img = $(this).closest('li').attr('data-image');
            $('.media-gallery-images ul li').eq(index).html('<img src="' + img + '">');
            $('.media-gallery-images ul li').eq(index).fadeIn('slow');
            medias.media_img = index;
        } else {
            medias.media_img = '';
        }
    });

    $(document).on('click', '.media-gallery-images .delete-gallery-media', function () {
        var id = $(this).closest('li').attr('data-id');
        var index = $('.media-gallery-images ul li').index($(this).closest('li'));
        $('#image_upload').modal('toggle');
        $.ajax({
            url: url + 'user/delete-media/' + id,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data) {
                    $('.media-gallery-images ul li').eq(index).remove();
                    $('.media-gallery-images ul li').eq(index).remove();
                    Main.popup_fon('subi', data, 1500, 2000);
                    get_media(1, 'image');
                } else {
                    Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                Main.popup_fon('sube', Main.translation.mm3, 1500, 2000);
            },
            complete: function () {
                setTimeout(function(){$('#image_upload').modal('toggle');},2000);
            }
        });
    });
    
    $(document).on('click', '.btn-add-selected-photos', function () {
        
        var img = $( '.multimedia-gallery-quick-schedule li a.media-selected' ).attr('data-url');
        
        if( $( '#nav-general' ).hasClass( 'active' ) ) {
            
            $(medias.mid).html('<img src="' + img + '" style="max-width: 100%;">'+'<button class="edit-this-temp-item" style="display: none"><i class="fas fa-pencil-alt"></i></button>');
            $( '.multimedia-gallery-quick-schedule li a' ).removeClass('media-selected');
            $( '.multimedia-gallery-selected-medias' ).fadeOut('slow');

        } else if($('#temp_bac').hasClass('active')) {
            
            if ( $('#show-image-for-content-template').is(':checked') ) {
                    
                $('.template-builder').css({'background-image':"url('" + img + "')", 'background-size': 'cover'});
                $('.template-builder').attr('data-src', img);
                
            } else {
                    
                $('.template-builder').attr('data-src', img);
                
            }
            
            $('.emails-page .template-builder').css({'padding':'15px'});
            
        } else if ( $('#temp_header').hasClass('active') ) {
            
            if ( $('#show-image-for-header-template').is(':checked') ) {
                               
                $('.email-template-header').css({'background-image':"url('" + img + "')", 'background-size': 'cover'});
                $('.email-template-header').attr('data-src', img );

            } else {
                
                $('.email-template-header').attr('data-src', img);

            }            
        } else if ( $('#temp_body').hasClass('active') ) {
            
            if( $('#show-image-for-body-template').is(':checked') ) {
                
                $('.email-template-body').css({'background-image':"url('" + img + "')", 'background-size': 'cover'});
                $('.email-template-body').attr('data-src', img);

            } else {
                
                $('.email-template-body').attr('data-src', img);
                    
            }
            
        } else if ( $('#temp_footer').hasClass('active') ) {
            
            if ( $('#show-image-for-footer-template').is(':checked') ) {
                
                $('.email-template-footer').css({'background-image':"url('" + img + "')", 'background-size': 'cover'});
                $('.email-template-footer').attr('data-src', img);

            } else {
                
                $('.email-template-footer').attr('data-src', img );
                    
            }            
        }
        
        $('#image_upload').modal('toggle');
        
    });
    
    $(document).on('click', '.media-images-next', function(){
        var page = medias.ipage;
        page++;
        medias.ipage = page;
        get_media(page, 'image');
    });
    $(document).on('click', '.media-images-back', function(){
        var page = medias.ipage;
        page--;
        medias.ipage = page;
        get_media(page, 'image');
    });
    $(document).on('click', '#show-image-for-content-template', function() {
        if($('#show-image-for-content-template').is(':checked')) {
            $('.template-builder').css({'background-image':"url('" + $('.template-builder').attr('data-src') + "')", 'background-size': 'cover'});
        } else {
            $('.template-builder').css({'background-image':"url('')", 'background-size': 'cover'});
        }
        $('.emails-page .template-builder').css({'padding':'15px'});
    });
    $(document).on('click', '#show-image-for-header-template', function() {
        if($('#show-image-for-header-template').is(':checked')) {
            $('.email-template-header').css({'background-image':"url('" + $('.email-template-header').attr('data-src') + "')", 'background-size': 'cover'});
        } else {
            $('.email-template-header').css({'background-image':"url('')", 'background-size': 'cover'});
        }
    });
    $(document).on('click', '#show-image-for-body-template', function() {
        if($('#show-image-for-body-template').is(':checked')) {
            $('.email-template-body').css({'background-image':"url('" + $('.email-template-body').attr('data-src') + "')", 'background-size': 'cover'});
        } else {
            $('.email-template-body').css({'background-image':"url('')", 'background-size': 'cover'});
        }
    });
    $(document).on('click', '#show-image-for-footer-template', function() {
        if($('#show-image-for-footer-template').is(':checked')) {
            $('.email-template-footer').css({'background-image':"url('" + $('.email-template-footer').attr('data-src') + "')", 'background-size': 'cover'});
        } else {
            $('.email-template-footer').css({'background-image':"url('')", 'background-size': 'cover'});
        }
    });
    var imsi = 1;
    var ped = Math.round(new Date().getTime()/1000);
    $(document).on('click','.emails-page .edit-this-temp-item',function(e) {
        var $this = $(this);
        var top = $this.offset().top-58;
        var left = $this.offset().left;
        medias.mid = $this.closest('.tem-item');
        if($this.closest('.tem-item').find('.insert-image-in-template').length > 0) {
            $('#image_upload').modal('show');
        } else if($this.closest('.tem-item').find('img').length > 0) {
            get_tools_for(top,left,1);
        }
        imsi = 2;
    });
    $(document).on('click','.emails-page .tem-item',function(e) {
        e.preventDefault();
        var $this = $(this);
        if(Math.round(new Date().getTime()/1000) === ped){return;}else{ped = Math.round(new Date().getTime()/1000);}
        setTimeout(function () {
            if($('.show-template-composer-tools').length < 1 && !$('#image_upload').hasClass('show')) {
               imsi = 1; 
            }
            if(imsi === 1) {
                if((e.offsetX > -1) && (e.offsetX < 23) && (e.offsetY > -1) && (e.offsetY < 21)) {
                    var top = $($this).offset().top-58;
                    var left = $($this).offset().left-100;
                    medias.mid = $this.closest('.tem-item');
                    if(($this.find('.insert-image-in-template').length > 0) && ($this.find('table').length < 1)) {
                        $('#image_upload').modal('show');
                    } else if(($this.find('.insert-html-in-template').length > 0) && ($this.find('table').length < 1)) {
                        $('#popup_html_edit').modal('show');
                    } else if(($this.find('.html').length > 0) && ($this.find('table').length < 1)) {
                        get_tools_for(top,left+100,6);                        
                    } else if(($this.find('img').length > 0) && ($this.find('table').length < 1)) {
                        get_tools_for(top,left,1);
                    } else if(($this.find('h1').length > 0 || $this.find('h2').length > 0 || $this.find('h3').length > 0 || $this.find('h4').length > 0 || $this.find('h5').length > 0) && ($this.find('table').length < 1)) {
                        get_tools_for(top,left,2);
                    } else if(($this.find('p').length > 0) && ($this.find('table').length < 1)) {
                        get_tools_for(top,left,3);
                    } else if($this.find('table').length > 0) {
                        var attrs = $(medias.mid).find('table').attr('style');
                        if(attrs) {
                            var res = parse_styles(attrs, 'background-color:', 3, '');
                            if(res) {
                                $('.tab-background-color').val(rgb2hex(res[1]));
                            } else {
                                $('.tab-background-color').val('#FFFFFF');
                            }
                        } else {
                            $('.tab-background-color').val('#FFFFFF');
                        }
                        var rows = $(medias.mid).find('table').attr('data-rows');
                        var columns = $(medias.mid).find('table').attr('data-columns');
                        var border = $(medias.mid).find('table').attr('data-border');
                        var border_color = $(medias.mid).find('table').attr('data-border-color');
                        var first = $(medias.mid).find('table').attr('data-first-column');
                        var second = $(medias.mid).find('table').attr('data-second-column');
                        var third = $(medias.mid).find('table').attr('data-third-column');
                        var fourth = $(medias.mid).find('table').attr('data-fourth-column');
                        var cellpadding = $(medias.mid).find('table').attr('cellpadding');
                        $('.first-column').val(first);
                        $('.second-column').val(second);
                        $('.third-column').val(third);
                        $('.fourth-column').val(fourth);
                        $('.tab-rows').val(rows);
                        $('.tab-columns').val(columns);
                        $('.tab-border').val(border);
                        $('.tab-cellpadding').val(cellpadding);
                        if(border_color) {
                            $('.tab-border-color').val(border_color);
                        } else {
                            $('.tab-border-color').val('#FFFFFF');
                        }
                        $('#popup_table').modal('show');
                    } else if(($this.find('hr').length > 0) && ($this.find('table').length < 1)) {
                        $('#popup_line').modal('show');
                        var attrs = $(medias.mid).find('hr').attr('style');
                        if(attrs) {
                            var res = parse_styles(attrs, 'border-top:', 3, '');
                            var b = res[1].split('px');
                            $('.line-height').val(b[0]);
                            var c = res[1].split('#');
                            $('.lin-background-color').val('#'+c[1]);
                        }
                    } else if(($this.find('.tab-space').length > 0) && ($this.find('table').length < 1)) {
                        $('#popup_space').modal('show');
                        var attrs = $(medias.mid).find('.tab-space').attr('style');
                        if(attrs) {
                            var res = parse_styles(attrs, 'height:', 3, '');
                            var lo = res[1].split('px');
                            $('.space-height').val(lo[0]);
                        }
                    } else if(($this.find('.tab-button').length > 0) && ($this.find('table').length < 1)) {
                        get_tools_for(top,left,4);
                    } else if((($this.find('ol').length > 0) || ($this.find('ul').length > 0)) && ($this.find('table').length < 1)) {
                        get_tools_for(top,left,5);
                    }
                }
            } else {
                imsi = 1;
            }
        }, 300);
    });
    $(document).on('change', '.space-height', function() {
        var space_height = $('.space-height').val();
        if(!isNaN(space_height)) {
            $(medias.mid).find('.tab-space').css('height',space_height+'px');
        }
    });
    $(document).on('change', '.footer-height', function() {
        // Change footer height
        var space_height = $('.footer-height').val();
        if(!isNaN(space_height)) {
            $('.email-template-footer').css('height',space_height+'px');
        }
    });
    $(document).on('change', '.header-height', function() {
        // Change header height
        var space_height = $('.header-height').val();
        if(!isNaN(space_height)) {
            $('.email-template-header').css('height',space_height+'px');
        }
    });
    $(document).on('change', '.header-padding', function() {
        // Change header padding
        var space_height = $('.header-padding').val();
        if(!isNaN(space_height)) {
            $('.email-template-header').css('padding',space_height+'px');
        }
    });
    $(document).on('change', '.body-padding', function() {
        // Change body padding
        var space_height = $('.body-padding').val();
        if(!isNaN(space_height)) {
            $('.email-template-body').css('padding',space_height+'px');
        }
    });
    $(document).on('change', '.footer-padding', function() {
        // Change footer padding
        var space_height = $('.footer-padding').val();
        if(!isNaN(space_height)) {
            $('.email-template-footer').css('padding',space_height+'px');
        }
    });    
    $(document).on('change', '.fix-template-width', function() {
        // Change template width
        var space_width = $('.fix-template-width').val();
        if(!isNaN(space_width)) {
            $('.template-builder>div').css('width',space_width+'px');
        }
    });
    $(document).on('keyup', '.for-css-template textarea', function() {
        // Edit Styles from here
        var content = $(this).val();
        if(content) {
            $('.only-css-here').html('<style>' + content + '</style>');
        } else {
            $('.only-css-here').empty();
        }
    });    
    $(document).on('change', '.body-height', function() {
        
        // Change body height
        var space_height = $('.body-height').val();

        if(!isNaN(space_height)) {
            $('.email-template-body').css('height',space_height+'px');
        }
    });    
    $(document).on('change', '.linmon', function() {
        var line_height = $('.line-height').val();
        var lin_background_color = $('.lin-background-color').val();
        if(!isNaN(line_height)) {
            $(medias.mid).find('hr').css('border-top',line_height+'px solid '+lin_background_color);
        }
    });
    $(document).on('change', '.tabut', function() {
        $(medias.mid).find('.tab-button').text($('.tab-button-text').val());
        $(medias.mid).find('.tab-button').css('color',$('.tab-border-text-color').val());
        $(medias.mid).find('.tab-button').css('background-color',$('.tab-border-background-color').val());
        var border = $('.tab-border-button').val();
        var background = $('.tab-border-button-color').val();
        if(!isNaN(border)) {
            $(medias.mid).find('.tab-button').css('border',border+'px solid '+background);
        }
    });    
    $(document).on('change', '.tabmon', function() {
        var rows = $('.tab-rows').val();
        var columns = $('#popup_table .tab-columns').val();
        var first_column = $('.first-column').val();
        var second_column = $('.second-column').val();
        var third_column = $('.third-column').val();
        var fourth_column = $('.fourth-column').val();
        var tab_border = $('.tab-border').val();
        var tab_border_color = $('.tab-border-color').val();
        var tab_background_color = $('.tab-background-color').val();
        var tab_cellpadding = $('.tab-cellpadding').val();
        var cellpadding = '';
        if(tab_cellpadding > 0) {
            if(tab_cellpadding > 15) {
                tab_cellpadding = 15;
            }
            cellpadding = 'padding: ' + tab_cellpadding + 'px;';
        }
        var border = '';
        if(tab_border > 0) {
            border = ' style="border: ' + tab_border + 'px solid ' + tab_border_color + cellpadding + ';"';
        }
        if(border && cellpadding) {
            border = border.replace(';"',';' + cellpadding + '"');
        } else if(cellpadding) {
            border = ' style="' + cellpadding + '"';
        }
        var tab_init = '<table data-rows="' + rows + '" data-columns="' + columns + '" data-border="' + tab_border + '" data-border-color="' + tab_border_color + '" data-first-column="' + first_column + '" data-second-column="' + second_column + '" data-third-column="' + third_column + '" data-fourth-column="' + fourth_column + '">';
        if(!isNaN(rows)) {
            for(var c = 0; c < rows; c++) {
                var colls = '';
                if(!isNaN(columns)) {
                    for(var d = 0; d < columns; d++) {
                        var size = '';
                        if(d === 0 && first_column > 0) {
                            size = ' width="' + first_column + '%"';
                        }
                        if(d === 1 && second_column > 0) {
                            size = ' width="' + second_column + '%"';
                        }
                        if(d === 2 && third_column > 0) {
                            size = ' width="' + third_column + '%"';
                        }
                        if(d === 3 && fourth_column > 0) {
                            size = ' width="' + fourth_column + '%"';
                        }
                        if(d > 3) {
                            break;
                        }
                        colls += '<td' + border + size + '></td>';
                    }
                }
                tab_init += '<tr>' + colls + '</tr>';
            }
        }
        tab_init += '</table>';
        $(medias.mid).html(tab_init);
        if(tab_background_color) {
            $(medias.mid).find('table').css({'background-color':tab_background_color});
        }
    });
    // Delete the template item
    $(document).on('click','.delete-the-template-item',function(){
        $(medias.mid).remove();
    });
    // Delete the template table
    $(document).on('click','#delete-table-from-template, #delete-line-from-template, #delete-space-from-template, #delete-button-from-template',function(){
        var $this = $(this);
        setTimeout(function(){
            if($('#popup_line').hasClass('show')) {
                $(medias.mid).remove();
                $('#popup_line').modal('hide');
            } else if($('#popup_space').hasClass('show')) {
                $(medias.mid).remove();
                $('#popup_space').modal('hide');
            } else if($('#popup_button_edit').hasClass('show')) {
                $(medias.mid).remove();
                $('#popup_button_edit').modal('hide');
            } else {
                $(medias.mid).remove();
                $(document).find('#delete-table-from-template').removeAttr('checked');
                $('#popup_table').modal('hide');
            }
            $this.removeAttr('checked');
        },500);
    });
    // Close the tolbox
    $(document).click(function() {
        $(document).find('.show-template-composer-tools').animate({opacity:'0.3'},300,function() {
            $(document).find('.show-template-composer-tools').remove();
        });
    });
    // Add a link for image
    $(document).on('click','body .enter-a-link-template-item',function(){
        if($('#popup_paragraph_edit').hasClass('show') || $('#popup_lists_edit').hasClass('show')) {
            $('.change-tem-link-color').show();
            medias.m = $(this);
        } else {
            $('.change-tem-link-color').hide();
        }
        $('#dialog-form').show();
        $('#dialog-form').dialog();
    });
    // Insert Link
    $(document).on('click','body .add-tem-link',function(){
        
        var newLink = $('#tem-url-field').val();

        if ( newLink ) {
            
            if ( $('#popup_paragraph_edit').hasClass('show') ) {
                
                var imi = $('.edit-paragraph-textarea').val();
                imi = stripHTML(imi);
                var im = '<a href="' + newLink + '" style="color:' + $('.change-tem-link-color').val() + '">' + imi + '</a>';
                $('.edit-paragraph-textarea').val(im);
                
            } else if ( $('#popup_lists_edit').hasClass('show') ) {
                
                var imi = $(medias.m).closest('.panel').find('textarea').val();
                imi = stripHTML(imi);
                var im = '<a href="' + newLink + '" style="color:' + $('.change-tem-link-color').val() + '">' + imi + '</a>';
                $(medias.m).closest('.panel').find('textarea').val(im);
                
            } else {
                
                if ( $(medias.mid).find('img').length > 0 ) {
                    
                    var imi = $(medias.mid).find('img').context.innerHTML;
                    imi = imi.split('<img');
                    imi = imi[1].split('>');
                    imi = '<img' + imi[0] + '>';
                    var im = '<a href="' + newLink + '">' + imi + '</a>';
                    $(medias.mid).html(im);
                    
                } else {
                    
                    $(medias.mid).find('a').attr('href',newLink);
                    
                }
                
            }
            
        }
        
        $('#tem-url-field').val('');
        $('#dialog-form').hide();
        $('#dialog-form').dialog('close');
        
    });    
    // Remove an image link
    $(document).on('click','.remove-a-link-template-item',function(){
        if($('#popup_lists_edit').hasClass('show')) {
            var imi = $(medias.m).closest('.panel').find('textarea').val();
            imi = stripHTML(imi);
            $(medias.m).closest('.panel').find('textarea').val(imi);
        } else if($('#popup_paragraph_edit').hasClass('show')) {
            var imi = $(medias.m).closest('.modal').find('textarea').val();
            imi = stripHTML(imi);
            $(medias.m).closest('.modal').find('textarea').val(imi);            
        } else {
            var imi = $(medias.mid).find('img').context.innerHTML;
            imi = imi.split('<img');
            imi = imi[1].split('>');
            var im = '<img' + imi[0] + '>';
            $(medias.mid).html(im);            
        }
    });
    // Align item's childrens to right
    $(document).on('click','.align-right-template-item',function(){
        $(medias.mid).css('text-align','right');
    });
    // Align item's childrens to center
    $(document).on('click','.align-center-template-item',function(){
        $(medias.mid).css('text-align','center');
    });
    // Align item's childrens to left
    $(document).on('click','.align-left-template-item',function(){
        $(medias.mid).css('text-align','left');
    });
    // Resize image
    $(document).on('click','.resize-image-template-item',function(){
        $(medias.mid).find('img').css('width',$(this).attr('data-value'));
    });
    // Add Bold Style
    $(document).on('click','.add-bold-style-template-item',function(){
        $(medias.mid).css('font-weight','600');
    });
    // Add Italic Style
    $(document).on('click','.add-italic-style-template-item',function(){
        $(medias.mid).css('font-style','italic');
    });    
    // Change header
    $(document).on('click','.change-header',function(){
        var type = $(this).attr('data-type');
        $(medias.mid).html('<' + type + ' style="margin: 0;">' + $(medias.mid).text() + '<' + type + '/>');
    });
    // Edit header text
    $(document).on('click','.edit-header-text',function(){
        $('.edit-header-textarea').val($(medias.mid).text());
        if($(medias.mid).attr('style')) {
            $('.edit-header-textarea').attr('style',$(medias.mid).attr('style'));
        } else {
            $('.edit-header-textarea').removeAttr('style');
        }
    });
    // Save edited header text
    $(document).on('click','#popup_header_edit .btn-primary',function(){
        $(medias.mid).children().html($('.edit-header-textarea').val());
        $(medias.mid).attr('style',$('.edit-header-textarea').attr('style'));
    });
    // Save edited lists
    $(document).on('click','#popup_lists_edit .btn-primary',function(){
        var mi = $('#popup_lists_edit').find('.panel-default').length;
        if(mi) {
            var min = '';
            for(var d = 0; d < mi; d++) {
                var teg = $('#popup_lists_edit').find('textarea')[d].value;
                var te = $('#popup_lists_edit').find('textarea')[d].getAttribute('style');
                min += '<li style="' + te + '">' + teg + '</li>';
            }
            $(medias.mid).children().html(min);
        } else {
            $(medias.mid).remove();
        }
    });
    // Save html code
    $(document).on('click','#popup_html_edit .btn-primary',function(){
        var html = $('#popup_html_edit').find('.edit-header-textarea').val();
        if(html) {
            $(medias.mid).find('.html').html(html);
        }
    });    
    // Edit paragraph text
    $(document).on('click','.edit-paragraph-text',function(){
        $('.edit-paragraph-textarea').removeAttr('style');
        $('.change-tem-text-color').val('#FFFFFF');
        $('.edit-paragraph-textarea').val($(medias.mid).children().html());
        $('.edit-paragraph-textarea').attr('style',$(medias.mid).attr('style'));
    });
    // Edit button text
    $(document).on('click','.edit-button-text',function(){
        $('.tab-button-text').val($(medias.mid).find('.tab-button').text());
        var attrs = $(medias.mid).find('.tab-button').attr('style');
        if(attrs) {
            var res = parse_styles(attrs, 'border:', 3, '');
            if(res) {
                var b = res[1].split('px');
                $('.tab-border-button').val(b[0]);
                if(res[1].search('#') > -1) {
                    var si = res[1].split('#');
                    si = '#'+si[1];
                } else {
                    var si = res[1].split('rgb');
                    si = rgb2hex('rgb'+si[1]);               
                }
                
                $('.tab-border-button-color').val(si);
            }
            res = parse_styles(attrs, 'color:', 3, '');
            if(res) {
                $('.tab-border-text-color').val(rgb2hex(res[1]));
            }
            res = parse_styles(attrs, 'background-color:', 3, '');
            if(res) {
                $('.tab-border-background-color').val(rgb2hex(res[1]));
            }
        }
    });
    // Edit button text
    $(document).on('click','.edit-tem-lists',function(){
        var sun = '';
        if($(medias.mid).find('ul').length > 0) {
            for(var s = 0; s < $(medias.mid).find('ul').find('li').length; s++) {
                sun += temison($(medias.mid).find('ul').find('li')[s].innerHTML,$(medias.mid).find('ul').find('li')[s].getAttribute('style'));
            }
        } else if($(medias.mid).find('ol').length > 0) {
            for(var s = 0; s < $(medias.mid).find('ol').find('li').length; s++) {
                sun += temison($(medias.mid).find('ol').find('li')[s].innerHTML,$(medias.mid).find('ol').find('li')[s].getAttribute('style'));
            }
        }
        $('#popup_lists_edit .media-gallery').html(sun);
    });
    // Edit html form
    $(document).on('click','.edit-tem-html',function(){
        $('#popup_html_edit').find('.edit-header-textarea').val($(medias.mid).find('.html').html());
    });    
    // Save edited header text
    $(document).on('click','#popup_paragraph_edit .btn-primary',function(){
        var attrs = $('.edit-paragraph-textarea').attr('style');
        $(medias.mid).attr('style',attrs);
        $(medias.mid).find('p').html($('.edit-paragraph-textarea').val());
    });
    // Change the paragraph color text
    $(document).on('change', '.change-tem-text-color', function() {
        if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
            var color = $(this).val();
            $(this).closest('.panel').find('textarea').css('color',color);
        } else {
            var color = $(this).val();
            $('.edit-paragraph-textarea').css('color',color);            
        }
    });
    // Change the header color text
    $(document).on('change', '.change-tem-header-color', function() {
        var color = $(this).val();
        $('.edit-header-textarea').css('color',color);
    });    
    // Align the text to left
    $(document).on('click', '.align-tem-text-to-left', function() {
        $(this).closest('.modal').find('textarea').css('text-align','left');
    });
    // Align the text to center
    $(document).on('click', '.align-tem-text-to-center', function() {
        $(this).closest('.modal').find('textarea').css('text-align','center');
    });
    // Align the text to right
    $(document).on('click', '.align-tem-text-to-right', function() {
        $(this).closest('.modal').find('textarea').css('text-align','right');
    });
    // Align the text to justify
    $(document).on('click', '.align-tem-text-to-justify', function() {
        $(this).closest('.modal').find('textarea').css('text-align','justify');
    });
    // Add bold to text
    $(document).on('click', '.bold-tem-text', function() {
        if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
            var attrs = $('.edit-header-textarea').attr('style');
        } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
            var attrs = $(this).closest('.panel').find('textarea').attr('style');
        } else {
            var attrs = $('.edit-paragraph-textarea').attr('style');
        }
        if(attrs) {
            var res = parse_styles(attrs, 'font-weight:', 3, '');
            if(res) {
                if(res[1] === '400') {
                    if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                        $('.edit-header-textarea').css('font-weight','600');
                    } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                        $(this).closest('.panel').find('textarea').css('font-weight','600');
                    } else {
                        $('.edit-paragraph-textarea').css('font-weight','600');
                    }
                } else {
                    if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                        $('.edit-header-textarea').css('font-weight','400');
                    } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                        $(this).closest('.panel').find('textarea').css('font-weight','400');
                    } else {
                        $('.edit-paragraph-textarea').css('font-weight','400');
                    }
                }
            } else {
                if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                    $('.edit-header-textarea').css('font-weight','600');
                } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                    $(this).closest('.panel').find('textarea').css('font-weight','600');
                } else {
                    $('.edit-paragraph-textarea').css('font-weight','600');
                }
            }
        } else {
            if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                $('.edit-header-textarea').css('font-weight','600');
            } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                $(this).closest('.panel').find('textarea').css('font-weight','600');
            } else {
                $('.edit-paragraph-textarea').css('font-weight','600');
            }
        }
    });
    // Add italic to text
    $(document).on('click', '.italic-tem-text', function() {
        if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
            var attrs = $('.edit-header-textarea').attr('style');
        } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
            var attrs = $(this).closest('.panel').find('textarea').attr('style');
        } else {
            var attrs = $('.edit-paragraph-textarea').attr('style');
        }
        if(attrs) {
            var res = parse_styles(attrs, 'font-style:', 3, '');
            if(res) {
                if(res[1] === 'normal') {
                    if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                        $('.edit-header-textarea').css('font-style','italic');
                    } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                        $(this).closest('.panel').find('textarea').css('font-style','italic');
                    } else {
                        $('.edit-paragraph-textarea').css('font-style','italic');
                    }
                } else {
                    if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                        $('.edit-header-textarea').css('font-style','normal');
                    } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                        $(this).closest('.panel').find('textarea').css('font-style','normal');
                    } else {
                        $('.edit-paragraph-textarea').css('font-style','normal');
                    }
                }
            } else {
                if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                    $('.edit-header-textarea').css('font-style','italic');
                } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                    $(this).closest('.panel').find('textarea').css('font-style','italic');
                } else {
                    $('.edit-paragraph-textarea').css('font-style','italic');
                }
            }
        } else {
            if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                $('.edit-header-textarea').css('font-style','italic');
            } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                $(this).closest('.panel').find('textarea').css('font-style','italic');
            } else {
                $('.edit-paragraph-textarea').css('font-style','italic');
            }
        }
    });
    // Add underline to text
    $(document).on('click', '.underline-tem-text', function() {
        if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
            var attrs = $('.edit-header-textarea').attr('style');
        } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
            var attrs = $(this).closest('.panel').find('textarea').attr('style');
        } else {
            var attrs = $('.edit-paragraph-textarea').attr('style');
        }
        if(attrs) {
            var res = parse_styles(attrs, 'text-decoration:', 3, '');
            if(res) {
                if(res[1] === 'none') {
                    if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                        $('.edit-header-textarea').css('text-decoration', 'underline');
                    } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                        $(this).closest('.panel').find('textarea').css('text-decoration', 'underline');
                    } else {
                        $('.edit-paragraph-textarea').css('text-decoration', 'underline');
                    }
                } else {
                    if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                        $('.edit-header-textarea').css('text-decoration', 'none');
                    } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                        $(this).closest('.panel').find('textarea').css('text-decoration', 'none');
                    } else {
                        $('.edit-paragraph-textarea').css('text-decoration', 'none');
                    }
                }
            } else {
                if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                    $('.edit-header-textarea').css('text-decoration', 'underline');
                } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                    $(this).closest('.panel').find('textarea').css('text-decoration', 'underline');
                } else {
                    $('.edit-paragraph-textarea').css('text-decoration', 'underline');
                }
            }
        } else {
            if($(this).closest('.modal').attr('id') === 'popup_header_edit') {
                $('.edit-header-textarea').css('text-decoration', 'underline');
            } else if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                $(this).closest('.panel').find('textarea').css('text-decoration', 'underline');
            } else {
                $('.edit-paragraph-textarea').css('text-decoration', 'underline');
            }
        }
    });
     // Add underline to paragraph text
    $(document).on('click', '.add-underline-style-template-item', function() {
        var attrs = $(medias.mid).attr('style');
        if(attrs) {
            var res = parse_styles(attrs, 'text-decoration:', 3, '');
            if(res) {
                if(res[1] === 'none') {
                    $(medias.mid).css('text-decoration', 'underline');
                } else {
                    $(medias.mid).css('text-decoration', 'none');
                }
            } else {
                $(medias.mid).css('text-decoration', 'underline');
            }
        } else {
            $(medias.mid).css('text-decoration', 'underline');
        }
    });   
    // Add indent to text
    $(document).on('click', '.indent-tem-text', function() {
        $('.edit-paragraph-textarea').css('text-indent', '50px');
    });
    // Add outdent to text
    $(document).on('click', '.outdent-tem-text', function() {
        $('.edit-paragraph-textarea').css('text-indent', '0');
    });
    // Add indent to paragraph text
    $(document).on('click', '.add-indent-style-template-item', function() {
        $(medias.mid).css('text-indent', '50px');
    });
    // Add outdent to paragraph text
    $(document).on('click', '.add-outdent-style-template-item', function() {
        $(medias.mid).css('text-indent', '0');
    });
    // Change ol to ul
    $(document).on('click', '.ul-template-item', function() {
        if($(medias.mid).find('ol').length > 0) {
            var set = $(medias.mid).html();
            set = set.replace('ol>','ul>');
            $(medias.mid).html(set);
        }
    });
    // Change ul to ol
    $(document).on('click', '.ol-template-item', function() {
        if($(medias.mid).find('ul').length > 0) {
            var set = $(medias.mid).html();
            set = set.replace('ul>','ol>');
            $(medias.mid).html(set);
        }
    });
    // Add new ul or ol child
    $(document).on('click', '.new-li-template-item', function() {
        if($(medias.mid).find('ul').length > 0) {
            $(medias.mid).find('ul').append('<li style="font-size:14px;color:#333333;">Nullam pretium risus sapien.</li>');
        } else if($(medias.mid).find('ol').length > 0) {
            $(medias.mid).find('ol').append('<li style="font-size:14px;color:#333333;">Nullam pretium risus sapien.</li>');
        }
    });    
    // Increase font size
    $(document).on('click', '.increase-item-tem-text-size', function() {
        if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
            var attrs = $(this).closest('.panel').find('textarea').attr('style');
        } else {
            var attrs = $('.edit-paragraph-textarea').attr('style');
        }
        if(attrs) {
            var res = parse_styles(attrs, 'font-size:', 1, 'px');
            if(res) {
                if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                    $(this).closest('.panel').find('textarea').css(res[0], res[1]);
                } else {
                   $('.edit-paragraph-textarea').css(res[0], res[1]);
                }
            } else {
                if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                    $(this).closest('.panel').find('textarea').css('font-size', '15px');
                } else {                
                    $('.edit-paragraph-textarea').css('font-size', '17px');
                }
            }
        } else {
            if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                $(this).closest('.panel').find('textarea').css('font-size', '15px');
            } else {                
                $('.edit-paragraph-textarea').css('font-size', '17px');
            }
        }
    });
    // Decrease font size
    $(document).on('click', '.decrease-item-tem-text-size', function() {
        if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
            var attrs = $(this).closest('.panel').find('textarea').attr('style');
        } else {
            var attrs = $('.edit-paragraph-textarea').attr('style');
        }
        if(attrs) {
            var res = parse_styles(attrs, 'font-size:', 2, 'px');
            if(res) {
                if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                    $(this).closest('.panel').find('textarea').css(res[0], res[1]);
                } else {
                    $('.edit-paragraph-textarea').css(res[0], res[1]);
                }
            } else {
                if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                    $(this).closest('.panel').find('textarea').css('font-size', '13px');
                } else {                
                    $('.edit-paragraph-textarea').css('font-size', '15px');
                }
            }
        } else {
            if($(this).closest('.modal').attr('id') === 'popup_lists_edit') {
                $(this).closest('.panel').find('textarea').css('font-size', '13px');
            } else {                
                $('.edit-paragraph-textarea').css('font-size', '15px');
            }
        }
    });
    // Get tabs
    $(document).on('click', '.campaign-menu>li>a', function(e) {
        e.preventDefault();
        $(document).find('.emails-page .campaign-menu>li').removeClass('active');
        $(document).find('.emails-page .campaign-tabs>div').removeClass('active');
        var href = $(this).attr('href');
        $(href).addClass('active');
        $(this).closest('li').addClass('active');
    });
    function get_tools_for(top,left,num) {
        var tabs = '';
        var clas = '';
        if(num === 1) {
            clas = ' first-tools-area';
            tabs += '<div class="col-xl-2"><button class="align-left-template-item"><i class="fas fa-align-left"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="align-center-template-item"><i class="fas fa-align-center"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="align-right-template-item"><i class="fas fa-align-right"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="enter-a-link-template-item"><i class="fa fa-link"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="remove-a-link-template-item"><i class="fas fa-unlink"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="resize-image-template-item" data-value="25%">25%</button></div>';
            tabs += '<div class="col-xl-2"><button class="resize-image-template-item" data-value="50%">50%</button></div>';    
            tabs += '<div class="col-xl-2"><button class="resize-image-template-item" data-value="100%">100%</button></div>'; 
            tabs += '<div class="col-xl-2"><button class="delete-the-template-item"><i class="icon-trash"></i></button></div>';        
        } else if(num === 2) {
            clas = ' second-tools-area';
            tabs += '<div class="col-xl-2"><button class="edit-header-text" data-toggle="modal" data-target="#popup_header_edit"><i class="fas fa-pen"></i></button></div>'; 
            tabs += '<div class="col-xl-2"><button class="align-left-template-item"><i class="fas fa-align-left"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="align-center-template-item"><i class="fas fa-align-center"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="align-right-template-item"><i class="fas fa-align-right"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="change-header" data-type="h1"><strong>H1</strong></button></div>';
            tabs += '<div class="col-xl-2"><button class="change-header" data-type="h2"><strong>H2</strong></button></div>';
            tabs += '<div class="col-xl-2"><button class="change-header" data-type="h3"><strong>H3</strong></button></div>';
            tabs += '<div class="col-xl-2"><button class="change-header" data-type="h4"><strong>H4</strong></button></div>';    
            tabs += '<div class="col-xl-2"><button class="change-header" data-type="h5"><strong>H5</strong></button></div>';
            tabs += '<div class="col-xl-2"><button class="delete-the-template-item"><i class="icon-trash"></i></button></div>';        
        } else if(num === 3) {
            clas = ' second-tools-area';
            tabs += '<div class="col-xl-2"><button class="edit-paragraph-text" data-toggle="modal" data-target="#popup_paragraph_edit"><i class="fas fa-pen"></i></button></div>'; 
            tabs += '<div class="col-xl-2"><button class="align-left-template-item"><i class="fas fa-align-left"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="align-center-template-item"><i class="fas fa-align-center"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="align-right-template-item"><i class="fas fa-align-right"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="add-bold-style-template-item"><i class="fas fa-bold"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="add-italic-style-template-item"><i class="fas fa-italic"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="add-underline-style-template-item"><i class="fas fa-underline"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="add-indent-style-template-item"><i class="fas fa-indent"></i></div>';    
            tabs += '<div class="col-xl-2"><button class="add-outdent-style-template-item"><i class="fas fa-outdent"></i></button></div>';
            tabs += '<div class="col-xl-2"><button class="delete-the-template-item"><i class="icon-trash"></i></button></div>';        
        } else if(num === 4) {
            clas = ' first-tools-area';
            tabs += '<div class="col-xl-3"><button class="edit-button-text" data-toggle="modal" data-target="#popup_button_edit"><i class="fas fa-pen"></i></button></div>'; 
            tabs += '<div class="col-xl-3"><button class="align-left-template-item"><i class="fas fa-align-left"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="align-center-template-item"><i class="fas fa-align-center"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="align-right-template-item"><i class="fas fa-align-right"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="enter-a-link-template-item"><i class="fas fa-link"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="delete-the-template-item"><i class="icon-trash"></i></button></div>';        
        } else if(num === 5) {
            clas = ' second-tools-area';
            tabs += '<div class="col-xl-3"><button class="edit-tem-lists" data-toggle="modal" data-target="#popup_lists_edit"><i class="fas fa-pen"></i></button></div>'; 
            tabs += '<div class="col-xl-3"><button class="new-li-template-item"><i class="far fa-plus-square"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="add-indent-style-template-item"><i class="fas fa-indent"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="add-outdent-style-template-item"><i class="fas fa-outdent"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="ul-template-item"><i class="fas fa-list"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="ol-template-item"><i class="fas fa-list-ol"></i></button></div>';
            tabs += '<div class="col-xl-3"><button class="delete-the-template-item"><i class="icon-trash"></i></button></div>';        
        } else if(num === 6) {
            clas = ' third-tools-area';
            tabs += '<div class="col-xl-6"><button class="edit-tem-html" data-toggle="modal" data-target="#popup_html_edit"><i class="fas fa-pen"></i></button></div>';
            tabs += '<div class="col-xl-6"><button class="delete-the-template-item"><i class="icon-trash"></i></button></div>';        
        }
        setTimeout(function() {
            $('<div class="show-template-composer-tools' + clas + '" data-type="' + num + '"><div class="row">' + tabs + '</div></div>').insertAfter('section');
            $(document).find('.show-template-composer-tools').css({top:top+'px',left:left+'px','z-index':7});
        },200);
    }
    function stripHTML(str){
        // Remove HTML tags
        var strippedText = $('<div/>').html(str).text();
        return strippedText;
    }    
    function campaigns_results(page) {
        
        // Empty the pagination
        $( '#nav-campaigns .pagination' ).empty();
        
        // Display emails by page
        $.ajax({
            url: url + 'user/show-campaigns/' + page + '/email',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                
                if(data.total) {
                    var tot;
                    Main.pagination.page = page;
                    Main.show_pagination( '#nav-campaigns', data.total );
                    for(var m = 0; m < data.campaigns.length; m++) {
                        var campaign_id = data.campaigns[m].campaign_id;
                        var name = data.campaigns[m].name;
                        var description = data.campaigns[m].description;
                        var gettime = Main.calculate_time(data.campaigns[m].created, data.date);
                        if(typeof tot === 'undefined') {
                            tot = '<li>'
                                    + '<div class="row">'
                                        + '<div class="col-xl-10">'
                                            + '<h3>'
                                                + name
                                            + '</h3>'
                                        + '</div>'
                                        + '<div class="col-xl-2">'
                                            + '<div class="btn-group pull-right">'
                                                + '<a href="' + url + 'user/emails/campaign/' + campaign_id + '" class="btn btn-default"><i class="icon-login"></i> ' + Main.translation.mm136 + '</a>'
                                                + '<a href="#" data-id="' + campaign_id + '" class="btn btn-default delete-cam">'
                                                    + '<i class="icon-trash"></i>'
                                                + '</a>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</li>';
                        } else {
                            tot += '<li>'
                                    + '<div class="row">'
                                        + '<div class="col-xl-10">'
                                            + '<h3>'
                                                + name
                                            + '</h3>'
                                        + '</div>'
                                        + '<div class="col-xl-2">'
                                            + '<div class="btn-group pull-right">'
                                                + '<a href="' + url + 'user/emails/campaign/' + campaign_id + '" class="btn btn-default"><i class="icon-login"></i> ' + Main.translation.mm136 + '</a>'
                                                + '<a href="#" data-id="' + campaign_id + '" class="btn btn-default delete-cam">'
                                                    + '<i class="icon-trash"></i>'
                                                + '</a>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</li>';
                        }
                    }
                    $( 'ul.midrub-emails-campaigns' ).html(tot);
                } else {
                    $( 'ul.midrub-emails-campaigns' ).html('<p class="no-results-found">' + Main.translation.mm179 + '</p>');
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                $( 'ul.midrub-emails-campaigns' ).html('<p class="no-results-found">' + Main.translation.mm179 + '</p>');
            }
        });
    }
    
    function show_template_lists() {
        // display schedules by campaign_id
        var campaign_id = $('.campaign-page').attr('data-id');
        $.ajax({
            url: url + 'user/emails/get-templates/' + campaign_id,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                
                if ( data ) {
                    
                    var tot = ' ';
                    var sd = [];
                    
                    for ( var m = 0; m < data.length; m++ ) {
                        
                        tot += '<li>'
                                    + '<h4>'
                                        + data[m].title
                                        + ' <div class="btn-group pull-right">'
                                            + '<button type="button" data-type="main" class="btn btn-default select-temp" data-id="' + data[m].template_id + '">'
                                                + '<i class="icon-note"></i>'
                                                + Main.translation.mm123
                                            + '</button>'
                                            + '<button type="button" class="btn btn-default show-accounts deleteTemplate" data-id="' + data[m].template_id + '">'
                                                + '<i class="icon-trash"></i>'
                                            + '</button>'
                                        + '</div>'
                                    + '</h4>'
                                + '</li>';
                        
                        sd.push([data[m].template_id,data[m].title]);
                        
                    }
                    
                    lists.templates = sd;
                    
                    $( '.show-templates-lists-here > ul' ).html(tot);
                    
                } else {
                    
                    $( '.show-templates-lists-here > ul' ).html( '<p class="no-results-found">' + Main.translation.mm154 + '</p>' );
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                
                console.log('Request failed: ' + textStatus);
                $( '.show-templates-lists-here > ul' ).html( '<p class="no-results-found">' + Main.translation.mm154 + '</p>' );
                
            }
            
        });
        
    }   
    
    function schedules() {
        // display schedules by campaign_id
        var campaign_id = $('.campaign-page').attr('data-id');
        $.ajax({
            url: url + 'user/emails/schedules/' + campaign_id,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data.length) {
                    var tot = '';
                    for(var m = 0; m < data.length; m++) {
                        var gettime = Main.calculate_time(data[m].send_at, data[m].tim);
                        if(typeof tot === 'undefined') {
                            tot = '<li><div class="col-xl-10 col-sm-8 col-xs-6 "><h3>'+Main.translation.mm156+data[m].title+Main.translation.mm157+data[m].name+'</h3><span>'+gettime+'</span></div><div class="col-xl-2 col-sm-4 col-xs-6  text-right"><button type="button" class="btn btn-danger delete-schedules" data-id="'+data[m].scheduled_id+'"><i class="icon-trash"></i> '+Main.translation.mm133+'</button></div></li>';
                        } else {
                            tot += '<li><div class="col-xl-10 col-sm-8 col-xs-6 "><h3>'+Main.translation.mm156+data[m].title+Main.translation.mm157+data[m].name+'</h3><span>'+gettime+'</span></div><div class="col-xl-2 col-sm-4 col-xs-6  text-right"><button type="button" class="btn btn-danger delete-schedules" data-id="'+data[m].scheduled_id+'"><i class="icon-trash"></i> '+Main.translation.mm133+'</button></div></li>';
                        }                
                    }
                    $('.feeds-rss').html(tot);
                } else {
                    $('.feeds-rss').html('');
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
            }
        });
    }
    function shistory(page) {
        // display sent templates
        var campaign_id = $('.campaign-page').attr('data-id');
        $.ajax({
            url: url + 'user/emails/shistory/' + campaign_id + '?page='+page,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data) {
                    Main.pagination.page = page;
                    Main.show_pagination( '#nav-history', data.total );
                    if(data.scheds.length) {
                        var tot = '';
                        for(var m = 0; m < data.scheds.length; m++) {
                            var gettime = Main.calculate_time(data.scheds[m].send_at, data.scheds[m].tim);
                            if(data.scheds[m].a < 1) {
                                var bi = '<p><a href="#" class="delete-schedules" data-id="' + data.scheds[m].scheduled_id + '"><span class="badge badge-info badge-danger"><i class="icon-trash"></i> ' + Main.translation.mm133 + '</span></a></p>';
                            } else {
                                var bi = '<p><a href="' + url + 'user/emails/sent/' + data.scheds[m].scheduled_id + '"><span class="badge badge-info">'+data.scheds[m].sent+' '+Main.translation.mm160+'</span></a><a href="' + url + 'user/emails/opened/' + data.scheds[m].scheduled_id + '"""><span class="badge badge-info badge-opened">'+data.scheds[m].readi+' '+Main.translation.mm159+'</span></a><a href="' + url + 'user/emails/unread/' + data.scheds[m].scheduled_id + '"><span class="badge badge-info badge-non">'+data.scheds[m].unread+' '+Main.translation.mm161+'</span></a><a href="' + url + 'user/emails/unsubscribed/' + data.scheds[m].scheduled_id + '"><span class="badge badge-info badge-danger">'+data.scheds[m].unsub+' '+Main.translation.mm162+'</span></a></p>';
                            }
                            var si = '<li><h4>'+Main.translation.mm156+data.scheds[m].title+Main.translation.mm158+data.scheds[m].name+' <span class="pull-right">'+gettime+'</span></h4>' + bi + '</li>';
                            if(typeof tot === 'undefined') {
                                tot = si;
                            } else {
                                tot += si;
                            }                
                        }
                        $('#nav-history .histories').html(tot);
                    } else {
                        $('#nav-history .histories').html('<li><p>'+Main.translation.mm163+'</p></li>');
                    }
                } else {
                    $('#nav-history .histories').html('<li><p>'+Main.translation.mm163+'</p></li>');
                }
            },
            error: function (data, jqXHR, textStatus) {
                $('#nav-history .histories').html('<li><p>'+Main.translation.mm163+'</p></li>');
            }
        });
    }
    function sehistory(page) {
        // display sent templates
        var sched_id = $('.sent-info').attr('data-id');
        var type = $('.sent-info').attr('data-type');
        $.ajax({
            url: url + 'user/schedules/' + type + '/' + sched_id + '/' + page,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data.total) {
                    var tot;
                    Main.pagination.page = page;
                    Main.show_pagination(data.total);
                    for(var m = 0; m < data.emails.length; m++) {
                        var list_id = data.emails[m].list_id;
                        var email = data.emails[m].body;
                        var meta_id = data.emails[m].meta_id;
                        if(typeof tot === 'undefined') {
                            tot = '<tr><td>'+email+'</td></tr>';
                        } else {
                            tot += '<tr><td>'+email+'</td></tr>';
                        }
                    }
                    $('#sent-emails .list-emails').html(tot);
                } else {
                    $('#sent-emails .list-emails').html('<tr><td>'+Main.translation.mm164+'</td></tr>');
                    $('.get-csv-sent').remove();
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                $('#sent-emails .list-emails').html('<tr><td>'+Main.translation.mm164+'</td></tr>');
                $('.get-csv-sent').remove();
            }
        });
    }
    function lists_results(page) {
        
        // Empty the pagination
        $( '#nav-lists .pagination' ).empty();
        
        // display lists by page
        $.ajax({
            url: url + 'user/show-lists/' + page + '/email',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data.total) {
                    var tot;
                    Main.pagination.page = page;
                    Main.show_pagination( '#nav-lists', data.total );
                    for(var m = 0; m < data.lists.length; m++) {
                        var list_id = data.lists[m].list_id;
                        var name = data.lists[m].name;
                        var description = data.lists[m].description;
                        var gettime = Main.calculate_time(data.lists[m].created, data.date);
                        
                        if ( typeof tot === 'undefined' ) {
                            
                            tot = '<li>'
                                    + '<div class="row">'
                                        + '<div class="col-xl-10">'
                                            + '<h3>'
                                                + name
                                            + '</h3>'
                                        + '</div>'
                                        + '<div class="col-xl-2">'
                                            + '<div class="btn-group pull-right">'
                                                + '<a href="' + url+'user/emails/lists/' + list_id + '" class="btn btn-default"><i class="icon-login"></i> ' + Main.translation.mm136 + '</a>'
                                                + '<a href="#" data-id="' + list_id + '" class="btn btn-default delete-list">'
                                                    + '<i class="icon-trash"></i>'
                                                + '</a>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</li>';
                        
                        } else {
                            
                            tot += '<li>'
                                    + '<div class="row">'
                                        + '<div class="col-xl-10">'
                                            + '<h3>'
                                                + name
                                            + '</h3>'
                                        + '</div>'
                                        + '<div class="col-xl-2">'
                                            + '<div class="btn-group pull-right">'
                                                + '<a href="' + url+'user/emails/lists/' + list_id + '" class="btn btn-default"><i class="icon-login"></i> ' + Main.translation.mm136 + '</a>'
                                                + '<a href="#" data-id="' + list_id + '" class="btn btn-default delete-list">'
                                                    + '<i class="icon-trash"></i>'
                                                + '</a>'
                                            + '</div>'
                                        + '</div>'
                                    + '</div>'
                                + '</li>';
                        
                        }
                        
                    }
                    
                    $( 'ul.midrub-emails-lists' ).html(tot);
                    
                } else {
                    $( 'ul.midrub-emails-lists' ).html('<p class="no-results-found">' + Main.translation.mm180 + '</p>');
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                $( 'ul.midrub-emails-lists' ).html('<p class="no-results-found">' + Main.translation.mm180 + '</p>');
            }
            
        });
        
    }
    
    function emails_results(page) {
        // display emails by list
        var list  = $('.list-details').attr('data-id');
        $.ajax({
            url: url + 'user/show-lists-meta/'+page+'/'+list,
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                
                if(data.total) {
                    var tot;
                    Main.pagination.page = page;
                    Main.show_pagination( '#nav-show-emails', data.total);
                    for(var m = 0; m < data.emails.length; m++) {
                        var list_id = data.emails[m].list_id;
                        var email = data.emails[m].body;
                        var meta_id = data.emails[m].meta_id;
                        if(typeof tot === 'undefined') {
                            
                            tot = '<tr>'
                                    + '<td>'
                                        + email
                                    + '</td>'
                                    + '<td style="text-align: right;">'
                                        + '<button class="btn-view-fund btn btn-default btn-xs delete-email" type="button" data-list="' + list_id + '" data-meta="' + meta_id + '">'
                                            + '<i class="icon-trash"></i>'
                                        + '</button>'
                                    + '</td>'
                                + '</tr>';
                            
                        } else {

                            tot += '<tr>'
                                    + '<td>'
                                        + email
                                    + '</td>'
                                    + '<td style="text-align: right;">'
                                        + '<button class="btn-view-fund btn btn-default btn-xs delete-email" type="button" data-list="' + list_id + '" data-meta="' + meta_id + '">'
                                            + '<i class="icon-trash"></i>'
                                        + '</button>'
                                    + '</td>'
                                + '</tr>';

                        }
                    }

                    $('#nav-show-emails .list-emails').html(tot);
                } else {
                    $('#nav-show-emails .list-emails').html('<tr><td>'+Main.translation.mm164+'</td></tr>');
                }
            },
            error: function (data, jqXHR, textStatus)
            {
                console.log(data);
                $('#nav-show-emails .list-emails').html('<tr><td>'+Main.translation.mm164+'</td></tr>');
            }
        });
    }
    function unactive_emails_results(page) {
        // display emails by list
        var list  = $('.list-details').attr('data-id');
        $.ajax({
            url: url + 'user/show-lists-meta/'+page+'/'+list+'/1',
            dataType: 'json',
            type: 'GET',
            success: function (data) {
                if(data.total) {
                    var tot;
                    Main.pagination.page = page;
                    Main.show_pagination( '#nav-unactive-emails', data.total);
                    for(var m = 0; m < data.emails.length; m++) {
                        var list_id = data.emails[m].list_id;
                        var email = data.emails[m].body;
                        var meta_id = data.emails[m].meta_id;
                        if(typeof tot === 'undefined') {
                            
                            tot = '<tr>'
                                    + '<td>'
                                        + email
                                    + '</td>'
                                    + '<td style="text-align: right;">'
                                        + '<button class="btn-view-fund btn btn-default btn-xs delete-email" type="button" data-list="' + list_id + '" data-meta="' + meta_id + '">'
                                            + '<i class="icon-trash"></i>'
                                        + '</button>'
                                    + '</td>'
                                + '</tr>';
                        
                        } else {

                            tot += '<tr>'
                                    + '<td>'
                                        + email
                                    + '</td>'
                                    + '<td style="text-align: right;">'
                                        + '<button class="btn-view-fund btn btn-default btn-xs delete-email" type="button" data-list="' + list_id + '" data-meta="'+meta_id+'">'
                                            + '<i class="icon-trash"></i>'
                                        + '</button>'
                                    + '</td>'
                                + '</tr>';

                        }
                    }
                    $('#nav-unactive-emails .list-emails').html(tot);
                } else {
                    $('#nav-unactive-emails .list-emails').html('<tr><td>'+Main.translation.mm164+'</td></tr>');
                }
            },
            error: function (data, jqXHR, textStatus)
            {
                console.log(data);
                $('#nav-unactive-emails .list-emails').html('<tr><td>'+Main.translation.mm164+'</td></tr>');
            }
        });
    }
    function parse_styles(attrs, key, m, r) {
        // This function parses the styles
        if(typeof attrs.split(key) !== 'undefined') {
            var dt = attrs.split(key);
            if(dt[1]) {
                var uj = dt[1].split(';');
                if(uj[0]) {
                    if(typeof r !== 'undefined') {
                        if(m === 1) {
                            var res = uj[0].replace(r,'');
                            var num = res.trim();
                            num++;
                            key = key.replace(':','');
                            return [key,num+r];
                        } else if(m === 2) {
                            var res = uj[0].replace(r,'');
                            var num = res.trim();
                            num--;
                            key = key.replace(':','');
                            return [key,num+r];                            
                        } else if(m === 3) {
                            key = key.replace(':','');
                            return [key,uj[0].trim()];                            
                        }
                    } else {

                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    function temison(text,attrs) {
        var st = attrs;
        var cl = '';
        if(attrs) {
            var res = parse_styles(attrs, 'color:', 3, '');
            if(res) {
                if(res[1].search('#') > -1) {
                    var si = res[1].split('#');
                    cl = '#'+si[1];
                } else {
                    var si = res[1].split('rgb');
                    cl = rgb2hex('rgb'+si[1]);               
                }
            }
        }
        // this function contains the lists editor
        return '<div class="panel panel-default"><div class="panel-heading"><table><tbody><tr><td class="ui-droppable"><input type="color" class="pull-right type-color change-tem-text-color" value="' + cl + '"></td><td class="ui-droppable"><button class="bold-tem-text"><i class="fa fa-bold"></i></button></td><td class="ui-droppable"><button class="italic-tem-text"><i class="fa fa-italic"></i></button></td><td class="ui-droppable"><button class="underline-tem-text"><i class="fas fa-underline"></i></button></td><td class="ui-droppable"><button class="enter-a-link-template-item"><i class="fa fa-link"></i></button></td><td class="ui-droppable"><button class="remove-a-link-template-item"><i class="fas fa-unlink"></i></button></td><td class="ui-droppable"><button class="increase-item-tem-text-size"><i class="fa fa-plus"></i></button></td><td class="ui-droppable"><button class="decrease-item-tem-text-size"><i class="fa fa-minus"></i></button></td><td class="ui-droppable"><button class="delete-item-tem-lists"><i class="icon-trash"></i></button></td></tr></tbody></table></div><div class="panel-body "><textarea style="' + st + '">' + text + '</textarea></div></div>';
    }

    var hexDigits = new Array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f'); 
    //Function to convert rgb color to hex format
    function rgb2hex(rgb) {
     rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
     return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
    }
    function gets_stats_for(template_id,time) {
        
        var campaign_id = $('.campaign-page').attr('data-id');
        
        // Create an object with form data
        var data = {'campaign_statistics': campaign_id, 'template_id': template_id, 'time': time };
        
        data[$('.upim').attr('data-csrf')] = $('input[name="' + $('.upim').attr('data-csrf') + '"]').val();
        
        $.ajax({
            url: url + 'user/emails/query',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                if(data) {
                    Morris.Line({
                        element: 'rations',
                        data: eval(data),
                        xkey: 'period',
                        xLabelFormat: function (date) {
                            return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                        },
                        xLabels: 'day',
                        ykeys: ['Sent', 'Opened', 'Unsubscribed'],
                        labels: ['Sent', 'Opened', 'Unsubscribed'],
                        pointSize: 5,
                        hideHover: 'auto',
                        lineColors: ['#2f9ecb', '#60d0b9', '#F05A75'],
                        lineWidth: 2,
                    });
                } else {
                    $('#rations').html(Main.translation.mu295);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                $('#rations').html(Main.translation.mu295);
            }
        });
    }
    function hex(x) {
      return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
    }
    
    /*******************************
    METHODS
    ********************************/
    Main.uploadFile = function (form, path) {
        
        // Set the media's cover
        form.append('cover', path.cover);
        
        // Set the action
        form.append('action', 'upload_media_in_storage');

        // Create inteval variable for animation
        var intval;

        // Upload media
        $.ajax({
            url: url + 'user/ajax/media',
            type: 'POST',
            data: form,
            dataType: 'JSON',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $( '.icon-cloud-upload' ).addClass( 'drag-upload-active' );
                intval = setInterval(function(){
                    $( '.icon-cloud-upload' ).removeClass( 'drag-upload-active' );
                    setTimeout(function(){
                        $( '.icon-cloud-upload' ).addClass( 'drag-upload-active' );
                    },500); 
                }, 1000);
            },
            success: function (data) {
                
                if ( data.success ) {
                
                    // Set the user storage
                    $( '.user-total-storage' ).text( data.user_storage );

                    Main.planner_quick_schedule_load_medias( 1 );
                
                } else {
                    
                    Main.popup_fon('sube', data.message, 1500, 2000);
                    
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                
                console.log(jqXHR);
                
            },
            complete: function () {
                clearInterval(intval);
                $( '.icon-cloud-upload' ).removeClass( 'drag-upload-active' );
            }
            
        });

    };
    
    Main.getPreview = function (file, object) {
        var fileReader = new FileReader();
        if (file.type.match('image')) {
            fileReader.onload = function () {
                var img = document.createElement('img');
                img.src = fileReader.result;

            var image = new Image();

            image.onload = function () {
                var canvas = document.createElement('canvas');
                canvas.width = 250;
                canvas.height = 250;

                canvas.getContext('2d').drawImage(this, 0, 0, 250, 250);

                object.cover = canvas.toDataURL('image/png');
            };
            image.src = img.src;

            };
            fileReader.readAsDataURL(file);
        } else {
            fileReader.onload = function () {
                var blob = new Blob([fileReader.result], {type: file.type});
                var url = URL.createObjectURL(blob);
                var video = document.createElement('video');
                var timeupdate = function () {
                    if (snapImage()) {
                        video.removeEventListener('timeupdate', timeupdate);
                        video.pause();
                    }
                };
                video.addEventListener('loadeddata', function () {
                    if (snapImage()) {
                        video.removeEventListener('timeupdate', timeupdate);
                    }
                });
                var snapImage = function () {
                    var canvas = document.createElement('canvas');
                    canvas.width = 250;
                    canvas.height = 250;
                    canvas.getContext('2d').drawImage(video, 0, 0, 250, 250);
                    var image = canvas.toDataURL();
                    var success = image.length > 10;
                    if (success) {
                        var img = document.createElement('img');
                        img.src = image;
                        URL.revokeObjectURL(url);
                        object.cover = img.src;
                    }
                    return success;
                };
                video.addEventListener('timeupdate', timeupdate);
                video.preload = 'metadata';
                video.src = url;
                video.muted = true;
                video.playsInline = true;
                video.play();
            };
            
            fileReader.readAsArrayBuffer(file);
            
        }
        
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
                    
                    if ( Main.medias_page === page && page === 1 ) {
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
                    
                    Main.medias_page = page;
                    
                    if ( ( Main.medias_page * 16 ) < data.total ) {
                        $( '.multimedia-gallery-quick-schedule-load-more-medias' ).css( 'display', 'flow-root' );
                    } else {
                        $( '.multimedia-gallery-quick-schedule-load-more-medias' ).css( 'display', 'none' );
                    }
                    
                } else {
                    
                    $( '.multimedia-gallery-quick-schedule ul' ).empty();
                    $( 'body .no-medias-found' ).css('display', 'flow-root');
                    $( '.multimedia-gallery-quick-schedule-load-more-medias' ).css( 'display', 'none' );
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                $( '.multimedia-gallery-quick-schedule ul' ).empty();
                $( 'body .no-medias-found' ).css('display', 'flow-root');
            }
            
        });
        
    };
    
    Main.saveFile = function (file) {
        
        if ( typeof Main.media === 'undefined') {
            Main.media = {
                files: []
            };
        }

        Main.media.files[file.lastModified + '-' + file.size] = {
            key: file.lastModified + '-' + file.size,
            name: file.name,
            type: file.type,
            size: file.size,
            lastModified: file.lastModified
        };
        
        var fileType = file.type.split('/');
        var form = new FormData();
        form.append('path', '/');
        form.append('file', file);
        form.append('type', fileType[0]);
        form.append('enctype', 'multipart/form-data');
        form.append($('.upim').attr('data-csrf'), $('input[name="' + $('.upim').attr('data-csrf') + '"]').val());
        Main.getPreview(file, Main.media.files[file.lastModified + '-' + file.size]);
        var s = 0;
        $( '.icon-cloud-upload' ).addClass( 'drag-upload-active' );
        var intval = setInterval(function(){
            $( '.icon-cloud-upload' ).removeClass( 'drag-upload-active' );
            setTimeout(function(){
                $( '.icon-cloud-upload' ).addClass( 'drag-upload-active' );
            },500); 
        }, 1000);
        var timer = setInterval(function(){
            var cover = Main.media.files[file.lastModified + '-' + file.size].cover;
            
            if ( typeof cover !== 'undefined') {
                Main.uploadFile( form, Main.media.files[file.lastModified + '-' + file.size] );
                clearInterval(timer);
                clearInterval(intval);
            }
            
            if ( s > 15 ) {
                Main.media.files[file.lastModified + '-' + file.size].cover = 'data:image/png;base64,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';
                Main.uploadFile( form, Main.media.files[file.lastModified + '-' + file.size] );
                clearInterval(timer);
                clearInterval(intval);
            } else {
                s++;
            }
            
        }, 1000);

    };
    
    /*******************************
    ACTIONS
    ********************************/
    $( document ).on( 'drag dragstart dragend dragover dragenter dragleave drop', '.drag-and-drop-files' , function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        $( this ).addClass( 'drag-active' );

        if ( e.handleObj.origType === 'dragleave' || e.handleObj.origType === 'drop' ) {
            
            $( this ).removeClass( 'drag-active' );
            
            if (typeof e.originalEvent.dataTransfer.files[0] !== 'undefined') {
                $('#file').prop('files', e.originalEvent.dataTransfer.files);
            }
            
        }

    });
    
    $( document ).on( 'click', '.drag-and-drop-files a', function (e) {
        e.preventDefault();
        
        $('#file').click();
    });
    
    $( document ).on( 'change', '#file', function (e) {
        $('#upim').submit();
    }); 
    
    $( document ).on( 'click', '.multimedia-gallery-quick-schedule-load-more-medias', function (e) {
        e.preventDefault();
                    
        Main.planner_quick_schedule_load_medias( ( Main.medias_page + 1 ) );
        
    });
    
    $('#upim').submit(function (e) {
        e.preventDefault();
        
        var files = $('#file')[0].files;
        
        if ( typeof files[0] !== 'undefined' ) {
            
            for ( var f = 0; f < files.length; f++ ) {
                
                Main.saveFile(files[f]);
                
            }
            
        }
        
    });
    
    /*
     * Select media in the quick schedule popup
     * 
     * @since   0.0.7.0
     */ 
    $(document).on('click', '.multimedia-gallery-quick-schedule li a', function (e) {
        e.preventDefault();
        
        if ( $( this ).attr('data-type') === 'video' ) {
            
            Main.popup_fon('sube', Main.translation.videos_arent_supported, 1500, 2000);
            return;
            
        }
        
        var id = $( this ).attr('data-id');
        
        if ( $( this ).hasClass( 'media-selected' ) ) {
            
            $( this ).removeClass( 'media-selected' );
            $( '.multimedia-gallery-selected-medias' ).fadeOut('slow');
            
        } else {
            
            $( '.multimedia-gallery-quick-schedule li a' ).removeClass( 'media-selected' );
            $( this ).addClass( 'media-selected' );
            $( '.multimedia-gallery-selected-medias' ).fadeIn('slow');
            
        }
        
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
        
        var media_id = $( '.multimedia-gallery-quick-schedule li a.media-selected' ).attr('data-id');
        
        var data = {
            action: 'delete_media',
            media_id: media_id,
            returns: 1
        };
                
        jQuery.ajax({
            url: url + 'user/ajax/media',
            dataType: 'json',
            type: 'GET',
            data: data,
            success: function (data) {
                
                if ( data.success ) {
                    
                    Main.popup_fon('subi', data.message, 1500, 2000);
                    
                    // Set the user storage
                    $( '.user-total-storage' ).text( data.user_storage );
                    
                    Main.planner_quick_schedule_load_medias( 1 );
                    
                    $( '.multimedia-gallery-selected-medias' ).fadeOut('slow');
                    
                } else {
                    Main.popup_fon('sube', data.message, 1500, 2000);
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                Main.popup_fon('sube', data.message, 1500, 2000);
                
            }
            
        });
        
    });
    
    if ( $('#nav-campaigns').length > 0 ) {
        
        campaigns_results(1);
        lists_results(1);
        
    } else if( $('.template-builder').length > 0 ) {
        
        shistory(1);
        show_template_lists();
        relod();
        
        Main.planner_quick_schedule_load_medias(1);
        Main.quick_schedule = {
            medias_page: 1
        };
      
    } else if ( $('#nav-show-emails').length > 0 ) {
        
        emails_results(1);
        unactive_emails_results(1);
        
    } else if( $('.sent-info').length > 0 ) {
        
        sehistory(1);
        
    }
    
});