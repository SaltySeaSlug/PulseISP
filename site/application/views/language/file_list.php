
<script>
$(document).ready(function(){
	$('#create_file_form').hide();
	$("#new_file").click(function() { ///add click action for button
		$('#create_file_form').toggle();
	});
	$('#new_lang_form').hide();
	$("#new_lang").click(function() { ///add click action for button
		$('#new_lang_form').toggle();
	});
	$('.button_del').click(function(){
		var answer = confirm('<?php echo $this->lang->line('language_confirm_lang_delete');?>');
		return answer; // answer is a boolean
	});
});
</script>


<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">

			<div class="row">
				<div id="leftCol" class="col-lg-7 connectedSortable">
					<div class="card">
						<div class="card-header">
							<h5 class="card-title mt-1"><i class="fa fa-th mr-1"></i>Blank Card _ File List</h5>
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
							<div class="box menu">
								<a href="<?php echo site_url('/language');?>"><?php echo $this->lang->line('language_home_link');?></a>&nbsp;|&nbsp;<a href="#" id="new_file"><?php echo $this->lang->line('language_create_file_link');?></a>
								<div class="right">Lang: <strong><?php echo $sel_dir;?></strong></div>
								<div class="clear"></div>
								<div id="create_file_form">
									<?php echo form_open(site_url('/language/create_file'));?>
									<p><?php echo $this->lang->line('language_create_file_info');?></p><br/>
									<input type="text" name="filename" value=""/>
									<input type="hidden" name="language" value="<?php echo $sel_dir;?>" />
									<input type="submit" name="create" value="<?php echo $this->lang->line('language_create_label');?>" />
									</form>
								</div>
							</div>
						</div>
					</div>
					<?php if(isset($dir)&&!empty($dir)){
						$this->load->view('language/dir_list_view');
					} ?>
				</div>

				<div class="col-lg-4 connectedSortable">

							<?php if(isset($files)&&!empty($files)){ ?>
								<div class="card">
									<div class="card-header">
										<h5 class="card-title mt-1"><i class="fa fa-th mr-1"></i>Blank Card _ Files</h5>
										<div class="card-tools">
											<button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" title="Collapse">
												<i class="fas fa-minus"></i>
											</button>
										</div>
									</div>
									<div class="card-body">
										<ul>
											<?php foreach($files as $f){ ?>
												<li><a href="<?php echo site_url('language/lang_file/'.$sel_dir.'/'.$f);?>"><?php echo $f;?></a>
													<?php echo form_open(site_url('/language/delete_language_file'));?>
													<input type="hidden" name="language" value="<?php echo $sel_dir;?>" />
													<input type="hidden" name="filename" value="<?php echo $f;?>" />
													<input type="submit" name="delete" value="<?php echo $this->lang->line('language_delete_file');?>" class="button_del" />
													</form><p class="clear"></p></li>
											<?php } ?>
										</ul>
									</div>
								</div>
							<?php }else{ ?>
								<div class="card files"><?php echo $this->lang->line('language_no_files');?></div>
							<?php } ?>

				</div>
			</div>

		</div><!-- /.container-fluid -->
	</section>
	<!-- /.content -->
</div>



</div>
