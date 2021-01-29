<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?= trans('dashboard') ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#"><?= trans('home') ?></a></li>
            <li class="breadcrumb-item active"><?= trans('dashboard') ?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
             <div class="small-box bg-blue">
           <div class="inner">
             <h3 id="statIP"><?= $free_ips; ?>/<?= $all_ips; ?></h3>

             <!--<p><?= trans('available_ip_addresses') ?></p>-->
             <p>Available IP Addresses</p>
           </div>
           <div class="icon" style="top:0px">
             <i class="fad fa-sitemap"></i>
           </div>
           <a href="#" class="small-box-footer"><?= trans('more_info') ?></a>
         </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $active_user_sessions; ?></h3>

                <!--<p><?= trans('active_user_sessions') ?></p>-->
                <p>Active Sessions</p>
              </div>
              <div class="icon">
                <i class="fad fa-eye"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <h3><?= $total_users; ?></h3>

                <!--<p><?= trans('inactive_users') ?></p>-->
                <p>Customers</p>
              </div>
              <div class="icon">
                <i class="fad fa-user"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?></a>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box <?php if ($total_alerts > 0) echo "bg-danger"; else echo "bg-success"; ?>">
              <div class="inner">
                <h3><?= $total_alerts; ?></h3>

                <!--<p><?= trans('unique_visitors') ?></p>-->
                <p>Alerts</p>
              </div>
              <div class="icon">
                <i class="fad <?php if ($total_alerts > 0) echo "fa-exclamation-circle"; else echo "fa-check-circle"; ?>"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

	<div class="row">
		<div id="leftCol" class="col-lg-7 connectedSortable">
			  <div id="today_usage" class="card">
				  <div class="card-header">
					  <h5 class="card-title mt-1"><i class="fad fa-th mr-1"></i>Today's Usage</h5>
					  <div class="card-tools">
						  <!--<span class="badge bg-purple"><?php echo "In [ " . (!is_null($statUsageToday['upload']) ? toxbyte($statUsageToday['upload']) : 0); ?> ]</span> <span class="badge bg-orange"><?php echo "Out [ " . (!is_null($statUsageToday['download']) ? toxbyte($statUsageToday['download']) : 0); ?> ]</span>-->
						  <ul class="nav nav-pills">
							  <li class="nav-item">
								  <a class="nav-link active" style="padding: 3px 9px 3px 10px" href="#today-chart" data-toggle="tab" title="Today" onclick="getChartUsage('T','<?php echo base_url('data/getChartUsageData') ?>')">T</a>
							  </li>
							  <li class="nav-item">
								  <a class="nav-link" style="padding: 3px 9px 3px 10px" href="#thisweek-chart" data-toggle="tab" title="This Week" onclick="getChartUsage('W','<?php echo base_url('data/getChartUsageData') ?>');">W</a>
							  </li>
							  <li class="nav-item">
								  <a class="nav-link" style="padding: 3px 9px 3px 10px" href="#thismonth-chart" data-toggle="tab" title="This Month" onclick="getChartUsage('M','<?php echo base_url('data/getChartUsageData') ?>')">M</a>
							  </li>
							  <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" title="Collapse">
								  <i class="fad fa-minus"></i>
							  </button>
						  </ul>
					  </div>
				  </div>
				  <div class="card-body">
					  <div id="rStats" class="text-right" style="margin-top: -20px; display: none"><span class="badge bg-orange" id="rDownload">Downloaded [ 0 B ]</span> <span class="badge bg-purple" id="rUpload">Uploaded [ 0 B ]</span></div>
					  <div class="tab-content p-0">
						  <!-- Morris chart - Sales -->
						  <div class="chart tab-pane active" id="today-chart" style="position: relative; height: 300px;">
							  <canvas id="today-chart-canvas" height="300" style="height: 300px;"></canvas>
						  </div>
						  <div class="chart tab-pane" id="thisweek-chart" style="position: relative; height: 300px;">
							  <canvas id="thisweek-chart-canvas" height="300" style="height: 300px;"></canvas>
						  </div>
						  <div class="chart tab-pane" id="thismonth-chart" style="position: relative; height: 300px;">
							  <canvas id="thismonth-chart-canvas" height="300" style="height: 300px;"></canvas>
						  </div>
					  </div>
				  </div>

				  <div id="lUChart" class="overlay dark" style="display: none">
					  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
				  </div>
			  </div>
		</div>

		<div id="rightCol" class="col-lg-5 connectedSortable">
				<div id="auth_request" class="card">
					<div class="card-header">
						<h5 class="card-title mt-1"><i class="fad fa-user mr-1"></i>Auth Requests</h5>
						<div class="card-tools">
							<ul class="nav nav-pills">
								<li class="nav-item">
									<a class="nav-link active" style="padding: 3px 9px 3px 10px" href="#today-authchart" data-toggle="tab" title="Today" onclick="getChartAuth('T','<?php echo base_url('data/getChartAuthData') ?>')">T</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" style="padding: 3px 9px 3px 10px" href="#thisweek-authchart" data-toggle="tab" title="This Week" onclick="getChartAuth('W','<?php echo base_url('data/getChartAuthData') ?>');">W</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" style="padding: 3px 9px 3px 10px" href="#thismonth-authchart" data-toggle="tab" title="This Month" onclick="getChartAuth('M','<?php echo base_url('data/getChartAuthData') ?>')">M</a>
								</li>
								<button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" title="Collapse">
									<i class="fad fa-minus"></i>
								</button>
							</ul>
						</div>
					</div>
					<div class="card-body">
						<div id="rAStats" class="text-right" style="margin-top: -20px; display: none"><span class="badge bg-green" id="rADownload">Accepted [ 0 ]</span> <span class="badge bg-red" id="rAUpload">Rejected [ 0 ]</span></div>
						<div class="tab-content p-0">
							<!-- Morris chart - Sales -->
							<div class="chart tab-pane active" id="today-authchart" style="position: relative; height: 300px;">
								<canvas id="today-authchart-canvas" height="300" style="height: 300px;"></canvas>
							</div>
							<div class="chart tab-pane" id="thisweek-authchart" style="position: relative; height: 300px;">
								<canvas id="thisweek-authchart-canvas" height="300" style="height: 300px;"></canvas>
							</div>
							<div class="chart tab-pane" id="thismonth-authchart" style="position: relative; height: 300px;">
								<canvas id="thismonth-authchart-canvas" height="300" style="height: 300px;"></canvas>
							</div>
						</div>
					</div>

					<div id="lUAChart" class="overlay dark" style="display: none">
						<i class="fas fa-3x fa-sync-alt fa-spin"></i>
					</div>
				</div>
			</div>
	</div>

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?= base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>
<script src="<?= base_url() ?>assets/dist/js/pages/global.js"></script>

<script>
	$(document).ready(function() {
		getChartUsage('T', '<?php echo base_url('data/getChartUsageData') ?>');
		getChartAuth('T', '<?php echo base_url('data/getChartAuthData') ?>');
	});
</script>
