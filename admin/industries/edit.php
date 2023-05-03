<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'industries';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/industries-update-script.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
    <title>Admin Dashboard | Naukri</title>
	<!-- Vendors Style-->
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/vendors_css.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/vendor_plugins/bootstrap/css/bootstrap.min.css">
	<!-- Style-->  
    <link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/toastr.min.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/switches.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/style.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/skin_color.css">  
	<script src="<?php echo $path; ?>/admin/assets/js/jquery.min.js"></script>
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
							<h3 class="page-title">Edit Industry</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item" aria-current="page"><a href="<?php echo $path; ?>/admin/industries/manage">Industries</a></li>
										<li class="breadcrumb-item active" aria-current="page">Edit Industry</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<?php
								$sql_retrieve = "SELECT * FROM industries WHERE id = :id";
								$query = $conn->prepare($sql_retrieve);
								$query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
								$query->execute();
								$query_fetch = $query->fetch();
								?>
								<div class="box-body">
									<div class="col-md-4">
										<div class="pro-photos">
											<div class="photos-item">
												<img src="<?php echo $path; ?>/assets/images/icon/<?php echo $query_fetch['icon']; ?>" id="product-image" class="img-fluid" alt="">
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-header -->
								<form id="content_form" class="form" method="post" action="" enctype="multipart/form-data">
									<div class="box-body">
									  	<div class="col-md-12">
											<div class="form-group">
											  	<label class="form-label">Industry</label>
											  	<input id="industry" type="text" class="form-control rounded30" name="industry" value="<?php echo $query_fetch['industry']; ?>" required>
											</div>
									  	</div>
									  	<div class="col-md-12">
											<div class="form-group">
											  	<label class="form-label">Icon</label>
											  	<input type="file" class="form-control rounded30" name="icon" id="icon">
											</div>
									  	</div>
									  	<div class="col-md-12">
									  		<div class="form-group">
												<label class="form-label">Status</label>
												<div class="c-inputs-stacked">
													<input name="status" type="radio" id="active" class="with-gap radio-col-success" value="1" <?php echo $query_fetch['status'] == true ? 'checked' : ''; ?>>
												  	<label class="me-30" for="active">Active</label>
												  	<input name="status" type="radio" id="inactive" class="with-gap radio-col-danger" value="0" <?php echo $query_fetch['status'] == false ? 'checked' : ''; ?>>
												  	<label for="inactive">In-Active</label>
												</div>
											</div>
									  	</div>
									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn fix-gr-bg submit">
										  	<i class="ti-save-alt"></i> UPDATE
										</button>
										<button type="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">
											<i class="ti-save-alt"></i> UPDATING...
										</button>
									</div>  
								</form>
								<!-- /.box-body -->
			  				</div>
				  			<!-- /.box -->
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
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/script.js"></script>
</body>
</html>