<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'dashboard';
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
	<title>Candidate Dashboard | Naukri</title>
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
	  	<div class="content-wrapper">
		  	<div class="container-full">
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-xl-9 col-12">
							<div class="row">
								<?php
								$sql_retrieve = "SELECT candidates.*, states.state, cities.city FROM candidates LEFT JOIN states ON candidates.state_id = states.id LEFT JOIN cities ON candidates.city_id = cities.id WHERE candidates.id = :id";
								$query = $conn->prepare($sql_retrieve);
								$query->bindParam(":id", $_SESSION['candidate_id'], PDO::PARAM_INT);
			                    $query->execute();
			                    $results = $query->fetch();								
								echo '
								<div class="col-lg-12 col-12">
									<div class="box box-inverse bg-twitter">
										<div class="row box-body">
											<div class="col-lg-2">
												<div class=" avatar avatar-xxl">
													<img src="'.$path.'/assets/images/profile_picture/'.$_SESSION['photo'].'">
												</div>
											</div>
											<div class="col-lg-8 package_details">
												<h1 class="text-success mt-0">'.$_SESSION['candidate_name'].'</h4>
												<h5 class="text-white mt-0"><i class="mdi mdi-map-marker"></i> '.$results['city'].', '.$results['state'].'</span></h5>
												<h5 class="text-warning mt-0"><i class="mdi mdi-phone"></i> '.$results['phone'].'</span></h5>
												<h5 class="text-white mt-0"><i class="fa fa-envelope"></i> '.$results['email'].'</span></h5>
											</div>
											<div class="text-right">
												<a class="btn btn-info" href="'.$path.'/candidate/profile">Edit Profile</a>
											</div>
										</div>
									</div>
								</div>';
			                    ?>

			                    <?php 
								$count = "SELECT id FROM page_visitor WHERE candidate_id = :candidate_id";
								$fetch = $conn->prepare($count);
								$fetch->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
								$fetch->execute();
								$cnt = $fetch->rowCount();
								?>
								<div class="col-12 col-md-4">
									<a class="box box-link-shadow text-center" href="javascript:void(0)">
										<div class="box-group">
											<div class="box overflow-hidden p-0">
												<div class="bg-danger vertical-align">
													<div class="vertical-align-middle text-center w-p100 fs-40">
														<div class="mb-5"><span class="mdi mdi-eye"></span></div>
														<span class="countnm"><?php echo $cnt; ?></span>
														<p class="fw-600 fs-16">Profile Views</p>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
								<?php 
								$count = "SELECT id FROM job_applied WHERE candidate_id = :candidate_id";
								$fetch = $conn->prepare($count);
								$fetch->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
								$fetch->execute();
								$cnt = $fetch->rowCount();
								?>
								<div class="col-md-4 col-12">
									<div class="box small-box bg-primary">
										<div class="inner">
											<h3><?php echo $cnt; ?></h3>
											<p>Applied Jobs</p>
										</div>
										<div class="icon">
											<span class="icon-Briefcase text-white"><span class="path1"></span><span class="path2"></span></span>
										</div>
										<a href="<?php echo $path; ?>/candidate/applied-jobs" class="small-box-footer mb-3">More info <i class="fa fa-arrow-right"></i></a>
									</div>
								</div>
								<?php 
								$count_completeness = "SELECT candidates.firstname, candidates.lastname, candidates.email, candidates.password, candidates.phone, candidates.fathername, candidates.dob, candidates.marital_status, candidates.nationality, candidates.expected_salary, candidates.country, candidates.state_id, candidates.city_id, candidates.industry_id, candidates.job_experience_id, candidates.functional_area_id, candidates.gender, candidates.resume, candidates.photo, manage_candidate_skills.candidate_skill_id, manage_candidate_experiences.experience_title, manage_candidate_qualifications.qualification_id,
									CASE WHEN candidates.firstname IS NOT NULL AND candidates.firstname<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.lastname IS NOT NULL AND candidates.lastname<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.email IS NOT NULL AND candidates.email<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.password IS NOT NULL AND candidates.password<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.phone IS NOT NULL AND candidates.phone<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.fathername IS NOT NULL AND candidates.fathername<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.dob IS NOT NULL AND candidates.dob<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.marital_status IS NOT NULL AND candidates.marital_status<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.nationality IS NOT NULL AND candidates.nationality<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.expected_salary IS NOT NULL AND candidates.expected_salary<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.country IS NOT NULL AND candidates.country<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.state_id IS NOT NULL AND candidates.state_id<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.city_id IS NOT NULL AND candidates.city_id<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.industry_id IS NOT NULL AND candidates.industry_id<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.job_experience_id IS NOT NULL AND candidates.job_experience_id<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.functional_area_id IS NOT NULL AND candidates.functional_area_id<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.gender IS NOT NULL AND candidates.gender<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.resume IS NOT NULL AND candidates.resume<>'' THEN 1 ELSE 0 END +
									CASE WHEN candidates.photo IS NOT NULL AND candidates.photo<>'' THEN 1 ELSE 0 END +
									CASE WHEN manage_candidate_skills.candidate_skill_id IS NOT NULL AND manage_candidate_skills.candidate_skill_id<>'' THEN 1 ELSE 0 END +
									CASE WHEN manage_candidate_experiences.experience_title IS NOT NULL AND manage_candidate_experiences.experience_title<>'' THEN 1 ELSE 0 END +
									CASE WHEN manage_candidate_qualifications.qualification_id IS NOT NULL AND manage_candidate_qualifications.qualification_id<>'' THEN 1 ELSE 0 END AS completed FROM candidates LEFT JOIN manage_candidate_skills ON candidates.id = manage_candidate_skills.candidate_id LEFT JOIN manage_candidate_experiences ON candidates.id = manage_candidate_experiences.candidate_id LEFT JOIN manage_candidate_qualifications ON candidates.id = manage_candidate_qualifications.candidate_id WHERE candidates.id = :candidate_id";
								$fetch_result = $conn->prepare($count_completeness);
								$fetch_result->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
								$fetch_result->execute();
								$cnt_result = $fetch_result->fetch();
								$count = $cnt_result['completed'];
								$percentage = ($count * 100)/22;
								?>
								<div class="col-xl-4 col-12">
									<div class="box info-box bg-success">
										<span class="info-box-icon rounded-circle"><span class="icon-User"><span class="path1"></span><span class="path2"></span></span></span>

										<div class="info-box-content mb-4">
											<span class="info-box-text">Profile Completeness</span>
											<div class="progress">
												<div class="progress-bar" style="width: <?php echo round("$percentage"); ?>%"></div>
											</div>
											<span class="progress-description">
												<?php echo round($percentage); ?>%
											</span>
										</div>
										<a href="<?php echo $path; ?>/candidate/profile" class="info-box-footer">More info <i class="fa fa-arrow-right"></i></a>
									</div>
								</div>
							</div>
						</div>				
						<div class="col-xl-3 col-12">
							<div class="box">
								<div class="box-body">							
									<div class="box no-shadow">
										<div class="box-body px-0 pt-0">
											<div id="calendar" class="dask evt-cal min-h-350"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
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