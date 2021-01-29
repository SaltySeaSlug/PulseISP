<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<section class="content">
		<div class="card">
			<div class="card-header">
				<div class="d-inline-block">
					<h3 class="card-title mt-2"><i class="fad fa-list mr-2"></i><?= $title ?></h3>
				</div>
				<div class="d-inline-block float-right">
					<a href="<?= base_url('admin/admin_roles/add'); ?>" class="btn btn-success"><i class="fad fa-plus mr-2"></i><?= trans('add_new_role') ?></a>
				</div>
			</div>

			<div class="card-body p-0">
				<table id="example2" class="table table-hover table-striped table-hover no-footer table-md text-md">
					<thead>
						<tr>
							<th width="100"><?= trans('id') ?></th>
							<th width="200"><?= trans('admin_role') ?></th>
							<th width="100"><?= trans('status') ?></th>
							<!--<th><?= trans('action') ?></th>-->
						</tr>
					</thead>
					<tbody>
						<?php foreach($records as $record): ?>
							<tr>
								<td><?php echo $record['admin_role_id']; ?></td>
								<td><?php echo $record['admin_role_title']; ?></td>
								<td>
									<input class='tgl tgl-light tgl_checkbox'
									data-id="<?php echo $record['admin_role_id']; ?>"
									id='cb_<?=$record['admin_role_id']?>'
									type='checkbox' <?php echo ($record['admin_role_status']==1)? "checked" : ""; ?> />
									<label class='tgl-btn' for='cb_<?=$record['admin_role_id']?>'></label>
								</td>
								<td>
									<div class="btn-group float-right">

									<a href="<?php echo site_url("admin/admin_roles/access/".$record['admin_role_id']); ?>" class="btn btn-sm btn-info" title="Permissions">
										<i class="fad fa-sliders-h"></i>
									</a>

									<?php if(!in_array($record['admin_role_id'],array(1))): ?>
										<a href="<?php echo site_url("admin/admin_roles/edit/".$record['admin_role_id']); ?>" class="btn btn-sm btn-warning" title="Edit">
											<i class="fad fa-edit"></i>
										</a>
										<a href="<?php echo site_url("admin/admin_roles/delete/".$record['admin_role_id']); ?>" onclick="return confirm('are you sure to delete?')" class="btn btn-sm btn-danger" title="Delete"><i class="fad fa-trash-alt"></i></a>
									<?php endif;?>
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

	<script>
		$("body").on("change",".tgl_checkbox",function(){
			$.post('<?=base_url("admin/admin_roles/change_status")?>',
			{
				'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>',	
				id : $(this).data('id'),
				status : $(this).is(':checked') == true ? 1:0
			},
			function(data){
				$.notify("Status Changed Successfully", "success");
			});
		});

	</script>
