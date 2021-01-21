<script>
$(document).ready(function(){
	$('.button_del').click(function(){
		var answer = confirm('<?php echo $this->lang->line('language_confirm_lang_delete');?>');
		return answer; // answer is a boolean
	});
	$('#new_lang_form').hide();
	$("#new_lang").click(function() { ///add click action for button
		$('#new_lang_form').toggle();
	});
});
</script>


	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">

				<div class="row">
					<div id="leftCol" class="col-lg-12 connectedSortable">
						<div class="card">
							<div class="card-header">
								<h5 class="card-title mt-1"><i class="fa fa-th mr-1"></i>Blank Card _ Dir List</h5>
								<div class="card-tools">
									<button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" title="Collapse">
										<i class="fas fa-minus"></i>
									</button>
								</div>
							</div>
							<div class="card-body">
								<?php if($this->session->flashdata('error')){ ?>
									<div class="error">
								<?php echo $this->session->flashdata('error');?>
									</div>
								<?php }elseif($this->session->flashdata('msg')){ ?>
									<div class="msg">
								<?php echo $this->session->flashdata('msg');?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div id="rightCol" class="col-lg-4 connectedSortable">
						<?php $this->load->view('language/dir_list_view'); ?>
					</div>
				</div>

			</div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>
