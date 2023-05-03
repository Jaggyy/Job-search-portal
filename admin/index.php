<?php
session_start();
error_reporting(E_ALL);
$path = 'http://localhost/naukri';
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{   
    header('location:'.$path.'/admin/dashboard');
    exit();
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/admin-login-script.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/images/favicon.png">
    <title>Admin Login | Naukri</title>
	<!-- Vendors Style-->
	<link rel="stylesheet" href="assets/css/vendors_css.css">
	<link rel="stylesheet" href="assets/vendor_components/bootstrap/dist/css/bootstrap.css">
	<!-- Style-->  
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/skin_color.css">	
	<script src="assets/js/vendors.min.js"></script>
    <link rel="stylesheet" href="assets/css/toastr.min.css">
    <script src="assets/js/toastr.min.js"></script>
</head>
<body class="hold-transition theme-primary bg-img" style="background-image: url(assets/images/auth-bg/bg-1.jpg)">
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">	
			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<a href="<?php echo $path; ?>"><img src="assets/images/naukri-logo.png" style="width: 50%;"></a>
								<h3 class="text-primary">Admin Login</h3>					
							</div>
							<div class="p-40">
								<form id="login_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											<input type="email" name="email" id="email" class="form-control ps-15 bg-transparent" placeholder="Email ID" required>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
											<input type="password" name="password" id="password" class="form-control ps-15 bg-transparent" placeholder="Password" required>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
										 	<div class="fog-pwd text-end">
												<a href="javascript:void(0)" class="hover-warning"><i class="ion ion-locked"></i> Forgot pwd?</a><br>
										  	</div>
										</div>
										<!-- /.col -->
										<div class="col-12 text-center">
										  	<button type="submit" class="btn fix-gr-bg mt-10 submit">SIGN IN</button>
										  	<button type="submit" class="btn fix-gr-bg mt-10 submitting" disabled style="display: none;">SIGNING IN...</button>
										</div>
										<!-- /.col -->
									</div>
								</form>	
								<?php
                                $sql_retrieve = "SELECT * FROM admin";
                                $query = $conn->prepare($sql_retrieve);
                                $query->execute();
                                $results = $query->fetch();
                                if($query->rowCount() == 0)
                                {
                                ?>
									<div class="text-center">
										<p class="mt-15 mb-0">Don't have an account? <a href="register.php" class="hover-warning ms-5">Sign Up</a></p>
									</div>
								<?php
								}
								?>
							</div>						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Vendor JS -->
	<script src="assets/js/pages/chat-popup.js"></script>
    <script src="assets/icons/feather-icons/feather.min.js"></script>	
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
        var _formValidation = function (form_id = '#login_form') {
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
