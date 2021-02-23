<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <!-- For Messages -->
    <?php $this->load->view('admin/includes/_messages.php') ?>
    <div class="card">
      <div class="card-header">
        <div class="d-inline-block">
          <h3 class="card-title mt-2"><i class="fad fa-list mr-2"></i><?= trans('users_list') ?></h3>
        </div>
        <div class="d-inline-block float-right">
          <?php if($this->rbac->check_operation_permission('add')): ?>
            <a href="<?= base_url('admin/users/add'); ?>" class="btn btn-success"><i class="fad fa-plus mr-2"></i><?= trans('add_new_user') ?></a>
          <?php endif; ?>
        </div>
	  </div>
	</div>
	  <div class="card">
		  <div class="card-body">
			  <table id="na_datatable"
					 class="table table-hover table-striped table-hover no-footer table-md text-md nowrap table-condensed table-valign-middle text-nowrap dataTable"
					 width="100%">
				  <thead>
				  <tr>
					  <th># <?= trans('id') ?></th>
					  <th><?= trans('username') ?></th>
					  <th><?= trans('email') ?></th>
					  <th><?= trans('phone') ?></th>
					  <th><?= trans('created_date') ?></th>
					  <th><?= trans('email_verification') ?></th>
					  <th><?= trans('status') ?></th>
					  <th class="text-right"><?= trans('action') ?></th>
				  </tr>
				  </thead>
			  </table>
		  </div>
	  </div>
  </section>
</div>

<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  //---------------------------------------------------
  var table = $('#na_datatable').DataTable( {
    "processing": true,
    "serverSide": false,
	"responsive": true,
	"ajax": "<?=base_url('admin/users/datatable_json')?>",
	  "order": [[0, 'asc']],
	  "columnDefs": [
		  {"targets": 0, "name": "id", 'searchable': true, 'orderable': true},
		  {"targets": 1, "name": "username", 'searchable': true, 'orderable': true},
		  {"targets": 2, "name": "email", 'searchable': true, 'orderable': true, responsivePriority: 4},
		  {"targets": 3, "name": "phone", 'searchable': true, 'orderable': true},
		  {"targets": 4, "name": "created", 'searchable': false, 'orderable': false, responsivePriority: 4},
		  {"targets": 5, "name": "active", 'searchable': true, 'orderable': true},
		  {"targets": 6, "name": "Action", 'searchable': false, 'orderable': false}
	  ]
  });
</script>


<script type="text/javascript">
	$("body").on("change", ".tgl_checkbox", function () {
		console.log('checked');
		$.post('<?=base_url("admin/users/change_status")?>',
    {
      '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',
      id : $(this).data('id'),
      status : $(this).is(':checked') == true?1:0
    },
    function(data){
      $.notify("Status Changed Successfully", "success");
    });
  });
</script>


