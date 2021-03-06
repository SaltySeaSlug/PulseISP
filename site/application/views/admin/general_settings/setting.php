<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="card card-default color-palette-bo">
            <div class="card-header">
              <div class="d-inline-block">
                  <h3 class="card-title mt-2"> <i class="fa fa-plus"></i>
                  <?= trans('general_settings') ?> </h3>
              </div>
            </div>
            <div class="card-body">   
                 <!-- For Messages -->
                <?php $this->load->view('admin/includes/_messages.php') ?>

                <?php echo form_open_multipart(base_url('admin/general_settings/add')); ?>	
                <!-- Nav tabs -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#main" role="tab" aria-controls="main" aria-selected="true"><?= trans('general_setting') ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#email" role="tab" aria-controls="email" aria-selected="false"><?= trans('email_setting') ?></a>
                  </li>
                   <li class="nav-item">
                    <a class="nav-link" id="pills-social-tab" data-toggle="pill" href="#social" role="tab" aria-controls="social" aria-selected="false"><?= trans('social_setting') ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#reCAPTCHA" role="tab" aria-controls="reCAPTCHA" aria-selected="false"><?= trans('google_setting') ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="pills-company-tab" data-toggle="pill" href="#company" role="tab" aria-controls="company" aria-selected="false"><?= trans('company_setting') ?></a>
				  </li>
					<li class="nav-item">
						<a class="nav-link" id="pills-radius-tab" data-toggle="pill" href="#radius" role="tab"
						   aria-controls="company" aria-selected="false">Radius Settings</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" id="pills-application-tab" data-toggle="pill" href="#application" role="tab"
						   aria-controls="application" aria-selected="false">Application Settings</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" id="pills-company_setup-tab" data-toggle="pill" href="#company_setup"
						   role="tab" aria-controls="company_setup" aria-selected="false">Company Setup</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">

					<!-- General Setting -->
					<div role="tabpanel" class="tab-pane active" id="main">

						<div class="form-group">
							<label class="control-label"><?= trans('timezone') ?></label>
							<select class="form-control" name="timezone">
								<option value="0">Please, select any timezone</option>
								<?php foreach ($this->setting_model->get_timezone_list() as $tzone) { ?>
									<option value="<?php print $tzone['zone'] ?>" <?= $general_settings['timezone'] == $tzone['zone'] ? ' selected="selected"' : ''; ?>>
										<?php print $tzone['diff_from_GMT'] . ' - ' . $tzone['zone'] ?>
									</option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
                            <label class="control-label"><?= trans('default_language') ?></label>
                            <?php 
                                $options = array_column($languages, 'name','id');
                                echo form_dropdown('language',$options,$general_settings['default_language'],'class="form-control"');
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('currency') ?></label>
                             <select class="form-control" name="currency">
                                <option value="0">Please, select any currency</option>
                                <?php foreach($this->setting_model->get_currency_list() as $tzone) { ?>
                                  <option value="<?php print $tzone['code'] ?>" <?= $general_settings['currency'] == $tzone['code'] ? ' selected="selected"' : ''; ?>>
                                    <?php print $tzone['name'] . ' - ' . $tzone['code']. ' - ' . $tzone['symbol'] ?>
                                  </option>
                                <?php } ?>
                              </select>
                        </div>
                         <div class="form-group">
                            <label class="control-label"><?= trans('use_google_font') ?></label>
                             <select class="form-control" name="use_google_font">
                              <option value="0" <?= $general_settings['use_google_font'] == 0 ? ' selected="selected"' : ''; ?>>
                                   False
                              </option>
                              <option value="1" <?= $general_settings['use_google_font'] == 1 ? ' selected="selected"' : ''; ?>>
                                   True
                              </option>
                              </select>
                        </div>
						<div class="form-group">
							<label class="control-label"><?= trans('google_maps_api') ?></label>
							<input type="text" class="form-control" name="google_maps_api" placeholder="Google Maps API Key" value="<?php echo html_escape($general_settings['google_api_key']); ?>">
						</div>

						<div class="form-group">
							<label class="control-label mr-2">Google Places Active</label>
							<input class="bootstrap-switch-small" data-toggle="switch" id="cb_google_places_status"
								   name="cb_google_places_status" type="checkbox">
						</div>

					</div>

					<!-- Email Setting -->
					<div role="tabpanel" class="tab-pane" id="email">
						<div class="form-group">
							<label class="control-label"><?= trans('email_from') ?></label>
							<input type="text" class="form-control" name="email_from" placeholder="no-reply@domain.com"
								   value="<?php echo html_escape($general_settings['email_from']); ?>">
						</div>
						<div class="form-group">
							<label class="control-label"><?= trans('smtp_host') ?></label>
							<input type="text" class="form-control" name="smtp_host" placeholder="SMTP Host"
								   value="<?php echo html_escape($general_settings['smtp_host']); ?>">
						</div>
						<div class="form-group">
							<label class="control-label"><?= trans('smtp_port') ?></label>
							<input type="text" class="form-control" name="smtp_port" placeholder="SMTP Port"
								   value="<?php echo html_escape($general_settings['smtp_port']); ?>">
						</div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('smtp_user') ?></label>
                            <input type="text" class="form-control" name="smtp_user" placeholder="SMTP Email" value="<?php echo html_escape($general_settings['smtp_user']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('smtp_password') ?></label>
                            <input type="password" class="form-control" name="smtp_pass" placeholder="SMTP Password" value="<?php echo html_escape($general_settings['smtp_pass']); ?>">
                        </div>
                    </div>

                    <!-- Social Media Setting -->
                    <div role="tabpanel" class="tab-pane" id="social">
                        <div class="form-group">
                            <label class="control-label">Facebook</label>
                            <input type="text" class="form-control" name="facebook_link" placeholder="" value="<?php echo html_escape($general_settings['facebook_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Twitter</label>
                            <input type="text" class="form-control" name="twitter_link" placeholder="" value="<?php echo html_escape($general_settings['twitter_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Google Plus</label>
                            <input type="text" class="form-control" name="google_link" placeholder="" value="<?php echo html_escape($general_settings['google_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Youtube</label>
                            <input type="text" class="form-control" name="youtube_link" placeholder="" value="<?php echo html_escape($general_settings['youtube_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">LinkedIn</label>
                            <input type="text" class="form-control" name="linkedin_link" placeholder="" value="<?php echo html_escape($general_settings['linkedin_link']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Instagram</label>
                            <input type="text" class="form-control" name="instagram_link" placeholder="" value="<?php echo html_escape($general_settings['instagram_link']); ?>">
                        </div>
                    </div>

                    <!-- Google reCAPTCHA Setting-->
                    <div role="tabpanel" class="tab-pane" id="reCAPTCHA">
                        <div class="form-group">
                            <label class="control-label"><?= trans('site_key') ?></label>
                            <input type="text" class="form-control" name="recaptcha_site_key" placeholder="Site Key" value="<?php echo ($general_settings['recaptcha_site_key']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('secret_key') ?></label>
                            <input type="text" class="form-control" name="recaptcha_secret_key" placeholder="Secret Key" value="<?php echo ($general_settings['recaptcha_secret_key']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('language') ?></label>
                            <input type="text" class="form-control" name="recaptcha_lang" placeholder="Language code" value="<?php echo ($general_settings['recaptcha_lang']); ?>">
                            <a href="https://developers.google.com/recaptcha/docs/language" target="_blank">https://developers.google.com/recaptcha/docs/language</a>
                        </div>
                    </div>

                    <!-- Company Settings -->
                    <div role="tabpanel" class="tab-pane" id="company">
                        <div class="form-group">
                            <label class="control-label"><?= trans('company_name') ?></label>
                            <input type="text" class="form-control" name="company_name" placeholder="company name" value="<?php echo html_escape($general_settings['company_name']); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('company_name') ?></label>
                            <input type="text" class="form-control" name="address_line_1" placeholder="address line 1" value="<?php echo html_escape($general_settings['address_line_1']); ?>">
                        </div>
                         <div class="form-group">
                            <label class="control-label"><?= trans('company_name') ?></label>
                            <input type="text" class="form-control" name="address_line_2" placeholder="address line 2" value="<?php echo html_escape($general_settings['address_line_2']); ?>">
                        </div>
                         <div class="form-group">
                            <label class="control-label"><?= trans('company_name') ?></label>
                            <input type="text" class="form-control" name="email_address" placeholder="email address" value="<?php echo html_escape($general_settings['email_address']); ?>">
                        </div>
                         <div class="form-group">
                            <label class="control-label"><?= trans('company_name') ?></label>
                            <input type="text" class="form-control" name="contact_number" placeholder="contact number" value="<?php echo html_escape($general_settings['contact_number']); ?>">
                        </div>
						<div class="form-group">
							<label class="control-label"><?= trans('company_name') ?></label>
							<textarea rows="5" type="text" class="form-control" name="terms"
									  placeholder="terms"><?php echo html_escape($general_settings['terms']); ?></textarea>
						</div>
					</div>

					<!-- Radius Settings -->
					<div role="tabpanel" class="tab-pane" id="radius">
						<div class="form-group">
							<label class="control-label">Radius Secret</label>
							<input type="text" class="form-control" name="radius_secret" placeholder="radius secret"
								   value="<?php echo html_escape($general_settings['radius_secret']); ?>">
						</div>
						<div class="form-group">
							<label class="control-label">Suffix</label>
							<input type="text" class="form-control" name="realm_suffix" placeholder="realm"
								   value="<?php echo html_escape($general_settings['realm_suffix']); ?>">
						</div>
						<div class="form-group">
							<input type="checkbox" id="users" name="users" checked>
							<label for="users">Add suffix when creating new users</label>

							<input type="checkbox" id="voucher" name="voucher" checked>
							<label for="voucher">Add suffix when creating vouchers</label>

							<input type="checkbox" id="byod" name="byod" checked>
							<label for="byod">Add suffix when creating BYOD</label>
						</div>
					</div>


					<!-- Application Settings -->
					<div role="tabpanel" class="tab-pane" id="application">
						<div class="form-group">
							<label class="control-label">System ID</label>
							<input type="text" class="form-control" name="system_id" placeholder="system id"
								   value="<?php echo html_escape($general_settings['system_id']); ?>">
						</div>
						<div class="form-group">
							<label class="control-label"><?= trans('favicon') ?> (25*25)</label><br/>
							<?php if (!empty($general_settings['favicon'])): ?>
								<p><img src="<?= base_url($general_settings['favicon']); ?>" class="favicon"></p>
							<?php endif; ?>
							<input type="file" name="favicon" accept=".png, .jpg, .jpeg, .gif, .svg">
							<p><small class="text-success"><?= trans('allowed_types') ?>: gif, jpg, png, jpeg</small>
							</p>
							<input type="hidden" name="old_favicon"
								   value="<?php echo html_escape($general_settings['favicon']); ?>">
						</div>
						<div class="form-group">
							<label class="control-label"><?= trans('logo') ?></label><br/>
							<?php if (!empty($general_settings['logo'])): ?>
								<p><img src="<?= base_url($general_settings['logo']); ?>" class="logo" width="150"></p>
							<?php endif; ?>
							<input type="file" name="logo" accept=".png, .jpg, .jpeg, .gif, .svg">
							<p><small class="text-success"><?= trans('allowed_types') ?>: gif, jpg, png, jpeg</small>
							</p>
							<input type="hidden" name="old_logo"
								   value="<?php echo html_escape($general_settings['logo']); ?>">
						</div>
						<div class="form-group">
							<label class="control-label"><?= trans('application_name') ?></label>
							<input type="text" class="form-control" name="application_name" placeholder="application name" value="<?php echo html_escape($general_settings['application_name']); ?>">
						</div>
						<div class="form-group">
							<label class="control-label"><?= trans('copyright') ?></label>
							<input type="text" class="form-control" name="copyright" placeholder="Copyright" value="<?php echo html_escape($general_settings['copyright']); ?>">
						</div>
					</div>


					<!-- Company Settings -->
					<div role="tabpanel" class="tab-pane" id="company_setup">
						<div class="form-group">
							<label class="control-label">Company Name</label>
							<input type="text" class="form-control" name="company_name" placeholder="" value="">
						</div>
						<div class="form-group">
							<label class="control-label">Company Slogan</label>
							<input type="text" class="form-control" name="company_slogan" placeholder="" value="">
						</div>
						<div class="form-group">
							<label class="control-label">Company URL</label>
							<input type="text" class="form-control" name="company_url" placeholder="" value="">
						</div>
						<div class="form-group">
							<label class="control-label">Company Logo</label>
							<input type="text" class="form-control" name="company_logo" placeholder="" value="">
						</div>
						<div class="form-group">
							<label class="control-label">Menu Logo</label>
							<input type="text" class="form-control" name="company_menu_logo" placeholder="" value="">
						</div>
						<div class="form-group">
							<label class="control-label">Mobile Logo</label>
							<input type="text" class="form-control" name="company_mobile_logo" placeholder="" value="">
						</div>
						<div class="form-group">
							<label class="control-label">From Email Address</label>
							<input type="text" class="form-control" name="company_form_email_address" placeholder=""
								   value="">
						</div>
						<div class="form-group">
							<label class="control-label">Phone Number</label>
							<input type="text" class="form-control" name="company_phone_number" placeholder="" value="">
						</div>
						<div class="form-group">
							<label class="control-label">Street Address</label>
							<input type="text" class="form-control" name="company_street_address" placeholder=""
								   value="">
						</div>
						<div class="form-group">
							<label class="control-label">Hide Powered By on public pages</label>
							<input type="text" class="form-control" name="company_hide_powered_by" placeholder=""
								   value="">
						</div>
						<div class="form-group">
							<label class="control-label">Enable Powered By</label>
							<input type="text" class="form-control" name="company_enable_powered_by" placeholder=""
								   value="">
						</div>
					</div>


					<div class="box-footer">
						<input type="submit" name="submit" value="<?= trans('save_changes') ?>"
							   class="btn btn-primary pull-right">
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
	</section>
</div>

<script>
	$("#setting").addClass('active');
	$('#myTabs a').click(function (e) {
     e.preventDefault()
     $(this).tab('show')

 })

	$(document).ready(function() {
		$('[data-toggle="switch"]').bootstrapSwitch();
		$('#cb_google_places_status').bootstrapSwitch('state', <?php echo ($general_settings['google_places_is_active'] == 1) ? 'true' : 'false'; ?>);


		$('#cb_google_places_status').on('switchChange.bootstrapSwitch', function (event, state) {
			if (state === false) { $("#grp_google_places").hide();}
			else { $("#grp_google_places").show();}
		});

		//$('#cb_google_places_status').on('change.bootstrapSwitch', function(e) {
		//	console.log(e.target.checked);
		//});

	});
</script>
