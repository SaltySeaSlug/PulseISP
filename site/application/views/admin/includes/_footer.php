<?php if(!isset($footer)): ?>

	<footer class="main-footer pt-0 pb-0 text-sm">
		<?php echo (ENVIRONMENT === 'development') ? 'Rendered in <strong>{elapsed_time}</strong> seconds | CodeIgniter Version <strong>' . CI_VERSION . '</strong> | ' . ENVIRONMENT . ' | ' : ''; ?>
		<div class="badge"><?= $this->config->item('PULSEISP_VERSION'); ?></div>
		<div class="float-right d-none d-sm-inline-block">
			<?= footer_variables($this->general_settings['copyright']); ?>
		</div>
	</footer>

<?php endif; ?>

<?php if(!isset($sidebar)): ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<?php endif; ?>


</div>
<!-- ./wrapper -->


<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
<!-- Notify JS -->
<script src="<?= base_url() ?>assets/plugins/notify/notify.min.js"></script>
<!-- DROPZONE -->
<script src="<?= base_url() ?>assets/plugins/dropzone/dropzone.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/dist/js/functions.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/select2/select2.full.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/chart.js/Chart.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/bootstrap-switch/js/bootstrap-switch.js" type="text/javascript"></script>

<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<?php if (!empty($this->general_settings['google_api_key'])) { ?>
	<script defer
			src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->general_settings['google_api_key']; ?><?php echo $this->general_settings['google_places_is_active'] == true ? '&libraries=places' : '' ?>"></script>
<?php } ?>

<script>

	var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';

var csfr_token_value = '<?php echo $this->security->get_csrf_hash(); ?>';

$(function(){
//-------------------------------------------------------------------
// Country State & City Change

$(document).on('change','.country',function()
{

  if(this.value == '')
  {
    $('.state').html('<option value="">Select Option</option>');

    $('.city').html('<option value="">Select Option</option>');

    return false;
  }


  var data =  {

    country : this.value,

  }

  data[csfr_token_name] = csfr_token_value;

  $.ajax({

    type: "POST",

    url: "<?= base_url('admin/auth/get_country_states') ?>",

    data: data,

    dataType: "json",

    success: function(obj) {
      $('.state').html(obj.msg);
   },

  });
});

$(document).on('change','.state',function()
{

  var data =  {

    state : this.value,

  }

  data[csfr_token_name] = csfr_token_value;

  $.ajax({

    type: "POST",

    url: "<?= base_url('admin/auth/get_state_cities') ?>",

    data: data,

    dataType: "json",

    success: function(obj) {

      $('.city').html(obj.msg);

   },

  });
    });
  });
</script>

</body>
</html>
