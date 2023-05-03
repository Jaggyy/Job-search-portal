<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'resume_builder';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["candidate_login"]) || $_SESSION["candidate_login"] !== true)
{   
	header('location:http://localhost/naukri/candidate');
	exit();
}
$candidate_id = $_SESSION['candidate_id'];
?>

<?php
if(isset($_GET['education']))
{
    $delete_sql = "DELETE FROM manage_candidate_qualifications WHERE id= :id";
    $delete = $conn->prepare($delete_sql);
    $delete->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    if($delete->execute())
    {
        $delMsg = "Deletion Successfull.";
        header('Refresh:2;url='.$path.'/candidate/resume-builder');
    }
    else
    {
        $delError = "Something Went Wrong! Try again..";
        header('Refresh:2;url='.$path.'/candidate/resume-builder');
    }
}

if(isset($_GET['experience']))
{
    $delete_sql = "DELETE FROM manage_candidate_experiences WHERE id= :id";
    $delete = $conn->prepare($delete_sql);
    $delete->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    if($delete->execute())
    {
        $delMsg = "Deletion Successfull.";
        header('Refresh:2;url='.$path.'/candidate/resume-builder');
    }
    else
    {
        $delError = "Something Went Wrong! Try again..";
        header('Refresh:2;url='.$path.'/candidate/resume-builder');
    }
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/resume-builder-script.php'); ?>
<?php
$sql_retrieve = "SELECT * FROM candidates WHERE id = :id";
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
    <title>Resume Builder | Naukri</title>
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
							<h3 class="page-title">RESUME BUILDER</h3>
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
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'email=invalid')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Invalid Email ID.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'updation=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                /******************************** Language Output ********************************
                ************************************************************************************/
                if (strpos($url, 'error=empty-language')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'language=duplicate')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Language Already Exists.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'language=inserted')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=language-insertion-error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }

                if (strpos($url, 'error=language-empty')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'language=updated')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=language-updation-error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
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
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'data=duplicate')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Experience Already Exists.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'operation=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=insertion-error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
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
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'duplicate=input')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Data Already Exists.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'insertion=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=operation-error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'update-education=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=education-update')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                /******************************** Skill Output ********************************
                ************************************************************************************/
                if (strpos($url, 'error=empty-rating')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'update=success')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=update-error')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                /******************************** Summary Output ********************************
                ************************************************************************************/
                if (strpos($url, 'error=empty-summary')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Please Fill Required Fields.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'summary=updated')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.success('Operation Successfull.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                if (strpos($url, 'error=not-updated')!== false) 
                {
                    echo 
                    "<script type='text/javascript'>
                        toastr.error('Something Went Wrong. Please Try Again Later.');
                        setTimeout(function() {
                            window.location.href = '".$path."/candidate/resume-builder';
                        }, 3000);
                    </script>";
                }
                ?>
                <?php
                if(isset($_GET['education']))
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

                if(isset($_GET['experience']))
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
								<!-- /.box-header -->
								<div class="box-body">
									<div class="vtabs col-md-12">
										<ul class="nav nav-tabs tabs-vertical" role="tablist" style="width: 200px;">
                                            <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#personal" role="tab"><span><i class="ion-person me-15"></i>Personal Info</span></a> </li>
											<li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#language" role="tab"><span><i class="fa fa-language me-15"></i>Languages</span></a> </li>
											<li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#education" role="tab"><span><i class="fa fa-graduation-cap me-15"></i>Education</span></a> </li>
                                            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab"><span><i class="fa fa-briefcase me-15"></i>Experience</span></a> </li>
                                            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#skills" role="tab"><span><i class="mdi mdi-tag me-15"></i>Skills</span></a> </li>
                                            <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#summary" role="tab"><span><i class="mdi mdi-note-text me-15"></i>Summary</span></a> </li>
											<li class="nav-item"> <a class="nav-link" href="<?php echo $path; ?>/candidate/resume-preview" target="_blank"><span><i class="mdi mdi-note-text me-15"></i>Preview</span></a> </li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
											<div class="tab-pane active" id="personal" role="tabpanel">
                                                <div class="box-header with-border ml-3 mb-3 p-0">
                                                    <h4 class="box-title">Personal Info</h4>
                                                </div>
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
																  	<label class="form-label">Date of Birth</label>
																  	<input type="date" class="form-control" name="dob" id="dob" value="<?php echo $row['dob']; ?>" required>
																</div>
														  	</div>
														</div>
													</div>
													<!-- /.box-body -->
													<div class="box-footer">
														<button type="submit" name="update" class="btn fix-gr-bg submit">UPDATE</button>
													</div>  
												</form>
											</div><div class="tab-pane" id="language" role="tabpanel">
                                                <div class="box-header with-border ml-3 mb-3 p-0">
                                                    <h4 class="box-title">Languages</h4>
                                                    <div class="col-auto text-right float-right ml-auto b-10">
                                                        <a href="#addLanguage" data-toggle="modal" data-target="#addLanguage" class="btn fix-gr-bg btn-rounded"><i class="mdi mdi-plus"></i>&nbsp;&nbsp;Add Language</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="box">
                                                            <?php
                                                            $query_run = "SELECT * FROM manage_candidate_languages WHERE candidate_id = :candidate_id ORDER BY language";
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
                                                                    <form method="post" action="'.$_SERVER['PHP_SELF'].'">
                                                                    <input type="hidden" name="id" id="id" value="'.$query_fetch->id.'">
                                                                    <div class="box-body pt-0">
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-8">
                                                                                <div class="form-group">
                                                                                    <label class="form-label">Language</label>
                                                                                    <input id="language" type="text" class="form-control" name="language" value="'.$query_fetch->language.'" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 mt-30">
                                                                                <button type="submit" name="update-4" class="btn fix-gr-bg submit">UPDATE</button>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </form>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
											<div class="tab-pane" id="education" role="tabpanel">
                                                <div class="box-header with-border ml-3 mb-3 p-0">
                                                    <h4 class="box-title">Education</h4>
                                                    <div class="col-auto text-right float-right ml-auto b-10">
                                                        <a href="#addEducation" data-toggle="modal" data-target="#addEducation" class="btn fix-gr-bg btn-rounded"><i class="mdi mdi-plus"></i>&nbsp;&nbsp;Add Education</a>
                                                    </div>
                                                </div>
												<div class="row">
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
                                                                            <a href="#editEducation'.$query_fetch->id.'" data-toggle="modal" data-target="#editEducation'.$query_fetch->id.'" class="btn btn-circle btn-primary btn-xs mr-2"><i class="fa fa-edit"></i></a>
                                                                            <a href="#deleteEducation'.$query_fetch->id.'" data-toggle="modal" data-target="#deleteEducation'.$query_fetch->id.'" class="btn btn-circle btn-danger btn-xs mr-2"><i class="fa fa-trash"></i></a>
                                                                        </div>
                                                                    </div>

<!--Modal Delete Education-->
<div class="modal fade" id="deleteEducation'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="exampleModalLongTitle">DELETE EDUCATION</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="mdi mdi-close"></i>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default">Close</button>
                <a class="btn fix-gr-bg" href="'.$path.'/candidate/resume-builder?id='.$query_fetch->id.'&education=delete">Delete</a>
            </div>
        </div>
    </div>
</div>

<!--Modal Edit Education-->
<div class="modal fade" id="editEducation'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top" role="document">
        <form method="post" action="'.$path.'/candidate/includes/resume-builder-update-script?id='.$query_fetch->id.'">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="exampleModalLongTitle">EDIT EDUCATION</h5>
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
                                    <option value="'.$query_fetch->qualification_id.'">'.$query_fetch->qualification.'</option>';
                                    $sql_select = "SELECT * FROM qualifications WHERE id != '".$query_fetch->qualification_id."' AND status = 1";
                                    $query_row = $conn->prepare($sql_select);
                                    $query_row->execute();
                                    $rw = $query_row->fetchAll(PDO::FETCH_OBJ);
                                    if($query_row->rowCount() > 0)
                                    {
                                        foreach($rw as $qfetch)
                                        {
                                            echo'
                                            <option value="'.$qfetch->id.'">'.$qfetch->qualification.'</option>';
                                        }
                                    }
                                echo '
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="institute">Institute</label>
                                <input type="text" name="institute" id="institute" value="'.$query_fetch->institute.'" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="graduation_year">Graduation Year</label>
                                <select name="graduation_year" id="graduation_year" class="form-control" required>
                                    <option value="'.$query_fetch->graduation_year.'">'.$query_fetch->graduation_year.'</option>';
                                    $earliestYear = 1950;
                                    foreach (range(date('Y'), $earliestYear) as $y) 
                                    {
                                        echo '<option value="'.$y.'">'.$y.'</option>';
                                    }
                                echo '
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="updateEducation" class="btn fix-gr-bg">Update</a>
                </div>
            </div>
        </form>
    </div>
</div>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
											</div>
											<div class="tab-pane" id="experience" role="tabpanel">
                                                <div class="box-header with-border ml-3 mb-3 p-0">
                                                    <h4 class="box-title">Experience</h4>
                                                    <div class="col-auto text-right float-right ml-auto b-10">
                                                        <a href="#addExperience" data-toggle="modal" data-target="#addExperience" class="btn fix-gr-bg btn-rounded"><i class="mdi mdi-plus"></i>&nbsp;&nbsp;Add Experience</a>
                                                    </div>
                                                </div>
												<div class="row">
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
                                                                            <a href="'.$path.'/candidate/experience-edit?id='.$query_fetch->id.'" class="btn btn-circle btn-primary btn-xs mr-2"><i class="fa fa-edit"></i></a>
                                                                            <a href="#deleteExperience'.$query_fetch->id.'" data-toggle="modal" data-target="#deleteExperience'.$query_fetch->id.'" class="btn btn-circle btn-danger btn-xs mr-2"><i class="fa fa-trash"></i></a>
																		</div>
																		<div class="mt-10">
																			<h6 class="text-dark mb-20">'.date('jS F, Y', $start_date).' - '.date('jS F, Y', $end_date).' | <i class="fa fa-map-marker"></i> '.$query_fetch->state.', '.$query_fetch->city.'</h6>
																			<p>'.$query_fetch->description.'</p>
																		</div>
																	</div>
<!--Modal Delete Experience-->
<div class="modal fade" id="deleteExperience'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="exampleModalLongTitle">DELETE EXPERIENCE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="mdi mdi-close"></i>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default">Close</button>
                <a class="btn fix-gr-bg" href="'.$path.'/candidate/resume-builder?id='.$query_fetch->id.'&experience=delete">Delete</a>
            </div>
        </div>
    </div>
</div>';
																}
															}
															?>
														</div>
													</div>
												</div>
											</div>
                                            <div class="tab-pane" id="skills" role="tabpanel">
                                                <div class="box-header with-border ml-3 mb-3 p-0">
                                                    <h4 class="box-title">Skills</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php
                                                        $query_run = "SELECT job_skills.*, manage_candidate_skills.candidate_skill_id, manage_candidate_skills.rating FROM job_skills LEFT JOIN manage_candidate_skills ON job_skills.id = manage_candidate_skills.candidate_skill_id WHERE manage_candidate_skills.candidate_id = :candidate_id";
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
                                                                <form method="post" action="'.$_SERVER['PHP_SELF'].'">
                                                                    <input type="hidden" name="candidate_skill_id" id="candidate_skill_id" value="'.$query_fetch->candidate_skill_id.'">
                                                                    <div class="box-body pt-0">
                                                                        <div class="row mb-3">
                                                                            <div class="col-md-5">
                                                                                <div class="form-group">
                                                                                    <label class="form-label">First Name</label>
                                                                                    <input id="job_skill" type="text" class="form-control" name="job_skill" value="'.$query_fetch->job_skill.'" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-5">
                                                                                <div class="form-group">
                                                                                    <label class="form-label">Skill rating (out of 100)</label>
                                                                                    <input id="rating" type="number" class="form-control" name="rating" value="'.$query_fetch->rating.'" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-2 mt-30">
                                                                                <button type="submit" name="update-2" class="btn fix-gr-bg submit">UPDATE</button>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                </form>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="summary" role="tabpanel">
                                                <div class="box-header with-border ml-3 mb-3 p-0">
                                                    <h4 class="box-title">Summary</h4>
                                                </div>
                                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                    <div class="box-body pt-0">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Summary</label>
                                                                <textarea name="summary" id="summary" class="form-control" rows="10" required><?php echo $row['summary']; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.box-body -->
                                                    <div class="box-footer">
                                                        <button type="submit" name="update-3" class="btn fix-gr-bg submit">UPDATE</button>
                                                    </div>  
                                                </form>
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

                <!--Modal Add Language-->
                <div class="modal fade" id="addLanguage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-top" role="document">
                        <div class="modal-content">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title" id="exampleModalLongTitle">ADD LANGUAGE</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="mdi mdi-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="language">Language</label>
                                                <input type="text" name="language" id="language" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="addLanguage" class="btn fix-gr-bg submit">
                                        <i class="ti-save-alt"></i> SAVE
                                    </button>
                                </div>
                            </form>
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
</body>
</html>
