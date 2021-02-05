<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<!--<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6"><h1>Server Performance</h1></div>
				</div>
			</div>
		</section>
		<br>
		<div class="row">
			<table class="table table-condensed table-sm">
				<tbody>
					<tr>
						<th>Ram Allocated</th>
						<td>61.5%</td>
						<th>Disk Usage</th>
						<td>14.8%</td>
						<th>System Load</th>
						<td>3.56</td>
						<th>Open File Limit</th>
						<td>1048576</td>
						<th>Open Files</th>
						<td>22</td>
						<th>Open Tables</th>
						<td>4000</td>
						<th>Threads Connected</th>
						<td>100</td>
					</tr>
				</tbody>
			</table>
		</div>-->

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
		</div>
	</section>
</div>
