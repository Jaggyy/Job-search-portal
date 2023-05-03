<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'jobs';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true)
{   
  header('location:http://localhost/naukri/');
  exit();
}
$id = $_GET['id'];
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
							<h3 class="page-title">Edit Job</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item" aria-current="page"><a href="<?php echo $path; ?>/employer/jobs/manage">jobs</a></li>
										<li class="breadcrumb-item active" aria-current="page">Edit Job</li>
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
                            window.location.href = '".$path."/employer/jobs/edit?id=".$id."';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'error=subscription_error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Your Naukri Subscription Has Been Expired.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/edit?id=".$id."';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'empty=empty')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/edit?id=".$id."';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'updation=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Your Post Has Been Updated Successfully.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/edit?id=".$id."';
                        }, 5000);
                    </script>";
                }
                if (strpos($url, 'error=error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/employer/jobs/edit?id=".$id."';
                        }, 5000);
                    </script>";
                }
                ?>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<?php
								$sql_retrieve = "SELECT jobs.*, job_types.job_type,functional_areas.functional_area,states.state,cities.city,qualifications.qualification,job_experiences.job_experience FROM jobs LEFT JOIN job_types ON jobs.job_type_id = job_types.id LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id LEFT JOIN states ON jobs.state_id = states.id LEFT JOIN cities ON jobs.city_id = cities.id LEFT JOIN qualifications ON jobs.qualification_id = qualifications.id LEFT JOIN job_experiences ON jobs.job_experience_id = job_experiences.id WHERE jobs.id = :id";
								$query = $conn->prepare($sql_retrieve);
								$query->bindParam(':id', $id, PDO::PARAM_INT);
								$query->execute();
								$query_fetch = $query->fetch();
								?>
								<!-- /.box-header -->
								<form class="form" method="post" action="<?php echo $path; ?>/employer/includes/jobs-update-script.php?id=<?php echo $id; ?>">
									<input type="hidden" name="company_id" id="company_id" value="<?php echo $_SESSION['company_id']; ?>">
									<input type="hidden" name="industry_id" id="industry_id" value="<?php echo $_SESSION['industry']; ?>">
									<input type="hidden" name="job_id" id="job_id" value="<?php echo $query_fetch['job_id']; ?>">
									<div class="box-body">
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Job Title</label>
												  	<input id="job_title" type="text" class="form-control" name="job_title" value="<?php echo $query_fetch['job_title']; ?>">
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Job Type</label>
												  	<select name="job_type_id" id="job_type_id" class="form-control" required>
												  		<option value="<?php echo $query_fetch['job_type_id']; ?>"><?php echo $query_fetch['job_type']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM job_types WHERE id != '".$query_fetch['job_type_id']."' AND status = 1";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $row=$rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($row as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->job_type.'</option>';
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
												  		<option value="<?php echo $query_fetch['functional_area_id']; ?>"><?php echo $query_fetch['functional_area']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM functional_areas WHERE id != '".$query_fetch['functional_area_id']."' AND status = 1";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $row=$rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($row as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->functional_area.'</option>';
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
												  		<?php
                                                        $sql = "SELECT job_skills.job_skill, job_skills.id, manage_job_skills.job_id,manage_job_skills.job_skill_id FROM job_skills JOIN manage_job_skills ON job_skills.id = manage_job_skills.job_skill_id WHERE manage_job_skills.job_id = '".$query_fetch['job_id']."'";
                                                        $rows = $conn->prepare($sql);
                                                        $array = [];
                                                        $rows->execute();
                                                        $row = $rows->fetchAll(PDO::FETCH_OBJ);
                                                        if($rows->rowCount() > 0)
                                                        {
                                                            foreach($row as $qfetch)
                                                            {
                                                            	$array[] = $qfetch->id;
                                                            }
                                                        }
                                                        ?>

                                                        <?php
                                                        $query = "SELECT * FROM job_skills";
                                                        $result = $conn->prepare($query);
                                                        $result->execute();
                                                        $results = $result->fetchAll(PDO::FETCH_OBJ);
                                                        if($result->rowCount() > 0)
                                                        {
                                                            foreach($results as $qryfetch)
                                                            {
                                                            ?>
                                                                <option value="<?php echo $qryfetch->id; ?>" <?php echo in_array($qryfetch->id, $array) ? 'selected' : '' ?>><?php echo $qryfetch->job_skill; ?></option>
                                                            <?php
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
												  	<textarea name="description" id="description" class="form-control" required><?php echo $query_fetch['description']; ?></textarea>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Gender</label>
												  	<select name="gender" id="gender" class="form-control" required>
												  		<option <?php if($query_fetch['gender'] == "Male"){ echo 'value="Male" selected="selected"';} ?>>Male</option>
												  		<option <?php if($query_fetch['gender'] == "Female"){ echo 'value="Female" selected="selected"';} ?>>Female</option>
												  		<option <?php if($query_fetch['gender'] == "Both"){ echo 'value="Both" selected="selected"';} ?>>Both</option>
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
													  	<input type="date" class="form-control pull-right" name="job_expiry_date" value="<?php echo $query_fetch['job_expiry_date']; ?>" id="job_expiry_date" required>
													</div>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Salary From (Monthly)</label>
												  	<input type="number" name="salary_from" value="<?php echo $query_fetch['salary_from']; ?>" id="salary_from" class="form-control" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Salary To (Monthly)</label>
												  	<input type="number" name="salary_to" value="<?php echo $query_fetch['salary_to']; ?>" id="salary_to" class="form-control" required>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">Country</label>
												  	<input type="text" name="country" id="country" value="India" class="form-control"  readonly>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">State</label>
												  	<select name="state_id" id="state_id" class="form-control" >
														<option value="<?php echo $query_fetch['state_id']; ?>"><?php echo $query_fetch['state']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM states WHERE id != '".$query_fetch['state_id']."'";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $row=$rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($row as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->state.'</option>';
								                            }
								                        }
								                        ?>
													</select>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">City</label>
												  	<select name="city_id" id="city_id" class="form-control" >
												  		<option value="<?php echo $query_fetch['city_id'];?>"><?php echo $query_fetch['city'];?></option>
                                                        <?php
                                                        $query="SELECT * FROM cities WHERE id != '".$query_fetch['city_id']."' AND state_id = '".$query_fetch['state_id']."'";
                                                        $res = $conn->prepare($query);
                                                        $res->execute();
                                                        $result=$res->fetchAll(PDO::FETCH_OBJ);
                                                        if($res->rowCount() > 0)
                                                        {
                                                            foreach($result as $rw)
                                                            {
                                                            	echo '
                                                        		<option value="'.$rw->id.'">'.$rw->city.'</option>';
                                                            }
                                                        }
                                                        ?>
													</select>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">Qualification</label>
												  	<select name="qualification_id" id="qualification_id" class="form-control" >
														<option value="<?php echo $query_fetch['qualification_id']; ?>"><?php echo $query_fetch['qualification']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM qualifications WHERE id != '".$query_fetch['qualification_id']."' AND status = 1";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $row=$rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($row as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->qualification.'</option>';
								                            }
								                        }
								                        ?>
													</select>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">Job Experience</label>
												  	<select name="job_experience_id" id="job_experience_id" class="form-control" >
														<option value="<?php echo $query_fetch['job_experience_id']; ?>"><?php echo $query_fetch['job_experience']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM job_experiences WHERE id != '".$query_fetch['job_experience_id']."'";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $row=$rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($row as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->job_experience.'</option>';
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
												  		<input name="hide_salary" type="radio" id="yes" class="with-gap radio-col-success" value="1" <?php echo $query_fetch['hide_salary'] == true ? 'checked' : ''; ?>>
													  	<label class="me-30" for="yes">Yes</label>
													  	<input name="hide_salary" type="radio" id="no" class="with-gap radio-col-danger" value="0" <?php echo $query_fetch['hide_salary'] == false ? 'checked' : ''; ?>>
													  	<label for="no">No</label>
													</div>
												</div>
										  	</div>
										</div>
										<div class="row">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Number Of Posts</label>
												  	<input type="number" name="num_of_posts" value="<?php echo $query_fetch['num_of_posts']; ?>" id="num_of_posts" class="form-control" >
												</div>
										  	</div>
										</div>
									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" name="update" class="btn fix-gr-bg submit">
										  	<i class="ti-save-alt"></i> UPDATE
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
