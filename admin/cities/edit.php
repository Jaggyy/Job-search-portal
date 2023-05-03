<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'cities';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/cities-update-script.php'); ?>
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
							<h3 class="page-title">Edit City</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item" aria-current="page"><a href="<?php echo $path; ?>/admin/cities/manage">Cities</a></li>
										<li class="breadcrumb-item active" aria-current="page">Edit City</li>
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
								<?php
								$sql_retrieve = "SELECT cities.state_id,cities.country,cities.city,states.state,states.id AS sid FROM cities LEFT JOIN states ON cities.state_id = states.id WHERE cities.id = :id";
								$query = $conn->prepare($sql_retrieve);
								$query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
								$query->execute();
								$query_fetch = $query->fetch();
								?>
								<!-- /.box-header -->
								<form id="content_form" class="form" method="post" action="">
									<div class="box-body">
									  	<div class="col-md-12">
											<div class="form-group">
											  	<label class="form-label">Country</label>
											  	<input id="country" type="text" class="form-control rounded30" name="country" value="<?php echo $query_fetch['country']; ?>" required readonly>
											</div>
									  	</div>
									  	<div class="col-md-12">
											<div class="form-group">
											  	<label class="form-label">State</label>
											  	<select name="state_id" id="state_id" class="form-control rounded30" required>
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
									  	<div class="col-md-12">
											<div class="form-group">
											  	<label class="form-label">City</label>
											  	<input id="city" type="text" class="form-control rounded30" name="city" value="<?php echo $query_fetch['city']; ?>" required>
											</div>
									  	</div>
									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" class="btn fix-gr-bg submit">
										  	<i class="ti-save-alt"></i> UPDATE
										</button>
										<button type="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">
											<i class="ti-save-alt"></i> UPDATING...
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
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/datatable/datatables.min.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/script.js"></script>
</body>
</html>