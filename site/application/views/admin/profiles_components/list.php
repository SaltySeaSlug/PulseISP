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
          <h3 class="card-title mt-2"><i class="fad fa-server mr-2"></i><?= trans('profiles_components_list') ?></h3>
        </div>
        <div class="d-inline-block float-right">
			<?php if($this->rbac->check_operation_permission('add')): ?>
				<a href="<?= base_url('admin/profiles_components/profile_add'); ?>" class="btn btn-success"><i class="fad fa-plus mr-1"></i><?= trans('add_profile') ?></a>
			<?php endif; ?>
			<?php if($this->rbac->check_operation_permission('add')): ?>
				<a href="<?= base_url('admin/profiles_components/component_add'); ?>" class="btn btn-success"><i class="fad fa-plus mr-1"></i><?= trans('add_component') ?></a>
			<?php endif; ?>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
		  <label>PROFILES</label>
		  <table id="na_datatable" class="table table-hover table-striped table-hover no-footer table-md text-md nowrap dataTable" width="100%">
          <thead>
            <tr>
				<th># <?= trans('id') ?></th>
              	<th><?= trans('name') ?></th>
              	<th><?= trans('status') ?></th>
				<th>Components</th>
              <th class="text-right"><?= trans('action') ?></th>
            </tr>
          </thead>
			<tbody>
			<?php foreach($profiles as $data): ?>
				<tr>
					<td><?= $data['id']; ?></td>
					<td><?= $data['name']; ?></td>
					<td><span class="btn btn-success btn-flat btn-xs"></span></td>
					<td>
						<?php foreach ($this->db->get_where('radusergroup', ['username' => $data['name']])->result_array() as $comp) { ?>
							<span class='badge badge-secondary'><?php echo $comp['groupname']; ?></span><br>
						<?php } ?>
					</td>
					<td>
						<div class="btn-group float-right">
							<a href="<?= base_url('admin/profiles_components/view/'.$data['id']); ?>" class="btn btn-sm btn-info"><i class="fad fa-eye"></i></a>
							<a href="<?= base_url('admin/profiles_components/edit/'.$data['id']); ?>" class="btn btn-sm btn-warning"><i class="fad fa-edit"></i></a>
							<a href="<?= base_url('admin/profiles_components/delete/'.$data['id']); ?>" class="btn btn-sm btn-danger"><i class="fad fa-trash"></i></a>
						</div>
					</td>

				</tr>
			<?php endforeach; ?>
			</tbody>
        </table>

		  <label>PROFILE COMPONENTS</label>
		  <table id="na_datatable1" class="table table-hover table-striped table-hover no-footer table-md text-md nowrap dataTable" width="100%">
			  <thead>
			  <tr>
				  <th># <?= trans('id') ?></th>
				  <th><?= trans('name') ?></th>
				  <th><?= trans('status') ?></th>
				  <th>Attributes</th>
				  <th class="text-right"><?= trans('action') ?></th>
			  </tr>
			  </thead>
			  <tbody>
			  <?php foreach($components as $data): ?>
				  <tr>
					  <td><?= $data['id']; ?></td>
					  <td><?= $data['name']; ?></td>
					  <td><span class="btn btn-success btn-flat btn-xs"></span></td>
					  <td>
						  <?php foreach ($this->db->get_where('radgroupreply', ['groupname' => $data['name']])->result_array() as $attr) { ?>
							  <span class='badge badge-secondary'><?php echo $attr['attribute']; ?><?php echo $attr['op']; ?><?php echo $attr['value']; ?></span><br>
						  <?php } ?>
					  </td>
					  <td>
						  <div class="btn-group float-right">
							  <a href="<?= base_url('admin/profiles_components/view/'.$data['id']); ?>" class="btn btn-sm btn-info"><i class="fad fa-eye"></i></a>
							  <a href="<?= base_url('admin/profiles_components/edit/'.$data['id']); ?>" class="btn btn-sm btn-warning"><i class="fad fa-edit"></i></a>
							  <a href="<?= base_url('admin/profiles_components/delete/'.$data['id']); ?>" class="btn btn-sm btn-danger"><i class="fad fa-trash"></i></a>
						  </div>
					  </td>

				  </tr>
			  <?php endforeach; ?>
			  </tbody>
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
  /*var table = $('#na_datatable').DataTable({
    "processing": true,
    "serverSide": false,
	"responsive": true,
    //"ajax": "<?=base_url('admin/profiles_components/datatable_json')?>",
    "order": [[0,'asc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "name", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "status", 'searchable':true, 'orderable':false},
    { "targets": 3, "name": "Action", 'searchable':false, 'orderable':false}
    ]
  });
  var table = $('#na_datatable1').DataTable({
	  "processing": true,
	  "serverSide": false,
	  "responsive": true,
	  //"ajax": "<?=base_url('admin/profiles_components/datatable_json')?>",
	  "order": [[0,'asc']],
	  "columnDefs": [
		  { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
		  { "targets": 1, "name": "name", 'searchable':true, 'orderable':true},
		  { "targets": 2, "name": "status", 'searchable':true, 'orderable':false},
		  { "targets": 3, "name": "Action", 'searchable':false, 'orderable':false}
	  ]
  });*/
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


