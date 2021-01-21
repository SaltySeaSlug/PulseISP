  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title mt-2"><i class="fad fa-plus mr-2"></i><?= trans('add_new_user') ?></h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/users'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i><?= trans('users_list') ?></a>
          </div>
        </div>
        <div class="card-body">
   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <?php echo form_open(base_url('admin/users/add'), 'class="form-horizontal"');  ?>
<!-- NAME -->
				<div class="form-group">
					<label for="firstname" class="col-md-2 control-label"><?= trans('firstname') ?></label>
					<div class="col-md-12">
						<input type="text" name="firstname" class="form-control" id="firstname" placeholder="">
					</div>
				</div>
<!-- SURNAME -->
				<div class="form-group">
					<label for="lastname" class="col-md-2 control-label"><?= trans('lastname') ?></label>
					<div class="col-md-12">
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
					<label for="address" class="col-md-2 control-label"><?= trans('address') ?></label>
					<div class="col-md-12">
						<input type="text" name="address" class="form-control" id="address" placeholder="">
					</div>
				</div>
<!-- ACCOUNT CODE -->
			<div class="form-group">
				<label for="account_code" class="col-md-2 control-label">Account Code</label>
				<div class="col-md-12">
					<div class="input-group">
						<input name="account_code" type="text" class="form-control" id="profile-input-account-code" placeholder="Account Code" autocomplete="off" value="" required>
						<span class="input-group-append"><button id="account_code_btn" onclick="generateAccountCode()" type="button" class="btn btn-default btn-flat">Generate</button></span>
					</div>
				</div>
			</div>
<!-- USERNAME -->
			<div class="form-group">
                <label for="username" class="col-md-2 control-label"><?= trans('username') ?></label>
                <div class="col-md-12">
					<div class="input-group">
						<input name="username" type="text" class="form-control" id="username" placeholder="" autocomplete="off" value="" required>
						<span class="input-group-append"><button id="account_code_btn" onclick="generatePPPUsername()" type="button" class="btn btn-default btn-flat">Generate</button></span>
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

              <div class="form-group">
                <div class="col-md-12">
                  <input type="submit" name="submit" value="<?= trans('add_user') ?>" class="btn btn-primary pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
        </div>
          <!-- /.box-body -->
      </div>
    </section> 
  </div>

  <script>
	  $(document).ready(function() {
		  $('#dhcpgroup').hide();
		  $('#staticgroup').hide();

		  $(function() {    // Makes sure the code contained doesn't run until
			  //     all the DOM elements have loaded

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
	  });

	  function generateAccountCode() {
		  var fname = $('#firstname').val().trim().toLowerCase();
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
	  function generatePPPUsername() {
		  var fname = $('#firstname').val().trim().toLowerCase();
		  var lname = $('#lastname').val().trim().toLowerCase();

		  if (fname.length <= 0) {
			  $('#firstname').addClass("is-invalid");
		  }
		  if (lname.length <= 0) {
			  $('#lastname').addClass("is-invalid");
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
