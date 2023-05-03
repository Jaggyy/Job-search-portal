<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'all-jobs';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/jobs-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT jobs.*, companies.companyname, job_types.job_type,functional_areas.functional_area,states.state,cities.city,qualifications.qualification,job_experiences.job_experience FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id LEFT JOIN job_types ON jobs.job_type_id = job_types.id LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id LEFT JOIN states ON jobs.state_id = states.id LEFT JOIN cities ON jobs.city_id = cities.id LEFT JOIN qualifications ON jobs.qualification_id = qualifications.id LEFT JOIN job_experiences ON jobs.job_experience_id = job_experiences.id WHERE jobs.id = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
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
    <script src="<?php echo $path; ?>/admin/assets/js/vendors.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
</head>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">	
	<div class="wrapper">
		<div id="loader"></div>
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper">
		  	<div class="container-full">
				<?php
				if(isset($_POST['verify']))
				{
					if($result)	
            		{
            			echo'
                        <script type="text/javascript">
                        	toastr.options.positionClass = "toast-top-right";
                            toastr.success("'.$success.'", "Success");
                    	</script>';
            		}
            		else
            		{
            			echo'
                        <script type="text/javascript">
                        	toastr.options.positionClass = "toast-top-right";
                            toastr.error("'.$error.'", "Error");
                    	</script>';
            		}
            	}
            	?>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<div class="card-body">
									<div class="row">
					          			<div class="col-12 col-md-12">
					          				<div class="row">
					          					<div class="col-md-6">
							            			<table class="table table-borderless">
							              				<tbody>
							                				<tr>
											                  	<th style="width: 160px;">Company Name:</th>
											                  	<td><?php echo $query_fetch['companyname']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Job Skills:</th>
											                  	<?php
																$sql = "SELECT job_skills.*, manage_job_skills.job_id, manage_job_skills.job_skill_id FROM job_skills JOIN manage_job_skills ON job_skills.id = manage_job_skills.job_skill_id WHERE manage_job_skills.job_id = '".$query_fetch['job_id']."'";
																$qry = $conn->prepare($sql);
											                    $qry->execute();
											                    $result=$qry->fetchAll(PDO::FETCH_OBJ);
											                    ?>
											                  	<td class="users-view-latest-activity">
											                  		<?php
												                    if(!empty($result))
												                    {
												                        foreach($result as $fetch)
												                        { 
												                        	echo '
												                        	<span class="waves-effect badge badge-primary">'.$fetch->job_skill.'</span>';
												                        }
												                    }
												                  	else
												                  	{
												                  		echo 'N/A';
												                  	}  
											                        ?>
											                  	</td>
											                </tr>
											                <tr>
											                  	<th>Functional Area:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['functional_area']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Gender:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['gender']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Salary To:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['salary_to']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Job Experience:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['job_experience']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Number Of Posts:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['num_of_posts']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Hide Salary:</th>
											                  	<td class="users-view-verified">
											                  		<?php 
											                  		if($query_fetch['hide_salary'] == 0)
											                  		{
											                  			echo 'No'; 
											                  		}
											                  		else
											                  		{
											                  			echo 'Yes';
											                  		}
											                  		?>
											                  	</td>
											                </tr>
											                <?php
											                if($query_fetch['status'] == 1)
											                {
											                	echo '
											                	<tr>
												                  	<th>Status:</th>
												                  	<td class="users-view-verified">Active</td>
												                </tr>';
											                }
											                ?>
							              				</tbody>
						            				</table>
						            			</div>
					          					<div class="col-md-6">
							            			<table class="table table-borderless">
							              				<tbody>
							                				<tr>
											                  	<th style="width: 160px;">Job Title:</th>
											                  	<td><?php echo $query_fetch['job_title']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Job Type:</th>
											                  	<td class="users-view-latest-activity"><?php echo $query_fetch['job_type']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Job Location:</th>
											                  	<td class="users-view-latest-activity"><?php echo $query_fetch['city'].', '.$query_fetch['state'].', '.$query_fetch['country']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Salary From:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['salary_from']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Qualification:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['qualification']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Job Expiry Date:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['job_expiry_date']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Created On:</th>
											                  	<td class="users-view-verified">
											                  		<?php 
											                  		$created_on = strtotime($query_fetch['created_at']);
											                  		echo date('jS M, Y', $created_on);
											                  		?>
											                  	</td>
											                </tr>
											                <?php
											                if($query_fetch['is_featured'] == 1)
											                {
											                	echo '
											                	<tr>
												                  	<th>Featured:</th>
												                  	<td class="users-view-verified">Yes</td>
												                </tr>';
											                }
											                ?>
							              				</tbody>
						            				</table>
						            			</div>
						            		</div>
							                <form method="post" action="" style="width: 80%;">
												<div class="col-md-6">
													<div class="d-flex">
														<div class="mt-2 mb-4">
															<?php
									            			if($query_fetch['verified'] == 0)
									            			{
									            				echo '
																<input type="hidden" name="verified" value="1">
																<input type="hidden" name="status" value="1">
																<button type="submit" name="verify" class="btn btn-primary submit">
																  	VERIFY JOB
																</button>';
															}
															else
															{
																echo '
																<span class="waves-effect badge badge-lg badge-success">
																	<button type="button" class="waves-effect waves-circle btn btn-circle btn-success btn-xs"><i class="mdi mdi-check"></i></button> VERIFIED
																</span>';
															}
															?>
														</div> 
													</div>
												</div>
						            		</form>
				            				<hr>
							            	<form id="content_form" class="form" method="post" action="">
				            					<div class="row">
				            						<div class="col-md-6">
														<div class="box-body">
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
						            				</div>
						            			</div>
						            			<div class="box-footer">
													<button type="submit" class="btn fix-gr-bg submit">
													  	<i class="ti-save-alt"></i> UPDATE
													</button>
													<button type="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">
														<i class="ti-save-alt"></i> UPDATING...
													</button>
												</div>
											</form>
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
	<script type="text/javascript">
		toastr.options =
		{
		    "closeButton": true,
		    "progressBar": true,
		    "positionClass": "toast-top-right",
		    "timeOut": "2000",
		}

		/***************************Form Validation************************************/
		$(document).ready(function () {
		    _formValidation();
		});
		var _formValidation = function (form_id = '#content_form') {
		    let form = $(form_id);
		    if (form.length > 0) {
		        form.on('submit', function (e) {
		            e.preventDefault();
		            form.find('.submit').hide();
		            form.find('.submitting').show();
		            const submit = $('#submit');
		            const submit_val = submit.val();
		            const submit_url = form.attr('action');
		            //Start Ajax
		            const formData = new FormData(form[0]);
		            formData.append('submit', submit_val);
		            $.ajax({
		                url: submit_url,
		                type: 'POST',
		                data: formData,
		                contentType: false, // The content type used when sending data to the server.
		                cache: false, // To unable request pages to be cached
		                processData: false,
		                dataType: 'JSON',
		                success: function (data) {
		                    if(data.message)
		                    {
		                        form[0].reset();
		                        form.find('.submit').show();
		                        form.find('.submitting').hide();
		                        toastr.success(data.message, data.title);
	                            setTimeout(function() {
	                                window.location.href = "<?php echo $path; ?>/admin/jobs/view?id=<?php echo $_GET['id']; ?>";
	                            }, 2000);
		                    }
		                    else if(data.error)
		                    {
		                        form.find('.submit').show();
		                        form.find('.submitting').hide();
		                        toastr.error(data.error);
		                    }
		                }
		            });
		        });
		    }
		};
	</script>
</body>
</html>
