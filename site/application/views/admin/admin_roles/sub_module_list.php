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
					<h3 class="card-title mt-2"><i class="fa fa-list"></i>&nbsp; Sub Module Setting</h3>
				</div>
				<?php $parent_module = $this->uri->segment(4); ?>
				<div class="d-inline-block float-right">
					<a href="<?= base_url('admin/admin_roles/sub_module_add/'.$parent_module); ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add New </a>
				</div>
			</div>

			<div class="card-body">
				<table id="example1" class="table table-hover table-striped table-hover no-footer table-md text-md nowrap dataTable" width="100%">
					<thead>
						<tr>
							<th width="50">ID</th>
							<th>Name</th>
							<th>Operations</th>
							<th class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($records as $record): ?>
							<tr>
								<td><?= $record['id']; ?></td>
								<td><?= trans($record['name']); ?></td>
								<td><?= $record['link']; ?></td>
								<td>
									<div class="text-right">
									<a title="Edit" href="<?php echo site_url("admin/admin_roles/sub_module_edit/".$record['id']); ?>" class="btn-right text-warning pr-1">
											<i class="fa fa-edit"></i>
										</a>
									<a title="Delete" href="<?php echo site_url("admin/admin_roles/sub_module_delete/".$record['id'].'/'.$record['parent']); ?>" onclick="return confirm('are you sure to delete?')" class="btn-right text-danger pr-1"><i class="fad fa-trash-alt"></i></a>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>


<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
  $(function () {
    $("#example1").DataTable();
  })
</script>
