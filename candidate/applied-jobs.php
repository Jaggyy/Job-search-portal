<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'applied_jobs';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["candidate_login"]) || $_SESSION["candidate_login"] !== true)
{
	header('location:http://localhost/naukri/');
	exit();
}
$candidate_id = $_SESSION['candidate_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
	<title>Applied Jobs | Naukri</title>
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
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper" style="min-height: 426px;">
			<div class="container-full">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<h3 class="page-title">Applied Jobs</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/candidate/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item active" aria-current="page">Applied Jobs</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>

				<!-- Main content -->
				<section class="content">
					<div class="row">
						<?php
						$sql = "SELECT job_applied.*, jobs.job_title, jobs.slug, companies.companyname FROM job_applied LEFT JOIN jobs ON job_applied.job_id = jobs.job_id LEFT JOIN companies ON job_applied.company_id = companies.id WHERE candidate_id = :candidate_id ORDER BY applied_at";
						$run_sql = $conn->prepare($sql);
						$run_sql->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
						$run_sql->execute();
						$count = $run_sql->rowCount();
						if($count > 0)
	                    {
							$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
	                        foreach($fetch_result as $query_fetch)
	                        {
	                        	echo '
								<div class="col-lg-4">
									<div class="box">
										<div class="box-body ribbon-box">';
											if($query_fetch->status == 'Applied')
											{
												echo '
												<div class="ribbon ribbon-info">Applied</div>';
											}
											elseif($query_fetch->status == 'Shortlisted')
											{
												echo '
												<div class="ribbon ribbon-primary">Shortlisted</div>';
											}
											elseif($query_fetch->status == 'Selected')
											{
												echo '
												<div class="ribbon ribbon-success">Selected</div>';
											}
											else
											{
												echo '
												<div class="ribbon ribbon-danger">Rejected</div>';
											}
											echo '
											<div class="d-flex flex-column flex-grow-1 w-p100">
												<h6 class="box-title text-muted fw-600 fs-18 mb-2 hover-primary">
													<i class="mdi mdi-contact-mail"></i><a href="'.$path.'/jobs?job='.$query_fetch->slug.'" class="ml-2">'.$query_fetch->job_title.'</a>
												</h6>
												<span class="fw-500 text-fade"><i class="fa fa-building"></i><span class="ml-3">'.$query_fetch->companyname.'</span></span>
												<span class="fw-500 text-fade"><i class="mdi mdi-clock"></i><span class="ml-3">'.$query_fetch->applied_at.'</span></span>
											</div>
										</div>
									</div>
								</div>';
							}
						}
						else
						{
							echo '
							<div class="col-md-12">
								<div class="box">
									<div class="box-body text-center">
										<div class="mb-20 mt-20">
											<img src="'.$path.'/assets/images/resource/data-not-found.png" style="width: 100%; height: 200px;">
										</div>
									</div>
								</div>
							</div>';
						}
						?>
					</div>
				</section>
				<!-- /.content -->	  
			</div>
		</div>
	  	<!-- /.content-wrapper -->
	  	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/footer.php'); ?>
	</div>
	<!-- ./wrapper -->

	<!-- Vendor JS -->
	<script src="<?php echo $path; ?>/admin/assets/js/vendors.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/popper.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/vendor_plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/icons/feather-icons/feather.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/datatable/datatables.min.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <!-- <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script> -->
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/script.js"></script>
</body>
</html>