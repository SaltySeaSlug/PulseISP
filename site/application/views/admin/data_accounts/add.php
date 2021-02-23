<div class="form" id="data_account_form">
	<!-- USER TYPE -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="user_type">User Type</label>
		<div class="col-sm-10">
			<select type="text" class="form-control" id="user_type" tabindex="-1" aria-hidden="true">
				<option value="radius_user">Radius User Login</option>
				<option value="radius_mac">Radius MAC Address Login</option>
				<option value="mikrotik_login">MikroTik Winbox Login</option>
			</select>
		</div>
	</div>
	<!-- CONNECTION TYPE -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="connection_type">Connection Type</label>
		<div class="col-sm-10">
			<select type="text" class="form-control" id="connection_type" tabindex="-1" aria-hidden="true">
				<option value="conn_wireless">Wireless</option>
				<option value="conn_hotspot">Hotspot</option>
				<option value="conn_fibre">Fibre</option>
			</select>
		</div>
	</div>
	<!-- USERNAME -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="username"><?= trans('username') ?></label>
		<div class="col-sm-10">
			<div class="input-group">
				<input name="username" type="text" class="form-control" id="username" placeholder="" autocomplete="off" value="" required>
				<span class="input-group-append"><button id="ppp_username_btn" onclick="generatePPPUsername()" type="button" class="btn btn-default btn-flat">Generate</button></span>
			</div>
		</div>
	</div>
	<!-- PASSWORD -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="password"><?= trans('password') ?></label>
		<div class="col-sm-10">
			<div class="input-group">
				<input name="password" type="text" class="form-control" id="password" placeholder="" autocomplete="off" value="" required>
				<span class="input-group-append"><button id="password" onclick="$('#password').val(generatePassword(12)); return false;" type="button" class="btn btn-default btn-flat">Generate Password</button></span>
			</div>
		</div>
	</div>
	<!-- ACCOUNT ALIAS -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="account_alias">Account Alias</label>
		<div class="col-sm-10">
			<input name="account_alias" type="text" class="form-control" id="account_alias" placeholder="" autocomplete="off" value="" required>
		</div>
	</div>
	<!-- ACCOUNT DESCRIPTION -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="account_description">Account Description</label>
		<div class="col-sm-10">
			<input name="account_description" type="text" class="form-control" id="account_description" placeholder="" autocomplete="off" value="" required>
		</div>
	</div>
	<!-- LABELS -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="account_labels">Labels</label>
		<div class="col-sm-10">
			<input name="account_labels" type="text" class="form-control" id="account_labels" placeholder=""
				   autocomplete="off" value="" required>
		</div>
	</div>
	<!-- TRAFFIC COUNTED -->
	<!-- TODO: Radius Accounting - a data account and session is required | IP Accounting - info is pulled from the router for a specific IP -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="traffic_count">Traffic Count</label>
		<div class="col-sm-10">
			<select type="text" class="form-control" id="traffic_count" tabindex="-1" aria-hidden="true">
				<option value="traffic_radius">Radius Accounting</option>
				<option value="traffic_ip">IP Accounting</option>
			</select>
		</div>
	</div>
	<!-- ACCOUNT TYPE -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="account_type">Account Type</label>
		<div class="col-sm-10">

			<select type="text" class="form-control" id="account_type" tabindex="-1" aria-hidden="true">
				<option value="account_normal">Normal Account</option>
				<option value="account_sub">Sub Account</option>
			</select>
		</div>
	</div>
	<!-- PASSWORD TYPE -->
	<!-- TODO: Implement password functions / password helper class -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="passwordtype">Password Type</label>
		<div class="col-sm-10">
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
	<!-- DATA PRODUCT -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label"for="data_product">Data Product</label>
		<div class="col-sm-10">
			<select class="form-control select2tag" id="data_product" name="data_product" style="width: 100%;" tabindex="-1" aria-hidden="true">
				<option value="-1">None</option>
				<?php foreach ($profiles as $profile) { ?>
					<option value="<?php echo $profile['id']; ?>"><?php echo $profile['name']; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<!-- CONCURRENT SESSIONS -->
	<!-- TODO : Add Simultaneous-Use := 1 to radgroupcheck-->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="session_concurrent">Concurrent Sessions</label>
		<div class="col-sm-10">
			<input name="session_concurrent" type="text" class="form-control" id="session_concurrent" placeholder=""
				   autocomplete="off" value="" required>
		</div>
	</div>
	<!-- IP MODE -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="ip_mode">IP Mode</label>
		<div class="col-sm-10">
			<select class="form-control select2tag" id="ip_mode" name="ip_mode">
				<option value='ip_static'>Manually Enter IP Address</option>
				<option value='ip_dhcp'>Select IP Address from IP Pool list</option>
			</select>
		</div>
	</div>
	<!-- FIXED IP ADDRESS -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="ip_address_fixed">Fixed IP Address</label>
		<div class="col-sm-10">
			<input name="ip_address_fixed" type="text" class="form-control" id="ip_address_fixed" placeholder="" autocomplete="off" value="" required>
		</div>
	</div>
	<!-- BRIDGED CPE IP ADDRESS -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="bridged_ip_address_fixed">Bridged CPE IP Address</label>
		<div class="col-sm-10">
			<input name="bridged_ip_address_fixed" type="text" class="form-control" id="bridged_ip_address_fixed" placeholder="" autocomplete="off" value="" required>
		</div>
	</div>
	<!-- HIGHSITE ROUTER -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="highsite_router">Highsite Router</label>
		<div class="col-sm-10">
			<select class="form-control select2tag" id="highsite_router" name="highsite_router">
				<option>None</option>
			</select>
		</div>
	</div>
	<!-- QUEUE ROUTER -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="queue_router">Queue Router</label>
		<div class="col-sm-10">
			<select class="form-control select2tag" id="queue_router" name="queue_router">
				<option>None</option>
			</select>
		</div>
	</div>
	<!-- AUTHENTICATION -->
	<!-- TODO: Implement pre check, if accept selected authentication will proceed, if reject selected authentication will be denied -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="authentication">Authentication</label>
		<div class="col-sm-10">
			<select class="form-control select2tag" id="authentication" name="authentication">
				<option>Accept</option>
				<option>Reject</option>
			</select>
		</div>
	</div>
	<!-- IP ADDRESS TYPE -->
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="ipaddresstype">IP Address Type</label>
		<div class="col-sm-10">
			<select class="form-control select2tag" id="ipaddresstype" name="ipaddresstype">
				<option value='dhcp'>DHCP</option>
				<option value='static'>Static</option>
			</select>
		</div>
	</div>
	<!-- IP ADDRESS -->
	<div id="staticgroup" class="form-group row">
		<label class="col-sm-2 col-form-label" for="staticip">Static IP Address</label>
		<div class="col-sm-10">
			<select class="form-control select2tag" id="staticip" name="staticip">
				<option value="None">None</option>
				<?php foreach ($ipAddresses as $ipaddress) { ?>
					<option value="<?php echo $ipaddress['id']; ?>"><?php echo $ipaddress['framedipaddress']; ?><?php echo " (".$ipaddress['pool_name'].")"; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
</div>
