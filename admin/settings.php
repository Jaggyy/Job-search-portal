<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'settings';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/amount-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT * FROM featuring_amount";
$query = $conn->prepare($sql_retrieve);
$query->execute();
$query_fetch = $query->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
    <title>Settings | Naukri</title>
	<!-- Vendors Style-->
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/vendors_css.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/vendor_plugins/bootstrap/css/bootstrap.min.css">
	<!-- Style-->  
    <link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/toastr.min.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/switches.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/style.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/skin_color.css">  
	<script src="<?php echo $path; ?>/admin/assets/js/jquery.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
    <script type="text/javascript">
    	toastr.options =
		{
		    "closeButton": true,
		    "progressBar": true,
		    "timeOut": "2000",
		    "positionClass": "toast-top-right"
		}
    </script>
</head>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">	
	<div class="wrapper">
		<div id="loader"></div>
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper">
		  	<div class="container-full">
		  		<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<h3 class="page-title">Settings</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item active" aria-current="page">Settings</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!-- Main content -->
				<?php
				if(isset($_POST['update']))
				{
					if($stmt == 0)
					{
						if($result)
						{
							echo'
	                        <script type="text/javascript">
	                            toastr.success("'.$success.'", "Success");
	                    	</script>';
						}
						else
						{
							echo'
	                        <script type="text/javascript">
	                            toastr.error("'.$error.'", "Error");
	                    	</script>';
						}
					}
					else
					{
						if($results)
						{
							echo'
	                        <script type="text/javascript">
	                            toastr.success("'.$success.'", "Success");
	                    	</script>';
						}
						else
						{
							echo'
	                        <script type="text/javascript">
	                            toastr.error("'.$error.'", "Error");
	                    	</script>';
						}
					}
				}
				?>
				<section class="content">
					<div class="row">
						<div class="col-xl-6 col-12">
							<div class="box box-shadowed">
								<div class="box-header with-border">
									<h4 class="box-title"><strong>Featuring</strong> Price</h4>
								</div>
								<form class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<input type="hidden" name="company_amount" value="">
									<div class="box-body">
										<div class="col-md-12">
											<div class="form-group">
											  	<label class="form-label">Job Featuring Amount</label>
											  	<input id="job_amount" type="number" class="form-control rounded30" name="job_amount" value="<?php echo $query_fetch['job_amount']; ?>" required>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
											  	<label class="form-label">Company Featuring Amount</label>
											  	<input id="company_amount" type="number" class="form-control rounded30" name="company_amount" value="<?php echo $query_fetch['company_amount']; ?>" required>
											</div>
										</div>
									</div>
									<div class="box-footer flexbox text-right">					 
										<div class="text-end flex-grow">
											<button type="submit" name="update" class="btn btn-sm btn-primary">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>
				<!-- /.content -->
		  	</div>
	  	</div>
	  	<!-- /.content-wrapper -->
	  	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/footer.php'); ?>
	</div>
	<!-- ./wrapper -->

	<!-- Vendor JS -->	
	<script src="<?php echo $path; ?>/admin/assets/js/vendors.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/popper.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/vendor_plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/icons/feather-icons/feather.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/datatable/datatables.min.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/script.js"></script>
</body>
</html>
