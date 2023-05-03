<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'jobs';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true)
{   
  header('location:http://localhost/naukri/');
  exit();
}
$job_id = $_GET['job_id'];
$id = $_GET['id'];
?>

<?php
if(isset($_GET['delete']))
{
	$delete_sql = "DELETE FROM job_applied WHERE id = :id";
	$delete = $conn->prepare($delete_sql);
	$delete->bindParam(':id', $_GET['delete'], PDO::PARAM_INT);
	$result = $delete->execute();
	if($result)
	{
		$success = "Deletion Successfull.";
		header('Refresh:2;url='.$path.'/employer/jobs/applications?job_id='.$job_id.'');
	}
	else
	{
	    $error = "Something Went Wrong! Try again..";
		header('Refresh:2;url='.$path.'/employer/jobs/applications?job_id='.$job_id.'');
	}
}

if(isset($_GET['shortlist']))
{
	$shortlist = 'Shortlisted';
	$updated_at = date("F d, Y");
	$shortlist_sql = "UPDATE job_applied SET status = :status, updated_at = :updated_at WHERE id = :id";
	$stmt = $conn->prepare($shortlist_sql);
	$stmt->bindParam(":status", $shortlist, PDO::PARAM_STR);
	$stmt->bindParam(":updated_at", $updated_at, PDO::PARAM_STR);
	$stmt->bindParam(":id", $_GET['shortlist'], PDO::PARAM_INT);
	$result = $stmt->execute();
	if($result)
	{
		$success = "Operation Successfull.";
		header('Refresh:2;url='.$path.'/employer/jobs/applications?job_id='.$job_id.'');
	}
	else
	{
	    $error = "Something Went Wrong! Try again..";
		header('Refresh:2;url='.$path.'/employer/jobs/applications?job_id='.$job_id.'');
	}
}

if(isset($_GET['select']))
{
	$select = 'Selected';
	$updated_at = date("F d, Y");
	$shortlist_sql = "UPDATE job_applied SET status = :status, updated_at = :updated_at WHERE id = :id";
	$stmt = $conn->prepare($shortlist_sql);
	$stmt->bindParam(":status", $select, PDO::PARAM_STR);
	$stmt->bindParam(":updated_at", $updated_at, PDO::PARAM_STR);
	$stmt->bindParam(":id", $_GET['select'], PDO::PARAM_INT);
	$result = $stmt->execute();
	if($result)
	{
		$success = "Operation Successfull.";
		header('Refresh:2;url='.$path.'/employer/jobs/applications?job_id='.$job_id.'');
	}
	else
	{
	    $error = "Something Went Wrong! Try again..";
		header('Refresh:2;url='.$path.'/employer/jobs/applications?job_id='.$job_id.'');
	}
}

if(isset($_GET['reject']))
{
	$reject = 'Rejected';
	$updated_at = date("F d, Y");
	$shortlist_sql = "UPDATE job_applied SET status = :status, updated_at = :updated_at WHERE id = :id";
	$stmt = $conn->prepare($shortlist_sql);
	$stmt->bindParam(":status", $reject, PDO::PARAM_STR);
	$stmt->bindParam(":updated_at", $updated_at, PDO::PARAM_STR);
	$stmt->bindParam(":id", $_GET['reject'], PDO::PARAM_INT);
	$result = $stmt->execute();
	if($result)
	{
		$success = "Operation Successfull.";
		header('Refresh:2;url='.$path.'/employer/jobs/applications?job_id='.$job_id.'');
	}
	else
	{
	    $error = "Something Went Wrong! Try again..";
		header('Refresh:2;url='.$path.'/employer/jobs/applications?job_id='.$job_id.'');
	}
}
?>

