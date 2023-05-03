<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'companies';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
?>

<?php
if(isset($_GET['del']))
{
	$id = $_GET['id'];
	$delete_sql = "DELETE FROM companies WHERE id= :id";
	$delete = $conn->prepare($delete_sql);
	$delete->bindParam(':id', $id, PDO::PARAM_INT);
	if($delete->execute())
	{
		$delMsg = "Deletion Successfull.";
		header('Refresh:2;url='.$path.'/admin/companies/manage');
	}
	else
	{
	    $delError = "Something Went Wrong! Try again..";
		header('Refresh:2;url='.$path.'/admin/companies/manage');
	}
}
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
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper">
		  	<div class="container-full">
		  		<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<h3 class="page-title">Companies</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item active" aria-current="page">Companies</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!-- Main content -->
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
													<th>Company</th>
													<th>Status</th>
													<th>Featured</th>
													<th>Verified</th>
													<th>Options</th>
												</tr>
											</thead>
											<tbody>
											<?php
											$sql_retrieve = "SELECT * FROM companies ORDER BY companyname";
											$query = $conn->prepare($sql_retrieve);
						                    $query->execute();
						                    $results=$query->fetchAll(PDO::FETCH_OBJ);
						                    if($query->rowCount() > 0)
						                    {
						                        foreach($results as $query_fetch)
						                        {
						                        	echo '
													<tr>
														<td><img class="avatar avatar-lg mr-2" src="http://localhost/naukri/assets/images/logo/'.$query_fetch->logo.'">'.$query_fetch->companyname.'</td>';
														?>
														<td>
															<div class="switch">
		                                                        <label>
		                                                            <input type="checkbox" class="status_update" data-id="<?php echo $query_fetch->id; ?>" <?php echo $query_fetch->status == true ? 'checked' : ''; ?>>
		                                                            <span class="lever"></span>
		                                                        </label>
		                                                    </div>
														</td>
														<td>
															<div class="switch">
		                                                        <label>
		                                                            <input type="checkbox" class="feature_update" data-id="<?php echo $query_fetch->id; ?>" <?php echo $query_fetch->is_featured == true ? 'checked' : ''; ?>>
		                                                            <span class="lever"></span>
		                                                        </label>
		                                                    </div>
														</td>
														<td>
															<div class="switch">
		                                                        <label>
		                                                            <input type="checkbox" class="verified" data-id="<?php echo $query_fetch->id; ?>" <?php echo $query_fetch->verified == true ? 'checked' : ''; ?>>
		                                                            <span class="lever"></span>
		                                                        </label>
		                                                    </div>
														</td>
														<?php
														echo '
														<td>
															<div class="btn-group">
															  	<button class="btn fix-gr-bg btn-rounded dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i> SELECT</button>
															  	<div class="dropdown-menu dropdown-menu-end" style="margin: 0px;">
																	<a class="dropdown-item" href="'.$path.'/admin/companies/view?id='.$query_fetch->id.'">VIEW</a>
																	<a class="dropdown-item" href="#delete'.$query_fetch->id.'" data-toggle="modal" data-target="#deleteCompany'.$query_fetch->id.'">DELETE</a>
															  	</div>
															</div>
														</td>
													</tr>
													<!--Modal-->
													<div class="modal fade" id="deleteCompany'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
													aria-hidden="true">
														<div class="modal-dialog modal-dialog-centered" role="document">
															<div class="modal-content">
																<div class="modal-header bg-danger">
																	<h5 class="modal-title" id="exampleModalLongTitle">DELETE COMPANY</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<i class="mdi mdi-close"></i>
																	</button>
																</div>
																<div class="modal-body">
																	Are you sure you want to delete?
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default">Close</button>
																	<a class="btn fix-gr-bg" href="'.$path.'/admin/companies/manage?id='.$query_fetch->id.'&del=delete">Delete</a>
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
