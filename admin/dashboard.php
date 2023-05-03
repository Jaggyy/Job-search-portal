<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'dashboard';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
	header('location:http://localhost/naukri/');
	exit();
}
$id = $_SESSION['admin_id'];
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/get-time-ago.php'); ?>
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
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-xl-9 col-12">
							<div class="row">
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="row d-flex justify-content-center align-items-center">
												<div class="m-2 p-2">
													<span class="waves-effect waves-light btn btn-app bg-gradient-primary m-0">
														<i class="fa fa-users"></i>
													</span>
												</div>
												<div class="m-2">
													<?php 
													$count = "SELECT id FROM candidates";
													$fetch = $conn->prepare($count);
													$fetch->execute();
													$cnt = $fetch->rowCount();
													?>
													<h5 class="text-fade">Total Candidates</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt; ?></h2>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="row d-flex justify-content-center align-items-center">
												<div class="m-2 p-2">
													<span class="waves-effect waves-light btn btn-app bg-gradient-secondary m-0">
														<i class="mdi mdi-account-settings-variant"></i>
													</span>
												</div>
												<div class="m-2">
													<?php 
													$count = "SELECT id FROM companies";
													$fetch = $conn->prepare($count);
													$fetch->execute();
													$cnt_employers = $fetch->rowCount();
													?>
													<h5 class="text-fade">Total Employers</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt_employers; ?></h2>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="row d-flex justify-content-center align-items-center">
												<div class="m-2 p-2">
													<span class="waves-effect waves-light btn btn-app bg-gradient-info m-0">
														<i class="mdi mdi-format-float-left"></i>
													</span>
												</div>
												<div class="m-2">
													<?php 
													$count = "SELECT job_id FROM jobs";
													$fetch = $conn->prepare($count);
													$fetch->execute();
													$cnt_total = $fetch->rowCount();
													?>
													<h5 class="text-fade">Total Jobs</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt_total; ?></h2>
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
													$count = "SELECT job_id FROM jobs WHERE status = 1 AND verified = 1 AND (job_expiry_date > CURDATE())";
													$fetch = $conn->prepare($count);
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
													$count = "SELECT job_id FROM jobs WHERE status is null AND (job_expiry_date > CURDATE())";
													$fetch = $conn->prepare($count);
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
													$count = "SELECT job_id FROM jobs WHERE (job_expiry_date < CURDATE())";
													$fetch = $conn->prepare($count);
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
													$count = "SELECT job_id FROM jobs WHERE status = 1 AND verified = 1 AND is_featured = 1 AND (job_expiry_date > CURDATE())";
													$fetch = $conn->prepare($count);
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
											<div class="d-flex justify-content-between align-items-center">
												<div>
													<?php 
													$count = "SELECT id FROM companies WHERE status = 1 AND verified = 1 AND is_featured = 1";
													$fetch = $conn->prepare($count);
													$fetch->execute();
													$cnt_featured_employers = $fetch->rowCount();
													?>
													<h5 class="text-fade">Featured Employers</h5>
													<h2 class="fw-500 mb-0"><?php echo $cnt_featured_employers; ?></h2>
												</div>
												<div>
													<div id="featured-employers"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="row d-flex justify-content-center align-items-center">
												<div class="m-2 p-2">
													<span class="waves-effect waves-light btn btn-app bg-gradient-success m-0" style="min-width: 49px;">
														<i class="mdi mdi-currency-inr"></i>
													</span>
												</div>
												<div class="m-2">
													<?php 
													$calculate = "SELECT SUM(amount) AS sum FROM revenue WHERE received_for = 'Featuring Job'";
													$fetch_sum = $conn->prepare($calculate);
													$fetch_sum->execute();
													$total_sum = $fetch_sum->fetch();
													?>
													<h5 class="text-fade">Featured Jobs Incomes</h5>
													<h2 class="fw-500 mb-0"><?php echo $total_sum['sum']; ?></h2>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="row d-flex justify-content-center align-items-center">
												<div class="mr-2">
													<span class="waves-effect waves-light btn btn-app bg-gradient-danger m-0" style="height: 76px;">
														<i class="mdi mdi-currency-inr"></i>
													</span>
												</div>
												<div class="pt-2">
													<?php 
													$calculate = "SELECT SUM(amount) AS sum FROM revenue WHERE received_for = 'Featuring Company'";
													$fetch_sum = $conn->prepare($calculate);
													$fetch_sum->execute();
													$total_sum = $fetch_sum->fetch();
													?>
													<h5 class="text-fade">Featured Employers <br> Incomes</h5>
													<h2 class="fw-500 text-center mb-0">
														<?php 
														if($total_sum['sum'] == null)
														{
															echo 0;
														}
														else
														{
															echo $total_sum['sum'];
														} 
														?>
													</h2>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="row d-flex justify-content-center align-items-center">
												<div class="m-2 p-2">
													<span class="waves-effect waves-light btn btn-app bg-gradient-warning m-0" style="min-width: 49px;">
														<i class="mdi mdi-currency-inr"></i>
													</span>
												</div>
												<div class="m-2">
													<?php 
													$calculate = "SELECT SUM(amount) AS sum FROM revenue WHERE received_for LIKE '%Package Subscription'";
													$fetch_sum = $conn->prepare($calculate);
													$fetch_sum->execute();
													$total_sum = $fetch_sum->fetch();
													?>
													<h5 class="text-fade">Subscription Incomes</h5>
													<h2 class="fw-500 text-center mb-0">
														<?php 
														if($total_sum['sum'] == null)
														{
															echo 0;
														}
														else
														{
															echo $total_sum['sum'];
														} 
														?>
													</h2>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-12">
									<div class="box">
										<div class="box-body py-0">
											<div class="row d-flex justify-content-center align-items-center">
												<div class="m-2 p-2">
													<span class="waves-effect waves-light btn btn-app btn-info m-0" style="min-width: 49px;">
														<i class="mdi mdi-currency-inr"></i>
													</span>
												</div>
												<div class="m-2">
													<?php 
													$calculate = "SELECT SUM(amount) AS sum FROM revenue";
													$fetch_sum = $conn->prepare($calculate);
													$fetch_sum->execute();
													$total_sum = $fetch_sum->fetch();
													?>
													<h5 class="text-fade">Total Income</h5>
													<h2 class="fw-500 text-center mb-0">
														<?php 
														if($total_sum['sum'] == null)
														{
															echo 0;
														}
														else
														{
															echo $total_sum['sum'];
														} 
														?>
													</h2>
												</div>
											</div>
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
						<div class="col-xl-12 col-12">
							<div class="row">
								<div class="col-xxxl-6 col-xl-6 col-12">
									<div class="box">
										<div class="box-header">
											<h4 class="box-title">Recent Candidates</h4>
											<ul class="box-controls pull-right d-md-flex d-none">
											  	<li class="dropdown">
													<a class="btn btn-primary px-10" href="<?php echo $path; ?>/admin/candidates/manage">View List</a>
											  	</li>
											</ul>
										</div>
										<table class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Name</th>
													<th>Gender</th>
													<th>Created On</th>
													<th class="text-center">Status</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											$sql_retrieve = "SELECT * FROM candidates ORDER BY id DESC LIMIT 6";
											$statement = $conn->prepare($sql_retrieve);
											$statement->execute();
											$rowCount = $statement->rowCount();
											$stmt = $statement->fetchAll(PDO::FETCH_OBJ);
											if($rowCount > 0)
											{
												foreach($stmt AS $row)
												{
													$time = strtotime($row->created_at);
													echo '
													<tr>
														<td><a href="'.$path.'/admin/candidates/view?id='.$row->id.'">'.$row->firstname.' '.$row->lastname.'</a></td>
														<td>'.$row->gender.'</td>
														<td>'.get_time_ago($time).'</td>';
														if($row->status == 1)
														{
															echo '<td class="text-center"><i class="fa fa-check-circle text-success"></i></td>';
														}
														else
														{
															echo '<td class="text-center"><i class="fa fa-times-circle text-danger"></i></td>';
														}
													echo '
													</tr>';
												}
											}
											?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-xxxl-6 col-xl-6 col-12">
									<div class="box">
										<div class="box-header">
											<h4 class="box-title">Recent Employers</h4>
											<ul class="box-controls pull-right d-md-flex d-none">
											  	<li class="dropdown">
													<a class="btn btn-primary px-10" href="<?php echo $path; ?>/admin/companies/manage">View List</a>
											  	</li>
											</ul>
										</div>
										<table class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Name</th>
													<th>Location</th>
													<th>Created On</th>
													<th class="text-center">Is Featured</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											$sql_retrieve = "SELECT companies.*, states.state, cities.city FROM companies LEFT JOIN states ON companies.state_id = states.id LEFT JOIN cities ON companies.city_id = cities.id ORDER BY companies.id DESC LIMIT 6";
											$statement = $conn->prepare($sql_retrieve);
											$statement->execute();
											$rowCount = $statement->rowCount();
											$stmt = $statement->fetchAll(PDO::FETCH_OBJ);
											if($rowCount > 0)
											{
												foreach($stmt AS $row)
												{
													$time = strtotime($row->created_at);
													echo '
													<tr>
														<td><a href="'.$path.'/admin/companies/view?id='.$row->id.'">'.$row->companyname.'</a></td>
														<td>'.$row->city.', '.$row->state.'</td>
														<td>'.get_time_ago($time).'</td>';
														if($row->is_featured == 1)
														{
															echo '<td class="text-center"><i class="fa fa-check-circle text-success"></i></td>';
														}
														else
														{
															echo '<td class="text-center"><i class="fa fa-times-circle text-danger"></i></td>';
														}
													echo '
													</tr>';
												}
											}
											?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-xxxl-8 col-xl-7 col-12">
									<div class="box">
										<div class="box-header">
											<h4 class="box-title">Recent Jobs</h4>
											<ul class="box-controls pull-right d-md-flex d-none">
											  	<li class="dropdown">
													<a class="btn btn-primary px-10" href="<?php echo $path; ?>/admin/jobs/all">View List</a>
											  	</li>
											</ul>
										</div>
										<table class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Job Title</th>
													<th>Company</th>
													<th>Created On</th>
													<th>Function</th>
													<th class="text-center">Is Featured</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											$sql_retrieve = "SELECT jobs.*, companies.companyname, functional_areas.functional_area FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id ORDER BY jobs.id DESC LIMIT 6";
											$statement = $conn->prepare($sql_retrieve);
											$statement->execute();
											$rowCount = $statement->rowCount();
											$stmt = $statement->fetchAll(PDO::FETCH_OBJ);
											if($rowCount > 0)
											{
												foreach($stmt AS $row)
												{
													$time = strtotime($row->created_at);
													echo '
													<tr>
														<td><a href="'.$path.'/admin/jobs/view?id='.$row->id.'">'.$row->job_title.'</a></td>
														<td>'.$row->companyname.'</td>
														<td>'.get_time_ago($time).'</td>
														<td>'.$row->functional_area.'</td>';
														if($row->is_featured == 1)
														{
															echo '<td class="text-center"><i class="fa fa-check-circle text-success"></i></td>';
														}
														else
														{
															echo '<td class="text-center"><i class="fa fa-times-circle text-danger"></i></td>';
														}
													echo '
													</tr>';
												}
											}
											?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-xxxl-4 col-xl-5 col-12">
									<div class="box">
										<div class="box-header with-border">
											<h4 class="box-title">New Applications</h4>
										</div>
										<div class="box-body">
											<?php 
											$sql_retrieve = "SELECT jobs.*, companies.companyname, job_applied.candidate_id, job_applied.job_id, candidates.firstname, candidates.lastname, candidates.photo FROM job_applied LEFT JOIN companies ON job_applied.company_id = companies.id LEFT JOIN jobs ON job_applied.job_id = jobs.job_id LEFT JOIN candidates ON job_applied.candidate_id = candidates.id ORDER BY job_applied.id DESC LIMIT 4";
											$statement = $conn->prepare($sql_retrieve);
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
															<a href="'.$path.'/admin/candidates/view?id='.$row->candidate_id.'" class="text-dark hover-primary mb-1 fs-16">'.$row->firstname.' '.$row->lastname.'</a>
															<span class="fs-12"><span class="text-fade">Applied for the post of</span> '.$row->job_title.' <span class="text-fade">of</span> '.$row->companyname.' <span class="text-fade">Company</span></span>
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
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/datatable/datatables.min.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/script.js"></script>
	<?php
	$percent_live = ($cnt_live*100)/$cnt_total;
	$percent_closed = ($cnt_closed*100)/$cnt_total;
	$percent_pending = ($cnt_pending*100)/$cnt_total;
	$percent_featured = ($cnt_featured*100)/$cnt_total;
	$percent_featured_employers = ($cnt_featured_employers*100)/$cnt_employers;
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
			/********Featured Jobs*******
			 * 
			 *******Featured Employers*****/
			var options = {
				chart: {
					height: 100,
					width: 100,
					type: "radialBar"
				},

				series: [<?php echo $percent_featured_employers; ?>],
				colors: ['#83005c'],
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

			var chart = new ApexCharts(document.querySelector("#featured-employers"), options);
			chart.render();
		});
	</script>
</body>
</html>