<?php
$sql_retrieve = "SELECT job_title FROM jobs WHERE job_id = :job_id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(":job_id", $job_id, PDO::PARAM_INT);
$query->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
    <title>Job Applications | Naukri</title>
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
    <script type="text/javascript">
    	toastr.options =
		{
		    "closeButton": true,
		    "progressBar": true,
		    "timeOut": "2000",
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
							<?php
							$results = $query->fetch();
							echo '
							<h3 class="page-title">Job Applications For '.$results['job_title'].'</h3>';
							?>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/employer/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item" aria-current="page"><a href="<?php echo $path; ?>/employer/jobs/manage">jobs</a></li>
										<li class="breadcrumb-item active" aria-current="page">Applications</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!-- Main content -->
				<?php
				if(isset($_GET['delete']))
				{
					if($result)
					{
						echo'
                        <script type="text/javascript">
                            toastr.success("'.$success.'", "Success");
                    	</script>';
					}
					else
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$error.'", "Error");
                    	</script>';
					}
				}

				//For Shortlist//
				if(isset($_GET['shortlist']))
				{
					if($result)
					{
						echo'
                        <script type="text/javascript">
                            toastr.success("'.$success.'", "Success");
                    	</script>';
					}
					else
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$error.'", "Error");
                    	</script>';
					}
				}

				//For Select//
				if(isset($_GET['select']))
				{
					if($result)
					{
						echo'
                        <script type="text/javascript">
                            toastr.success("'.$success.'", "Success");
                    	</script>';
					}
					else
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$error.'", "Error");
                    	</script>';
					}
				}

				//For Reject//
				if(isset($_GET['reject']))
				{
					if($result)
					{
						echo'
                        <script type="text/javascript">
                            toastr.success("'.$success.'", "Success");
                    	</script>';
					}
					else
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$error.'", "Error");
                    	</script>';
					}
				}
				?>
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<!-- /.box-header -->
								<div class="box-body">
									<div class="table-responsive">
						  				<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Candidate Name</th>
													<th>Application Date</th>
													<th>Resume</th>
													<th>Status</th>
													<th>Options</th>
												</tr>
											</thead>
											<tbody>
											<?php
											$sql = "SELECT job_applied.*, candidates.id AS candidate_id, candidates.firstname, candidates.lastname, candidates.resume FROM job_applied LEFT JOIN candidates ON job_applied.candidate_id = candidates.id WHERE job_applied.job_id = :job_id";
											$statement = $conn->prepare($sql);
											$statement->bindParam(":job_id", $job_id, PDO::PARAM_INT);
						                    $statement->execute();
						                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
						                    if($statement->rowCount() > 0)
						                    {
						                        foreach($result as $query_fetch)
						                        {
						                        	echo '
													<tr>
														<td><a href="'.$path.'/candidate-details?id='.$query_fetch->candidate_id.'">'.$query_fetch->firstname.' '.$query_fetch->lastname.'</a></td>
														<td>'.$query_fetch->applied_at.'</td>
														<td class="text-center"><a href="'.$path.'/includes/resume-download?file_id='.$query_fetch->candidate_id.'"><span class="badge badge-pill badge-primary">Download</span></a></td>
														<td>';
															if($query_fetch->status == 'Applied')
															{
																echo '
																<span class="badge badge-lg badge-info">'.$query_fetch->status.'</span>';
															}
															elseif($query_fetch->status == 'Shortlisted')
															{
																echo '
																<span class="badge badge-lg badge-primary">'.$query_fetch->status.'</span>';
															}
															elseif($query_fetch->status == 'Selected')
															{
																echo '
																<span class="badge badge-lg badge-success">'.$query_fetch->status.'</span>';
															}
															elseif($query_fetch->status == 'Rejected')
															{
																echo '
																<span class="badge badge-lg badge-danger">'.$query_fetch->status.'</span>';
															}
														echo '
														</td>
														<td>
															<div class="btn-group">
															  	<button class="btn fix-gr-bg btn-rounded dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i> SELECT</button>
															  	<div class="dropdown-menu dropdown-menu-end" style="margin: 0px;">';
															  	if($query_fetch->status == 'Applied')
															  	{
															  		echo '
															  		<a class="dropdown-item" href="#shortlist'.$query_fetch->id.'" data-toggle="modal" data-target="#shortlistApplication'.$query_fetch->id.'">SHORTLISTED</a>
															  		<a class="dropdown-item" href="#select'.$query_fetch->id.'" data-toggle="modal" data-target="#selectApplication'.$query_fetch->id.'">SELECTED</a>
															  		<a class="dropdown-item" href="#reject'.$query_fetch->id.'" data-toggle="modal" data-target="#rejectApplication'.$query_fetch->id.'">REJECTED</a>
															  		<a class="dropdown-item" href="#delete'.$query_fetch->id.'" data-toggle="modal" data-target="#deleteApplication'.$query_fetch->id.'">DELETE</a>';
															  	}
															  	elseif($query_fetch->status == 'Shortlisted')
															  	{
															  		echo '
															  		<a class="dropdown-item" href="#select'.$query_fetch->id.'" data-toggle="modal" data-target="#selectApplication'.$query_fetch->id.'">SELECTED</a>
															  		<a class="dropdown-item" href="#reject'.$query_fetch->id.'" data-toggle="modal" data-target="#rejectApplication'.$query_fetch->id.'">REJECTED</a>
															  		<a class="dropdown-item" href="#delete'.$query_fetch->id.'" data-toggle="modal" data-target="#deleteApplication'.$query_fetch->id.'">DELETE</a>';
															  	}
															  	elseif($query_fetch->status == 'Selected' || $query_fetch->status == 'Rejected')
															  	{
															  		echo '
															  		<a class="dropdown-item" href="#delete'.$query_fetch->id.'" data-toggle="modal" data-target="#deleteApplication'.$query_fetch->id.'">DELETE</a>';
															  	}
																echo '
															  	</div>
															</div>
														</td>
													</tr>
													<!--DELETE Modal-->
													<div class="modal fade" id="deleteApplication'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
													aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header bg-danger">
																	<h5 class="modal-title" id="exampleModalLongTitle">DELETE JOB APPLICATION</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<i class="mdi mdi-close"></i>
																	</button>
																</div>
																<div class="modal-body">
																	Are you sure you want to delete?
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default">Close</button>
																	<a class="btn fix-gr-bg" href="'.$path.'/employer/jobs/applications?job_id='.$query_fetch->job_id.'&delete='.$query_fetch->id.'">Delete</a>
														  		</div>
															</div>
														</div>
													</div>

													<!--SHORTLISTED Modal-->
													<div class="modal fade" id="shortlistApplication'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
													aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header bg-danger">
																	<h5 class="modal-title" id="exampleModalLongTitle">SHORTLIST JOB APPLICATION</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<i class="mdi mdi-close"></i>
																	</button>
																</div>
																<div class="modal-body">
																	Are you sure?
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default">Close</button>
																	<a class="btn fix-gr-bg" href="'.$path.'/employer/jobs/applications?job_id='.$query_fetch->job_id.'&shortlist='.$query_fetch->id.'">Shortlist</a>
														  		</div>
															</div>
														</div>
													</div>

													<!--SELECTED Modal-->
													<div class="modal fade" id="selectApplication'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
													aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header bg-danger">
																	<h5 class="modal-title" id="exampleModalLongTitle">SELECT JOB APPLICATION</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<i class="mdi mdi-close"></i>
																	</button>
																</div>
																<div class="modal-body">
																	Are you sure?
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default">Close</button>
																	<a class="btn fix-gr-bg" href="'.$path.'/employer/jobs/applications?job_id='.$query_fetch->job_id.'&select='.$query_fetch->id.'">SELECT</a>
														  		</div>
															</div>
														</div>
													</div>

													<!--REJECTED Modal-->
													<div class="modal fade" id="rejectApplication'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
													aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header bg-danger">
																	<h5 class="modal-title" id="exampleModalLongTitle">REJECT JOB APPLICATION</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<i class="mdi mdi-close"></i>
																	</button>
																</div>
																<div class="modal-body">
																	Are you sure?
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default">Close</button>
																	<a class="btn fix-gr-bg" href="'.$path.'/employer/jobs/applications?job_id='.$query_fetch->job_id.'&reject='.$query_fetch->id.'">REJECT</a>
														  		</div>
															</div>
														</div>
													</div>';
												}
											}
											?>
											</tbody>
						  				</table>
									</div>
								</div>
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
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/datatable/datatables.min.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/script.js"></script>
</body>
</html>
