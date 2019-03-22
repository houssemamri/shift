<section>
    <div class="container-fluid users" style="padding-left:15px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 fl">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading"  style="width:100%;">
                                <h2 style="margin-top:20px;"><i class="fa fa-cog"></i> All Migration Setting List <a href="<?php echo site_url('user/new-migration-setting') ?>" class="pull-right">New Migration Setting</a></h2>
                            </div>
                        </div>

                        <div class="row settings-item">
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination"></ul>
                                <img src="<?= base_url(); ?>assets/img/load-prev.gif" class="pull-right pageload">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 fr migration-details display-none">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details">
                                <h2><i class="fa fa-inbox"></i> Details<span></span></h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?= form_open('user/migration-settings', ['class' => 'update-migration']) ?>
								<input type="hidden" name="actionname" value="update_setting" class="actionname" />
								<div class="form-group">
                                    <input class="new-message form-control opencart_websiteurl" type="text" placeholder="Opencart Web URL" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control opencart_database" type="text" placeholder="Opencart Database Name" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control opencart_dbuser" type="text" placeholder="Opencart Database User" required>
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control opencart_dbpassword" type="text" placeholder="Opencart Database Password">
                                </div>
                                <div class="form-group">
                                    <input class="new-message form-control opencart_dbhost" type="text" placeholder="Opencart Database Host" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control opencart_dbprefix" type="text" placeholder="Opencart Database Prefix" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control opencart_admin" type="text" placeholder="Opencart Admin Username" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control opencart_admin_password" type="text" placeholder="Opencart Admin Password" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_websiteurl" type="text" placeholder="Magento Web URL" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_database" type="text" placeholder="Magento Database Name" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_dbuser" type="text" placeholder="Magento Database User" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_dbpassword" type="text" placeholder="Magento Database Password">
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_dbhost" type="text" placeholder="Magento Database Host" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_dbprefix" type="text" placeholder="Magento Database Prefix">
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_admin" type="text" placeholder="Magento Admin Username" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_admin_password" type="text" placeholder="Magento Admin Password" required>
                                </div>

                                <div class="form-group">
                                  <!--  <button type="button" class="btn btn-labeled btn-danger pull-left delete-account">Delete Settings</button> <p class="pull-left confirm">Are you sure? <a href="#" class="yes">Yes</a><a href="#" class="no">No</a></p>-->
                                    <button type="submit" class="btn btn-labeled btn-primary pull-right">Update Settings</button>
                                </div>
                                <div class="form-group alert-msg"></div>
                                <?= form_close() ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel-footer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
