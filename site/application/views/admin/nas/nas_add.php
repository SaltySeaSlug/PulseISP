  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-plus"></i>
              <?= trans('add_new_nas') ?> </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/nas'); ?>" class="btn btn-success"><i class="fa fa-list"></i> <?= trans('nas_list') ?></a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <!-- form start -->
                <div class="box-body">

                  <!-- For Messages -->
                  <?php $this->load->view('admin/includes/_messages.php') ?>

                  <?php echo form_open(base_url('admin/nas/add'), 'class="form-horizontal"');  ?>
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
						<input type="text" class="form-control" id="nashost" name="nashost" required>
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
					<input type="text" class="form-control" id="nassecret" name="nassecret" value="qHeOh65w23" required>
				</div>
			</div>
<!-- NAS TYPE -->
			<div class="form-group">
				<label for="nastype" class="col-md-12 control-label">NAS Type</label>
				<div class="col-md-12">
					<select class="form-control" id="nastype" name="nastype">
						<option value="Mikrotik">Mikrotik</option>
						<option value="Cisco">Cisco</option>
						<option value="Other">Other</option>
					</select>
				</div>
			</div>
<!-- NAS NAME -->
			<div class="form-group">
				<label for="nasname" class="col-md-12 control-label">Name</label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nasname" name="nasname" required>
				</div>
			</div>
<!-- NAS IDENTIFIER -->
			<div class="form-group">
				<label for="nasidentifier" class="col-md-12 control-label">Identifier</label>
				<div class="col-md-12">
					<input type="text" class="form-control" id="nasidentifier" name="nasidentifier" required>
				</div>
			</div>

                  <div class="form-group">
                    <div class="col-md-12">
                      <input type="submit" name="submit" value="<?= trans('add_admin') ?>" class="btn btn-primary pull-right">
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
		  event.preventDefault();
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
  </script>
