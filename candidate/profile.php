<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'profile';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["candidate_login"]) || $_SESSION["candidate_login"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
$candidate_id = $_SESSION['candidate_id'];
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/get-time-ago.php'); ?>
<?php
if(!empty($_FILES['photo']['name']))
{
    $photo = $_FILES['photo']['name'];
    $uploadDir = "../assets/images/profile_picture/";
    $fileName = basename($photo);
    $targetPath = $uploadDir. $fileName;
    // get the image extension
    $extension = substr($photo,strlen($photo)-4,strlen($photo));
    // allowed extensions
    $allowed_extensions = array(".jpg","jpeg",".png");

    $sql = "UPDATE candidates SET photo = :photo WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':photo', $fileName, PDO::PARAM_STR);
    $query->bindParam(':id', $candidate_id, PDO::PARAM_INT);
    $result = $query->execute();
    if($result)
    {
        move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath);
    }
    
    //Load JavaScript function to show the upload status
    echo '<script type="text/javascript">window.top.window.completeUpload(' . $result . ',\'' . $targetPath . '\');</script>  ';
}
?>

<?php
if(isset($_GET['del']))
{
	$delete_sql = "UPDATE candidates SET resume = '' WHERE id= :id";
	$delete = $conn->prepare($delete_sql);
	$delete->bindParam(':id', $candidate_id, PDO::PARAM_INT);
	if($delete->execute())
	{
		$delMsg = "Deletion Successfull.";
		header('Refresh:2;url='.$path.'/candidate/profile');
	}
	else
	{
	    $delError = "Something Went Wrong! Try again..";
		header('Refresh:2;url='.$path.'/candidate/profile');
	}
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/profile-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT candidates.*, industries.industry,states.state,cities.city, job_experiences.job_experience, functional_areas.functional_area FROM candidates LEFT JOIN industries ON candidates.industry_id = industries.id LEFT JOIN states ON candidates.state_id = states.id LEFT JOIN cities ON candidates.city_id = cities.id LEFT JOIN job_experiences ON candidates.job_experience_id = job_experiences.id LEFT JOIN functional_areas ON candidates.functional_area_id = functional_areas.id WHERE candidates.id = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $candidate_id, PDO::PARAM_INT);
$query->execute();
$row = $query->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
    <title>Candidate Profile | Naukri</title>
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
		    "timeOut": "3000",
		    "positionClass": "toast-top-right"
		}
    </script>
