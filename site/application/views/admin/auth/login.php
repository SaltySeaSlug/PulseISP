<div class="login-page form-background">
  <header class="main-header" style="margin-left: 0;vertical-align: middle;padding-top: .15rem;padding-bottom: .15rem;padding-left: .50em;background-color: #00a7d0; color: white;font-size: large; left:0; top:0; position: fixed; width: 100%">
        <?= $this->general_settings['application_name']; ?>
  </header>

  <div class="login-box">
    <div class="login-logo">
    <!--  <h2><a href="<?= base_url('admin'); ?>"><?= $this->general_settings['application_name']; ?></a></h2> -->
    </div>
    <!-- /.login-logo -->
    <div class="card">

      <div class="card-body login-card-body">
        <!--<p class="login-box-msg"><?= trans('signin_to_start_your_session') ?></p>-->

        <?php $this->load->view('admin/includes/_messages.php') ?>
        
        <?php echo form_open(base_url('admin/auth/login'), 'class="login-form" '); ?>
        
        <!--<div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="<?= trans('username') ?>" required="" autofocus="">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>-->

        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="<?= trans('username') ?>" required="" autofocus="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fad fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="<?= trans('password') ?>" required="">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fad fa-lock"></span>
            </div>
          </div>
        </div>

       <!-- <div class="form-group has-feedback">
          <input type="password" name="password" class="form-control" placeholder="<?= trans('password') ?>" required="">
          <span class="fa fa-dashboard form-control-feedback"></span>
        </div> -->

        

          <!--<div class="form-group has-feedback">
            <input type="text" name="username" id="name" class="form-control" placeholder="<?= trans('username') ?>" >
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="<?= trans('password') ?>" >
          </div>-->


          <div class="row">
           <!-- <div class="col-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> <?= trans('remember_me') ?>
                </label>
              </div>
            </div>-->
            <!-- /.col -->
            <div class="col-12">
              <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-flat" value="<?= trans('signin') ?>">
            </div>
            <!-- /.col -->
          </div>
        <?php echo form_close(); ?>

       
        <!--<p class="mb-0">
          <a href="<?= base_url('admin/auth/register'); ?>" class="text-center"><?= trans('register_new_membership') ?></a>
        </p>
        <br>
         <p class="mb-1 login-box-msg">
          <a href="<?= base_url('admin/auth/forgot_password'); ?>"><?= trans('i_forgot_my_password') ?></a>
        </p>-->
      </div>

      
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <footer class="main-footer p-0 pr-2 text-sm align-middle ml-0 position-fixed text-center text-md-right text-lg-right text-xl-right text-nowrap" style="bottom: 0;width: 100%">
    <?= $this->general_settings['copyright']; ?>
</footer>
</div>
<script src="<?= base_url() ?>assets/dist/js/functions.js" type="text/javascript"></script>

<script>

	$('#password').enterKey(function () {
		$('input[name = submit]').click();
	})

</script>
