<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'dashboard';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true)
{
	header('location:http://localhost/naukri/');
	exit();
}
$company_id = $_SESSION['company_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
	<title>Employer Dashboard | Naukri</title>
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
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/employer/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/employer/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper">
		  	<div class="container-full">
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-xl-9 col-12">
							<div class="row">
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="d-flex justify-content-center align-items-center">
												<div class="m-2">
													<?php 
													$count = "SELECT job_id FROM jobs WHERE company_id = :company_id";
													$fetch = $conn->prepare($count);
													$fetch->bindParam(":company_id", $company_id, PDO::PARAM_INT);
													$fetch->execute();
													$cnt = $fetch->rowCount();
													?>
													<h5 class="text-fade">Total Jobs</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt; ?></h2>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<?php 
													$count = "SELECT job_id FROM jobs WHERE company_id = :company_id AND status = 1 AND verified = 1 AND (job_expiry_date > CURDATE())";
													$fetch = $conn->prepare($count);
													$fetch->bindParam(":company_id", $company_id, PDO::PARAM_INT);
													$fetch->execute();
													$cnt_live = $fetch->rowCount();
													?>
													<h5 class="text-fade">Live Jobs</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt_live; ?></h2>
												</div>
												<div>
													<div id="live-jobs"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<?php 
													$count = "SELECT job_id FROM jobs WHERE company_id = :company_id AND status is null AND (job_expiry_date > CURDATE())";
													$fetch = $conn->prepare($count);
													$fetch->bindParam(":company_id", $company_id, PDO::PARAM_INT);
													$fetch->execute();
													$cnt_pending = $fetch->rowCount();
													?>
													<h5 class="text-fade">Pending Jobs</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt_pending; ?></h2>
												</div>
												<div>
													<div id="pending-jobs"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<?php 
													$count = "SELECT job_id FROM jobs WHERE company_id = :company_id AND (job_expiry_date < CURDATE())";
													$fetch = $conn->prepare($count);
													$fetch->bindParam(":company_id", $company_id, PDO::PARAM_INT);
													$fetch->execute();
													$cnt_closed = $fetch->rowCount();
													?>
													<h5 class="text-fade">Closed Jobs</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt_closed; ?></h2>
												</div>
												<div>
													<div id="closed-jobs"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<?php 
													$count = "SELECT job_id FROM jobs WHERE company_id = :company_id AND status = 1 AND verified = 1 AND is_featured = 1 AND (job_expiry_date > CURDATE())";
													$fetch = $conn->prepare($count);
													$fetch->bindParam(":company_id", $company_id, PDO::PARAM_INT);
													$fetch->execute();
													$cnt_featured = $fetch->rowCount();
													?>
													<h5 class="text-fade">Featured Jobs</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt_featured; ?></h2>
												</div>
												<div>
													<div id="featured-jobs"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="d-flex justify-content-center align-items-center">
												<div class="m-2">
													<?php 
													$count = "SELECT id FROM job_applied WHERE company_id = :company_id";
													$fetch = $conn->prepare($count);
													$fetch->bindParam(":company_id", $company_id, PDO::PARAM_INT);
													$fetch->execute();
													$cnt_applications = $fetch->rowCount();
													?>
													<h5 class="text-fade">Total Job Applications</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt_applications; ?></h2>
												</div>
												<div>
													<div id="applications-jobs"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
								$sql_retrieve = "SELECT plans.*, companies.package_id,companies.package_start_date,companies.package_end_date FROM plans LEFT JOIN companies ON plans.id = companies.package_id ORDER BY plans.plan";
								$query = $conn->prepare($sql_retrieve);
			                    $query->execute();
			                    $results=$query->fetch();
			                    $currentDate = time();
								$package_start_date = strtotime($results['package_start_date']);
								$package_end_date = strtotime($results['package_end_date']);
								$days_left = $package_end_date - $currentDate;
								$days_left = round($days_left / (60*60*24));

								$count_applications = "SELECT jobs.id AS id, jobs.created_at, jobs.company_id, companies.package_start_date, companies.package_end_date FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id WHERE jobs.company_id = :company_id AND (jobs.created_at BETWEEN companies.package_start_date AND companies.package_end_date)";
								$fetch_application_id = $conn->prepare($count_applications);
								$fetch_application_id->bindParam(':company_id', $_SESSION['company_id'], PDO::PARAM_INT);
								$fetch_application_id->execute();
								$cnt_application_id = $fetch_application_id->rowCount();

								$jobs_left = ($results['allowed_jobs'] - $cnt_application_id);
								$jobs_posted = $results['allowed_jobs'] - $jobs_left;
								
								echo '
								<div class="col-lg-12 col-12">
									<div class="box box-inverse bg-twitter">
										<div class="row box-body">
											<div class="col-lg-3 package_details">
												<h4 class="text-white mt-0">PACKAGE:</h4>
												<h5 class="text-white mt-0">PACKAGE DURATION:</h5>
												<h5 class="text-white mt-0">JOBS POSTED:</h5>
											</div>
											<div class="col-lg-9 package_details">
												<h4 class="text-white mt-0"><span style="color: #15067a;">'.$results['plan'].'(Rs. '.$results['amount'].')</span></h4>
												<h5 class="text-white mt-0"><span style="color: #15067a;">'.date('jS M, Y', $package_start_date).' - '.date('jS M, Y', $package_end_date).'</span></h5>
												<h5 class="text-white mt-0"><span style="color: #15067a;">'.$jobs_posted.'/'.$results['allowed_jobs'].'</span></h5>
											</div>
										</div>
									</div>
								</div>';
			                    ?>
								<div class="col-xxxl-8 col-xl-7 col-12">
									<div class="box">
										<div class="box-header">
											<h4 class="box-title">Recent Jobs</h4>
											<ul class="box-controls pull-right d-md-flex d-none">
											  <li class="dropdown">
												<a class="btn btn-primary px-10" href="<?php echo $path; ?>/employer/jobs/manage" style="font-family: inherit;">VIEW LIST</a>
											  </li>
											</ul>
										</div>
										<div class="box-body">
											<div class="bb-1 d-flex justify-content-between">
												<h5>Job title</h5>
												<h5>Applications</h5>
											</div>
											<?php 
											$sql_retrieve = "SELECT * FROM jobs WHERE company_id = :company_id LIMIT 4";
											$statement = $conn->prepare($sql_retrieve);
											$statement->bindParam(":company_id", $company_id, PDO::PARAM_INT);
											$statement->execute();
											$rowCount = $statement->rowCount();
											$stmt = $statement->fetchAll(PDO::FETCH_OBJ);
											if($rowCount > 0)
											{
												foreach($stmt AS $row)
												{
													$job_id = $row->job_id;
													echo '
													<div class="d-flex justify-content-between my-15">';
														$count = "SELECT id FROM job_applied WHERE job_id = :job_id AND company_id = :company_id";
														$fetch = $conn->prepare($count);
														$fetch->bindParam(":job_id", $job_id, PDO::PARAM_INT);
														$fetch->bindParam(":company_id", $company_id, PDO::PARAM_INT);
														$fetch->execute();
														$cnt_applications = $fetch->rowCount();
														echo '
														<p>'.$row->job_title.'</p>
														<p> 
															<strong>'.$cnt_applications.'</strong>
															<button type="button" class="waves-effect waves-light btn btn-xs btn-outline btn-primary-light mx-5">
																<i class= "fa fa-line-chart"></i>
															</button>
														</p>
													</div>';
												}
											}
											?>
										</div>
									</div>
								</div>
								<div class="col-xxxl-4 col-xl-5 col-12">
									<div class="box">
										<div class="box-header with-border">
											<h4 class="box-title">New Applications</h4>
										</div>
										<div class="box-body">
											<?php 
											$sql_retrieve = "SELECT jobs.*, job_applied.candidate_id, job_applied.job_id, candidates.firstname, candidates.lastname, candidates.photo FROM job_applied LEFT JOIN jobs ON job_applied.job_id = jobs.job_id LEFT JOIN candidates ON job_applied.candidate_id = candidates.id WHERE job_applied.company_id = :company_id ORDER BY job_applied.id DESC LIMIT 4";
											$statement = $conn->prepare($sql_retrieve);
											$statement->bindParam(":company_id", $company_id, PDO::PARAM_INT);
											$statement->execute();
											$rowCount = $statement->rowCount();
											$stmt = $statement->fetchAll(PDO::FETCH_OBJ);
											if($rowCount > 0)
											{
												foreach($stmt AS $row)
												{
													echo '
													<div class="d-flex align-items-center mb-30">
														<div class="me-15">
															<img src="'.$path.'/assets/images/profile_picture/'.$row->photo.'" class="avatar avatar-lg rounded100 bg-primary-light" alt="" />
														</div>
														<div class="d-flex flex-column flex-grow-1 fw-500">
															<a href="'.$path.'/candidate-details?id='.$row->candidate_id.'" class="text-dark hover-primary mb-1 fs-16">'.$row->firstname.' '.$row->lastname.'</a>
															<span class="fs-12"><span class="text-fade">Applied for</span> '.$row->job_title.'</span>
														</div>
													</div>';
												}
											}
											?>
										</div>
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
	  	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/employer/includes/footer.php'); ?>
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
	<?php
	$percent_live = ($cnt_live*100)/$cnt;
	$percent_closed = ($cnt_closed*100)/$cnt;
	$percent_pending = ($cnt_pending*100)/$cnt;
	$percent_featured = ($cnt_featured*100)/$cnt;
	?>
	<script>
		$(function () {
  			'use strict';
			/********Live Jobs*******/
			var options = {
				chart: {
					height: 100,
					width: 100,
					type: "radialBar"
				},

				series: [<?php echo $percent_live; ?>],
				colors: ['#3da643'],
				plotOptions: {
					radialBar: {
						hollow: {
							margin: 0,
							size: "55%"
						},
						track: {
							background: '#e7daff',
						},

						dataLabels: {
							showOn: "always",
							name: {
								show: false,
							},
							value: {
								offsetY: 5,
								color: "#111",
								fontSize: "14px",
								show: true
							}
						}
					}
				},

				stroke: {
					lineCap: "round",
				},
				labels: ["Progress"]
			};

			var chart = new ApexCharts(document.querySelector("#live-jobs"), options);
			chart.render();
			/********Live Jobs*******
			 * 
			 *******Closed Jobs*****/
			var options = {
				chart: {
					height: 100,
					width: 100,
					type: "radialBar"
				},

				series: [<?php echo $percent_closed; ?>],
				colors: ['#f00'],
				plotOptions: {
					radialBar: {
						hollow: {
							margin: 0,
							size: "55%"
						},
						track: {
							background: '#e7daff',
						},

						dataLabels: {
							showOn: "always",
							name: {
								show: false,
							},
							value: {
								offsetY: 5,
								color: "#111",
								fontSize: "14px",
								show: true
							}
						}
					}
				},

				stroke: {
					lineCap: "round",
				},
				labels: ["Progress"]
			};

			var chart = new ApexCharts(document.querySelector("#closed-jobs"), options);
			chart.render();
			/********Closed Jobs*******
			 * 
			 *******Pending Jobs*****/
			 var options = {
				chart: {
					height: 100,
					width: 100,
					type: "radialBar"
				},

				series: [<?php echo $percent_pending; ?>],
				colors: ['#fdac42'],
				plotOptions: {
					radialBar: {
						hollow: {
							margin: 0,
							size: "55%"
						},
						track: {
							background: '#e7daff',
						},

						dataLabels: {
							showOn: "always",
							name: {
								show: false,
							},
							value: {
								offsetY: 5,
								color: "#111",
								fontSize: "14px",
								show: true
							}
						}
					}
				},

				stroke: {
					lineCap: "round",
				},
				labels: ["Progress"]
			};

			var chart = new ApexCharts(document.querySelector("#pending-jobs"), options);
			chart.render();
			/********Pending Jobs*******
			 * 
			 *******Featured Jobs*****/
			 var options = {
				chart: {
					height: 100,
					width: 100,
					type: "radialBar"
				},

				series: [<?php echo $percent_featured; ?>],
				colors: ['#673ab7'],
				plotOptions: {
					radialBar: {
						hollow: {
							margin: 0,
							size: "55%"
						},
						track: {
							background: '#e7daff',
						},

						dataLabels: {
							showOn: "always",
							name: {
								show: false,
							},
							value: {
								offsetY: 5,
								color: "#111",
								fontSize: "14px",
								show: true
							}
						}
					}
				},

				stroke: {
					lineCap: "round",
				},
				labels: ["Progress"]
			};

			var chart = new ApexCharts(document.querySelector("#featured-jobs"), options);
			chart.render();
		});
	</script>
</body>
</html>