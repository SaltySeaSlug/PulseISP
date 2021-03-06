  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default color-palette-bo">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title mt-2"><i class="fad fa-plus mr-2"></i><?= trans('add_ip_pool') ?></h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/ip_pool'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i><?= trans('ip_pool_list') ?></a>
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

                  <?php echo form_open(base_url('admin/ip_pool/add'), 'class="form-horizontal"');  ?>
					<!-- POOL NAME
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->
					<!-- DESCRIPTION
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->
					<!-- POOL TYPE
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<select>
							<option>Auto Allocation (Radius Dynamic)</option>
							<option>Manual Allocation (IP Accounting)</option>
							<option>System Allocation (Capped, Suspended & Unauth)</option>
						</select>
					</div>-->
					<!-- NETWORK SUBNETS , comma seperated
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->
					<!-- IPs IN RANGE
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->
					<!-- NUMBER OF IPs
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->
					<!-- EXCLUDED IPs
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->
					<!-- REALM
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->
					<!-- INCLUDED NAS ROUTERS (leave blank for all) -->
					<div class="form-group">
						<label for="include_nasdevices" class="col-md-12 control-label">NAS Devices</label>
						<select class="form-control select2 select2tag select2-hidden-accessible"
								id="include_nasdevices" name="include_nasdevices[]" style="width: 100%;" tabindex="-1"
								aria-hidden="true" multiple>
							<?php foreach ($nas_devices as $item) { echo "<option value='".$item['id']."'>".$item['nasname']." (".$item['shortname'].")</option>"; } ?>
						</select>
					</div>
					<!-- EXCLUDED NAS ROUTERS
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->
					<!-- ENABLED
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label">Pool Name</label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>-->





					<!--<div class="form-group">
						<label for="addunaddressableips" class="col-md-12 control-label"><?= trans('unaddressableips') ?></label>
						<input type="checkbox" class="form-control" id="addunaddressableips" name="addunaddressableips">
					</div>-->

					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label"><?= trans('ippool_name') ?></label>
						<input type="text" class="form-control" id="poolname" name="poolname" required>
					</div>
					<div class="form-group">
						<label for="iprange" class="col-md-12 control-label"><?= trans('ip_range') ?></label>
						<div class="col-md-12">
							<div class="input-group">
								<input type="text" class="form-control" id="iprange" name="iprange" required>
								<span class="input-group-append">
									<button type="button" id="generatebtn" class="btn btn-info btn-flat">Generate</button>
								</span>
							</div>
						</div>
					</div>

					<table id="table" class="table table-striped table-condensed table-valign-middle table-sm nowrap text-nowrap d-table nowrap" style="width: 100%">
						<thead>
						<tr>
							<th></th>
							<th></th>
						</tr>
						</thead>
						<tbody id="tbodyid">
						</tbody>
					</table>

                  <div class="form-group">
                    <div class="col-md-12">
                      <input type="submit" name="submit" value="<?= trans('add_ip_pool') ?>" class="btn btn-primary pull-right">
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
	  $('#generatebtn').on('click', function(event){
		  if (event != null) event.preventDefault();

		  $.ajax({
			  type: "GET",
			  url: "<?php echo base_url("functions/getIPDetails.php") ?>",
			  dataType: "json",
			  data: "iprange=" + $("#iprange").val(),
			  success: function(result) {
				  $("#tbodyid").empty();
				  $.each(result,function(i,item){
					  $("#table tbody").append(
						  "<tr>"
						  +item+
						  +"</tr>" )
				  });
			  }
		  });
	  });
  </script>