</head>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">	
	<div class="wrapper">
		<div id="loader"></div>
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper">
		  	<div class="container-full">
		  		<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<h3 class="page-title">EDIT PROFILE</h3>
						</div>
					</div>
				</div>
				<?php
				$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                if (strpos($url, 'error=empty')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'email=invalid')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Invalid Email ID.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'updation=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                /******************************** Experience Output ********************************
                ************************************************************************************/
                if (strpos($url, 'error=empty-data')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'data=duplicate')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Experience Already Exists.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'operation=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=insertion-error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                /******************************** Education Output ********************************
                ************************************************************************************/
                if (strpos($url, 'error=empty-inputs')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'duplicate=input')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Data Already Exists.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'insertion=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=operation-error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/profile';
                        }, 3000);
                    </script>";
                }
                ?>
                <?php
				if(isset($_GET['del']))
				{
					if($delete->execute())
					{
						echo'
                        <script type="text/javascript">
                            toastr.success("'.$delMsg.'", "Success");
                    	</script>';
					}
					else
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$delError.'", "Error");
                    	</script>';
					}
				}
				?>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<div class="media">
                                    <a href="javascript: void(0);">
                                        <?php
                                        if($row['photo'])
                                        {
                                            echo '
                                            <img src="'.$path.'/assets/images/profile_picture/'.$row['photo'].'" class="rounded mr-75" id="imagePreview" alt="profile image" height="200" width="300">';
                                        }
                                        else
                                        {
                                            echo '
                                            <img src="assets/images/user.png" class="rounded mr-75" id="imagePreview" alt="profile image" height="200" width="300">';
                                        }
                                        ?>
                                        
                                    </a>
                                    <div class="media-body mt-2">
                                        <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                            <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 editLink" for="account-upload">Upload New Photo</label>
                                            <form method="post" action="" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
                                                <input type="file" name="photo" id="account-upload"  style="display:none"/>
                                            </form>
                                            <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                        </div>
                                        <p class="text-muted mt-2"><small>Allowed JPG, JPEG or PNG.</small></p>
                                    </div>
                                </div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="vtabs col-md-12">
										<ul class="nav nav-tabs tabs-vertical" role="tablist" style="width: 200px;">
											<li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab"><span><i class="ion-person me-15"></i>Profile</span></a> </li>
											<li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#resume" role="tab"><span><i class="mdi mdi-file-pdf me-15"></i>Resume</span></a> </li>
											<li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#career_informations" role="tab"><span><i class="fa fa-graduation-cap me-15"></i>Career Informations</span></a> </li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
											<div class="tab-pane active" id="profile" role="tabpanel">
												<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
													<div class="box-body pt-0">
														<div class="row mb-3">
														  	<div class="col-md-6">
																<div class="form-group">
																  	<label class="form-label">First Name</label>
																  	<input id="firstname" type="text" class="form-control" name="firstname" value="<?php echo $row['firstname']; ?>" required>
																</div>
														  	</div>
														  	<div class="col-md-6">
																<div class="form-group">
																  	<label class="form-label">Last Name</label>
																  	<input id="lastname" type="text" class="form-control" name="lastname" value="<?php echo $row['lastname']; ?>" required>
																</div>
														  	</div>
														</div>
														<div class="row mb-3">
														  	<div class="col-md-6">
																<div class="form-group">
																  	<label class="form-label">Email ID</label>
																  	<input id="email" type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
																</div>
														  	</div>
														  	<div class="col-md-6">
																<div class="form-group">
																  	<label class="form-label">Contact Number</label>
																  	<input id="phone" type="text" class="form-control" name="phone" value="<?php echo $row['phone']; ?>" required>
																</div>
														  	</div>
														</div>
														<div class="row mb-3">
														  	<div class="col-md-6">
																<div class="form-group">
																  	<label class="form-label">Father's Name</label>
																  	<input id="fathername" type="text" class="form-control" name="fathername" value="<?php echo $row['fathername']; ?>">
																</div>
														  	</div>
														  	<div class="col-md-6">
																<div class="form-group">
																  	<label class="form-label">Date of Birth</label>
																  	<input type="date" class="form-control" name="dob" id="dob" value="<?php echo $row['dob']; ?>" required>
																</div>
														  	</div>
														</div>
														<div class="row mb-3">
														  	<div class="col-md-6">
																<div class="form-group">
																  	<label class="form-label">Gender</label>
																  	<select name="gender" id="gender" class="form-control" required>
																  		<option <?php if($row['gender'] == "Male"){ echo 'value="Male" selected="selected"';} ?>>Male</option>
																  		<option <?php if($row['gender'] == "Female"){ echo 'value="Female" selected="selected"';} ?>>Female</option>
																  		<option <?php if($row['gender'] == "Both"){ echo 'value="Both" selected="selected"';} ?>>Both</option>
																  	</select>
																</div>
														  	</div>
														  	<div class="col-md-6">
																<div class="form-group">
																  	<label class="form-label">Skills</label>
																  	<select name="candidate_skill_id[]" id="candidate_skill_id" class="form-control select2" multiple="multiple" required>
																  		<?php
				                                                        $sql = "SELECT job_skills.job_skill, job_skills.id, manage_candidate_skills.candidate_id,manage_candidate_skills.candidate_skill_id FROM job_skills JOIN manage_candidate_skills ON job_skills.id = manage_candidate_skills.candidate_skill_id WHERE manage_candidate_skills.candidate_id = '".$row['id']."'";
				                                                        $rows = $conn->prepare($sql);
				                                                        $array = [];
				                                                        $rows->execute();
				                                                        $stmt = $rows->fetchAll(PDO::FETCH_OBJ);
				                                                        if($rows->rowCount() > 0)
				                                                        {
				                                                            foreach($stmt as $qfetch)
				                                                            {
				                                                            	$array[] = $qfetch->id;
				                                                            }
				                                                        }
				                                                        ?>

				                                                        <?php
				                                                        $select = "SELECT * FROM job_skills";
				                                                        $result = $conn->prepare($select);
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
														  	<div class="col-md-4">
																<div class="form-group">
																  	<label class="form-label">Marital Status</label>
																  	<select name="marital_status" id="marital_status" class="form-control" required>
																  		<option value="">Select Marital Status</option>
																  		<option <?php if($row['marital_status'] == "Single"){ echo 'value="Single" selected="selected"';} ?>>Single</option>
																  		<option <?php if($row['marital_status'] == "Married"){ echo 'value="Married" selected="selected"';} ?>>Married</option>
																  		<option <?php if($row['marital_status'] == "Divorced"){ echo 'value="Divorced" selected="selected"';} ?>>Divorced</option>
																  		<option <?php if($row['marital_status'] == "Widowed"){ echo 'value="Widowed" selected="selected"';} ?>>Widowed</option>
																  	</select>
																</div>
														  	</div>
														  	<div class="col-md-4">
																<div class="form-group">
																  	<label class="form-label">Nationality</label>
																  	<input type="text" name="nationality" id="nationality" value="<?php echo $row['nationality']; ?>" class="form-control">
																</div>
														  	</div>
														  	<div class="col-md-4">
																<div class="form-group">
																  	<label class="form-label">Expected Salary</label>
																  	<input type="number" name="expected_salary" id="expected_salary" value="<?php echo $row['expected_salary']; ?>" class="form-control">
																</div>
														  	</div>
														</div>
														<div class="row mb-3">
														  	<div class="col-md-4">
																<div class="form-group">
																  	<label class="form-label">Country</label>
																  	<input id="country" type="text" class="form-control" name="country" value="<?php echo $row['country']; ?>" readonly required>
																</div>
														  	</div>
														  	<div class="col-md-4">
																<div class="form-group">
																  	<label class="form-label">State</label>
																  	<select name="state_id" id="state_id" class="form-control" required>
																  		<option value="<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
												                        <?php
												                        $sql = "SELECT * FROM states WHERE id != '".$row['state_id']."'";
												                        $rows = $conn->prepare($sql);
												                        $rows->execute();
												                        $output = $rows->fetchAll(PDO::FETCH_OBJ);
												                        if($rows->rowCount() > 0)
												                        {
												                            foreach($output as $qfetch)
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
																  		<option value="<?php echo $row['city_id'];?>"><?php echo $row['city'];?></option>
				                                                        <?php
				                                                        $query="SELECT * FROM cities WHERE id != '".$row['city_id']."' AND state_id = '".$row['state_id']."'";
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
																  	<label class="form-label">Experience</label>
																  	<select name="job_experience_id" id="job_experience_id" class="form-control" required>
																  		<option value="<?php echo $row['job_experience_id']; ?>"><?php echo $row['job_experience']; ?></option>
												                        <?php
												                        $sql = "SELECT * FROM job_experiences WHERE id != '".$row['job_experience_id']."'";
												                        $rows = $conn->prepare($sql);
												                        $rows->execute();
												                        $result = $rows->fetchAll(PDO::FETCH_OBJ);
												                        if($rows->rowCount() > 0)
												                        {
												                            foreach($result as $qfetch)
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
																  	<label class="form-label">Industry</label>
																  	<select name="industry_id" id="industry_id" class="form-control" required>
																  		<option value="<?php echo $row['industry_id']; ?>"><?php echo $row['industry']; ?></option>
												                        <?php
												                        $sql = "SELECT * FROM industries WHERE id != '".$row['industry_id']."' AND status = 1";
												                        $rows = $conn->prepare($sql);
												                        $rows->execute();
												                        $result = $rows->fetchAll(PDO::FETCH_OBJ);
												                        if($rows->rowCount() > 0)
												                        {
												                            foreach($result as $qfetch)
												                            {
												                            	echo'
												                        		<option value="'.$qfetch->id.'">'.$qfetch->industry.'</option>';
												                            }
												                        }
												                        ?>
																  	</select>
																</div>
														  	</div>
														  	<div class="col-md-4">
																<div class="form-group">
																  	<label class="form-label">Functional Area</label>
																  	<select name="functional_area_id" id="functional_area_id" class="form-control" required>
																  		<option value="<?php echo $row['functional_area_id']; ?>"><?php echo $row['functional_area']; ?></option>
												                        <?php
												                        $sql = "SELECT * FROM functional_areas WHERE id != '".$row['functional_area_id']."' AND status = 1";
												                        $rows = $conn->prepare($sql);
												                        $rows->execute();
												                        $result = $rows->fetchAll(PDO::FETCH_OBJ);
												                        if($rows->rowCount() > 0)
												                        {
												                            foreach($result as $qfetch)
												                            {
												                            	echo'
												                        		<option value="'.$qfetch->id.'">'.$qfetch->functional_area.'</option>';
												                            }
												                        }
												                        ?>
																  	</select>
																</div>
														  	</div>
														</div>
													</div>
													<!-- /.box-body -->
													<div class="box-footer">
														<button type="submit" name="update" class="btn fix-gr-bg submit">UPDATE</button>
													</div>  
												</form>
											</div>
											<div class="tab-pane" id="resume" role="tabpanel">
												<div class="row">
													<div class="col-lg-5 col-12">
														<div class="box">
															<?php
															if($row['resume'])
															{
																echo '
																<div class="box-body text-center">
																	<div class="mb-20 mt-20">
																		<img src="'.$path.'/assets/images/resource/resume-icon.png" class="" alt="user" width="88">
																		<h4 class="mt-20 mb-0">'.$row['resume'].'</h4>';
																		$time = strtotime($row['created_at']);
																		echo '
																		<p>'.get_time_ago($time).'</p>
																	</div>
																</div>
																<div class="p-25 mt-15 bt-1">
																	<div class="row text-center">
																		<div class="col-6 be-1">
																			<a href="'.$path.'/includes/resume-download?file_id='.$candidate_id.'" class="d-flex justify-content-center badge badge-pill badge-info-light fs-16"><span class="mdi mdi-download"></span>&nbsp;Download</a>
																		</div>
																		<div class="col-6">
																			<a href="#delete'.$row['id'].'" data-toggle="modal" data-target="#deleteResume'.$row['id'].'" class="d-flex justify-content-center badge badge-pill badge-danger-light fs-16"><span class="mdi mdi-delete-circle"></span>&nbsp;Delete</a>
																		</div>
																	</div>
																</div>';
															}
															else
															{
																echo '
																<div class="box-body text-center">
																	<div class="mb-20 mt-20">
																		<img src="'.$path.'/assets/images/resource/file-not-found.webp" style="width: 100%;">
																	</div>
																</div>';
															}
															?>
														</div>
													</div>
													<div class="col-lg-7 col-12">
														<div class="col-auto text-left float-left ml-auto">
															<a href="#addResume" data-toggle="modal" data-target="#addResume" class="btn fix-gr-bg btn-rounded"><i class="mdi mdi-plus"></i>&nbsp;&nbsp;Upload Resume</a>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="career_informations" role="tabpanel">
												<div class="row">
													<div class="col-12">
													  	<div class="box">
															<div class="box-header no-border p-3">
																<h4 class="box-title mt-2 mb-0">Experience</h4>
																<div class="col-auto text-right float-right ml-auto">
																	<a href="#addExperience" data-toggle="modal" data-target="#addExperience" class="btn fix-gr-bg btn-rounded"><i class="mdi mdi-plus"></i>&nbsp;&nbsp;Add Experience</a>
																</div>
															</div>
														</div>
													</div>
													<div class="col-12">
														<div class="box">
															<?php
															$query_run = "SELECT manage_candidate_experiences.*, states.state, cities.city FROM manage_candidate_experiences LEFT JOIN states ON manage_candidate_experiences.state_id = states.id LEFT JOIN cities ON manage_candidate_experiences.city_id = cities.id WHERE candidate_id = :candidate_id";
															$output = $conn->prepare($query_run);
															$output->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
															$output->execute();
															$count = $output->rowCount();
															if($count > 0)
										                    {
																$fetch = $output->fetchAll(PDO::FETCH_OBJ);
										                        foreach($fetch as $query_fetch)
										                        {
										                        	$start_date = strtotime($query_fetch->start_date);
										                        	$end_date = strtotime($query_fetch->end_date);
										                        	echo '
																	<div class="box-body">	
																		<div class="d-flex flex-wrap align-items-center">
																			<div class="d-flex flex-column flex-grow-1 my-lg-0 my-10 pe-15">
																				<h3 class="text-dark fw-600 hover-danger fs-18 mt-0 mb-0">'.$query_fetch->experience_title.'</h3>
																				<span class="text-fade fw-600 fs-16">'.$query_fetch->company.'</span>
																			</div>
																		</div>
																		<div class="mt-10">
																			<h6 class="text-dark mb-20">'.date('jS F, Y', $start_date).' - '.date('jS F, Y', $end_date).' | <i class="fa fa-map-marker"></i> '.$query_fetch->state.', '.$query_fetch->city.'</h6>
																			<p>'.$query_fetch->description.'</p>
																		</div>
																	</div>';
																}
															}
															else
															{
																echo '
																<div class="box-body text-center">
																	<div class="mb-20 mt-20">
																		<img src="'.$path.'/assets/images/resource/data-not-found.png" style="width: 100%; height: 200px;">
																	</div>
																</div>';
															}
															?>
														</div>
													</div>
												</div>
												<hr>
												<div class="row">
													<div class="col-12">
													  	<div class="box">
															<div class="box-header no-border p-3">
																<h4 class="box-title mt-2 mb-0">Education</h4>
																<div class="col-auto text-right float-right ml-auto">
																	<a href="#addEducation" data-toggle="modal" data-target="#addEducation" class="btn fix-gr-bg btn-rounded"><i class="mdi mdi-plus"></i>&nbsp;&nbsp;Add Education</a>
																</div>
															</div>
														</div>
													</div>
													<div class="col-12">
														<div class="box">
															<?php
															$query_run = "SELECT manage_candidate_qualifications.*, qualifications.qualification, qualifications.abbreviation FROM manage_candidate_qualifications LEFT JOIN qualifications ON manage_candidate_qualifications.qualification_id = qualifications.id WHERE candidate_id = :candidate_id ORDER BY graduation_year";
															$output = $conn->prepare($query_run);
															$output->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
															$output->execute();
															$count = $output->rowCount();
															if($count > 0)
										                    {
																$fetch = $output->fetchAll(PDO::FETCH_OBJ);
										                        foreach($fetch as $query_fetch)
										                        {
										                        	echo '
																	<div class="box-body">	
																		<div class="row">
																			<div class="ml-2">
																				<span class="badge badge-xl badge-ring fill badge-primary"></span>
																			</div>
																			<div class="col-md-10">
																				<div class="d-flex flex-wrap align-items-center">
																					<div class="d-flex flex-column flex-grow-1 my-lg-0 my-10 pe-15">
																						<h3 class="text-dark fw-600 hover-danger fs-18 mt-0 mb-0">'.$query_fetch->qualification.' ('.$query_fetch->abbreviation.')</h3>
																						<span class="text-fade fw-600 fs-16">'.$query_fetch->institute.'</span>
																					</div>
																				</div>
																				<div class="mt-10">
																					<h6 class="text-dark mb-20">'.$query_fetch->graduation_year.'</h6>
																				</div>
																			</div>
																		</div>
																	</div>';
																}
															}
															else
															{
																echo '
																<div class="box-body text-center">
																	<div class="mb-20 mt-20">
																		<img src="'.$path.'/assets/images/resource/data-not-found.png" style="width: 100%; height: 200px;">
																	</div>
																</div>';
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
			  				</div>
				  			<!-- /.box -->
						</div>
					</div>
				</section>
				<!-- /.content -->

				<!--Modal Upload Resume-->
				<div class="modal fade" id="addResume" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
				aria-hidden="true">
					<div class="modal-dialog modal-dialog-top" role="document">
						<div class="modal-content">
							<form id="resume-upload-form" method="post" action="<?php echo $path; ?>/candidate/includes/resume-update-script.php" enctype="multipart/form-data">
								<div class="modal-header bg-danger">
									<h5 class="modal-title" id="exampleModalLongTitle">UPLOAD RESUME</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i class="mdi mdi-close"></i>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group">
										<input type="file" name="resume" id="resume" class="form-control">
									</div>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn fix-gr-bg submit">
									  	<i class="ti-save-alt"></i> UPLOAD
									</button>
									<button type="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">
										<i class="ti-save-alt"></i> UPLOADING...
									</button>
						  		</div>
						  	</form>
						</div>
					</div>
				</div>

				<!--Modal Delete Resume-->
				<div class="modal fade" id="deleteResume<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
				aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header bg-danger">
								<h5 class="modal-title" id="exampleModalLongTitle">DELETE RESUME</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i class="mdi mdi-close"></i>
								</button>
							</div>
							<div class="modal-body">
								Are you sure you want to delete?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default">Close</button>
								<a class="btn fix-gr-bg" href="<?php echo $path; ?>/candidate/profile?id=<?php echo $row['id']; ?>&del=delete">Delete</a>
					  		</div>
						</div>
					</div>
				</div>

				<!--Modal Add Experience-->
				<div class="modal fade" id="addExperience" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
				aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-top" role="document">
						<div class="modal-content">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<div class="modal-header bg-danger">
									<h5 class="modal-title" id="exampleModalLongTitle">ADD EXPERIENCE</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i class="mdi mdi-close"></i>
									</button>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="experience_title">Experience Title</label>
												<input type="text" name="experience_title" id="experience_title" class="form-control" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="company">Company</label>
												<input type="text" name="company" id="company" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="stateid">State</label>
												<select name="state_id" id="stateid" class="form-control" required>
					 								<option value="">Select State</option>
													<?php
													$select_state = "SELECT * FROM states ORDER BY state";
													$run_query = $conn->prepare($select_state);
													$run_query->execute();
													$qry = $run_query->fetchAll(PDO::FETCH_OBJ);
								                    if($run_query->rowCount() > 0)
								                    {
								                        foreach($qry as $query_fetch)
								                        {
								                        	echo '
															<option value="'.$query_fetch->id.'">'.$query_fetch->state.'</option>';
														}
													}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="cityid">City</label>
												<select name="city_id" id="cityid" class="form-control" required>
													
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="start_date">Start Date</label>
												<input type="date" name="start_date" id="start_date" class="form-control" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="end_date">End Date</label>
												<input type="date" name="end_date" id="end_date" class="form-control" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
											    <textarea name="description" id="description" class="form-control" required></textarea>
                                            </div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="submit" name="addExperience" class="btn fix-gr-bg submit">
									  	<i class="ti-save-alt"></i> SAVE
									</button>
						  		</div>
						  	</form>
						</div>
					</div>
				</div>

				<!--Modal Add Education-->
				<div class="modal fade" id="addEducation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
				aria-hidden="true">
					<div class="modal-dialog modal-dialog-top" role="document">
						<div class="modal-content">
							<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<div class="modal-header bg-danger">
									<h5 class="modal-title" id="exampleModalLongTitle">ADD EDUCATION</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<i class="mdi mdi-close"></i>
									</button>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label for="qualification_id">Qualification</label>
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
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="institute">Institute</label>
												<input type="text" name="institute" id="institute" class="form-control" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="graduation_year">Graduation Year</label>
												<select name="graduation_year" id="graduation_year" class="form-control" required>
													<option value="">Select</option>
													<?php
													$earliest_year = 1950;
													foreach (range(date('Y'), $earliest_year) as $x) 
													{
													    echo '<option value="'.$x.'">'.$x.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="submit" name="addEducation" class="btn fix-gr-bg submit">
									  	<i class="ti-save-alt"></i> SAVE
									</button>
						  		</div>
						  	</form>
						</div>
					</div>
				</div>
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

	    $(document).ready(function(){
	        $("#stateid").change(function(){
	            var stateid = $(this).val();
	            $.ajax({
	                type: "POST",
	                url: "<?php echo $path; ?>/candidate/get-cities",
	                data: { stateid : stateid } 
	            }).done(function(data){
	                $("#cityid").html(data);
	            });
	        });
	    });
	</script>
	<script type="text/javascript">
        $(document).ready(function () {
            //If image edit link is clicked
            $(".editLink").on('click', function(e){
                e.preventDefault();
                $("#account-upload:hidden").trigger('click');
            });

            //On select file to upload
            $("#account-upload").on('change', function(){
                var image = $('#account-upload').val();
                var img_ex = /(\.jpg|\.jpeg|\.png)$/i;

                //validate file type
                if(!img_ex.exec(image)){
                    toastr.error("Please Upload Only .JPG/.JPEG/ or /.PNG File.");
                    $('#account-upload').val('');
                    return false;
                }else{
                    $('.uploadProcess').show();
                    $('#uploadForm').hide();
                    $( "#picUploadForm" ).submit();
                }
            });
        });

        //After completion of image upload process
        function completeUpload(success, fileName) {
            if(success == 1){
                $('#imagePreview').attr("src", "");
                $('#imagePreview').attr("src", fileName);
                $('#account-upload').attr("value", fileName);
                $('.uploadProcess').hide();
                toastr.success("Image Uploaded Successfully");
            }else{
                $('.uploadProcess').hide();
                toastr.error("Something Went Wrong. Please Try Again Later.");
            }
            return true;
        }
    </script>
    <script>
	    $(document).ready(function () {
	        _formValidation();
	    });
	</script>
	<script type="text/javascript">
	    var _formValidation = function (form_id = '#resume-upload-form') {
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
	                                window.location.href = "<?php echo $path; ?>/candidate/profile";
	                            }, 3000);
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
