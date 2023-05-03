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
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/employer/includes/package-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT * FROM plans WHERE id = :id";
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
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/employer/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/employer/subscriptions/manage">Subscriptions</a></li>
										<li class="breadcrumb-item active" aria-current="page">Payment</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<?php
			    if(isset($_POST['submit']))
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
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
							  	<div class="box-body">
									<h4 class="box-title mb-15">Payment</h4>
									<!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
										<li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#debit-card" role="tab"><span class="hidden-sm-up"><i class="fa fa-cc"></i></span> <span class="hidden-xs-down">Debit Card</span></a> </li>
									</ul>

									<!-- Tab panes -->
									<div class="tab-content tabcontent-border">
										<div class="tab-pane active" id="debit-card" role="tabpanel">
											<div class="p-30">
												<div class="row">
													<div class="col-lg-7 col-md-6 col-12">
														<form method="post" action="">
															<input type="hidden" name="package_id" value="<?php echo $_GET['id']; ?>">
															<input type="hidden" name="amount" value="<?php echo $query_fetch['amount']; ?>">
															<input type="hidden" name="plan" value="<?php echo $query_fetch['plan']; ?>">
															<div class="form-group">
																<label for="exampleInputEmail1" class="form-label">CARD NUMBER</label>
																<div class="input-group">
																	<div class="input-group-addon"><i class="fa fa-credit-card"></i></div>
																	<input type="text" class="form-control" id="exampleInputuname" placeholder="Card Number" required> 
																</div>
															</div>
															<div class="row">
																<div class="col-7">
																	<div class="form-group">
																		<label class="form-label">EXPIRATION DATE</label>
																		<input type="text" class="form-control" name="Expiry" placeholder="MM / YY" required> 
																	</div>
																</div>
																<div class="col-5 pull-right">
																	<div class="form-group">
																		<label class="form-label">CV CODE</label>
																		<input type="text" class="form-control" name="CVV" placeholder="CVC" required> 
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-12">
																	<div class="form-group">
																		<label class="form-label">NAME OF CARD</label>
																		<input type="text" class="form-control" name="nameCard" placeholder="NAME OF CARD" required> 
																	</div>
																</div>
															</div>
															<button type="submit" name="submit" class="btn btn-success submit">
															  	Pay Rs. <?php echo $query_fetch['amount']; ?>
															</button>
														</form>
													</div>
													<div class="col-lg-5 col-md-6 col-12">
														<h3 class="box-title mt-10 text-danger">NOTE</h3>
														<p class="text-danger">This is only for demo purpose. These data will not be stored in the database.</p>
													</div>
												</div>
											</div>
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
</body>
</html>
