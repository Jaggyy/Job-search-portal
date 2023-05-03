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

<?php
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM admin WHERE id = :id";
$query = $conn->prepare($sql);
$query->bindParam(":id", $admin_id, PDO::PARAM_INT);
$query->execute();
$fetch = $query->fetch();
?>

<?php
$id = $_GET['id'];
$sql_retrieve = "SELECT companies.*, states.state, cities.city, revenue.id AS 'r_id', revenue.company_id, revenue.amount, revenue.received_for, revenue.created_at AS payment_date FROM companies LEFT JOIN states ON companies.state_id = states.id LEFT JOIN cities ON companies.city_id = cities.id LEFT JOIN revenue ON companies.id = revenue.company_id WHERE revenue.id = :id";
$statement = $conn->prepare($sql_retrieve);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$stmt = $statement->fetch();
$rid = $stmt['r_id'];
$invoice = date('Y').'-'.sprintf('%04d', $rid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
    <title>Invoice-<?php echo $invoice; ?> | Naukri</title>
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
		<div class="container mt-75">
			<!-- Main content -->
			<section class="invoice printableArea">
			  	<div class="row">
					<div class="col-12">
				  		<div class="page-header">
							<h2 class="d-inline"><span class="fs-30">Invoice</span></h2>
							<div class="pull-right text-right">
								<h3><?php echo date("jS F Y"); ?></h3>
							</div>	
				  		</div>
					</div>
					<!-- /.col -->
			  	</div>
			  	<div class="row invoice-info">
					<div class="col-md-6 invoice-col">
					  	<strong>From</strong>	
					  	<address>
							<strong class="text-blue fs-24">Naukri</strong><br>
							<strong>Email: <?php echo $fetch['email']; ?></strong>  
					  	</address>
					</div>
					<!-- /.col -->
					<div class="col-md-6 invoice-col text-right">
						<strong>To</strong>
						<address>
							<strong class="text-blue fs-24"><?php echo $stmt['companyname']; ?></strong><br>
							<?php echo $stmt['city'].', '.$stmt['state'].', '.$stmt['country']; ?><br>
							<strong>Phone: +91 <?php echo $stmt['phone']; ?> &nbsp;&nbsp;&nbsp;&nbsp; Email: <?php echo $stmt['email']; ?></strong>
				  		</address>
					</div>
					<!-- /.col -->
					<div class="col-sm-12 invoice-col mb-15">
						<div class="invoice-details row no-margin">
							<div class="col-md-6 col-lg-4"><b>Invoice </b>#<?php echo $invoice; ?></div>
							<div class="col-md-6 col-lg-4"><b>Date Paid:</b> <?php echo $stmt['payment_date']; ?></div>
							<div class="col-md-6 col-lg-4"><b>Payment Method:</b> Credit/Debit Card</div>
						</div>
					</div>
				  	<!-- /.col -->
			  	</div>
			  	<div class="row">
					<div class="col-12 table-responsive">
				  		<table class="table table-bordered">
							<tbody>
								<tr>
									<th>#</th>
									<th>Description</th>
									<th class="text-right">Quantity</th>
									<th class="text-right">Unit Price</th>
									<th class="text-right">Subtotal</th>
								</tr>
								<tr>
									<td>1</td>
									<td><?php echo $stmt['received_for']; ?></td>
									<td class="text-right">1</td>
									<td class="text-right">Rs. <?php echo $stmt['amount']; ?></td>
									<td class="text-right">Rs. <?php echo $stmt['amount']; ?></td>
								</tr>
							</tbody>
				  		</table>
					</div>
					<!-- /.col -->
			  	</div>
			  	<div class="row">
					<div class="col-12 text-right">
						<div>
							<p>Sub-Total  :  Rs. <?php echo $stmt['amount']; ?></p>
						</div>
						<div class="total-payment">
							<h3><b>Amount paid :</b> Rs. <?php echo $stmt['amount']; ?></h3>
						</div>
					</div>
					<!-- /.col -->
			  	</div>
			  	<div class="row no-print">
					<div class="col-12">
					  	<div class="bb-1 clearFix">
							<div class="text-right pb-15">
								<button id="print2" class="btn btn-warning" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
							</div>	
					  	</div>
					</div>
				</div>
			</section>
			<!-- /.content -->
		</div>
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
    <script src="<?php echo $path; ?>/admin/assets/vendor_plugins/JqueryPrintArea/demo/jquery.PrintArea.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/script.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/pages/invoice.js"></script>
</body>
</html>