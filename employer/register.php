<?php
session_start();
error_reporting(E_ALL);
$path = 'http://localhost/naukri';
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
if(isset($_SESSION["login"]) && $_SESSION["login"] === true)
{   
    header('location:'.$path.'/employer/dashboard');
    exit();
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/employer/includes/company-register-script.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Job Search - Latest Job Openings | Naukri</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/bootstrap-grid.css" />
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/icons.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/animate.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/responsive.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/colors/colors.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>/assets/css/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/fonts/font-awesome/4.5.0/css/font-awesome.min.css" />
	<script src="<?php echo $path; ?>/assets/js/jquery.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="<?php echo $path; ?>/assets/css/toastr.min.css">
    <script src="<?php echo $path; ?>/assets/js/toastr.min.js"></script>
</head>
<body class="newbg" style="background-image: url('<?php echo $path; ?>/assets/images/resource/body-bg.jpg')">
<div class="page-loading">
	<img src="<?php echo $path; ?>/assets/images/loader.gif" alt="" />
</div>

<div class="theme-layout" id="scrollup">
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-responsive.php'); ?>

	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-1.php'); ?>

	<section>
        <div class="block remove-bottom">
            <div class="container">
                <div class="row d-flex justify-content-center mb-5">
                    <div class="col-lg-9">
                        <div class="account-popup-area signup-popup-box static pt-3" style="border-radius: 5px;">
                            <div class="account-popup pb-3 mb-4">
                                <h5 class="text-left font-weight-bold mb-3">Sign Up</h5>
                                <form id="register_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                	<div class="row">
                                		<div class="col-md-6">
		                                    <div class="cfield">
		                                        <input type="text" name="firstname" id="firstname" placeholder="First Name" required />
		                                        <i class="la la-user"></i>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                    <div class="cfield">
		                                        <input type="text" name="lastname" id="lastname" placeholder="Last Name" required />
		                                        <i class="la la-user"></i>
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="row">
                                		<div class="col-md-6">
		                                    <div class="cfield">
		                                        <input type="text" name="email" id="email" placeholder="Email ID" required />
		                                        <i class="la la-envelope"></i>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                    <div class="cfield">
		                                        <input type="text" name="phone" id="phone" placeholder="Contact Number" required />
		                                        <i class="la la-phone"></i>
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="row">
                                		<div class="col-md-6">
		                                    <div class="cfield">
		                                        <input type="text" name="companyname" id="companyname" placeholder="Company Name" required />
		                                        <i class="la la-user"></i>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                	<div class="cfield" style="border: none;">
					 							<select name="industry_id" id="industry_id" class="chosen" required style="display: none;">
					 								<option value="">Select Industry</option>
													<?php
													$query = "SELECT * FROM industries WHERE status =1 ORDER BY industry";
													$result = $conn->prepare($query);
													$result->execute();
													$results=$result->fetchAll(PDO::FETCH_OBJ);
								                    if($result->rowCount() > 0)
								                    {
								                        foreach($results as $query_fetch)
								                        {
								                        	echo '
															<option value="'.$query_fetch->id.'">'.$query_fetch->industry.'</option>';
														}
													}
													?>
												</select>
					 						</div>
		                                </div>
		                            </div>
		                            <div class="row">
                                		<div class="col-md-6">
		                                    <div class="cfield">
		                                        <input type="text" name="country" id="country" value="India" required readonly />
		                                        <i class="la la-globe"></i>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                	<div class="cfield" style="border: none;">
					 							<select name="state_id" id="state_id" class="chosen" required style="display: none;">
					 								<option value="">Select State</option>
													<?php
													$query = "SELECT * FROM states ORDER BY state";
													$result = $conn->prepare($query);
													$result->execute();
													$results=$result->fetchAll(PDO::FETCH_OBJ);
								                    if($result->rowCount() > 0)
								                    {
								                        foreach($results as $query_fetch)
								                        {
								                        	echo '
															<option value="'.$query_fetch->id.'">'.$query_fetch->state.'</option>';
														}
													}
													?>
												</select>
					 						</div>
		                                </div>
		                            </div>
		                            <div class="row">
                                		<div class="col-md-6">
		                                    <div class="cfield">
		                                    	<select name="city_id" id="city_id" required>
		                                    	</select>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                	<div class="cfield">
					 							<input type="file" name="logo" id="logo" required style="display: none;" />
					 							<label class="label_file" for="logo">Upload Company Logo</label>
					 							<i class="la la-support"></i>
					 						</div>
		                                </div>
		                            </div>
		                            <div class="row">
                                		<div class="col-md-6">
		                                    <div class="cfield">
		                                    	<input type="password" name="password" id="password" placeholder="Password" required />
		                                        <i class="la la-key"></i>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                	<div class="cfield">
		                                    	<input type="password" name="confirmpassword" id="confirmpassword" placeholder="Repeat Password" required />
		                                        <i class="la la-key"></i>
		                                    </div>
		                                </div>
		                            </div>
                                    <div class="pf-field">
                                    	<textarea name="description" id="description" placeholder="Description" required></textarea>
                                    </div>
                                    <button type="submit" id="submit" class="btn fix-gr-bg submit">SIGN UP</button>
									<button type="submit" id="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">LOADING...</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<footer>
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 column">
						<div class="widget">
							<div class="about_widget">
								<div class="logo">
									<a href="index-2.html" title=""><img src="images/resource/logo.png" alt="" /></a>
								</div>
								<span>Collin Street West, Victor 8007, Australia.</span>
								<span>+1 246-345-0695</span>
								<span><a href="https://grandetest.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d0b9beb6bf90babfb2b8a5bea4feb3bfbd">[email&#160;protected]</a></span>
								<div class="social">
									<a href="#" title=""><i class="fa fa-facebook"></i></a>
									<a href="#" title=""><i class="fa fa-twitter"></i></a>
									<a href="#" title=""><i class="fa fa-linkedin"></i></a>
									<a href="#" title=""><i class="fa fa-pinterest"></i></a>
									<a href="#" title=""><i class="fa fa-behance"></i></a>
								</div>
							</div><!-- About Widget -->
						</div>
					</div>
					<div class="col-lg-4 column">
						<div class="widget">
							<h3 class="footer-title">Frequently Asked Questions</h3>
							<div class="link_widgets">
								<div class="row">
									<div class="col-lg-6">
										<a href="#" title="">Privacy & Seurty </a>
										<a href="#" title="">Terms of Serice</a>
										<a href="#" title="">Communications </a>
										<a href="#" title="">Referral Terms </a>
										<a href="#" title="">Lending Licnses </a>
										<a href="#" title="">Disclaimers </a>	
									</div>
									<div class="col-lg-6">
										<a href="#" title="">Support </a>
										<a href="#" title="">How It Works </a>
										<a href="#" title="">For Employers </a>
										<a href="#" title="">Underwriting </a>
										<a href="#" title="">Contact Us</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-2 column">
						<div class="widget">
							<h3 class="footer-title">Find Jobs</h3>
							<div class="link_widgets">
								<div class="row">
									<div class="col-lg-12">
										<a href="#" title="">US Jobs</a>	
										<a href="#" title="">Canada Jobs</a>	
										<a href="#" title="">UK Jobs</a>	
										<a href="#" title="">Emplois en Fnce</a>	
										<a href="#" title="">Jobs in Deuts</a>	
										<a href="#" title="">Vacatures China</a>	
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 column">
						<div class="widget">
							<div class="download_widget">
								<a href="#" title=""><img src="images/resource/dw1.png" alt="" /></a>
								<a href="#" title=""><img src="images/resource/dw2.png" alt="" /></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bottom-line">
			<span>© 2018 Jobhunt All rights reserved. Design by Creative Layers</span>
			<a href="#scrollup" class="scrollup" title=""><i class="la la-arrow-up"></i></a>
		</div>
	</footer>
</div>


<script src="<?php echo $path; ?>/assets/js/modernizr.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/script.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/wow.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/slick.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/parallax.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/select-chosen.js" type="text/javascript"></script>
<script type="text/javascript">
	$("[type=file]").on("change", function(){
		var file = this.files[0].name;
		var dflt = $(this).attr("placeholder");
		if($(this).val()!=""){
			$(this).next().text(file);
		} else {
			$(this).next().text(dflt);
		}
	});
</script>
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
	toastr.options =
    {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right"
    }
    var _formValidation = function (form_id = '#register_form') {
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
                                window.location.href = "<?php echo $path; ?>/employer";
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