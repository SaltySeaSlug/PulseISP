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
					<div class="form-group">
						<label for="poolname" class="col-md-12 control-label"><?= trans('ippool_name') ?></label>
								<input type="text" class="form-control" id="poolname" name="poolname" required>
							</div>
						</div>
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
