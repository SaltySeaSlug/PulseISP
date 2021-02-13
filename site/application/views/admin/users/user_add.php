  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

		<div class="card">
			<div class="card-header d-flex p-0">
				<div class="d-inline-block">
					<h3 class="card-title p-3 mt-1"><i class="fad fa-plus mr-2"></i><?= trans('add_new_user') ?></h3>
				</div>
				<ul class="nav nav-pills ml-auto p-2">
					<li class="nav-item ml-2"><a href="<?= base_url('admin/users'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i><?= trans('users_list') ?></a></li>
				</ul>
			</div><!-- /.card-header -->
			<?php echo form_open(base_url('admin/users/add'), 'class="form-horizontal"');  ?>

			<div class="card-body">
				<ul class="nav nav-tabs mb-3" role="tablist">
					<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">User Account</a>
					</li>
					<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Data Account</a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Portal Login</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<div class="form">
							<div class="form-group row">
								<label class="col-md-2 col-sm-3 col-form-label" for="summary-input-type">Type</label>
								<div class="col-md-10 col-sm-9">
									<select type="text" class="form-control" id="summary-input-type" tabindex="-1"
											aria-hidden="true" onchange="customerType(this.value)">
										<option value="0">Individual</option>
										<option value="1">Company</option>
									</select>

									<!--<div class="btn-group btn-group-toggle" data-toggle="buttons">
										<label class="btn btn-secondary active">
											<input type="radio" name="options" id="option1" autocomplete="off" onchange="customerType(0)" checked> Individual
										</label>
										<label class="btn btn-secondary">
											<input type="radio" name="options" id="option2" autocomplete="off" onchange="customerType(1)"> Company
										</label>
									</div>-->
								</div>
							</div>

							<div id="summary-company_type" style="display: none">
								<div class="form-group row">
									<label class="col-md-2 col-sm-3 col-form-label" for="company-name">Company Name</label>
									<div class="col-md-10 col-sm-9"><input type="text" class="form-control" id="company-name" placeholder="Company Name" autocomplete="off"></div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 col-sm-3 col-form-label" for="company-registration">Registration</label>
									<div class="col-md-10 col-sm-9"><input type="text" class="form-control" id="company-registration" placeholder="Company Registration" autocomplete="off"></div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 col-sm-3 col-form-label" for="company-vat-number">VAT Number</label>
									<div class="col-md-10 col-sm-9"><input type="text" class="form-control" id="company-vat-number" placeholder="VAT Number" autocomplete="off"></div>
								</div>
							</div>
							<!-- IDENTITY NUMBER -->
							<div class="form-group row">
								<label class="col-md-2 col-sm-3 col-form-label" for="profile-input-id-number">ID Number</label>
								<div class="col-md-10 col-sm-9"><input name="id_number" type="text" class="form-control" id="profile-input-id-number" autocomplete="off"></div>
							</div>
							<!-- NAME -->
							<div class="form-group row">
								<label class="col-md-2 col-sm-3 col-form-label"
									   for="firstname"><?= trans('firstname') ?></label>
								<div class="col-md-10 col-sm-9"><input type="text" name="firstname" class="form-control"
																	   id="firstname" placeholder=""></div>
							</div>
							<!-- SURNAME -->
							<div class="form-group row">
								<label class="col-md-2 col-sm-3 col-form-label"
									   for="lastname"><?= trans('lastname') ?></label>
								<div class="col-md-10 col-sm-9"><input type="text" name="lastname" class="form-control"
																	   id="lastname" placeholder=""></div>
							</div>
							<!-- EMAIL ADDRESS -->
							<div class="form-group row">
								<label class="col-md-2 col-sm-3 col-form-label"
									   for="email"><?= trans('email') ?></label>
								<div class="col-md-10 col-sm-9"><input type="email" name="email" class="form-control"
																	   id="email" placeholder=""></div>
							</div>
							<!-- CONTACT NUMBER -->
							<div class="form-group row">
								<label class="col-md-2 col-sm-3 col-form-label"
									   for="mobile_no"><?= trans('mobile_no') ?></label>
								<div class="col-md-10 col-sm-9"><input type="tel" name="mobile_no" class="form-control"
																	   id="mobile_no" placeholder=""></div>
							</div>
							<!-- ADDRESS -->
							<?php if (!empty($this->general_settings['google_api_key']) && !empty($this->general_settings['google_places_is_active'])) { ?>
								<div class="form-group row">
									<!-- GOOGLE PLACES API -->
									<label class="col-md-2 col-sm-3 col-form-label" for="autocomplete">Search
										Address</label>
									<div class="col-md-10 col-sm-9">
										<div class="input-group">
											<input class="form-control" name="autocomplete" id="autocomplete"
												   type="text">
											<?php if (!empty($this->general_settings['google_api_key'])) { ?>
												<input id="btn-view-on-map" type="button" class="btn btn-info btn-flat"
													   onclick="showContactAddress(); return false;"
													   title="This displays a rough estimate based on address, gps coordinates are more precise"
													   value="View on Map">
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
							<!-- MAP -->
							<?php if (!empty($this->general_settings['google_api_key'])) { ?>
								<div class="row">
									<div class="col-sm-7 col-md-6">
										<div class="form-group row">
											<label class="col-sm-5 col-md-4 col-form-label"
												   for="street_number">Number</label>
											<div class="col-sm-7 col-md-8"><input class="form-control"
																				  name="street_number"
																				  id="street_number" type="text"
																				  autocomplete="off"></div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-md-4 col-form-label" for="route">Street Address</label>
										<div class="col-sm-7 col-md-8"><input class="form-control" name="route" id="route" type="text" autocomplete="off"></div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-md-4 col-form-label" for="locality">City</label>
										<div class="col-sm-7 col-md-8"><input class="form-control" name="locality" id="locality" type="text" autocomplete="off"></div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-md-4 col-form-label" for="administrative_area_level_1">State</label>
										<div class="col-sm-7 col-md-8"><input class="form-control" name="administrative_area_level_1" id="administrative_area_level_1" type="text" autocomplete="off"></div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-md-4 col-form-label" for="postal_code">Postal Code</label>
										<div class="col-sm-7 col-md-8"><input class="form-control" name="postal_code" id="postal_code" type="text" autocomplete="off"></div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-md-4 col-form-label" for="country">Country</label>
										<div class="col-sm-7 col-md-8"><input class="form-control" name="country" id="country" type="text" autocomplete="off"></div>
									</div>
								</div>
								<div class="col-sm-5 col-md-6">
									<div id="google-map" style="border: 1px solid rgb(204, 204, 204); border-radius: 4px; height: 284px; width: 100%; overflow: hidden;"></div>
									<small>Drag the marker to mark the exact location on the map.</small>
									<input name="marker_gps_coordinates" class="form-control ml-0 mt-0 no-border font-size-0 bg-transparent border-transparent" id="marker_gps_coordinates" type="text" autocomplete="off" readonly disabled hidden>
								</div>
							</div>
							<?php } ?>

							<!-- GPS COORDINATES -->
							<div class="form-group row">
								<!-- GOOGLE PLACES API -->
								<label class="col-md-2 col-sm-3 col-form-label">GPS Coordinates</label>
								<div class="col-md-10 col-sm-9">
									<div class="input-group">
										<input class="form-control" name="gps_coordinates" id="gps_coordinates" type="text" autocomplete="off">
									</div>
								</div>
							</div>

							<!-- ACCOUNT CODE -->
							<div class="form-group row">
								<label class="col-md-2 col-sm-3 col-form-label" for="account_code">Account Code</label>
								<div class="col-md-10 col-sm-9">
									<div class="input-group">
										<input name="account_code" type="text" class="form-control" id="profile-input-account-code" autocomplete="off" value="" required>
										<span class="input-group-append"><button id="account_code_btn" onclick="generateAccountCode()" type="button" class="btn btn-default btn-flat">Generate</button></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab_2">
						<div class="row m-0 mb-4">
							<input data-toggle="switch" class="tgl_checkbox" data-id="data_account" id="cb_data_account" type="checkbox"
								   data-on-text="Disable Data Account"
								   data-off-text="Create Data Account"
								   data-size="large">
						</div>

						<?php $this->load->view('admin/data_accounts/add'); ?>

					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab_3">
						<form>
							<!-- USERNAME -->
							<div class="form-group row">
								<label class="col-sm-2 col-form-label" for="portal_username"><?= trans('username') ?></label>
								<div class="col-sm-10">
									<input name="portal_username" type="text" class="form-control" id="portal_username" placeholder="" autocomplete="off" value="" required>
								</div>
							</div>
							<!-- PASSWORD -->
							<div class="form-group row">
								<label class="col-sm-2 col-form-label" for="portal_password"><?= trans('password') ?></label>
								<div class="col-sm-10">
									<input type="password" name="portal_password" class="form-control" id="portal_password" placeholder="">
								</div>
							</div>
						</form>
					</div>
					<!-- /.tab-pane -->
				</div>
			</div>

			<div class="card-footer">
				<div class="form-group">
					<div class="col-md-12">
						<input type="submit" name="submit" value="<?= trans('add_user') ?>" class="btn btn-primary pull-right">
					</div>
				</div>
			</div>
			<?php echo form_close( ); ?>
		</div>
	</section>
  </div>






  <script>
	  const componentForm = {
		  street_number: "short_name",
		  route: "long_name",
		  locality: "long_name",
		  administrative_area_level_1: "short_name",
		  country: "long_name",
		  postal_code: "short_name",
	  };

	  $(document).ready(function() {
		  $('#dhcpgroup').hide();
		  $('#staticgroup').hide();
		  $("#data_account_form").hide();

		  $('[data-toggle="switch"]').bootstrapSwitch();

		  $('#cb_data_account').on('switchChange.bootstrapSwitch', function (event, state) {
			  (state === false) ? $('#data_account_form').hide() : $('#data_account_form').show();
		  });

		  <?php if (!empty($this->general_settings['google_api_key'])) { ?>
			  let options = {
				  country: "ZA",
				  location: "ZA",
				  input: 'autocomplete',
				  output: 'gps_coordinates',
				  outputgrp: 'gps_marker_group'
			  };
			  buildGoogleMap('google-map', '0,0', false, options);
		  <?php } ?>

		  $(function() {
			  $('#ipaddresstype').change(function(){
				  $('#dhcpgroup').hide();
				  $('#staticgroup').hide();
				  if ($(this).val() != '') {
					  $('#' + $(this).val() + 'group').show();
				  }
			  });

		  });
		  if ($('#profile-input-account-code').val().trim() != '') {
			  $('#profile-input-account-code').attr("readonly", "true");
			  $('#account_code_btn').attr("disabled", "true");
		  }
		  $( "#summary-input-type" ).change(function() {
			  $("#firstname").removeClass("is-invalid");
			  $("#lastname").removeClass("is-invalid");
			  $("#company-name").removeClass("is-invalid");
		  });
	  });

	  function setActiveTab(tab) {
		  $('.nav-item .nav-link').removeClass('active');
		  $('.tab-content .tab-pane').removeClass('active');

		  $('a[href="#' + tab + '"]').closest('a').addClass('active');
		  $('#' + tab).addClass('active');
	  }
	  function generateAccountCode() {

		  if ($('#summary-input-type').val() == 0) {
			  let fname = $('#firstname').val().trim().toLowerCase();

			  if ($('#firstname').val().trim().length <= 0) {
				  $('#firstname').addClass("is-invalid");
				  return;
			  }
			  if ($('#firstname').val().trim().length >= 3) {
				  $.ajax({
					  type: "GET",
					  url: "<?php echo base_url("data/generate_user_account_code"); ?>",
					  dataType: "json",
					  data: {"name": fname},
					  success: function (data) {
						  if (data.status == 'OK') {
							  $('#profile-input-account-code').val(data.result);
							  $('#account_code_btn').attr("disabled", "true");
							  $('#firstname').removeClass("is-invalid")
						  } else if (data.status == 'ERR') {
							  $('#firstname').addClass("is-invalid");
						  } else {
							  alert("Error");
						  }
					  },
					  error: function (error) {
						  alert(error);
					  }
				  });
			  } else {
				  $('#profile-input-account-code').val('');
				  $('#account_code_btn').removeAttr("disabled");
			  }
		  }
		  if ($('#summary-input-type').val() == 1) {
			  let fname = $('#company-name').val().trim().toLowerCase();

			  if ($('#company-name').val().trim().length <= 0) {
				  $('#company-name').addClass("is-invalid");
				  return;
			  }
			  if ($('#company-name').val().trim().length >= 3) {
				  $.ajax({
					  type: "GET",
					  url: "<?php echo base_url("data/generate_user_account_code"); ?>",
					  dataType: "json",
					  data: {"name": fname},
					  success: function (data) {
						  if (data.status == 'OK') {
							  $('#profile-input-account-code').val(data.result);
							  $('#account_code_btn').attr("disabled", "true");
							  $('#company-name').removeClass("is-invalid")
						  } else if (data.status == 'ERR') {
							  $('#company-name').addClass("is-invalid");
						  } else {
							  alert("Error");
						  }
					  },
					  error: function (error) {
						  alert(error);
					  }
				  });
			  } else {
				  $('#profile-input-account-code').val('');
				  $('#account_code_btn').removeAttr("disabled");
			  }
		  }
		  else {

		  }


	  }
	  function generatePPPUsername() {
		  var fname = $('#firstname').val().trim().toLowerCase();
		  var lname = $('#lastname').val().trim().toLowerCase();

		  if (fname.length <= 0) {
			  $('#firstname').addClass("is-invalid");
			  setActiveTab('tab_1');
		  }
		  if (lname.length <= 0) {
			  $('#lastname').addClass("is-invalid");
			  setActiveTab('tab_1');
		  }
		  if (fname.length <= 0 || lname.length <= 0) return

		  $.ajax({
			  type: "GET",
			  url: "<?php echo base_url("data/generate_data_account_username"); ?>",
			  dataType: "json",
			  data: {"firstname": fname, "lastname": lname},
			  success: function (data) {
				  if (data.status == 'OK') {
					  $('#username').val(data.result);
					  $('#username').removeClass("is-invalid");
					  $('#firstname').removeClass("is-invalid");
					  $('#lastname').removeClass("is-invalid");
				  } else if (data.status == 'ERR') {
					  $('#username').addClass("is-invalid");
				  } else {
					  //alert("Error");
				  }
			  },
			  error: function (error) {
				  //alert(error);
			  }
		  });
	  }
	  function checkIfUsernameExists() {
		  var fname = $('#username').val().trim().toLowerCase();

		  $.ajax({
			  type: "GET",
			  url: "<?php echo base_url("data/check_data_account_username"); ?>",
			  dataType: "json",
			  data: {"un": fname},
			  success: function (data) {
				  if (data == false) {
					  $('#username').removeClass("is-invalid");
				  } else if (data == true) {
					  $('#username').addClass("is-invalid");
				  } else {
					  //alert("Error");
				  }
			  },
			  error: function (error) {
				  //alert(error);
			  }
		  });
	  }
	  function customerType(id) {
		  if (id === '1') {
			  $('#summary-company_type').show();
			  $("#name").removeClass("is-valid");
			  $("#name").removeClass("is-invalid");
		  }
		  else {
			  $('#summary-company_type').hide();
			  $('#company-name').val('');
			  $('#company-registration').val('');
			  $('#company-vat-number').val('');
			  $("#company-name").removeClass("is-valid");
			  $("#company-name").removeClass("is-invalid");
		  }
	  }
	  function showContactAddress() {
		  let address = $('#autocomplete').val();

		  if ($('#gps_coordinates').val() !== '') {
			  address = $('#gps_coordinates').val();
			  $("#physical_address").removeClass("is-invalid");
			  $("#gps_coordinates").removeClass("is-invalid");
		  }
		  else if ($('#physical_address').val() === '') {
			  showWarningAlert('Physical address or GPS co-ordinates are required');
			  $("#physical_address").addClass("is-invalid");
			  $("#gps_coordinates").addClass("is-invalid");
			  return;
		  }
		  else {
			  $("#physical_address").removeClass("is-invalid");
			  $("#gps_coordinates").removeClass("is-invalid");
		  }

		  let country = 'ZA';
		  let contact_map = document.getElementById("google-map").map;
		  let contact_marker = document.getElementById("google-map").marker;

		  let geocoder = new google.maps.Geocoder();
		  if (IsValidGPS(address)) {
			  let gps = address.split(",");
			  let latitude = parseFloat(gps[0].trim());
			  let longitude = parseFloat(gps[1].trim());

			  let latlng = new google.maps.LatLng(latitude, longitude);

			  contact_map.setCenter(latlng);
			  contact_marker.setPosition(latlng);
			  let gpsstr = contact_marker.getPosition();
			  document.getElementById('marker_gps_coordinates').value = gpsstr.toString().substring(1,gpsstr.toString().length-1);
			  console.log('1' + gpsstr);
			  contact_map.setZoom(18);
		  }
		  else {
			  google.maps.event.trigger(contact_map, "resize");
			  geocoder.geocode({'address': removeNL(address + ' ' + country)}, function (results, status) {
				  if (status === google.maps.GeocoderStatus.OK) {
					  contact_map.setCenter(results[0].geometry.location);
					  contact_marker.setPosition(results[0].geometry.location);
					  let gpsstr = contact_marker.getPosition();
					  document.getElementById('marker_gps_coordinates').value = gpsstr.toString().substring(1,gpsstr.toString().length-1);
					  console.log('2 ' + gpsstr);
					  contact_map.setZoom(18);
				  } else {
					  showErrorAlert("Unable to find the address on the map. Please drag the marker on the map manually to set the location.", null, 4000);
				  }
			  });
		  }
	  }

	  (function($){
		  $.fn.extend({
			  donetyping: function(callback,timeout){
				  timeout = timeout || 1e3; // 1 second default timeout
				  var timeoutReference,
						  doneTyping = function(el){
							  if (!timeoutReference) return;
							  timeoutReference = null;
							  callback.call(el);
						  };
				  return this.each(function(i,el){
					  var $el = $(el);
					  // Chrome Fix (Use keyup over keypress to detect backspace)
					  // thank you @palerdot
					  $el.is(':input') && $el.on('keyup keypress paste',function(e){
						  // This catches the backspace button in chrome, but also prevents
						  // the event from triggering too preemptively. Without this line,
						  // using tab/shift+tab will make the focused element fire the callback.
						  if (e.type=='keyup' && e.keyCode!=8) return;

						  // Check if timeout has been set. If it has, "reset" the clock and
						  // start over again.
						  if (timeoutReference) clearTimeout(timeoutReference);
						  timeoutReference = setTimeout(function(){
							  // if we made it here, our timeout has elapsed. Fire the
							  // callback
							  doneTyping(el);
						  }, timeout);
					  }).on('blur',function(){
						  // If we can, fire the event since we're leaving the field
						  doneTyping(el);
					  });
				  });
			  }
		  });
	  })(jQuery);

	  $('#firstname').donetyping(function(){
		  generateAccountCode();
	  });
	  $('#firstname').donetyping(function(){
		  if ($('#firstname').val().trim().length > 0 && $('#lastname').val().trim().length > 0) {
			  generatePPPUsername();
		  }
	  });
	  $('#lastname').donetyping(function(){
		  if ($('#firstname').val().trim().length > 0 && $('#lastname').val().trim().length > 0) {
			  generatePPPUsername();
		  }
	  });
	  $('#username').donetyping(function(){
		  checkIfUsernameExists();
	  });

  </script>
