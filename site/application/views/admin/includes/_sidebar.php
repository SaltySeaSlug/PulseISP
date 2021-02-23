<?php
/*
 * Copyright (c) 2021.
 * Last Modified : 2021/05/17, 17:14
 */

$cur_tab = $this->uri->segment(2) == '' ? 'dashboard' : $this->uri->segment(2);
$cur_tab1 = $this->uri->segment(3) == '' ? '' : $this->uri->segment(3);
?>


<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow: inherit;">
	<!-- Brand Logo -->

	<?php if (isset($this->general_settings['logo'])) { ?>
		<img src="<?= base_url($this->general_settings['logo']); ?>" alt="Logo" class="brand-image ml-4 mt-1 mb-2"
			 style="opacity: .8">
	<?php } else { ?>
		<a href="<?= base_url('admin'); ?>" class="brand-link">
    		<img src="<?= base_url($this->general_settings['favicon']); ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
			<span class="brand-text font-weight-light"><?= $this->general_settings['application_name']; ?></span>
		</a>
	<?php } ?>


	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column nav-flat text-sm nav-compact" data-widget="treeview"
				role="menu" data-accordion="true">
				<!-- main-menu -->
				<?php $menu = get_sidebar_menu();
				foreach ($menu as $nav): $sub_menu = get_sidebar_sub_menu($nav['module_id']);
					$has_submenu = count($sub_menu) > 0; ?>
					<?php if ($this->rbac->check_module_permission($nav['controller_name'])): ?>
						<li id="<?= ($nav['controller_name']) ?>"
							class="nav-item <?= ($has_submenu) ? 'has-treeview' : '' ?> has-treeview">
							<a href="<?= base_url('admin/' . $nav['controller_name']) ?>" class="nav-link">
								<i class="nav-icon <?= $nav['fa_icon'] ?>"></i>
								<p> <?= trans($nav['module_name']) ?> <?= ($has_submenu) ? '<i class="right fa fa-angle-left"></i>' : '' ?>    </p>
							</a>
							<!-- sub-menu -->
							<?php if ($has_submenu): ?>
								<ul class="nav nav-treeview">
									<?php foreach ($sub_menu as $sub_nav): ?>
										<li id="<?= $nav['controller_name'] . '_' . $sub_nav['link'] ?>"
											class="nav-item">
											<a href="<?= base_url('admin/' . $nav['controller_name'] . '/' . $sub_nav['link']); ?>"
											   class="nav-link"><i class="fad fa-angle-double-right nav-icon"></i>
												<p><?= trans($sub_nav['name']) ?></p></a>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
							<!-- /sub-menu -->
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
				<!-- /main-menu -->
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>

<script>
	$("#<?= $cur_tab ?>").addClass('menu-open');
	$("#<?= $cur_tab ?> > a").addClass('active');
	$("#<?= $cur_tab ?>_<?= $cur_tab1 ?> > a").addClass('active');

	//localStorage.setItem('lastTab', "<?= $cur_tab ?>")
	//localStorage.setItem('lastSubTab', "<?= $cur_tab ?>_<?= $cur_tab1 ?>")


	//$(".nav li").click(function() {
	//$(this).addClass('menu-open');
	//$(this).find(" > a").addClass('active');
	//localStorage.setItem('lastTab', this.id);
	//alert(this.id); // id of clicked li by directly accessing DOMElement property
	//alert($(this).attr('id')); // jQuery's .attr() method, same but more verbose
	//alert($(this).html()); // gets innerHTML of clicked li
	//alert($(this).text()); // gets text contents of clicked li
	//});

	/*var lastTab = localStorage.getItem('lastTab');
	if (lastTab) {
		$('#'+lastTab).tab('show');
	}*/


	/*$('.nav li').click(function(e) {
		alert($(e).attr('id'));
		document.cookie="activeAccordion=" + $(e).attr('id');
		//$(this).find('>ul').slideToggle();
		//ev.stopPropagation();
	});*/



	/*$(function() {
		//for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
		$('li').on('shown', function (e) {
			//save the latest tab; use cookies if you like 'em better:
			localStorage.setItem('lastTab', $(e.target).attr('id'));
		});

		//go to the latest tab, if it exists:
		var lastTab = localStorage.getItem('lastTab');
		if (lastTab) {
			$('#'+lastTab).tab('show');
		}
	});*/
</script>
