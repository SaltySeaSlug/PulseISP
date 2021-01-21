  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title mt-2"><i class="fad fa-pencil mr-2"></i><?= trans('edit_nas') ?></h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/ip_pool'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i><?= trans('ip_pool_list') ?></a>
            <a href="<?= base_url('admin/ip_pool/add'); ?>" class="btn btn-success"><i class="fad fa-plus mr-2"></i><?= trans('add_ip_pool') ?></a>
          </div>
        </div>
        <div class="card-body">
   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>
           
            <?php echo form_open(base_url('admin/nas/edit/'.$nas['id']), 'class="form-horizontal"' )?>
			<!-- NAS TYPE (CONNECTION TYPE) -->
			<div class="form-group">
				<label for="nasconnectiontype" class="col-md-12 control-label">Connection Type</label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nasconnectiontype" name="nasconnectiontype" readonly value="Direct (Fixed IP)" required>
				</div>
			</div>
			<!-- NAS HOST (IP ADDRESS) -->
			<div class="form-group">
				<label for="nashost" class="col-md-12 control-label">IP Address</label>
				<div class="col-md-12">
					<div class="input-group">
						<input type="text" class="form-control" id="nashost" name="nashost" required value="<?= $nas['nasname']; ?>">
						<span class="input-group-append">
						<button type="button" id="pingbtn" class="btn btn-info btn-flat">Ping</button>
					</span>
					</div>
				</div>
			</div>
			<!-- NAS SECRET -->
			<div class="form-group">
				<label for="nassecret" class="col-md-12 control-label">NAS Secret</label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nassecret" name="nassecret" value="<?= $nas['secret']; ?>" required>
				</div>
			</div>
			<!-- NAS TYPE -->
			<div class="form-group">
				<label for="nastype" class="col-md-12 control-label">NAS Type</label>
				<div class="col-md-12">
					<select class="form-control" id="nastype" name="nastype">
						<option <?php if($nas['type'] == 'mikrotik') echo 'selected="selected"'; ?> value="Mikrotik">Mikrotik</option>
						<option <?php if($nas['type'] == 'cisco') echo 'selected="selected"'; ?> value="Cisco">Cisco</option>
						<option <?php if(strtolower($nas['type']) == 'other') echo 'selected="selected"'; ?> value="Other">Other</option>
					</select>
				</div>
			</div>
			<!-- NAS NAME -->
			<div class="form-group">
				<label for="nasname" class="col-md-12 control-label">Name</label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nasname" name="nasname" required value="<?= $nas['shortname']; ?>">
				</div>
			</div>
			<!-- NAS IDENTIFIER -->
			<div class="form-group">
				<label for="nasidentifier" class="col-md-12 control-label">Identifier</label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nasidentifier" name="nasidentifier" required value="<?= $nas['nasidentifier']; ?>">
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12">
					<input type="submit" name="submit" value="<?= trans('update_nas') ?>" class="btn btn-primary pull-right">
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
		  <!-- /.box-body -->
	  </div>
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
		  if (!isValidIP($('#nashost').val())) { $("#pingbtn").removeClass("bg-green"); $("#pingbtn").addClass("bg-red"); $("#pingbtn").html('Invalid IP'); return; }

		  $.ajax({
			  type: "GET",
			  url: "<?php echo base_url("functions/ping_ip.php"); ?>",
			  dataType: "json",
			  data: {"ip": $("#nashost").val()},
			  success: function (result) {

				  if (result != "ERR") { $("#pingbtn").removeClass("bg-red"); $("#pingbtn").addClass("bg-green"); $("#pingbtn").html(result + ' ms'); }
				  else { $("#pingbtn").removeClass("bg-green"); $("#pingbtn").addClass("bg-red"); $("#pingbtn").html(result); }
			  },
			  error: function (error) {
				  $("#pingbtn").removeClass("bg-green"); $("#pingbtn").addClass("bg-red"); $("#pingbtn").html('Unreachable');
			  }
		  });
	  }

	  $('#pingbtn').on('click', doPing);

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

	  $('#nashost').donetyping(function(){
		  doPing();
	  });
  </script>
