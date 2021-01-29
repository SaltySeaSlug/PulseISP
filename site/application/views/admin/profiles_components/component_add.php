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
          <h3 class="card-title mt-2"><i class="fad fa-server mr-2"></i><?= trans('add_profile_component') ?></h3>
        </div>
        <div class="d-inline-block float-right">
          <!--<?php if($this->rbac->check_operation_permission('view')): ?>-->
			  <a href="<?= base_url('admin/profiles_components'); ?>" class="btn btn-success"><i class="fad fa-list mr-2"></i><?= trans('list') ?></a>
          <!--<?php endif; ?>-->
        </div>
      </div>
    </div>
    <div class="card">
		<?php $this->load->view('admin/includes/_messages.php') ?>


		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="name">Component Name</label>
						<input type="text" class="form-control" id="name" name="name" required>
					</div>
				</div>
			</div>

			<form id="myform">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="vendor">Vendors</label>
							<select class="form-control select" id="vendor" name="vendor" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="getAttributes(this.value)">
								<option>None</option>
								<?php foreach ($vendors as $vendor) { echo "<option value='".$vendor['vendor']."'>".$vendor['vendor']."</option>"; } ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group" id="grpAttribute">
							<label for="attribute">Attributes</label>
							<select class="form-control select" id="attribute" name="attribute" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="getDefaults(this.value)">
								<option>Select a Vendor</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group" id="grpValue">
							<label for="value">Value</label>
							<input type="text" class="form-control" id="value" name="value" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group" id="grpOperation">
							<label for="operation">Operation</label>
							<select class="form-control select" id="operation" name="operation" style="width: 100%;" tabindex="-1" aria-hidden="true">
								<option value="=">=</option>
								<option value="==">==</option>
								<option value=":=" selected>:=</option>
								<option value="+=">+=</option>
								<option value="!=">!=</option>
								<option value=">">&gt;</option>
								<option value=">=">&gt;=</option>
								<option value="<">&lt;</option>
								<option value="<=">&lt;=</option>
								<option value="=~">=~</option>
								<option value="!~">!~</option>
								<option value="=*">=*</option>
								<option value="!*">!*</option>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group" id="grpTarget">
							<label for="target">Target</label>
							<select class="form-control select" id="target" name="target" style="width: 100%;" tabindex="-1" aria-hidden="true">
								<option value="reply">Reply</option>
								<option value="check">Check</option>
							</select>
						</div>
					</div>
					<div class="col-md-2" id="grpAdd">
						<button type="submit" class="btn btn-success save-btn" style="margin-top: 25px; width: 100%">Add</button>
					</div>
				</div>
			</form>

			<div class="table-responsive no-border">
				<table id="table" class="table table-striped table-condensed table-valign-middle table-sm nowrap text-nowrap d-table" style="width: 100%">
					<thead>
					<th>Vendor</th>
					<th>Attribute</th>
					<th>Operation</th>
					<th>Value</th>
					<th>Target</th>
					<th class="text-right"></th>
					</thead>
					<tbody></tbody>
				</table>
			</div>

		</div>

		<?php echo form_open(base_url('admin/profiles_components/component_add'), 'class="form-horizontal" id="mainform"');  ?>
		<div class="card-footer">
			<div class="form-group">
				<div class="col-md-12">
					<input type="submit" name="submit" value="Add Component" class="btn btn-primary pull-right">
				</div>
			</div>
		</div>
		<input type="hidden" id="componentname" name="componentname" value="" />
		<input type="hidden" id="data" name="data" value="" />
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

  $(document).ready(function() {
	  $('#profilecomponents').select2();
  });




  $(document).ready(function() {
	  $('#grpAttribute').hide();
	  $('#grpValue').hide();
	  $('#grpOperation').hide();
	  $('#grpTarget').hide();
	  $('#grpAdd').hide();
  });

  function getAttributes(id) {
	  $.ajax({
		  type: "GET",
		  url: "<?php echo base_url("data/get_vendor_attributes"); ?>",
		  dataType: "json",
		  data: "vendor=" + id,
		  success: function (result) {
			  if (result == "None") {
				  $('#grpAttribute').hide();
				  $('#grpValue').hide();
				  $('#grpOperation').hide();
				  $('#grpTarget').hide();
				  $('#grpAdd').hide();
			  }
			  else {
				  $('#grpAttribute').show();
				  $("#attribute").html(result);
			  }
		  }
	  });
  };
  function getDefaults(id) {
	  $.ajax({
		  type: "GET",
		  url: "<?php echo base_url("data/get_attribute_defaults"); ?>",
		  dataType: "json",
		  data: "attribute=" + id,
		  success: function(result) {
			  if (result == "None") {
				  $('#grpValue').hide();
				  $('#grpOperation').hide();
				  $('#grpTarget').hide();
				  $('#grpAdd').hide();
			  }
			  else {
				  $('#grpValue').show();
				  $('#grpOperation').show();
				  $('#grpTarget').show();
				  $('#grpAdd').show();
				  var value = document.getElementById('value');
				  $(value).val(result[0]);

				  var operation = document.getElementById('operation');
				  $(operation).val(result[1]);

				  var target = document.getElementById('target');
				  $(target).val(result[2]);
			  }
		  }
	  });
  };

  $("#myform").submit(function(e){
	  e.preventDefault();
	  let vendor = $("select[name='vendor']").val();
	  let attribute = $("#attribute option:selected").text();
	  let operation = $("select[name='operation']").val();
	  let value = $("input[name='value']").val();
	  let target = $("#target option:selected").text();




	  $("#table tbody").append("<tr><td>"+vendor+"</td><td>"+attribute+"</td><td>"+operation+"</td><td>"+value+"</td><td>"+target+"</td><td><a href='#' class='btn-right text-danger btn-delete' title='Delete'><i class='far fa-trash-alt'></i></a></td></tr>");

	  $("input[name='value']").val('');
	  let attribute1 = document.getElementById('attribute');
	  $(attribute1).val("None");

	  $('#grpValue').hide();
	  $('#grpOperation').hide();
	  $('#grpTarget').hide();
	  $('#grpAdd').hide();
  });


  $("body").on("click", ".btn-delete", function(){
	  $(this).parents("tr").remove();
  });

  $("#mainform").submit(function() {
	  var table = $('#table').DataTable({
		  retrieve: true,
		  searching: false,
		  "sDom": 'lrtip',
		  paging: false,
		  ordering: false,
		  info: false,
		  drawCallback: function(settings) {
			  var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
			  pagination.toggle(this.api().page.info().pages > 1);
		  }
	  });
	  var fieldNames =  [], json = []
	  table.settings().columns()[0].forEach(function(index) {
		  fieldNames.push($(table.column(index).header()).text())
	  })
	  table.rows().data().toArray().forEach(function(row) {
		  var item = {}
		  row.forEach(function(content, index) {
			  if (fieldNames[index] == "") return
			  item[fieldNames[index]] = content
		  })
		  json.push(item)
	  })
	  document.getElementById('data').value = JSON.stringify(json);
	  document.getElementById('componentname').value = $('#name').val();
  });

</script>


