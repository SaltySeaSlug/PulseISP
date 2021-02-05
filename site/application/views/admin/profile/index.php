<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="card card-default color-palette-bo">
		<div class="card-header">
		  <div class="d-inline-block">
			  <h3 class="card-title mt-2"><i class="fad fa-pencil mr-2"></i><?= trans('profile') ?> </h3></div>
		  <div class="d-inline-block float-right">
			<a href="<?= base_url('admin/profile/change_pwd'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i> <?= trans('change_password') ?></a>
		  </div>
		</div>
		<div class="card-body">
		   <!-- For Messages -->
			<?php $this->load->view('admin/includes/_messages.php') ?>

			<?php echo form_open(base_url('admin/profile'), 'class="form-horizontal"' )?>
			  <div class="form-group row">
				<div class="col-sm-3"><label for="username" class="control-label"><?= trans('username') ?></label></div>
				<div class="col-sm-9"><input type="text" name="username" value="<?= $admin['username']; ?>" class="form-control" id="username" placeholder=""></div>
			  </div>

			  <div class="form-group row">
				<div class="col-sm-3"><label for="firstname" class="control-label"><?= trans('firstname') ?></label></div>
				<div class="col-sm-9"><input type="text" name="firstname" value="<?= $admin['firstname']; ?>" class="form-control" id="firstname" placeholder=""></div>
			  </div>

			  <div class="form-group row">
				<div class="col-sm-3"><label for="lastname" class="control-label"><?= trans('lastname') ?></label></div>
				<div class="col-sm-9"><input type="text" name="lastname" value="<?= $admin['lastname']; ?>" class="form-control" id="lastname" placeholder=""></div>
			  </div>

			  <div class="form-group row">
				<div class="col-sm-3"><label for="email" class="control-label"><?= trans('email') ?></label></div>
				<div class="col-sm-9"><input type="email" name="email" value="<?= $admin['email']; ?>" class="form-control" id="email" placeholder=""></div>
			  </div>

			  <div class="form-group row">
				<div class="col-sm-3"><label for="mobile_no" class="control-label"><?= trans('mobile_no') ?></label></div>
				<div class="col-sm-9"><input type="number" name="mobile_no" value="<?= $admin['mobile_no']; ?>" class="form-control" id="mobile_no" placeholder=""></div>
			  </div>

			  <div class="form-group">
				<div class="col-md-12">
				  <input type="submit" name="submit" value="<?= trans('update_profile') ?>" class="btn btn-info pull-right">
				</div>
			  </div>
			<?php echo form_close(); ?>
		</div>
		<!-- /.box-body -->
	  </div>

		<div class="card card-default color-palette-bo">
			<div class="card-header">
				<div class="d-inline-block">
					<h3 class="card-title mt-2"><i class="fad fa-pencil mr-2"></i><?= trans('change_password') ?> </h3>
				</div>
			</div>
			<div class="card-body">
				<!-- For Messages -->
				<?php $this->load->view('admin/includes/_messages.php') ?>

				<?php echo form_open(base_url('admin/profile/change_pwd'), 'class="form-horizontal"');  ?>
				<div class="form-group row">
					<div class="col-sm-3"><label for="password" class="control-label"><?= trans('new_password') ?></label></div>
					<div class="col-sm-9"><input type="password" name="password" class="form-control" id="password" placeholder=""></div>
				</div>

				<div class="form-group row">
					<div class="col-sm-3"><label for="confirm_pwd" class="control-label"><?= trans('confirm_password') ?></label></div>
					<div class="col-sm-9"><input type="password" name="confirm_pwd" class="form-control" id="confirm_pwd" placeholder=""></div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<input type="submit" name="submit" value="<?= trans('change_password') ?>" class="btn btn-info pull-right">
					</div>
				</div>
				<?php echo form_close( ); ?>
			</div>
			<!-- /.box-body -->
		</div>

		<div class="card card-default color-palette-bo">
			<div class="card-header">
				<div class="d-inline-block mt-2">
					<h3 class="card-title"><i class="fad fa-pencil mr-2"></i>Application Settings</h3>
				</div>
			</div>
			<div class="card-body">
				<!-- For Messages -->
				<?php $this->load->view('admin/includes/_messages.php') ?>

				<?php echo form_open(base_url('admin/profile/change_pwd'), 'class="form-horizontal"');  ?>
				<div class="form-group row">
					<div class="col-sm-3"><label for="default_list_size" class="control-label">Default List Size</label></div>
					<div class="col-sm-9">
						<select type="text" class="form-control" id="default_list_size" tabindex="-1" aria-hidden="true">
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="15">15</option>
							<option value="25">25</option>
							<option value="35">35</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="All">All</option>
						</select>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-3"><label for="theme" class="control-label">Theme</label></div>
					<div class="col-sm-9">
						<select type="text" class="form-control" id="theme" tabindex="-1" aria-hidden="true">
							<option value="light">Default Light Theme</option>
							<option value="dark">Default Dark Theme</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<input type="submit" name="submit" value="Update" class="btn btn-info pull-right">
					</div>
				</div>
				<?php echo form_close( ); ?>
			</div>
			<!-- /.box-body -->
		</div>

	</section>
</div>
</div>
