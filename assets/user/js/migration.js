/*
 * Migration javascript file
 * 
 * @author Scrisoft
*/

jQuery(document).ready(function ($) {
	  // Get main page URL
    var url = jQuery('.home-page-link').attr('href');
    var users = {'page': 1,'limit': 10,'user_id': 0,'rsearch': ''};
	
	jQuery('.new_migrationsetting').submit(function () {
                
        // Get the CSRF token
        var name = jQuery('input[name="csrf_test_name"]').val();
        
        // create an object with form data
        var data = {
			migration_id: '',
            opencart_websiteurl: jQuery('.opencart_websiteurl').val(),
            opencart_database: jQuery('.opencart_database').val(),
            opencart_dbuser: jQuery('.opencart_dbuser').val(),
            opencart_dbpassword: jQuery('.opencart_dbpassword').val(),
            opencart_dbhost: jQuery('.opencart_dbhost').val(),
			opencart_dbprefix: jQuery('.opencart_dbprefix').val(),
			opencart_admin: jQuery('.opencart_admin').val(),
			opencart_admin_password: jQuery('.opencart_admin_password').val(),			
            magento_websiteurl: jQuery('.magento_websiteurl').val(),
			magento_database: jQuery('.magento_database').val(),
			magento_dbuser: jQuery('.magento_dbuser').val(),
			magento_dbpassword: jQuery('.magento_dbpassword').val(),
			magento_dbhost: jQuery('.magento_dbhost').val(),
			magento_dbprefix: jQuery('.magento_dbprefix').val(),
			magento_admin: jQuery('.magento_admin').val(),
			magento_admin_password: jQuery('.magento_admin_password').val(),
            csrf_test_name: name,
			actionname: jQuery('.actionname').val(),
        };
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'user/create-msettings',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                jQuery('.alert-msg').show();
                jQuery('.alert-msg').html(data);
                jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                    jQuery('.alert-msg').hide();
                });
                jQuery('.msuccess').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.msuccess').remove();
                    jQuery('.alert-msg').hide();
                    document.getElementsByClassName('new_migrationsetting')[0].reset();
                });
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed:' + textStatus);
            }
        });
        return false;
    });
	
	function results(page) {
        
        // Verify if admin is in the statistics page 
        if ( jQuery('.widget-box').length > 0 ) {            
            var url_a = url + 'user/migrationall-result/' + page + '/1/' + users.rsearch;            
        } else {            
            var url_a = url + 'user/migrationall-result/' + page + '/0/' + users.rsearch            
        }
        
        // display settings by page
        jQuery.ajax({
            url: url_a,
            dataType: 'json',
            type: 'GET',
            beforeSend: function () {
                if (jQuery(document).width() > 700)
                    jQuery( '.fl .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).show();
            },
            success: function (data) {
                if (data) {
                    // Generate the pagination
                  //  show_pagination(data.total, '.fl');
                    console.log(data);
                    var allusers = '';
                    for (var u = 0; u < data.settings.length; u++) {
                        
                        // Get user's role
                        var role = (data.settings[u].role == 0) ? 'User' : 'Administrator';
                        
                        // Get the edit button
                        var edit = '<button type="button" data-user="' + data.settings[u].id + '" class="btn btn-edit pull-right migration-edit"><i class="fas fa-pencil-alt"></i></button>';
                        
                        // Verify if admin is in the statistics page 
                        if ( jQuery('.widget-box').length > 0 ) {
                            
                            edit = '<button type="button" data-user="' + data.settings[u].user_id + '" class="btn btn-edit pull-right user-statistics"><i class="fas fa-chart-pie"></i></button>';
                            
                        }
                        
                        // Create a string with founded settings
                        allusers += '<div class="col-lg-12"><div><b>Magento Web URL</b>: '+ data.settings[u].magento_websiteurl + '</br> <b>Opencart Web URL</b>: ' + data.settings[u].opencart_websiteurl + '</div>' + edit + '</div>';
                    }
                    
                    // Display the settings
                    jQuery('.settings-item').html(allusers);
                    
                }
                
            },
            error: function (data, jqXHR, textStatus) {
                
                // Display the issue
                console.log('Request failed: ' + textStatus);
                
                // Hide the users found in the last search
                jQuery('.settings-item').html('<div class="col-lg-12"><p class="nofound">'+translation.ma141+'</p></div>');
                
                // Display a message error
                jQuery('.merror').fadeIn(1000).delay(3000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                });
                
            },
            complete: function () {
                jQuery( '.fl .pagination' ).closest( '.col-lg-12' ).find( '.pageload' ).fadeOut('slow');
            },
        });
    }
	
	 /*
     * Verify if we are on the setting page
     * 
     * @since   0.0.0.1
     */
    if (jQuery('.settings-item').length > 0) {
        results(users.page);
        if (window.location.hash) {
            var hash = window.location.hash;
            hash = hash.replace('#', '');
            users.user_id = hash;
            user_edit();
        }
    }
	
	
	/*
     * Display user's pagination
     * 
     * @since   0.0.0.1
     */
    function show_pagination( total, location ) {
        
        // Empty the pagination
        jQuery(location + ' .pagination').empty();
        
        // Verify if exists previous pages
        if (parseInt(users.page) > 1) {
            var bac = parseInt(users.page) - 1;
            var pages = '<li><a href="#" data-page="' + bac + '">' + translation.mm128 + '</a></li>';
        } else {
            var pages = '<li class="pagehide"><a href="#">' + translation.mm128 + '</a></li>';
        }
        
        // Verify how many pages exists
        var tot = parseInt(total) / parseInt(users.limit);
        tot = Math.ceil(tot) + 1;
        var from = (parseInt(users.page) > 2) ? parseInt(users.page) - 2 : 1;
        for (var p = from; p < parseInt(tot); p++) {
            if (p === parseInt(users.page)) {
                pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
            } else if ((p < parseInt(users.page) + 3) && (p > parseInt(users.page) - 3)) {
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
            } else if ((p < 6) && (Math.round(tot) > 5) && ((parseInt(users.page) == 1) || (parseInt(users.page) == 2))) {
                pages += '<li><a href="#" data-page="' + p + '">' + p + '</a></li>';
            } else {
                break;
            }
        }
        
        // Verify if exists more pages
        if (p === 1) {
            pages += '<li class="active"><a data-page="' + p + '">' + p + '</a></li>';
        }
        var next = parseInt(users.page);
        next++;
        
        // Display pagination
        if (next < Math.round(tot)) {
            jQuery(location + ' .pagination').html(pages + '<li><a href="#" data-page="' + next + '">' + translation.mm129 + '</a></li>');
        } else {
            jQuery(location + ' .pagination').html(pages + '<li class="pagehide"><a href="#">' + translation.mm129 + '</a></li>');
        }
    }
	
	
	 /*
     * Detect setting edit click
     * 
     * @since   0.0.0.1
     */
    jQuery(document).on('click', '.migration-edit', function () {
        
        // Get setting's ID
        var $this = jQuery(this);
        users.user_id = $this.attr('data-user');
        
        // Display migration's settings
        migration_edit();
        
    });
	
	
	 /*
     * Edit migration data
     * 
     * @since   0.0.0.1
     */
    function migration_edit() {
        jQuery('.migration-details').hide();
        jQuery('.migration-details').fadeIn('slow');
        jQuery('.drole').removeAttr('disabled');
        jQuery('.dstatus').removeAttr('disabled');
        jQuery('.delete-account').show();
        jQuery('.confirm').hide();
        jQuery.ajax({
            url: url + 'user/migration-info/' + users.user_id,
            dataType: 'json',
            type: 'GET',
            beforeSend: function () {
                document.getElementsByClassName('update-migration')[0].reset();
            },
            success: function (data) {				
                if (data.msg) {
                    jQuery('.opencart_websiteurl').val(data.msg.opencart_websiteurl);
                    jQuery('.opencart_database').val(data.msg.opencart_database);
                    jQuery('.opencart_dbuser').val(data.msg.opencart_dbusername);
                    jQuery('.opencart_dbpassword').val(data.msg.opencart_dbpassword);
                    jQuery('.opencart_dbhost').val(data.msg.opencart_dbhost);
                    jQuery('.opencart_dbprefix').val(data.msg.opencart_dbprefix);
                    jQuery('.opencart_admin').val(data.msg.opencart_admin);
					jQuery('.opencart_admin_password').val(data.msg.opencart_admin_password);
					jQuery('.magento_websiteurl').val(data.msg.magento_websiteurl);
					jQuery('.magento_database').val(data.msg.magento_database);
					jQuery('.magento_dbuser').val(data.msg.magento_dbusername);
					jQuery('.magento_dbpassword').val(data.msg.magento_dbpassword);
					jQuery('.magento_dbhost').val(data.msg.magento_dbhost);
					jQuery('.magento_dbprefix').val(data.msg.magento_dbprefix);
					jQuery('.magento_admin').val(data.msg.magento_admin);
					jQuery('.magento_admin_password').val(data.msg.magento_admin_password);					
                }
            },
            error: function (data, jqXHR, textStatus) {
                //console.log('Request failed: ' + textStatus);
                jQuery('.alert-msg').show();
                jQuery('.alert-msg').html('<p class="merror">'+translation.mm3+'</p>');
                jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                    jQuery('.alert-msg').hide();
                });
            }
        });
    }
	
	 /*
     * Update migration's data     
     */
    jQuery('.update-migration').submit(function (e) {
        e.preventDefault();
        
        // Get CRSF token
        var name = jQuery('input[name="csrf_test_name"]').val();
        
        // create an object with form data
        var data = {
			migration_id: users.user_id,
            opencart_websiteurl: jQuery('.opencart_websiteurl').val(),
            opencart_database: jQuery('.opencart_database').val(),
            opencart_dbuser: jQuery('.opencart_dbuser').val(),
            opencart_dbpassword: jQuery('.opencart_dbpassword').val(),
            opencart_dbhost: jQuery('.opencart_dbhost').val(),
			opencart_dbprefix: jQuery('.opencart_dbprefix').val(),
			opencart_admin: jQuery('.opencart_admin').val(),
			opencart_admin_password: jQuery('.opencart_admin_password').val(),			
            magento_websiteurl: jQuery('.magento_websiteurl').val(),
			magento_database: jQuery('.magento_database').val(),
			magento_dbuser: jQuery('.magento_dbuser').val(),
			magento_dbpassword: jQuery('.magento_dbpassword').val(),
			magento_dbhost: jQuery('.magento_dbhost').val(),
			magento_dbprefix: jQuery('.magento_dbprefix').val(),
			magento_admin: jQuery('.magento_admin').val(),
			magento_admin_password: jQuery('.magento_admin_password').val(),
            csrf_test_name: name,
			actionname: jQuery('.actionname').val(),
        };
        
        // submit data via ajax
        jQuery.ajax({
            url: url + 'user/update-migration-setting',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                jQuery('.alert-msg').show();
                jQuery('.alert-msg').html(data);
                jQuery('.merror').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.merror').remove();
                    jQuery('.alert-msg').hide();
                });
                jQuery('.msuccess').fadeIn(1000).delay(2000).fadeOut(1000, function () {
                    jQuery('.msuccess').remove();
                    jQuery('.alert-msg').hide();
                });
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
            }
        });
    });
	
});