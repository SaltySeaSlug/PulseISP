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
          <h3 class="card-title mt-2"><i class="fad fa-server mr-2"></i><?= trans('nas_list') ?></h3>
        </div>
        <div class="d-inline-block float-right">
          <?php if($this->rbac->check_operation_permission('add')): ?>
            <a href="<?= base_url('admin/nas/add'); ?>" class="btn btn-success"><i class="fad fa-plus mr-1"></i><?= trans('add_new_nas') ?></a>
          <?php endif; ?>
		</div>
	  </div>
	</div>
	  <div class="card">
		  <div class="card-body">
			  <table id="na_datatable"
					 class="table table-hover table-striped no-footer table-sm text-md nowrap dataTable"
					 style="width: 100%">
				  <thead>
				  <tr>
					  <th># <?= trans('id') ?></th>
              	<th><?= trans('name') ?></th>
              	<th><?= trans('ip_address') ?></th>
              	<th><?= trans('identifier') ?></th>
              	<th><?= trans('status') ?></th>
					  <th class="text-right" style="width: 1em"></th>
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
    "ajax": "<?=base_url('admin/nas/datatable_json')?>",
    "order": [[0,'asc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "shortname", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "nasname", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "nasidentifier", 'searchable':true, 'orderable':true},
    { "targets": 4, "name": "status", 'searchable':true, 'orderable':false},
    { "targets": 5, "name": "Action", 'searchable':false, 'orderable':false},
    //{ "targets": 6, "name": "is_verify", 'searchable':true, 'orderable':true},
    //{ "targets": 7, "name": "Action", 'searchable':false, 'orderable':false,'width':'100px'}
    ]
  });
</script>


<script type="text/javascript">
  $("body").on("change",".tgl_checkbox",function(){
    console.log('checked');
    $.post('<?=base_url("admin/nas/change_status")?>',
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


