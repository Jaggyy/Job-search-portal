<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'candidates';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/candidates-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT candidates.*, industries.industry,states.state,cities.city, job_experiences.job_experience, functional_areas.functional_area FROM candidates LEFT JOIN industries ON candidates.industry_id = industries.id LEFT JOIN states ON candidates.state_id = states.id LEFT JOIN cities ON candidates.city_id = cities.id LEFT JOIN job_experiences ON candidates.job_experience_id = job_experiences.id LEFT JOIN functional_areas ON candidates.functional_area_id = functional_areas.id WHERE candidates.id = :id";
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
    <title><?php echo $query_fetch['firstname'].' '.$query_fetch['lastname']; ?> | Naukri</title>
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
		  		<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item" aria-current="page"><a href="<?php echo $path; ?>/admin/candidates/manage">Candidates</a></li>
										<li class="breadcrumb-item active" aria-current="page"><?php echo $query_fetch['firstname'].' '.$query_fetch['lastname']; ?></li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12 col-sm-12">
				      		<div class="avatar-list-overlap mb-2">
						        <a class="mr-1" href="#">
						          	<img src="<?php echo $path; ?>/assets/images/profile_picture/<?php echo $query_fetch['photo']; ?>" alt="<?php echo $query_fetch['firstname']; ?>" class="avatar rounded-circle" style="width: 17%; height: 200px;">
						        </a>
				      		</div>
				    	</div>
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
											                  	<th style="width: 160px;">Candidate Name:</th>
											                  	<td><?php echo $query_fetch['firstname'].' '.$query_fetch['lastname']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Phone Number:</th>
											                  	<td class="users-view-latest-activity"><?php echo $query_fetch['phone']; ?></td>
											                </tr>
							                				<tr>
											                  	<th>Date of Birth:</th>
											                  	<td><?php echo $query_fetch['dob']; ?></td>
											                </tr>
							                				<tr>
											                  	<th>Nationality:</th>
											                  	<td><?php echo $query_fetch['nationality']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Address:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['city'].', '.$query_fetch['state'].', '.$query_fetch['country']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Functional Area:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['functional_area']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Gender:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['gender']; ?></td>
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
											                  	<th style="width: 160px;">Email ID:</th>
											                  	<td><?php echo $query_fetch['email']; ?></td>
											                </tr>
							                				<tr>
											                  	<th>Father's Name:</th>
											                  	<td><?php echo $query_fetch['fathername']; ?></td>
											                </tr>
							                				<tr>
											                  	<th>Marital Status:</th>
											                  	<td><?php echo $query_fetch['marital_status']; ?></td>
											                </tr>
							                				<tr>
											                  	<th>Expected Salary:</th>
											                  	<td><?php echo $query_fetch['expected_salary']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Industry:</th>
											                  	<td class="users-view-latest-activity"><?php echo $query_fetch['industry']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Job Experience:</th>
											                  	<td class="users-view-latest-activity"><?php echo $query_fetch['job_experience']; ?></td>
											                </tr>
											                <?php
								 							$sql = "SELECT job_skills.*, manage_candidate_skills.candidate_skill_id FROM job_skills LEFT JOIN manage_candidate_skills ON job_skills.id = manage_candidate_skills.candidate_skill_id WHERE manage_candidate_skills.candidate_id = :candidate_id";
								 							$run_sql = $conn->prepare($sql);
								 							$run_sql->bindParam(":candidate_id", $_GET['id'], PDO::PARAM_INT);
								 							$run_sql->execute();
															$count = $run_sql->rowCount();
															if($count > 0)
										                    {
																$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
																echo '
												                <tr>
												                	<th>Skills:</th>
												                	<td class="users-view-latest-activity">';
												                	foreach($fetch_result as $qfetch)
			                        								{
			                        									echo '
											                				<span class="waves-effect badge badge-primary">'.$qfetch->job_skill.'</span>';
											                		}
											                		echo '
											                		</td>
											                	</tr>';
											                }
											                ?>
							              				</tbody>
						            				</table>
						            			</div>
						            		</div>
				            				<hr>
				            				<h5 class="mb-3"><i class="fa fa-graduation-cap"></i> Career Informations</h5>
				            				<div class="row">
				            					<?php
					 							$sql = "SELECT qualifications.*, manage_candidate_qualifications.institute, manage_candidate_qualifications.graduation_year FROM qualifications LEFT JOIN manage_candidate_qualifications ON qualifications.id = manage_candidate_qualifications.qualification_id WHERE manage_candidate_qualifications.candidate_id = :candidate_id ORDER BY graduation_year";
					 							$run_sql = $conn->prepare($sql);
					 							$run_sql->bindParam(":candidate_id", $_GET['id'], PDO::PARAM_INT);
					 							$run_sql->execute();
												$count = $run_sql->rowCount();
												if($count > 0)
							                    {
													$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
													echo '
					            					<div class="col-12">
														<h5>Education</h5>
					            						<table class="table table-bordered">
					            							<thead>
					            								<tr>
					            									<th>Qualification</th>
					            									<th>Institution</th>
					            									<th>Graduation Year</th>
					            								</tr>
					            							</thead>
					            							<tbody>';
									                        foreach($fetch_result as $qfetch)
									                        {
									                        	echo '
					            								<tr>
					            									<td>'.$qfetch->qualification.'</th>
					            									<td>'.$qfetch->institute.'</th>
					            									<td>'.$qfetch->graduation_year.'</th>
					            								</tr>';
					            							}
					            							echo '
					            							</tbody>
					            						</table>
					            					</div>';
					            				}


					            				$sql = "SELECT manage_candidate_experiences.*, states.state, cities.city FROM manage_candidate_experiences LEFT JOIN states ON manage_candidate_experiences.state_id = states.id LEFT JOIN cities ON manage_candidate_experiences.city_id = cities.id WHERE candidate_id = :candidate_id";
					 							$run_sql = $conn->prepare($sql);
					 							$run_sql->bindParam(":candidate_id", $_GET['id'], PDO::PARAM_INT);
					 							$run_sql->execute();
												$count = $run_sql->rowCount();
												if($count > 0)
							                    {
													$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
													echo '
					            					<div class="col-12">
														<h5>Experience</h5>
					            						<table class="table table-bordered">
					            							<thead>
					            								<tr>
					            									<th>Experience Title</th>
					            									<th>Company</th>
					            									<th>Location</th>
					            									<th style="width: 17%;">Duration</th>
					            									<th>Description</th>
					            								</tr>
					            							</thead>
					            							<tbody>';
									                        foreach($fetch_result as $qfetch)
									                        {
									                        	$start_date = strtotime($qfetch->start_date);
										            			$end_date = strtotime($qfetch->end_date);
									                        	echo '
					            								<tr>
					            									<td>'.$qfetch->experience_title.'</th>
					            									<td>'.$qfetch->company.'</th>
					            									<td>'.$qfetch->city.', '.$qfetch->state.'</th>
					            									<td><p>From - '.date('jS F, Y', $start_date).'</p>
					            										<p>To - '.date('jS F, Y', $end_date).'</p></th>
					            									<td>'.$qfetch->description.'</th>
					            								</tr>';
					            							}
					            							echo '
					            							</tbody>
					            						</table>
					            					</div>';
					            				}
						            			?>
				            				</div>
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
	                                window.location.href = "<?php echo $path; ?>/admin/candidates/view?id=<?php echo $_GET['id']; ?>";
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