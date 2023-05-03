<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'transactions';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
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
    <title>Transactions | Naukri</title>
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
							<h3 class="page-title">Transactions</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item active" aria-current="page">Transactions</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<!-- Main content -->
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
													<th>Transaction Type</th>
													<th>Company Name</th>
													<th class="text-center">Transaction Date</th>
													<th class="text-center">Amount</th>
													<th class="text-center">Invoice</th>
												</tr>
											</thead>
											<tbody>
											<?php
											$sql_retrieve = "SELECT revenue.*, companies.companyname FROM revenue LEFT JOIN companies ON revenue.company_id = companies.id";
											$query = $conn->prepare($sql_retrieve);
						                    $query->execute();
						                    $results=$query->fetchAll(PDO::FETCH_OBJ);
						                    if($query->rowCount() > 0)
						                    {
						                        foreach($results as $query_fetch)
						                        {
						                        	echo '
													<tr>';
														if($query_fetch->received_for == 'Featuring Job')
														{
															echo '<td>Job Feature</td>';
														}
														elseif($query_fetch->received_for == 'Featuring Company')
														{
															echo '<td>Company Feature</td>';
														}
														else
														{
															echo '<td>Company Subscription</td>';
														}
														echo '
														<td>'.$query_fetch->companyname.'</td>
														<td class="text-center">'.$query_fetch->created_at.'</td>
														<td class="text-center">'.$query_fetch->amount.'</td>
														<td class="text-center">
															<a href="'.$path.'/admin/transactions/invoice?id='.$query_fetch->id.'" target="_blank" title="View Invoice"><span class="badge badge-lg badge-success"><i class="mdi mdi-eye"></i></span></a>
														</td>
													</tr>';
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
