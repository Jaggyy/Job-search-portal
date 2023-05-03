<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'resume_builder';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["candidate_login"]) || $_SESSION["candidate_login"] !== true)
{   
	header('location:http://localhost/naukri/candidate');
	exit();
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/experience-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT manage_candidate_experiences.*, states.state, cities.city FROM manage_candidate_experiences LEFT JOIN states ON manage_candidate_experiences.state_id = states.id LEFT JOIN cities ON manage_candidate_experiences.city_id = cities.id WHERE manage_candidate_experiences.id = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
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
    <title>Edit Experience | Naukri</title>
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
							<h3 class="page-title">Edit Experience</h3>
						</div>
					</div>
				</div>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<!-- /.box-header -->
								<form id="content_form" method="post" action="">
									<div class="box-body">
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Experience Title</label>
												  	<input id="experience_title" type="text" class="form-control" name="experience_title" value="<?php echo $row['experience_title']; ?>" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Company</label>
												  	<input id="company" type="text" class="form-control" name="company" value="<?php echo $row['company']; ?>" required>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">State</label>
												  	<select name="state_id" id="state_id" class="form-control" >
														<option value="<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM states WHERE id != '".$row['state_id']."'";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $result = $rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($result as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->state.'</option>';
								                            }
								                        }
								                        ?>
													</select>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">City</label>
												  	<select name="city_id" id="city_id" class="form-control" >
												  		<option value="<?php echo $row['city_id'];?>"><?php echo $row['city'];?></option>
                                                        <?php
                                                        $sql = "SELECT * FROM cities WHERE id != '".$row['city_id']."' AND state_id = '".$row['state_id']."'";
                                                        $res = $conn->prepare($sql);
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
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Start Date</label>
												  	<input id="start_date" type="date" class="form-control" name="start_date" value="<?php echo $row['start_date']; ?>" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">End Date</label>
												  	<input id="end_date" type="date" class="form-control" name="end_date" value="<?php echo $row['end_date']; ?>" required>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-12">
												<div class="form-group">
												  	<label class="form-label">Description</label>
												  	<textarea name="description" id="description" class="form-control" required><?php echo $row['description']; ?></textarea>
												</div>
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
	  	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/footer.php'); ?>
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
    </script>
    <script>
	    $(document).ready(function () {
	        _formValidation();
	    });
	</script>
	<script type="text/javascript">
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
	                                window.location.href = "<?php echo $path; ?>/candidate/resume-builder";
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
