<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$ci = new CI_Controller();
$ci =& get_instance();
$ci->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>404 Page Not Found</title>
	<style type="text/css">
		body {
			overflow-y: hidden ! important;
			overflow-x: hidden ! important;
			background: url(<?php echo base_url(); ?>assets/dist/img/404.jpg) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}

		.wrap {
			margin: 0 auto;
			width: 100%;
		}

		.logo {
			text-align: center;
		}

		.sub a {
			color: white;
			background: rgba(0, 0, 0, 0.3);
			text-decoration: none;
			padding: 5px 10px;
			font-size: 3em;
			font-family: arial, serif;
			font-weight: bold;
		}
	</style>
</head>
<body>

<div class="wrap">
	<div class="logo">
		<img src="../assets/dist/img/404PAGE-NOT-FOUND.png"/>
		<div class="sub"
			 style="position: fixed;left: 50%;bottom: 20px;transform: translate(-50%, -50%);margin: 0 auto;">
			<p><a href="<?php echo base_url(); ?>">BACK TO HOME</a></p>
		</div>
	</div>
</div>
</body>
</html>
