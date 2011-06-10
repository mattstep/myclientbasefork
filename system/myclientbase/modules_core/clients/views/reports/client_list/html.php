<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			<?php echo $this->lang->line('client_detail_report'); ?>
		</title>
		<style type="text/css">

			body {
				margin-left: 35px;
				margin-right: 45px;
			}

			th {
				border: 1px solid #666666;
				background-color: #D3D3D3;
			}

			h2 {
				margin-bottom: 0px;
			}

			p.notop {
				margin-top: 0px;
			}

			#box, .box {
				width : 100%;
				margin : 0 auto;
			}

			#left, .box {
				width : 49%;
				float : left;
			}

			#right, .box {
				width : 49%;
				float : right;
			}

		</style>
	</head>
	<body>

		<h1><?php echo $this->lang->line('client_detail_report'); ?></h1>

		<?php $this->load->view('reports/client_list/html_result_table'); ?>

	</body>
</html>