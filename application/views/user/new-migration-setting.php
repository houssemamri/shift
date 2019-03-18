<section>
    <div class="container-fluid migrationnew">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="panel-heading details">
                                <h2><i class="fa fa-cog"></i>Settings Opencart to Magento Migrations</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?= form_open('user/migration-settings', ['class' => 'new_migrationsetting']) ?>
								<input type="hidden" name="actionname" value="save_settings" class="actionname" />
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
                                    <input class="new-message form-control opencart_dbpassword" type="text" placeholder="Opencart Database Password" required>
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
                                    <input class="new-message form-control magento_dbpassword" type="text" placeholder="Magento Database Password" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_dbhost" type="text" placeholder="Magento Database Host" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_dbprefix" type="text" placeholder="Magento Database Prefix" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_admin" type="text" placeholder="Magento Admin Username" required>
                                </div>
								<div class="form-group">
                                    <input class="new-message form-control magento_admin_password" type="text" placeholder="Magento Admin Password" required>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-labeled btn-primary pull-right">Save Settings</button>
									<br/>
                                </div>
                                <div class="form-group alert-msg"></div><br/>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>