<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="card card-primary card-outline color-palette-bo">
			<div class="card-header">
				<div class="d-inline-block">
					<h3 class="card-title mt-2"><i class="fad fa-tasks mr-2"></i> General Information </h3>
				</div>
			</div>
			<div class="card-body p-0">
					<table class="table table-striped table-hover table-sm">
						<thead>
						</thead>
						<tbody>
						<?php foreach($general_status as $key=>$value): ?>
							<tr>
								<td><?=$key?></td>
								<td><?=$value?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
			</div>
		</div>

			<div class="card card-primary card-outline color-palette-bo">
				<div class="card-header">
					<div class="d-inline-block">
						<h3 class="card-title mt-2"> <i class="fad fa-tasks mr-2"></i> System Information </h3>
					</div>
				</div>
				<div class="card-body p-0">
					<table class="table table-striped table-hover table-sm">
						<thead>
						</thead>
						<tbody>
						<?php foreach($system_status as $key=>$value): ?>
							<tr>
								<td><?=$key?></td>
								<td><?=$value?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>

		<div class="card card-primary card-outline color-palette-bo">
			<div class="card-header">
				<div class="d-inline-block">
					<h3 class="card-title mt-2"> <i class="fad fa-tasks mr-2"></i> Service Information </h3>
				</div>
			</div>
			<div class="card-body p-0">
				<table class="table table-striped table-hover table-sm">
					<thead>
					</thead>
					<tbody>
						<tr>
							<td>FreeRadius</td>
							<td><?= check_service('freeradius') ?></td>
							<td></td>
						</tr>
						<tr>
							<td>MySQL</td>
							<td><?= check_service('mysql') ?></td>
							<td></td>
						</tr>
						<tr>
							<td>Apache</td>
							<td><?= check_service('apache2') ?></td>
							<td></td>
						</tr>
						<tr>
							<td>Server</td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
	</section>
</div>
