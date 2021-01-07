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
             <i class="fa fa-sitemap"></i>
           </div>
           <a href="#" class="small-box-footer"><?= trans('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
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
                <i class="fa fa-eye"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
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
                <i class="fa fa-user"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
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
                <i class="fa <?php if ($total_alerts > 0) echo "fa-exclamation-circle"; else echo "fa-check-circle"; ?>"></i>
              </div>
              <a href="#" class="small-box-footer"><?= trans('more_info') ?> <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

<div class="row">
      <div class="col-lg-7">
        <div class="box box-primary" >
          <div class="box-header with-border">
            <i class="fa fa-bar-chart-o"></i>
          <h3 class="box-title">Todays Usage</h3>
          <div class="box-tools pull-right">
            <span class="label bg-purple"><?php echo "In [ " . (!is_null($statUsageToday['upload']) ? toxbyte($statUsageToday['upload']) : 0); ?> ]</span> <span class="label bg-orange"><?php echo "Out [ " . (!is_null($statUsageToday['download']) ? toxbyte($statUsageToday['download']) : 0); ?> ]</span>
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
          </div>
          <div class="box-body">
          <div class="chart" style="overflow: auto;">
            <canvas id="Client6Chart" style="height: 250px"></canvas>
          </div>
          </div>
          <div class="box-footer text-center">
            <a href="?route=radius/authrequests" class="uppercase">View All Data Usage</a>
          </div>
        </div>
       </div>
      <div class="col-lg-5">
               <div class="box box-primary">
                 <div class="box-header with-border">
                     <i class="fa fa-user"></i>
                     <h3 class="box-title">Auth Requests</h3>
                     <div class="box-tools pull-right">
                         <span id="statAuthRequests"></span>
                         <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                     </div>
                 </div>
                 <div class="box-body">
            <div class="chart" style="overflow: auto;">
              <canvas id="Client7Chart" style="height: 250px"></canvas>
            </div>
          </div>
          <div class="box-footer text-center">
            <a href="?route=radius/authrequests" class="uppercase">View All Authentication Requests</a>
          </div>
        </div>
      </div>
    </div>

      <div class="row">
        <div class="col-12 text-center">
          <h4>Welcome to <?= $this->general_settings['application_name'] ?>!</h4>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(function() {
    function buildUsageChartData(data) {
      var name = [];
      var upload = [];
      var download = [];

      for (var i in data) {
        name.push(data[i].SUMTime);
        upload.push(data[i].SUMUpload);
        download.push(data[i].SUMDownload);
      }

      return {
        labels: name,
        datasets: [{
          label: 'Upload',
          backgroundColor: "#605ca8",
          data: upload
        }, {
          label: 'Download',
          backgroundColor: "#ff851b",
          data: download
        }]
      };
    }
    function buildUsageChartConfig(data) {
      return {
        type: 'bar',
        data: data,
        options: {
          title: {
            display: false
          },
          legend: {
            display: false
          },
          tooltips: {
            mode: 'index',
            intersect: false,
            callbacks: {
              title: function () {
                return "";
              },
              label: function (item, data) {
                var datasetLabel = data.datasets[item.datasetIndex].label || "";
                var dataPoint = item.yLabel;
                return datasetLabel + ": " + bytes(dataPoint, true);
              }
            }
          },
          responsive: true,
          scales: {
            xAxes: [{
              scaleLabel: {
                display: false,
                labelString: 'Hours of the day'
              },
              ticks : {
                beginAtZero: true
              },
              stacked: true
            }],
            yAxes: [{
              scaleLabel: {
                display: false,
                labelString: 'Usage'
              },
              stacked: true,
              ticks: {
                beginAtZero: true,
                callback: function (data, index, labels) {
                  return bytes(data, true);
                }
              }
            }]
          }
        }
      }
    }
    function bindUsageChart(data) {
      var config = buildUsageChartConfig(buildUsageChartData(data));
      var ctx = document.getElementById('Client6Chart').getContext('2d');
      var usageChart = new Chart(ctx, config);
    }
    function loadUsageChartData() {
      $.ajax({
        type: 'GET',
        url: './shell/getChartData.php',
        dataType: 'json'
      })
          .then(bindUsageChart)
          .then(function () {
            setTimeout(loadUsageChartData, reloadTime);
          });
    }

    loadUsageChartData();
  });
</script>