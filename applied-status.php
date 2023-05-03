<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
if(!isset($_SESSION["candidate_login"]) || $_SESSION["candidate_login"] !== true)
{   
	header('location:'.$path.'/candidate/');
	exit();
}
?>

<?php
$job_id = $_GET['id'];
$sql_retrieve = "SELECT jobs.*, companies.companyname FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id WHERE jobs.job_id = :job_id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':job_id', $job_id, PDO::PARAM_INT);
$query->execute();
$fetch = $query->fetch();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
	<title>Applied Successfully to <?php echo $fetch['job_title']; ?> | Naukri</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/bootstrap-grid.css" />
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/icons.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/animate.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/colors/colors.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/fonts/font-awesome/4.5.0/css/font-awesome.min.css" />
	<script src="<?php echo $path; ?>/assets/js/jquery.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/toastr.min.css">
    <script src="<?php echo $path; ?>/assets/js/toastr.min.js"></script>
</head>
<body>
<div class="page-loading">
	<img src="<?php echo $path; ?>/assets/images/loader.gif" alt="" />
</div>

<div class="theme-layout" id="scrollup">
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-responsive.php'); ?>
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-1.php'); ?>

	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 column">
						<div class="job-listings-sec no-border">
							<?php
							$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
							if (strpos($url, 'status=already-applied')!== false) 
			                {
			                    echo '
			                    <h4>ALREADY APPLIED</h4>
								<div class="row job-listing wtabs mb-2 mt-2 p-5">
									<button class="btn btn-danger btn-lg btn-applied"><i class="la la-times"></i></button>
									<div class="pt-4 pl-4 d-flex">
										<strong>You have already submitted your application for</strong>
									</div>
									<i class="pl-4 d-flex">'.$fetch['job_title'].' at '.$fetch['companyname'].'</i>
								</div>';
			                }
			                if (strpos($url, 'status=applied')!== false) 
			                {
			                    echo '
			                    <h4>JOB APPLIED</h4>
								<div class="row job-listing wtabs mb-2 mt-2 p-5">
									<button class="btn btn-success btn-lg btn-applied"><i class="la la-check"></i></button>
									<div class="pt-4 pl-4 d-flex">
										<strong>You have successfully submitted your application for</strong>
									</div>
									<i class="pl-4 d-flex">'.$fetch['job_title'].' at '.$fetch['companyname'].'</i>
								</div>';
			                }
			                ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/footer.php'); ?>
</div>

<script src="<?php echo $path; ?>/assets/js/modernizr.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/script.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/wow.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/slick.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/parallax.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/select-chosen.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/jquery.scrollbar.min.js" type="text/javascript"></script>
</body>
</html>