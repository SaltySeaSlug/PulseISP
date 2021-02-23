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
          <h3 class="card-title mt-2"><i class="fa fa-list"></i>&nbsp; <?= trans('users_activity_log') ?></h3>
		</div>
	  </div>
	</div>
	  <div class="card">
		  <div class="card-body table-responsive">
			  <table id="na_datatable" class="table table-hover table-striped no-footer table-sm text-md dataTable"
					 style="width: 100%">
				  <thead>
				  <tr>
					  <th>#</th>
					  <th>User ID</th>
					  <th>Admin ID</th>
					  <th>Name</th>
					  <th>Event</th>
					  <th>Table Name</th>
					  <th>Old Values</th>
					  <th>New Values</th>
				<th>Url</th>
				<th>IP Address</th>
				<th>User Agent</th>
				<th>Timestamp</th>
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
	var table = $('#na_datatable').DataTable({
		"processing": true,
		"serverSide": false,
		"responsive": true,
		"ajax": "<?=base_url('admin/activity/datatable_json')?>",
		"order": [[0, 'asc']],
		"columnDefs": [
			{"targets": 0, "name": "id", 'searchable': true, 'orderable': true},
			{"targets": 1, "name": "user_id", 'searchable': true, 'orderable': true},
			{"targets": 2, "name": "admin_id", 'searchable': true, 'orderable': true},
			{"targets": 3, "name": "name", 'searchable': true, 'orderable': true},
			{"targets": 4, "name": "event", 'searchable': true, 'orderable': true},
			{"targets": 5, "name": "table_name", 'searchable': true, 'orderable': true},
			{"targets": 6, "name": "old_values", 'searchable': true, 'orderable': true},
			{"targets": 7, "name": "new_values", 'searchable': true, 'orderable': true},
			{"targets": 8, "name": "url", 'searchable': true, 'orderable': true},
			{"targets": 9, "name": "ip_address", 'searchable': true, 'orderable': true},
			{"targets": 10, "name": "user_agent", 'searchable': true, 'orderable': true},
			{"targets": 11, "name": "created_at", 'searchable': true, 'orderable': true},
		]
	});
</script>
