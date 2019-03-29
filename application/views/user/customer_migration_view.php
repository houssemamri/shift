<section>
    <div class="container-fluid migrationnew">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details" style="text-align:center;">
                                <h1>Select Migration Services</h1>
                            </div>
                        </div>
						<?php echo form_open('user/do-customer-migration'); ?>
						<div class="row">
                            <div class="col-lg-6">
								<img src="<?= base_url(); ?>assets/img/opencart.png">
								<div class="form-group">
								<label>From</label>
									<select class="form-control" id="opencartweb" name="opencart_website_url">
										<option>Select Website URL</option>
										<?php $i=0;
										  foreach ($user_websites as $value) {
											echo '<option value="'.$value->id.'">'.$value->opencart_websiteurl.'</option>';
											$i++;
										  }
										?>
									  </select>
                                </div>
							</div>
							<div class="col-lg-6">
								<img src="<?= base_url(); ?>assets/img/magento.png">
								<div class="form-group" ><label>To</label>
									<div id="magentoweb"></div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="form-group" style="text-align:;">
									<button type="submit" class="btn btn-labeled btn-primary">Start Customer Migration</button>
									<br/>
								</div>
							</div>
						</div>
						 <?php echo form_close(); ?>

						 <hr>

						<div class="row">
                            <div class="col-lg-6">
								<img src="<?= base_url(); ?>assets/img/magento.png">

							</div>
							<div class="col-lg-6">
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
						<div class="row">
                            <div class="col-lg-6">
								<img src="<?= base_url(); ?>assets/img/wordpress.png" height="60" width="180">
							</div>
							<div class="col-lg-6">
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
jQuery(document).ready(function(){
	jQuery('#opencartweb').change(function(){
		var url = jQuery('.home-page-link').attr('href');
		opencart_websiteurl= jQuery('#opencartweb').val();
		var name = jQuery('input[name="csrf_test_name"]').val();
		data = {
			csrf_test_name: name,
			opencart_websiteurl: jQuery('#opencartweb').val(),
		};
		jQuery.ajax({
            url: url + 'user/magento-website-data',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data) {
					console.log(data);
                    // Display the settings
                    jQuery('#magentoweb').html(data.webdata);
                }
            },
            error: function (data, jqXHR, textStatus) {
                console.log('Request failed: ' + textStatus);
                jQuery('#magentoweb').html('<div class="col-lg-12"><p class="nofound">No website found</p></div>');
            },

        });
	});
});
</script>
