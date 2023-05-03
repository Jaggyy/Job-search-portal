<?php
session_start();
error_reporting(E_ALL);
$path = 'http://localhost/naukri';
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
if(isset($_SESSION["candidate_login"]) && $_SESSION["candidate_login"] === true)
{   
    header('location:'.$path.'/candidate/dashboard');
    exit();
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/candidate/includes/candidate-login-script.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Jobseeker's Sign In | Naukri</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/bootstrap-grid.css" />
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/icons.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/animate.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/colors/colors.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/fonts/font-awesome/4.5.0/css/font-awesome.min.css" />
	<script src="<?php echo $path; ?>/assets/js/jquery.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/toastr.min.css">
    <script src="<?php echo $path; ?>/assets/js/toastr.min.js"></script>
</head>
<body class="newbg">
<div class="page-loading">
	<img src="<?php echo $path; ?>/assets/images/loader.gif" alt="" />
</div>

<div class="theme-layout" id="scrollup">
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-responsive.php'); ?>
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-1.php'); ?>

	<section>
		<div class="block no-padding">
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="main-featured-sec">
							<div class="new-slide-3">
								<img src="<?php echo $path; ?>/assets/images/resource/vector-4.png">
							</div>
							<div class="job-search-sec">
								<div class="col-lg-6">
			                        <div class="account-popup-area signup-popup-box static pt-3">
			                            <div class="account-popup pb-3 mb-4" style="border-bottom: 2px solid #ddd9d9">
											<h3>Login</h3>
			                                <form id="login_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			                                    <div class="cfield">
			                                        <input type="email" name="email" id="email" placeholder="Email ID" required>
			                                        <i class="la la-user"></i>
			                                    </div>
			                                    <div class="cfield">
			                                        <input type="password" name="password" id="password" placeholder="Password" required>
			                                        <i class="la la-key"></i>
			                                    </div>
			                                    <button type="submit" class="btn fix-gr-bg submit">SIGN IN</button>
										  		<button type="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">SIGNING IN...</button>
			                                </form>
			                            </div>
			                            <div class="account-popup p-0 mb-4">
			                                <span>New User? <a href="<?php echo $path; ?>/candidate/register">Sign Up</a></span>
			                            </div>
			                        </div><!-- SIGNUP POPUP -->
			                    </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/footer.php'); ?>
</div>

<script src="<?php echo $path; ?>/assets/js/modernizr.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/script.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/wow.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/slick.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/parallax.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/select-chosen.js" type="text/javascript"></script>
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
        "positionClass": "toast-top-left"
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
                                window.location.href = "<?php echo $path; ?>/candidate/dashboard";
                            }, 5000);
                    	}
                    	else if(data.error)
                    	{
                            form.find('.submit').show();
                            form.find('.submitting').hide();
                            toastr.error(data.error);
                    	}
                    	else if(data.info)
                    	{
                            form.find('.submit').show();
                            form.find('.submitting').hide();
                            toastr.warning(data.info, data.title);
                    	}
                    }
                });
            });
        }
    };
</script>
</body>
</html>