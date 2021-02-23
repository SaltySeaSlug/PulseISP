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
          <h3 class="card-title mt-2"><i class="fad fa-server mr-2"></i><?= trans('add_profile') ?></h3>
        </div>
        <div class="d-inline-block float-right">
          <!--<?php if($this->rbac->check_operation_permission('add')): ?>-->
			  <a href="<?= base_url('admin/profiles_components'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i><?= trans('list') ?></a>
          <!--<?php endif; ?>-->
        </div>
      </div>
    </div>
    <div class="card">
		<?php $this->load->view('admin/includes/_messages.php') ?>

		<?php echo form_open(base_url('admin/profiles_components/profile_add'), 'class="form-horizontal"');  ?>

		<div class="card-body">
			<div class="col-md-6">
				<div class="form-group">
					<label for="profilename">Profile Name</label>
					<input type="text" class="form-control" id="profilename" name="profilename" required>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="profilecomponents">Profile Components</label>
					<select class="form-control select2 select2tag select2-hidden-accessible" id="profilecomponents"
							name="profilecomponents[]" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple>
						<?php foreach ($components as $item) { echo "<option value='".$item['id']."'>".$item['name']."</option>"; } ?>
				  </select>
			  </div>

		  </div>
      </div>

		<div class="card-footer">
			<div class="form-group">
				<div class="col-md-12">
					<input type="submit" name="submit" value="<?= trans('add_profile') ?>" class="btn btn-primary pull-right">
				</div>
			</div>			</div>
		<?php echo form_close(); ?>
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
  var table = $('#na_datatable').DataTable( {
    "processing": true,
    "serverSide": false,
	"responsive": true,
    "ajax": "<?=base_url('admin/nas/datatable_json')?>",
    "order": [[0,'asc']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':true, 'orderable':true},
    { "targets": 1, "name": "shortname", 'searchable':true, 'orderable':true},
    { "targets": 2, "name": "nasname", 'searchable':true, 'orderable':true},
    { "targets": 3, "name": "nasidentifier", 'searchable':true, 'orderable':true},
    { "targets": 4, "name": "status", 'searchable':true, 'orderable':false},
    { "targets": 5, "name": "Action", 'searchable':false, 'orderable':false},
    //{ "targets": 6, "name": "is_verify", 'searchable':true, 'orderable':true},
    //{ "targets": 7, "name": "Action", 'searchable':false, 'orderable':false,'width':'100px'}
    ]
  });
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


