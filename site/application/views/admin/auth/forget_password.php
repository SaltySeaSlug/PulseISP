<div class="login-page form-background">
  <header class="main-header" style="margin-left: 0;vertical-align: middle;padding-top: .15rem;padding-bottom: .15rem;padding-left: .50em;background-color: #00a7d0; color: white;font-size: large; left:0; top:0; position: fixed; width: 100%">
        <?= $this->general_settings['application_name']; ?>
  </header>

  <div class="login-box">

    <div class="login-logo">
    </div>

    <!-- /.login-logo -->

    <div class="card">

      <div class="card-body login-card-body">

        <p class="login-box-msg"><?= trans('forgot_password') ?></p>



        <?php $this->load->view('admin/includes/_messages.php') ?>

        

         <?php echo form_open(base_url('admin/auth/forgot_password'), 'class="login-form" '); ?>

          <div class="form-group has-feedback">

            <input type="text" name="email" id="email" class="form-control" placeholder="<?= trans('email') ?>" >

          </div>

          <div class="row">

            <!-- /.col -->

            <div class="col-12">

              <input type="submit" name="submit" id="submit" class="btn btn-primary btn-block btn-flat" value="<?= trans('submit') ?>">

            </div>

            <!-- /.col -->

          </div>

        <?php echo form_close(); ?>


        <br>
        <p class="mb-1 login-box-msg">
        <a href="<?= base_url('admin/auth/login'); ?>"><?= trans('you_remember_password') ?> </a>
        </p>



      </div>

      <!-- /.login-card-body -->

    </div>

  </div>

  <!-- /.login-box -->
 <footer class="main-footer p-0 pr-2" style="position: fixed;bottom: 0;width: 100%;margin-left: 0;vertical-align: middle;text-align: right">
    <?= $this->general_settings['copyright']; ?>
</footer>
</div>

          