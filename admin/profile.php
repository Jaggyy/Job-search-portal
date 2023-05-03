<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = '';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
$admin_id = $_SESSION['admin_id'];
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/profile-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT * FROM admin WHERE id = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $admin_id, PDO::PARAM_INT);
$query->execute();
$row=$query->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
    <title>Admin Profile | Naukri</title>
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
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper">
		  	<div class="container-full">
		  		<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex justify-content-center">
						<div class="me-auto">
							<h3 class="page-title">EDIT PROFILE</h3>
						</div>
					</div>
				</div>
				<?php
				if(isset($_POST['update']))
				{
					if($firstname == null || $lastname == null || $email == null)
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$empty.'", "Error");
                    	</script>';
					}
					elseif(!filter_var($email, FILTER_SANITIZE_EMAIL))
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$email_error.'", "Error");
                    	</script>';
					}
					elseif(empty($empty) && empty($email_error))
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
				}
				?>
				<!-- Main content -->
				<section class="content">
					<div class="row d-flex justify-content-center">
						<div class="col-8">
							<div class="box">
								<div class="box-body">
									<div class="vtabs col-md-12">
										<ul class="nav nav-tabs tabs-vertical" role="tablist">
											<li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab"><span><i class="ion-person me-15"></i>Profile</span></a> </li>
											<li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab"><span><i class="mdi mdi-lock me-15"></i>Change Password</span></a> </li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
											<div class="tab-pane active" id="profile" role="tabpanel">
												<form id="profile_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
													<div class="box-body pt-0">
													  	<div class="col-md-12">
															<div class="form-group">
															  	<label class="form-label">First Name</label>
															  	<input id="firstname" type="text" class="form-control" name="firstname" value="<?php echo $row['firstname']; ?>" required>
															</div>
													  	</div>
													  	<div class="col-md-12">
															<div class="form-group">
															  	<label class="form-label">Last Name</label>
															  	<input id="lastname" type="text" class="form-control" name="lastname" value="<?php echo $row['lastname']; ?>" required>
															</div>
													  	</div>
													  	<div class="col-md-12">
															<div class="form-group">
															  	<label class="form-label">Email ID</label>
															  	<input id="email" type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
															</div>
													  	</div>
													</div>
													<!-- /.box-body -->
													<div class="box-footer">
														<button type="submit" name="update" class="btn fix-gr-bg submit">UPDATE</button>
													</div>  
												</form>
											</div>
											<div class="tab-pane" id="changePassword" role="tabpanel">
												<form id="password_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
													<div class="box-body pt-0">
													  	<div class="col-md-12">
															<div class="form-group">
															  	<label class="form-label">Current Password</label>
															  	<input id="password" type="password" class="form-control" name="password" placeholder="Current Password" required>
															</div>
													  	</div>
													  	<div class="col-md-12">
															<div class="form-group">
															  	<label class="form-label">New Password</label>
															  	<input id="newpassword" type="password" class="form-control" name="newpassword" placeholder="New Password" required>
															</div>
													  	</div>
													  	<div class="col-md-12">
															<div class="form-group">
															  	<label class="form-label">Confirm New Password</label>
															  	<input id="confirmpassword" type="password" class="form-control" name="confirmpassword" placeholder="Confirm New Password" required>
															</div>
													  	</div>
													</div>
													<!-- /.box-body -->
													<div class="box-footer">
														<button type="submit" id="submit" class="btn fix-gr-bg submit">UPDATE</button>
														<button type="submit" id="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">UPDATING...</button>
													</div>  
												</form>
											</div>
										</div>
									</div>
								</div>
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
    <script>
	    $(document).ready(function () {
	        _formValidation();
	    });
	</script>
	<script type="text/javascript">
		toastr.options =
	    {
	        "closeButton": true,
	        "progressBar": true,
	        "positionClass": "toast-top-right"
	    }
	    var _formValidation = function (form_id = '#password_form') {
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
	                                window.location.href = "<?php echo $path; ?>/admin/dashboard";
	                            }, 5000);
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
