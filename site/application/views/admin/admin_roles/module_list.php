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
					<h3 class="card-title"><i class="fa fa-list"></i>&nbsp; <?= $title ?></h3>
				</div>
				<div class="d-inline-block float-right">
					<a href="<?= base_url('admin/admin_roles/module_add'); ?>" class="btn btn-success"><i class="fa fa-plus"></i> <?= trans('add_new_module') ?></a>
				</div>
			</div>

			<div class="card-body">
				<table id="example1" class="table table-hover table-striped table-hover no-footer table-md text-md">
					<thead>
						<tr>
							<th width="50"><?= trans('id') ?></th>
							<th><?= trans('module_name') ?></th>
							<th><?= trans('controller_name') ?></th>
							<th><?= trans('fa_icon') ?></th>
							<th><?= trans('operations') ?></th>
							<th class="text-right"><?= trans('action') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($records as $record): ?>
							<tr>
								<td><?= $record['module_id']; ?></td>
								<td><?= trans($record['module_name']); ?></td>
								<td><?= $record['controller_name']; ?></td>
								<td><?= $record['fa_icon']; ?></td>
								<td><?= $record['operation']; ?></td>
								<td>
									<div class="text-right">
									<a href="<?= base_url('admin/admin_roles/sub_module/'.$record['module_id']) ?>" class="btn-right text-dark pr-1" title="Sub Module">
										<i class="fad fa-sliders-h"></i>
									</a>
									<a href="<?php echo site_url("admin/admin_roles/module_edit/".$record['module_id']); ?>" class="btn-right text-warning pr-1" title="Edit">
											<i class="fad fa-edit"></i>
										</a>
									<a href="<?php echo site_url("admin/admin_roles/module_delete/".$record['module_id']); ?>" onclick="return confirm('are you sure to delete?')" class="btn-right text-red" title="Delete"><i class="fad fa-trash-alt"></i></a>
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

<script>
  $(function () {
    $("#example1").DataTable();
  })
</script>
