<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'add_jobs';
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
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
	<script>
    	toastr.options =
		{
		    "closeButton": true,
		    "progressBar": true,
		    "timeOut": "5000",
		    "positionClass": "toast-top-right"
		}
    </script>
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
							<h3 class="page-title">Add Job</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item" aria-current="page"><a href="<?php echo $path; ?>/employer/jobs/manage">jobs</a></li>
										<li class="breadcrumb-item active" aria-current="page">Add Job</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<?php
				$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                if (strpos($url, 'error=package_error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Subscribe A Package First.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/create';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'error=subscription_error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Your Naukri Subscription Has Been Expired.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/create';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'error=jobs_error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Your Allowed Jobs Is Over. Please Subscribe A Package First.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/create';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'empty=empty')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/create';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'insertion=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Your Post Will Be Posted After Consideration.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/create';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'error=error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/create';
                        }, 5000);
                    </script>";
                }
                ?>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<!-- /.box-header -->
								<form class="form" method="post" action="<?php echo $path; ?>/employer/includes/jobs-create-script.php">
									<input type="hidden" name="company_id" id="company_id" value="<?php echo $_SESSION['company_id']; ?>">
									<input type="hidden" name="industry_id" id="industry_id" value="<?php echo $_SESSION['industry']; ?>">
									<div class="box-body">
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Job Title</label>
												  	<input id="job_title" type="text" class="form-control" name="job_title" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Job Type</label>
												  	<select name="job_type_id" id="job_type_id" class="form-control" required>
												  		<option value="">Select Job Type</option>
												  		<?php
														$query = "SELECT * FROM job_types WHERE status = 1 ORDER BY job_type";
														$result = $conn->prepare($query);
														$result->execute();
														$results=$result->fetchAll(PDO::FETCH_OBJ);
									                    if($result->rowCount() > 0)
									                    {
									                        foreach($results as $query_fetch)
									                        {
									                        	echo '
																<option value="'.$query_fetch->id.'">'.$query_fetch->job_type.'</option>';
															}
														}
														?>
												  	</select>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Functional Area</label>
												  	<select name="functional_area_id" id="functional_area_id" class="form-control" required>
												  		<option value="">Select Functional Area</option>
												  		<?php
														$query = "SELECT * FROM functional_areas WHERE status = 1 ORDER BY functional_area";
														$result = $conn->prepare($query);
														$result->execute();
														$results=$result->fetchAll(PDO::FETCH_OBJ);
									                    if($result->rowCount() > 0)
									                    {
									                        foreach($results as $query_fetch)
									                        {
									                        	echo '
																<option value="'.$query_fetch->id.'">'.$query_fetch->functional_area.'</option>';
															}
														}
														?>
												  	</select>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Job Skill</label>
												  	<select name="job_skill_id[]" id="job_skill_id" class="form-control select2" multiple="multiple" required>
														<option value="" disabled="true">Select Job Skill</option>
												  		<?php
														$query = "SELECT * FROM job_skills WHERE status = 1 ORDER BY job_skill";
														$result = $conn->prepare($query);
														$result->execute();
														$results=$result->fetchAll(PDO::FETCH_OBJ);
									                    if($result->rowCount() > 0)
									                    {
									                        foreach($results as $query_fetch)
									                        {
									                        	echo '
																<option value="'.$query_fetch->id.'">'.$query_fetch->job_skill.'</option>';
															}
														}
														?>
													</select>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-12">
												<div class="form-group">
												  	<label class="form-label">Job Description</label>
												  	<textarea name="description" id="description" class="form-control" required></textarea>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Gender</label>
												  	<select name="gender" id="gender" class="form-control" required>
												  		<option value="">Select Gender</option>
												  		<option value="Both">Both</option>
												  		<option value="Male">Male</option>
												  		<option value="Female">Female</option>
												  	</select>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Job Expiry Date</label>
												  	<div class="input-group date">
													  	<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
													  	</div>
													  	<input type="date" class="form-control pull-right" name="job_expiry_date" id="job_expiry_date" required>
													</div>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Salary From (Monthly)</label>
												  	<input type="number" name="salary_from" id="salary_from" class="form-control" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Salary To (Monthly)</label>
												  	<input type="number" name="salary_to" id="salary_to" class="form-control" required>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">Country</label>
												  	<input type="text" name="country" id="country" value="India" class="form-control" required readonly>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">State</label>
												  	<select name="state_id" id="state_id" class="form-control" required>
														<option value="">Select State</option>
												  		<?php
														$query = "SELECT * FROM states ORDER BY state";
														$result = $conn->prepare($query);
														$result->execute();
														$results=$result->fetchAll(PDO::FETCH_OBJ);
									                    if($result->rowCount() > 0)
									                    {
									                        foreach($results as $query_fetch)
									                        {
									                        	echo '
																<option value="'.$query_fetch->id.'">'.$query_fetch->state.'</option>';
															}
														}
														?>
													</select>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">City</label>
												  	<select name="city_id" id="city_id" class="form-control" required>
													</select>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">Qualification</label>
												  	<select name="qualification_id" id="qualification_id" class="form-control" required>
														<option value="">Select Qualification</option>
												  		<?php
														$query = "SELECT * FROM qualifications WHERE status = 1 ORDER BY qualification";
														$result = $conn->prepare($query);
														$result->execute();
														$results=$result->fetchAll(PDO::FETCH_OBJ);
									                    if($result->rowCount() > 0)
									                    {
									                        foreach($results as $query_fetch)
									                        {
									                        	echo '
																<option value="'.$query_fetch->id.'">'.$query_fetch->qualification.'</option>';
															}
														}
														?>
													</select>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">Job Experience</label>
												  	<select name="job_experience_id" id="job_experience_id" class="form-control" required>
														<option value="">Select Job Experience</option>
												  		<?php
														$query = "SELECT * FROM job_experiences ORDER BY job_experience";
														$result = $conn->prepare($query);
														$result->execute();
														$results=$result->fetchAll(PDO::FETCH_OBJ);
									                    if($result->rowCount() > 0)
									                    {
									                        foreach($results as $query_fetch)
									                        {
									                        	echo '
																<option value="'.$query_fetch->id.'">'.$query_fetch->job_experience.'</option>';
															}
														}
														?>
													</select>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">Hide Salary</label>
												  	<div class="c-inputs-stacked">
														<input name="hide_salary" type="radio" id="yes" class="with-gap radio-col-success" value="1">
													  	<label class="me-30" for="yes">Yes</label>
													  	<input name="hide_salary" type="radio" id="no" class="with-gap radio-col-danger" value="0" checked="checked">
													  	<label for="no">No</label>
													</div>
												</div>
										  	</div>
										</div>
										<div class="row">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Number Of Posts</label>
												  	<input type="number" name="num_of_posts" id="num_of_posts" class="form-control" required>
												</div>
										  	</div>
										</div>
									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" name="submit" class="btn fix-gr-bg submit">
										  	<i class="ti-save-alt"></i> POST
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
	<script type="text/javascript" src="<?php echo $path; ?>/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
    	CKEDITOR.replace("description");
	</script>
	<script>
	    $(document).ready(function(){
	        $("#state_id").change(function(){
	            var state_id = $(this).val();
	            $.ajax({
	                type: "POST",
	                url: "<?php echo $path; ?>/employer/get-cities",
	                data: { state_id : state_id } 
	            }).done(function(data){
	                $("#city_id").html(data);
	            });
	        });
	    });
	</script>
</body>
</html>
