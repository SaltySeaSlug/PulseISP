<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $gravatar_url = $this->gravatar->get($this->session->userdata('email')); ?>
<!-- Automatic element centering -->
<div class="lockscreen lockscreen-wrapper" style="background-color: transparent; margin-top: 100%; ">
  <div class="lockscreen-logo">
    <!--<a href="../../index2.html"><b>Admin</b>LTE</a>-->
  </div>
  <!-- User name -->
  <div class="lockscreen-name font-size-3"><?= ucwords($this->session->userdata('fullname')); ?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image"><?php echo '<img src="'.$gravatar_url.'" alt="User Image">'; ?></div>
    <!-- /.lockscreen-image -->

	  <?php echo form_open(base_url('admin/auth/lock_screen_unlock'), 'class="lockscreen-credentials"'); ?>
		<!-- lockscreen credentials (contains the form) -->
		  <div class="input-group">
			  <input type="text" name="username" id="username" value="<?= $this->session->userdata('username'); ?>" hidden>
				<input type="password" name="password" id="password" class="form-control" placeholder="Password" autofocus>

			<div class="input-group-append">
				<button type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-flat" value="<?= trans('signin') ?>"><i class="fad fa-arrow-right text-muted"></i></button>
			</div>
		  </div>
	  <?php echo form_close(); ?>

	  <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
  </div>
  <div class="text-center">
    <a class="text-dark" href="<?= base_url('admin/auth/logout') ?>">click here to login as a different user</a>
  </div>
  <div class="lockscreen-footer text-center">
  </div>
</div>
<!-- /.center -->
