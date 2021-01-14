  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="card card-default">
        <div class="card-header">
          <div class="d-inline-block">
              <h3 class="card-title"> <i class="fa fa-plus"></i>
             <?= trans('add_new_user') ?> </h3>
          </div>
          <div class="d-inline-block float-right">
            <a href="<?= base_url('admin/users'); ?>" class="btn btn-success"><i class="fa fa-list"></i>  <?= trans('users_list') ?></a>
          </div>
        </div>
        <div class="card-body">
   
           <!-- For Messages -->
            <?php $this->load->view('admin/includes/_messages.php') ?>

            <?php echo form_open(base_url('admin/users/add'), 'class="form-horizontal"');  ?>
			<div class="form-group">
				<label for="account_code" class="col-md-2 control-label">Account Code</label>
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
                  <input type="text" name="username" class="form-control" id="username" placeholder="">
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

<!-- PROFILE -->

<!-- IP ADDRESS -->

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

		  if ($('#profile-input-account-code').val().trim() != '') {
			  $('#profile-input-account-code').attr("readonly", "true");
			  $('#account_code_btn').attr("disabled", "true");
		  }
	  });

	  function generateAccountCode() {
		  var fname = $('#firstname').val().trim().toLowerCase();

		  $.ajax({
			  type: "GET",
			  url: "<?php echo base_url("functions/generate_accountcode.php"); ?>",
			  dataType: "json",
			  data: {"name": fname},
			  success: function (data) {
			  	if (data.status == 'OK') {
					$('#profile-input-account-code').val(data.result);
					$('#account_code_btn').attr("disabled", "true");
					$('#firstname').removeClass("is-invalid")
				}
			  	else if (data.status == 'ERR')
				{
					$('#firstname').addClass("is-invalid");
				}
			  	else { alert("Error"); }
			  },
			  error: function (error) {
				  alert(error);
			  }
		  });
	  }
  </script>
