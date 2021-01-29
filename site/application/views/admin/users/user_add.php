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
					<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">User Account</a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Data Account</a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Portal Login</a></li>
					<li class="nav-item ml-2"><a href="<?= base_url('admin/users'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i><?= trans('users_list') ?></a></li>
				</ul>
			</div><!-- /.card-header -->
			<?php echo form_open(base_url('admin/users/add'), 'class="form-horizontal"');  ?>

			<div class="card-body">

				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<div class="form">
							<div class="form-group">
								<label for="summary-input-type">Type</label>
								<select type="text" class="form-control" id="summary-input-type" tabindex="-1" aria-hidden="true" onchange="customerType(this.value)">
									<option value="0">Individual</option>
									<option value="1">Company</option>
								</select>
							</div>

							<div id="summary-company_type" class="row" style="display: none">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="form-group">
										<label for="company-name">Company Name</label>
										<input type="text" class="form-control" id="company-name" placeholder="Company Name" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-12 col-md-6 col-lg-6">
									<div class="form-group">
										<label for="company-registration">Company Registration</label>
										<input type="text" class="form-control" id="company-registration" placeholder="Company Registration" autocomplete="off">
									</div>
								</div>
								<div class="col-sm-12 col-md-6 col-lg-6">
									<div class="form-group">
										<label for="company-vat-number">VAT Number</label>
										<input type="text" class="form-control" id="company-vat-number" placeholder="VAT Number" autocomplete="off">
									</div>
								</div>
							</div>
							<!-- IDENTITY NUMBER -->
							<div class="col-sm-12 col-md-12">
								<div class="form-group">
									<label for="profile-input-id-number">ID Number</label>
									<input name="id_number" type="text" class="form-control" id="profile-input-id-number" autocomplete="off">
								</div>
							</div>
							<!-- NAME -->
							<div class="form-group">
								<label for="firstname" class="col-md-2 control-label"><?= trans('firstname') ?></label>
								<div class="col-md-12 col-lg-12">
									<input type="text" name="firstname" class="form-control" id="firstname" placeholder="">
								</div>
							</div>
							<!-- SURNAME -->
							<div class="form-group">
								<label for="lastname" class="col-md-2 control-label"><?= trans('lastname') ?></label>
								<div class="col-md-12 col-lg-12">
									<input type="text" name="lastname" class="form-control" id="lastname" placeholder="">
								</div>
							</div>
							<!-- EMAIL ADDRESS -->
							<div class="form-group">
								<label for="email" class="col-md-2 control-label"><?= trans('email') ?></label>
								<div class="col-md-12">
									<input type="email" name="email" class="form-control" id="email" placeholder="">
								</div>
							</div>
							<!-- CONTACT NUMBER -->
							<div class="form-group">
								<label for="mobile_no" class="col-md-2 control-label"><?= trans('mobile_no') ?></label>
								<div class="col-md-12">
									<input type="number" name="mobile_no" class="form-control" id="mobile_no" placeholder="">
								</div>
							</div>
							<!-- ADDRESS -->
							<div class="form-group">
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<label for="physical_address">Physical Address</label>
										<div class="input-group">
											<input name="physical_address" class="form-control" id="physical_address" type="text" autocomplete="off">
											<?php if (!empty($this->general_settings['google_api'])) { ?>
												<span class="input-group-append"><button id="btn-view-on-map" type="button" class="btn btn-info btn-flat" onclick="showContactAddress($('#physical_address').val()); return false;" title="This displays a rough estimate based on address, gps coordinates are more precise">View on Map</button></span>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>

							<?php if (!empty($this->general_settings['google_api'])) { ?>
							<div class="form-group">
								<div class="col-lg-12">
									<div id="google-map" style="border: 1px solid rgb(204, 204, 204); border-radius: 4px; height: 199px; position: relative; overflow: hidden;"></div>
									<small style="margin-left: 0px;">Drag the marker to mark the exact location on the map.</small>
									<div class="input-group" id="gps_marker_group">
										<input name="marker_gps_coordinates" class="form-control ml-0 no-border border-transparent bg-transparent font-size-0" id="marker_gps_coordinates" type="text" autocomplete="off" readonly disabled>
											<span class="input-group-append"><input id="btn-copy-from-map" type="button" class="btn btn-info btn-flat" onclick="copyGPSCoordinates($('#marker_gps_coordinates').val()); return false;" value="Use GPS Coordinates"></input></span>
									</div>
								</div>
							</div>
							<?php } ?>

							<!-- GPS COORDINATES -->
							<div class="form-group">
								<label for="gps_coordinates" class="col-md-2 control-label">GPS Coordinates</label>
								<div class="col-md-12">
									<input name="gps_coordinates" class="form-control" id="gps_coordinates" type="text" autocomplete="off">
								</div>
							</div>
							<!-- ACCOUNT CODE -->
							<div class="form-group">
								<label for="account_code" class="col-md-2 control-label">Account Code</label>
								<div class="col-md-12">
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
						<div class="row mb-2 ml-2">
							<input class="tgl tgl-light tgl_checkbox" data-id="data_account" id="cb_data_account" type="checkbox">
							<label class="tgl-btn" for="cb_data_account"></label><i class="ml-2">Create data account</i>
						</div>
						<div class="form" id="data_account_form">
							<!-- USERNAME -->
							<div class="form-group">
								<label for="username" class="col-md-2 control-label"><?= trans('username') ?></label>
								<div class="col-md-12">
									<div class="input-group">
										<input name="username" type="text" class="form-control" id="username" placeholder="" autocomplete="off" value="" required>
										<span class="input-group-append"><button id="ppp_username_btn" onclick="generatePPPUsername()" type="button" class="btn btn-default btn-flat">Generate</button></span>
									</div>
								</div>
							</div>
							<!-- PASSWORD -->
							<div class="form-group">
								<label for="password" class="col-md-2 control-label"><?= trans('password') ?></label>
								<div class="col-md-12">
									<input type="password" name="password" class="form-control" id="password" placeholder="">
								</div>
							</div>
							<!-- PASSWORD TYPE -->
							<div class="form-group">
								<label for="passwordtype" class="col-md-2 control-label">Password Type</label>
								<div class="col-md-12">
									<select class="form-control select2tag" id="passwordtype" name="passwordtype">
										<option value='Cleartext-Password'>Cleartext-Password</option>
										<option value='User-Password'>User-Password</option>
										<option value='Crypt-Password'>Crypt-Password</option>
										<option value='MD5-Password'>MD5-Password</option>
										<option value='SHA1-Password'>SHA1-Password</option>
										<option value='CHAP-Password'>CHAP-Password</option>
									</select>
								</div>
							</div>
							<!-- PROFILE -->
							<div class="form-group">
								<label for="profileid" class="col-md-2 control-label">Profile</label>
								<div class="col-md-12">
									<select class="form-control select2tag" id="profileid" name="profileid" style="width: 100%;" tabindex="-1" aria-hidden="true">
										<option value="-1">None</option>
										<?php foreach ($profiles as $profile) { ?>
											<option value="<?php echo $profile['id']; ?>"><?php echo $profile['name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<!-- IP ADDRESS TYPE -->
							<div class="form-group">
								<label for="ipaddresstype" class="col-md-2 control-label">IP Address Type</label>
								<div class="col-md-12">
									<select class="form-control select2tag" id="ipaddresstype" name="ipaddresstype">
										<option>None</option>
										<option value='dhcp'>DHCP</option>
										<option value='static'>Static</option>
									</select>
								</div>
							</div>
							<!-- DHCP POOL -->
							<div id="dhcpgroup" class="form-group">
								<label for="dhcppool" class="col-md-2 control-label">IP Pools</label>
								<div class="col-md-12">
									<select class="form-control select2tag" id="dhcppool" name="dhcppool">
										<option value="None">None</option>
										<?php foreach ($ipAddresses as $ipaddress) { ?>
											<option value="<?php echo $ipaddress['framedipaddress']; ?>"><?php echo $ipaddress['framedipaddress']; ?><?php echo " (".$ipaddress['pool_name'].")"; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<!-- IP ADDRESS -->
							<div id="staticgroup" class="form-group">
								<label for="staticip" class="col-md-2 control-label">Static IP Address</label>
								<div class="col-md-12">
									<select class="form-control select2tag" id="staticip" name="staticip">
										<option value="None">None</option>
										<?php foreach ($ipAddresses as $ipaddress) { ?>
											<option value="<?php echo $ipaddress['framedipaddress']; ?>"><?php echo $ipaddress['framedipaddress']; ?><?php echo " (".$ipaddress['pool_name'].")"; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->
					<div class="tab-pane" id="tab_3">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
						when an unknown printer took a galley of type and scrambled it to make a type specimen book.
						It has survived not only five centuries, but also the leap into electronic typesetting,
						remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
						sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
						like Aldus PageMaker including versions of Lorem Ipsum.
					</div>
					<!-- /.tab-pane -->
				</div>

				<!-- /.tab-content -->
			</div><!-- /.card-body -->

			<div class="card-footer">
				<div class="form-group">
					<div class="col-md-12">
						<input type="submit" name="submit" value="<?= trans('add_user') ?>" class="btn btn-primary pull-right">
					</div>
				</div>			</div>

			<?php echo form_close( ); ?>
		</div>

	</section>
  </div>






  <script>
	  $(document).ready(function() {
		  $('#dhcpgroup').hide();
		  $('#staticgroup').hide();
		  $("#data_account_form").hide();

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

		  <?php if (!empty($this->general_settings['google_api'])) { ?>

		  let options = {
			  country: "ZA",
			  location: "ZA",
			  input: 'physical_address',
			  output: 'marker_gps_coordinates',
			  outputgrp: 'gps_marker_group'
		  };
		  buildGoogleMap('google-map', '0,0', false, options);
		  google.maps.event.addDomListener(document.getElementById('physical_address'), 'keydown', function(event) {
			  if (event.keyCode === 13) {
				  event.preventDefault();
			  }
		  });
		  <?php } ?>
	  });
	  $("body").on("change",".tgl_checkbox",function(){
		  if ($(this).is(':checked') === false) {
			  $("#data_account_form").hide();
		  } else {
			  $("#data_account_form").show();
		  }
	  });

	  function setActiveTab(tab) {
		  $('.nav-pills .nav-item .nav-link').removeClass('active');
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
					url: "<?php echo base_url("data/generate_account_code"); ?>",
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
					url: "<?php echo base_url("data/generate_account_code"); ?>",
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
			  url: "<?php echo base_url("data/generate_ppp_username"); ?>",
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
			  url: "<?php echo base_url("data/check_username"); ?>",
			  dataType: "json",
			  data: {"username": fname},
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
	  function copyGPSCoordinates(gpsmarker){
		  if ($('#marker_gps_coordinates').val() === '')
		  {
			  alert('Please drag the marker to obtain gps coordinates');
			  return ;
		  }
		  else {
			  $('#gps_coordinates').val($('#marker_gps_coordinates').val());
			  $("#physical_address").removeClass("is-invalid");
			  $("#gps_coordinates").removeClass("is-invalid");
		  }
	  }
	  function showContactAddress(address) {

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
