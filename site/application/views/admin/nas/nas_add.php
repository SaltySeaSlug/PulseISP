  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title mt-2"> <i class="fad fa-plus mr-2"></i><?= trans('add_new_nas') ?> </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/nas'); ?>" class="btn btn-success"><i class="fad fa-list mr-1"></i> <?= trans('nas_list') ?></a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
                  <!-- For Messages -->
                  <?php $this->load->view('admin/includes/_messages.php') ?>

                  <?php echo form_open(base_url('admin/nas/add'), 'class="form-horizontal"');  ?>
<!-- NAS TYPE (CONNECTION TYPE) -->
			<div class="form-group">
				<label for="nasconnectiontype" class="col-md-12 control-label"><?= trans('connection_type') ?></label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nasconnectiontype" name="nasconnectiontype" readonly value="Direct (Fixed IP)" required>
				</div>
			</div>
<!-- NAS HOST (IP ADDRESS) -->
			<div class="form-group">
				<label for="nashost" class="col-md-12 control-label"><?= trans('ip_address') ?></label>
				<div class="col-md-12">
					<div class="input-group">
						<input type="text" class="form-control" id="nashost" name="nashost" required>
						<span class="input-group-append">
						<button type="button" id="pingbtn" class="btn btn-info btn-flat">Ping</button>
					</span>
					</div>
				</div>
			</div>
				<!-- SNMP LOOKUP -->
				<div class="col-12" id="snmp"></div>
				<!-- NAS SECRET -->
				<div class="form-group">
					<label for="nassecret" class="col-md-12 control-label"><?= trans('secret') ?> <span
								class="badge badge-warning">using system specified password</span></label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="nassecret" name="nassecret"
							   value="<?php echo html_escape($general_settings['radius_secret']); ?>" required>
					</div>
				</div>
				<!-- NAS TYPE -->
				<!-- TODO: When snmp walk is complete - check vendor type and update accordingly, else leave as other -->
				<div class="form-group">
					<label for="nastype" class="col-md-12 control-label"><?= trans('type') ?></label>
					<div class="col-md-12">
						<select class="form-control" id="nastype" name="nastype">
							<option value="other">Other</option>
							<option value="mikrotik">Mikrotik</option>
							<option value="cisco">Cisco</option>
							<option value="livingston">Livingston</option>
							<option value="max40xx">Max40xx</option>
							<option value="multitech">Multitech</option>
							<option value="natserver">Nat Server</option>
							<option value="pathras">PathRAS</option>
							<option value="patton">Patton</option>
							<option value="portslave">Port Slave</option>
							<option value="tc">TC</option>
							<option value="usrhiper">USRhiper</option>
						</select>
					</div>
				</div>
				<!-- NAS NAME -->
				<div class="form-group">
					<label for="nasname" class="col-md-12 control-label"><?= trans('name') ?></label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nasname" name="nasname" required>
				</div>
			</div>
<!-- NAS IDENTIFIER -->
			<div class="form-group">
				<label for="nasidentifier" class="col-md-12 control-label"><?= trans('identifier') ?></label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nasidentifier" name="nasidentifier" required>
				</div>
			</div>
				<!-- NAS PORT -->
				<div class="form-group" hidden>
					<label for="nasport" class="col-md-12 control-label"><?= trans('nas_port') ?></label>
					<div class="col-md-12">
						<input type="number" class="form-control" id="nasport" name="nasport" value="3799" required>
					</div>
				</div>
				<!-- COMMUNITY -->
				<div class="form-group" hidden>
					<label for="nascommunity" class="col-md-12 control-label"><?= trans('community') ?></label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="nascommunity" name="nascommunity" value="public">
					</div>
				</div>
				<!-- DESCRIPTION -->
				<div class="form-group">
					<label for="nasdescription" class="col-md-12 control-label"><?= trans('description') ?></label>
					<div class="col-md-12">
						<input type="text" class="form-control" id="nasdescription" name="nasdescription"
							   value="RADIUS Client" required>
					</div>
				</div>
				<!-- DHCP POOL
			<div class="form-group">
				<label for="ippool" class="col-md-2 control-label">IP Pools</label>
				<div class="col-md-12">
					<select class="form-control select2tag" id="ippool" name="ippool">
						<option value="None">None</option>
						<?php foreach ($ippools as $pool) { ?>
							<option value="<?php echo $pool['id']; ?>"><?php echo $pool['pool_name']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
-->
				<div class="form-group">
                    <div class="col-md-12">
                      <input type="submit" name="submit" value="<?= trans('add_new_nas') ?>" class="btn btn-primary pull-right">
                    </div>
                  </div>
                <?php echo form_close(); ?>
			</div>
		  </div>
		</div>
	  </div>
	</section>
  </div>

  <script>
	  function isValidIP(str) {
		  const octet = '(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]?|0)';
		  const regex = new RegExp(`^${octet}\\.${octet}\\.${octet}\\.${octet}$`);
		  return regex.test(str);
	  }

	  function doPing(event) {
		  if (event != null) event.preventDefault();
		  if (!isValidIP($('#nashost').val())) {
			  $("#pingbtn").removeClass("bg-green");
			  $("#pingbtn").addClass("bg-red");
			  $("#pingbtn").html('Invalid IP');
			  return;
		  }

		  $.ajax({
			  type: "GET",
			  url: "<?php echo base_url("functions/ping_ip.php"); ?>",
			  dataType: "json",
			  data: {"ip": $("#nashost").val()},
			  success: function (result) {
				  if (result != "ERR") {
					  $("#pingbtn").removeClass("bg-red");
					  $("#pingbtn").addClass("bg-green");
					  $("#pingbtn").html('Reachable');
					  $.ajax({
						  type: "GET",
						  url: "<?php echo base_url("data/checkDevice"); ?>",
						  dataType: "text",
						  data: {"ip": $("#nashost").val()},
						  success: function (result) {
							  $("#snmp").html(result);
							  const vendor = result.substring(result.lastIndexOf("Device Vendor:</b> ") + 19, result.lastIndexOf("<br> <b>Device Identity:"));
							  const identifier = result.substring(result.lastIndexOf("Device Identity:</b> ") + 21, result.lastIndexOf("<br> <b>Device Uptime:"));
							  $("#nastype").val(vendor.toLowerCase()).change();
							  $("#nasidentifier").val(identifier.toUpperCase()).change()
						  },
						  error: function (error) {
						  }
					  });
				  } else {
					  $("#pingbtn").removeClass("bg-green");
					  $("#pingbtn").addClass("bg-red");
					  $("#pingbtn").html(result);
					  $("#snmp").html('');
				  }
			  },
			  error: function (error) {
				  $("#pingbtn").removeClass("bg-green");
				  $("#pingbtn").addClass("bg-red");
				  $("#pingbtn").html('Unreachable');
				  $("#snmp").html('');
			  }
		  });
	  }

	  $('#pingbtn').on('click', doPing);

	  (function ($) {
		  $.fn.extend({
			  donetyping: function (callback, timeout) {
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

	  $('#nashost').donetyping(function () {
		  doPing();
	  }, 2000);
  </script>
