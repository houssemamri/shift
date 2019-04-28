<style media="screen">
.nopadding {
  padding: 0 !important;
  margin: 0 !important;
}

#wizard {
  border: 1px #EEE solid;
  border-radius: 5px;
}

#wizard ul li {
  text-align: center;
  cursor: pointer;
  color: #BBB;
}

.active-tab {
  color: #FFFFFF !important;
  background-color: #4285F4 !important;
}

.inactive-tab {
  cursor: not-allowed;
}

.tab-content h3 {
  color: #DDD;
  text-align: center;
}

.log {
  height: 180px;
  background-color: #DDD;
  overflow-y: scroll;
  border-radius: 5px;
  display: none;
}

.log h3 {
  color: #FFFFFF;
  border-bottom: 1px #FFFFFF solid;
}

#product-migration-progress-bar {
  width: 100%;
  height: 30px;
  margin-top: 40px;
  border: 1px #DDD solid;
  border-radius: 5px;
  display: none;
}

#product-migration-inner-progress-bar {
  width: 0%;
  height: 100%;
  border-radius: 5px;
  background-color: #4285F4;
  display: none;
}
</style>



<section>
  <div class="container-fluid migrationnew">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-12 col-lg-offset-0">
          <div class="col-lg-12">
            <div class="row">
              <div class="panel-heading details" style="text-align:center;">
                <h1>OpenCart To Magento</h1>
              </div>
            </div>
            <div class="row">

              <!-- Wizard -->
              <div class="col-lg-12 nopadding" id="wizard">
                <ul class="nav nav-tabs">
                  <!-- Tab one -->
                  <li class="nav-item col-lg-3 nopadding">
                    <a class="nav-link active-tab" id="tab-one">
                      Step 1 <br><small>Select OpenCart Website URL</small>
                    </a>
                  </li>
                  <!-- Tab two -->
                  <li class="nav-item col-lg-3 nopadding">
                    <a class="nav-link inactive-tab" id="tab-two">
                      Step 2 <br><small>Start Product Migration</small>
                    </a>
                  </li>
                  <!-- Tab three -->
                  <li class="nav-item col-lg-3 nopadding">
                    <a class="nav-link inactive-tab" id="tab-three">
                      Step 3 <br><small>Start Customer Migration</small>
                    </a>
                  </li>
                  <!-- Tab four -->
                  <li class="nav-item col-lg-3 nopadding">
                    <a class="nav-link inactive-tab" id="tab-four">
                      Step 4 <br><small>Start Order Migration</small>
                    </a>
                  </li>
                </ul>

                <div class="tab-content">
                  <!-- Tab one -->
                  <div class="tab-pane active p-2" id="tab-one-content">
                    <?php echo form_open('user/get-magento-website'); ?>
                    <h3 class="border-bottom border-gray p-2">Select OpenCart Website</h3>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/opencart.png">
                      <div class="form-group">
                        <label>From</label>
                        <select class="form-control" id="opencart_website_url" name="opencart_website_url">
                          <option>Select OpenCart Website URL</option>
                          <?php
                          foreach ($all_user_opencart_websites as $value) {
                            echo '<option value="'.$value->id.'">'.$value->opencart_website_url.'</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/magento.png">
                      <div class="form-group" >
                        <label>To</label>
                        <b><div class="magento_website_url">Auto-select Magento Website URL</div></b>
                      </div>
                    </div>
                    <div class="col-lg-12 log" id="database-connection-log">
                      <h3 class="col-lg-12 mt-2 mb-2">Activity Log: Database Connection Status</h3>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="button-group mb-2 mt-2 col-lg-12" style="overflow: auto;">
                      <div style="float: right;">
                        <button class="btn btn-secondary" id="tab-one-previous-button">Previous</button>
                        <button class="btn btn-primary" id="tab-one-next-button">Next</button>
                        <button class="btn btn-danger tab-cancel-button">Cancel</button>
                      </div>
                    </div>
                  </div>

                  <!-- Tab two -->
                  <div class="tab-pane fade p-2" id="tab-two-content">
                    <?php echo form_open('user/start-product-migration', ['class' => 'start-product-migration']); ?>
                    <h3 class="border-bottom border-gray p-2">Start Product Migration</h3>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/opencart.png">
                      <div class="form-group">
                        <label>From</label>
                        <b><div class="opencart_website_url"></div></b>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div id="product-migration-progress-bar">
                        <div id="product-migration-inner-progress-bar">

                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/magento.png">
                      <div class="form-group" >
                        <label>To</label>
                        <b><div class="magento_website_url"></div></b>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-lg-12" id="start-product-migration-button">Start Product Migration</button>
                    <div class="col-lg-12 log" id="product-migration-log">
                      <h3 class="col-lg-12 mt-2 mb-2">Activity Log: Product Migration Status</h3>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="button-group mb-2 mt-2 col-lg-12" style="overflow: auto;">
                      <div style="float: right;">
                        <button class="btn btn-secondary" id="tab-two-previous-button">Previous</button>
                        <button class="btn btn-primary" id="tab-two-next-button">Next</button>
                        <button class="btn btn-danger tab-cancel-button">Cancel</button>
                      </div>
                    </div>
                  </div>

                  <!-- Tab three -->
                  <div class="tab-pane fade p-2" id="tab-three-content">
                    <?php echo form_open('user/start-customer-migration', ['class' => 'start-customer-migration']); ?>
                    <h3 class="border-bottom border-gray p-2">Start Customer Migration</h3>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/opencart.png">
                      <div class="form-group">
                        <label>From</label>
                        <b><div class="opencart_website_url"></div></b>
                      </div>
                    </div>
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/magento.png">
                      <div class="form-group" >
                        <label>To</label>
                        <b><div class="magento_website_url"></div></b>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-lg-12" id="start-customer-migration-button">Start Customer Migration</button>
                    <div class="col-lg-12 log" id="customer-migration-log">
                      <h3 class="col-lg-12 mt-2 mb-2">Activity Log: Customer Migartion Status</h3>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="button-group mb-2 mt-2 col-lg-12" style="overflow: auto;">
                      <div style="float: right;">
                        <button class="btn btn-secondary" id="tab-three-previous-button">Previous</button>
                        <button class="btn btn-primary" id="tab-three-next-button">Next</button>
                        <button class="btn btn-danger tab-cancel-button">Cancel</button>
                      </div>
                    </div>
                  </div>

                  <!-- Tab four -->
                  <div class="tab-pane fade p-2" id="tab-four-content">
                    <?php echo form_open('user/start-order-migration', ['class' => 'start-order-migration']); ?>
                    <h3 class="border-bottom border-gray p-2">Start Order Migration</h3>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/opencart.png">
                      <div class="form-group">
                        <label>From</label>
                        <b><div class="opencart_website_url"></div></b>
                      </div>
                    </div>
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/magento.png">
                      <div class="form-group" >
                        <label>To</label>
                        <b><div class="magento_website_url"></div></b>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-lg-12" id="start-order-migration-button">Start Order Migration</button>
                    <div class="col-lg-12 log" id="order-migration-log">
                      <h3 class="col-lg-12 mt-2 mb-2">Activity Log: Customer Migartion Status</h3>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="button-group mb-2 mt-2 col-lg-12" style="overflow: auto;">
                      <div style="float: right;">
                        <button class="btn btn-secondary" id="tab-four-previous-button">Previous</button>
                        <button class="btn btn-primary" id="tab-four-next-button">Next</button>
                        <button class="btn btn-danger tab-cancel-button">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>





              <div class="col-lg-12">
                <br><br><br><br><br>
                <div class="row">
                  <div class="panel-heading details" style="text-align:center;">
                    <h1> Magento To WordPress</h1>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-4">
                    <img src="<?= base_url(); ?>assets/img/magento.png">
                  </div>
                  <div class="col-lg-4">

                  </div>
                  <div class="col-lg-4">
                    <img src="<?= base_url(); ?>assets/img/wordpress.png" height="60" width="180">
                    <div class="form-group" ></div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group" style="text-align:;">
                      <a href="<?= base_url(); ?>/user/upgrade/20" class="custom_btn">Custom Plan</a>
                    </div>
                  </div>
                </div>

                <hr>

                <div class="col-lg-12">
                  <br><br><br><br><br>
                  <div class="row">
                    <div class="panel-heading details" style="text-align:center;">
                      <h1>WordPress To OpenCart</h1>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/wordpress.png" height="60" width="180">
                    </div>
                    <div class="col-lg-4">

                    </div>
                    <div class="col-lg-4">
                      <img src="<?= base_url(); ?>assets/img/opencart.png">
                      <div class="form-group" ></div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group" style="text-align:;">
                        <a href="<?= base_url(); ?>/user/upgrade/20" class="custom_btn">Custom Plan</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>











      <script>
      jQuery(document).ready(function() {
        $('#tab-one-previous-button').css('disabled', true);
        $('#tab-one-previous-button').css('cursor', 'not-allowed');
        $('#tab-one-next-button').attr('disabled', true);
        $('#tab-one-next-button').css('cursor', 'not-allowed');
        $('#tab-two-next-button').attr('disabled', true);
        $('#tab-two-next-button').css('cursor', 'not-allowed');
        $('#tab-three-next-button').attr('disabled', true);
        $('#tab-three-next-button').css('cursor', 'not-allowed');
        $('#tab-four-next-button').attr('disabled', true);
        $('#tab-four-next-button').css('cursor', 'not-allowed');

        // Wizard.
        $('#tab-one-next-button').click(function(){
          $('#tab-one').removeClass('active-tab');
          $('#tab-one').removeAttr('href data-toggle');
          $('#tab-one-content').removeClass('active');
          $('#tab-one').addClass('inactive-tab');

          $('#tab-two').removeClass('inactive-tab');
          $('#tab-two').addClass('active-tab');
          $('#tab-two').attr('href', '#tab-two-content');
          $('#tab-two').attr('data-toggle', 'tab');
          $('#tab-two-content').addClass('active show');
        });

        $('#tab-two-next-button').click(function(){
          $('#tab-two').removeClass('active-tab');
          $('#tab-two').removeAttr('href data-toggle');
          $('#tab-two-content').removeClass('active');
          $('#tab-two').addClass('inactive-tab');

          $('#tab-three').removeClass('inactive-tab');
          $('#tab-three').addClass('active-tab');
          $('#tab-three').attr('href', '#tab-three-content');
          $('#tab-three').attr('data-toggle', 'tab');
          $('#tab-three-content').addClass('active show');
        });

        $('#tab-three-next-button').click(function(){
          $('#tab-three').removeClass('active-tab');
          $('#tab-three').removeAttr('href data-toggle');
          $('#tab-three-content').removeClass('active');
          $('#tab-three').addClass('inactive-tab');

          $('#tab-four').removeClass('inactive-tab');
          $('#tab-four').addClass('active-tab');
          $('#tab-four').attr('href', '#tab-four-content');
          $('#tab-four').attr('data-toggle', 'tab');
          $('#tab-four-content').addClass('active show');
        });

        $('#tab-two-previous-button').click(function(){
          $('#tab-two').removeClass('active-tab');
          $('#tab-two').removeAttr('href data-toggle');
          $('#tab-two-content').removeClass('active');
          $('#tab-two').addClass('inactive-tab');

          $('#tab-one').removeClass('inactive-tab');
          $('#tab-one').addClass('active-tab');
          $('#tab-one').attr('href', '#tab-one-content');
          $('#tab-one').attr('data-toggle', 'tab');
          $('#tab-one-content').addClass('active show');
        });

        $('#tab-three-previous-button').click(function(){
          $('#tab-three').removeClass('active-tab');
          $('#tab-three').removeAttr('href data-toggle');
          $('#tab-three-content').removeClass('active');
          $('#tab-three').addClass('inactive-tab');

          $('#tab-two').removeClass('inactive-tab');
          $('#tab-two').addClass('active-tab');
          $('#tab-two').attr('href', '#tab-two-content');
          $('#tab-two').attr('data-toggle', 'tab');
          $('#tab-two-content').addClass('active show');
        });

        $('#tab-four-previous-button').click(function(){
          $('#tab-four').removeClass('active-tab');
          $('#tab-four').removeAttr('href data-toggle');
          $('#tab-four-content').removeClass('active');
          $('#tab-four').addClass('inactive-tab');

          $('#tab-three').removeClass('inactive-tab');
          $('#tab-three').addClass('active-tab');
          $('#tab-three').attr('href', '#tab-three-content');
          $('#tab-three').attr('data-toggle', 'tab');
          $('#tab-three-content').addClass('active show');
        });

        $('.tab-cancel-button').click(function(){
          var url = jQuery('.home-page-link').attr('href');
          window.location.href = url + 'user/common-migration-view';
        });





        // Get Magento website URL.
        jQuery('#opencart_website_url').change(function() {
          $('.page-loading').fadeIn('slow');
          var url = jQuery('.home-page-link').attr('href');
          opencart_website_id = jQuery('#opencart_website_url').val();
          var name = jQuery('input[name="csrf_test_name"]').val();

          data = {
            csrf_test_name: name,
            opencart_website_id: jQuery('#opencart_website_url').val()
          };

          jQuery.ajax({
            url: url + 'user/get-magento-website',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(data) {
              if (data) {
                $('#database-connection-log').fadeIn('2000');
                jQuery('.opencart_website_url').html(data.opencart_website_url);
                jQuery('.magento_website_url').html(data.magento_website_url);
                if(data.opencart_database_connection_status){
                  jQuery('#database-connection-log').append('<div class="alert alert-success col-lg-12" role="alert">OpenCart database connection successful.</div>');
                } else {
                  jQuery('#database-connection-log').append('<div class="alert alert-danger" role="alert">OpenCart database connection failed.</div>');
                }
                if(data.magento_database_connection_status){
                  jQuery('#database-connection-log').append('<div class="alert alert-success col-lg-12" role="alert">Magento database connection successful.</div>');
                } else {
                  jQuery('#database-connection-log').append('<div class="alert alert-danger" role="alert">Magento database connection failed.</div>');
                }
                $('#tab-one-next-button').css('cursor', 'pointer');
                $('#tab-one-next-button').attr('disabled', false);
                $('.page-loading').hide();
              }
            },
            error: function (data, jqXHR, textStatus) {
              console.log('Request failed: ' + textStatus);
              jQuery('.magento_website_url').html('<div class="col-lg-12"><p class="nofound">No website found</p></div>');
            }
          });
        });





        // Start product migration.
        $(".start-product-migration").submit(function() {
          $('.page-loading').fadeIn('slow');
          $('#start-product-migration-button').hide();

          var url = jQuery('.home-page-link').attr('href');
          var name = jQuery('input[name="csrf_test_name"]').val();
          data = {
            csrf_test_name: name,
            action: 'start_product_migration'
          };

          $.ajax({
            type: "POST",
            url: url + "user/start-product-migration",
            data: data,
            dataType: "json",
            success: function(data) {
              if (data) {
                $('#product-migration-log').fadeIn(2000);
                if(data.migration_status == "complete") {
                    $('#product-migration-log').append('<div class="alert alert-success col-lg-12" role="alert">Product migration complete.</div>');
                    $('#product-migration-log').append('<div class="alert alert-success col-lg-12" role="alert">You may now proceed to step three.</div>');
                    $('#tab-two-next-button').css('cursor', 'pointer');
                    $('#tab-two-next-button').attr('disabled', false);
                    $('.page-loading').hide();
                }
              }
            }
          });
          return false;
        });





        // Start customer migration.
        $(".start-customer-migration").submit(function() {
          $('.page-loading').fadeIn('slow');
          $('#start-customer-migration-button').hide();

          var url = jQuery('.home-page-link').attr('href');
          var name = jQuery('input[name="csrf_test_name"]').val();
          data = {
            csrf_test_name: name,
            action: 'start_customer_migration'
          };

          $.ajax({
            type: "POST",
            url: url + "user/start-customer-migration",
            data: data,
            dataType: "json",
            success: function(data) {
              if (data) {
                $('#customer-migration-log').fadeIn(2000);
                if(data.migration_status == "complete") {
                    $('#customer-migration-log').append('<div class="alert alert-success col-lg-12" role="alert">Customer migration complete.</div>');
                    $('#customer-migration-log').append('<div class="alert alert-success col-lg-12" role="alert">You may now proceed to step four.</div>');
                    $('#tab-three-next-button').css('cursor', 'pointer');
                    $('#tab-three-next-button').attr('disabled', false);
                    $('.page-loading').hide();
                }
              }
            }
          });
          return false;
        });





        // Start order migration.
        $(".start-order-migration").submit(function() {
          $('.page-loading').fadeIn('slow');
          $('#start-order-migration-button').hide();

          var url = jQuery('.home-page-link').attr('href');
          var name = jQuery('input[name="csrf_test_name"]').val();
          data = {
            csrf_test_name: name,
            action: 'start_order_migration'
          };

          $.ajax({
            type: "POST",
            url: url + "user/start-order-migration",
            data: data,
            dataType: "json",
            success: function(data) {
              if (data) {
                $('#order-migration-log').fadeIn(2000);
                if(data.migration_status == "complete") {
                    $('#order-migration-log').append('<div class="alert alert-success col-lg-12" role="alert">Order migration complete.</div>');
                    $('.page-loading').hide();
                }
              }
            }
          });
          return false;
        });
      });
      </script>
