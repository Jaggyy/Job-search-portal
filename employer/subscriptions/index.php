<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'subscriptions';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true)
{   
  header('location:http://localhost/naukri/');
  exit();
}
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
		  		<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/employer/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
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
					$sql_retrieve = "SELECT plans.*, companies.package_id,companies.package_start_date,companies.package_end_date FROM plans LEFT JOIN companies ON plans.id = companies.package_id ORDER BY plans.plan";
					$query = $conn->prepare($sql_retrieve);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    if($query->rowCount() > 0)
                    {
                        foreach($results as $query_fetch)
                        {
                        	echo '
							<div class="col-lg-4">
								<div class="box card-shadowed box-inverse bg-gradient-danger" style="height: 454px;">
									<div class="box-body text-center">
										<h5 class="text-uppercase text-muted">'.$query_fetch->plan.'</h5>
										<br>
										<h3 class="price">
											<i class="mdi mdi-currency-inr"></i>'.$query_fetch->amount.'
											<span>per month</span>
										</h3>

										<hr>
										<p><strong>'.$query_fetch->allowed_jobs.'</strong> Jobs Allowed</p>';

										$count = "SELECT jobs.id AS id, jobs.created_at, jobs.company_id, companies.package_start_date, companies.package_end_date FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id WHERE jobs.company_id = :company_id AND (jobs.created_at BETWEEN companies.package_start_date AND companies.package_end_date)";
										$fetch_id = $conn->prepare($count);
										$fetch_id->bindParam(':company_id', $_SESSION['company_id'], PDO::PARAM_INT);
										$fetch_id->execute();
										$cnt = $fetch_id->rowCount();

										$used_job = ($query_fetch->allowed_jobs - $cnt);
										$currentDate = time();
										$package_end_date = strtotime($query_fetch->package_end_date);
										$days_left = $package_end_date - $currentDate;
										$days_left = round($days_left / (60*60*24));
										if($query_fetch->package_id == $query_fetch->id && $days_left > 0)
										{
											echo '
											<p><strong>'.$used_job.'</strong> Jobs Used</p>
											<p><strong>'.$days_left.'</strong> Days Left</p>';
										}
										echo '
										<br><br>';
										if(($query_fetch->package_id == $query_fetch->id) && ($days_left > 0))
										{
											echo '
											<a class="btn btn-outline btn-white">CURRENT PLAN</a>';
										}
										elseif($days_left <= 0)
										{
											echo '
											<a class="btn btn-outline btn-white" href="'.$path.'/employer/subscriptions/payment-method?id='.$query_fetch->id.'">PURCHASE</a>';
										}
										echo '
										
									</div>
								</div>
							</div>';
						}
					}
					?>
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
	<script src="<?php echo $path; ?>/admin/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/vendor_components/select2/dist/js/select2.full.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/datatable/datatables.min.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/advanced-form-element.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/script.js"></script>
</body>
</html>
