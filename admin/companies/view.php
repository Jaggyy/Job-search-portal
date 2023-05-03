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

<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/companies-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT companies.*, industries.industry,states.state,cities.city FROM companies LEFT JOIN industries ON companies.industry_id = industries.id LEFT JOIN states ON companies.state_id = states.id LEFT JOIN cities ON companies.city_id = cities.id WHERE companies.id = :id";
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
    <script src="<?php echo $path; ?>/admin/assets/js/vendors.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/toastr.min.js"></script>
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
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item" aria-current="page"><a href="<?php echo $path; ?>/admin/companies/manage">Companies</a></li>
										<li class="breadcrumb-item active" aria-current="page"><?php echo $query_fetch['companyname']; ?></li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<?php
				if(isset($_POST['verify']))
				{
					if($result)	
            		{
            			echo'
                        <script type="text/javascript">
                        	toastr.options.positionClass = "toast-top-right";
                            toastr.success("'.$success.'", "Success");
                    	</script>';
            		}
            		else
            		{
            			echo'
                        <script type="text/javascript">
                        	toastr.options.positionClass = "toast-top-right";
                            toastr.error("'.$error.'", "Error");
                    	</script>';
            		}
            	}
            	?>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12 col-sm-12">
				      		<div class="avatar-list-overlap mb-2">
						        <a class="mr-1" href="#">
						          	<img src="http://localhost/naukri/assets/images/logo/<?php echo $query_fetch['logo']; ?>" alt="<?php echo $query_fetch['companyname']; ?>" class="avatar rounded-circle" style="width: 17%; height: 200px;">
						        </a>
				      		</div>
				    	</div>
						<form method="post" action="" style="width: 80%;">
							<div class="col-md-3">
								<div class="d-flex justify-content-center">
									<div class="mt-2 mb-4">
										<?php
				            			if($query_fetch['verified'] == 0)
				            			{
				            				echo '
											<input type="hidden" name="verified" value="1">
											<button type="submit" name="verify" class="btn fix-gr-bg submit">
											  	<i class="ti-save-alt"></i> VERIFY ACCOUNT
											</button>';
										}
										else
										{
											echo '
											<button type="button" class="btn btn-secondary" disabled>VERIFIED
											</button>';
										}
										?>
									</div> 
								</div>
							</div>
	            		</form>
						<div class="col-12">
							<div class="box">
								<div class="card-body">
									<div class="row">
					          			<div class="col-12 col-md-12">
					          				<div class="row">
					          					<div class="col-md-6">
							            			<table class="table table-borderless">
							              				<tbody>
							                				<tr>
											                  	<th style="width: 160px;">Company Name:</th>
											                  	<td><?php echo $query_fetch['companyname']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Phone Number:</th>
											                  	<td class="users-view-latest-activity"><?php echo $query_fetch['phone']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Address:</th>
											                  	<td class="users-view-verified"><?php echo $query_fetch['city'].', '.$query_fetch['state'].', '.$query_fetch['country']; ?></td>
											                </tr>
											                <?php
											                if($query_fetch['status'] == 1)
											                {
											                	echo '
											                	<tr>
												                  	<th>Status:</th>
												                  	<td class="users-view-verified">Active</td>
												                </tr>';
											                }
											                ?>
							              				</tbody>
						            				</table>
						            			</div>
					          					<div class="col-md-6">
							            			<table class="table table-borderless">
							              				<tbody>
							                				<tr>
											                  	<th style="width: 160px;">Email ID:</th>
											                  	<td><?php echo $query_fetch['email']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Industry:</th>
											                  	<td class="users-view-latest-activity"><?php echo $query_fetch['industry']; ?></td>
											                </tr>
											                <tr>
											                  	<th>Created By:</th>
											                  	<td class="users-view-latest-activity"><?php echo $query_fetch['firstname'].' '.$query_fetch['lastname']; ?></td>
											                </tr>
											                <?php
											                if($query_fetch['is_featured'] == 1)
											                {
											                	echo '
											                	<tr>
												                  	<th>Featured:</th>
												                  	<td class="users-view-verified">Yes</td>
												                </tr>';
											                }
											                ?>
							              				</tbody>
						            				</table>
						            			</div>
						            		</div>
				            				<hr>
							            	<form id="content_form" class="form" method="post" action="">
				            					<div class="row">
				            						<div class="col-md-6">
														<div class="box-body">
														  	<div class="col-md-12">
														  		<div class="form-group">
																	<label class="form-label">Status</label>
																	<div class="c-inputs-stacked">
																		<input name="status" type="radio" id="active" class="with-gap radio-col-success" value="1" <?php echo $query_fetch['status'] == true ? 'checked' : ''; ?>>
																	  	<label class="me-30" for="active">Active</label>
																	  	<input name="status" type="radio" id="inactive" class="with-gap radio-col-danger" value="0" <?php echo $query_fetch['status'] == false ? 'checked' : ''; ?>>
																	  	<label for="inactive">In-Active</label>
																	</div>
																</div>
														  	</div>
														</div>
						            				</div>
						            			</div>
						            			<div class="box-footer">
													<button type="submit" class="btn fix-gr-bg submit">
													  	<i class="ti-save-alt"></i> UPDATE
													</button>
													<button type="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">
														<i class="ti-save-alt"></i> UPDATING...
													</button>
												</div>
											</form>
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
	<script type="text/javascript">
		toastr.options =
		{
		    "closeButton": true,
		    "progressBar": true,
		    "positionClass": "toast-top-right",
		    "timeOut": "2000",
		}

		/***************************Form Validation************************************/
		$(document).ready(function () {
		    _formValidation();
		});
		var _formValidation = function (form_id = '#content_form') {
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
	                                window.location.href = "<?php echo $path; ?>/admin/companies/view?id=<?php echo $_GET['id']; ?>";
	                            }, 2000);
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