<div class="datalist">
	<table id="table" class="table table-hover table-striped no-footer table-sm text-md dataTable" style="width: 100%">
		<thead>
		<tr>
			<th width="100"><?= trans('id') ?></th>
                <th><?= trans('user') ?></th>
                <th><?= trans('username') ?></th>
                <th><?= trans('email') ?></th>
                <th><?= trans('role') ?></th>
                <th><?= trans('status') ?></th>
			<th class="text-right" style="width: 1em"></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($info as $row): ?>
            <tr>
            	<td>
					<?=$row['admin_id']?>
                </td>
                <td>
					<h5 class="m0 mb2"><?=$row['firstname']?> <?=$row['lastname']?></h5>
                    <small class="text-muted"><?=$row['admin_role_title']?></small>
				</td>
				<td>
					<?= $row['username'] ?>
				</td>
				<td>
					<?= $row['email'] ?>
				</td>
				<td>
					<button class="btn btn-xs btn-success"><?= $row['admin_role_title'] ?></button>
				</td>
				<td>
					<input class='tgl tgl-light tgl_checkbox' data-id="<?= $row['admin_id'] ?>"
						   id='cb_<?= $row['admin_id'] ?>'
						   type='checkbox' <?php echo ($row['is_active'] == 1) ? "checked" : ""; ?> <?php echo($this->rbac->check_operation_permission('change_status') ? "" : "disabled") ?> />
					<label class='tgl-btn' for='cb_<?= $row['admin_id'] ?>'></label>
				</td>
				<td>
					<div class="btn-group float-right">
						<a href="<?= base_url("admin/admin/edit/" . $row['admin_id']); ?>"
						   class="btn btn-sm btn-warning"><i class="fad fa-edit"></i></a>
						<a href="<?= base_url("admin/admin/delete/" . $row['admin_id']); ?>"
						   onclick="return confirm('are you sure to delete?')" class="btn btn-sm btn-danger"><i
									class="fad fa-trash-alt"></i></a>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>

<script>
	$(function () {
		$("#table").DataTable({searching: false, paging: false, info: false, response: true});
	})
</script>
