<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
?>

<?php
$id = $_GET['id'];
$visited_on = date('F d, Y');
if(!empty($_SERVER["HTTP_CLIENT_IP"]))
{
	$visitor_ip = $_SERVER["HTTP_CLIENT_IP"];
}
else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
{
	$visitor_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else
{
	$visitor_ip = $_SERVER['REMOTE_ADDR'];
}

//checking if visitor is unique
$check_visitor = "SELECT * FROM page_visitor WHERE ip_address = :ip_address AND candidate_id = :candidate_id";
$result = $conn->prepare($check_visitor);
$result->bindParam(":ip_address", $visitor_ip, PDO::PARAM_STR);
$result->bindParam(":candidate_id", $id, PDO::PARAM_INT);
$result->execute();
$total_visitors = $result->rowCount();
if($total_visitors < 1) 
{
	$insert_visitor = "INSERT INTO page_visitor (candidate_id, ip_address, visited_on) VALUES (:candidate_id, :ip_address, :visited_on)";
	$statement = $conn->prepare($insert_visitor);
	$statement->bindParam(":candidate_id", $id, PDO::PARAM_INT);
	$statement->bindParam(":ip_address", $visitor_ip, PDO::PARAM_STR);
	$statement->bindParam(":visited_on", $visited_on, PDO::PARAM_STR);
	$statement->execute();
}


$sql_retrieve = "SELECT candidates.*, states.state, cities.city, functional_areas.functional_area, industries.industry, job_experiences.job_experience FROM candidates LEFT JOIN states ON candidates.state_id = states.id LEFT JOIN cities ON candidates.city_id = cities.id LEFT JOIN functional_areas ON candidates.functional_area_id = functional_areas.id LEFT JOIN industries ON candidates.industry_id = industries.id LEFT JOIN job_experiences ON candidates.job_experience_id = job_experiences.id WHERE candidates.id = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$fetch = $query->fetch();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
	<title><?php echo $fetch['firstname'].' '.$fetch['lastname']; ?> | Naukri</title>
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
<body>

<div class="page-loading">
	<img src="<?php echo $path; ?>/assets/images/loader.gif" alt="" />
	<span>Skip Loader</span>
</div>

<div class="theme-layout" id="scrollup">
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-responsive.php'); ?>
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-1.php'); ?>

	<section class="overlape">
		<div class="block no-padding">
			<div data-velocity="-.1" style="background: linear-gradient(45deg, rgb(218, 43, 225) 0%,rgb(0, 96, 246) 71%,rgb(189, 11, 61) 100%)" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header" style="padding-top: 130px;">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="overlape">
		<div class="block remove-top">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="cand-single-user">
							<div class="share-bar circle"></div>
				 			<div class="can-detail-s">
				 				<div class="cst"><img src="<?php echo $path; ?>/assets/images/profile_picture/<?php echo $fetch['photo']; ?>" alt="" /></div>
				 				<h3><?php echo $fetch['firstname'].' '.$fetch['lastname']; ?></h3>
				 				<p><i class="la la-envelope-o"></i><?php echo $fetch['email']; ?></p>
				 				<p><i class="la la-phone"></i>+91 <?php echo $fetch['phone']; ?></p>
				 				<p><i class="la la-map-marker"></i><?php echo $fetch['city'].', '.$fetch['state']; ?></p>
				 				<?php
	 							$sql = "SELECT job_skills.*, manage_candidate_skills.candidate_skill_id FROM job_skills LEFT JOIN manage_candidate_skills ON job_skills.id = manage_candidate_skills.candidate_skill_id WHERE manage_candidate_skills.candidate_id = :candidate_id";
	 							$run_sql = $conn->prepare($sql);
	 							$run_sql->bindParam(":candidate_id", $id, PDO::PARAM_INT);
	 							$run_sql->execute();
								$count = $run_sql->rowCount();
								if($count > 0)
			                    {
									$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
			                        echo '
						 			<div class="skills-badge">';
						 			foreach($fetch_result as $query_fetch)
			                        {
			                        	echo '
						 				<span>'.$query_fetch->job_skill.'</span>';
						 			}
						 			echo '</div>';
						 		}
						 		?>
				 			</div>
				 			<div class="download-cv"></div>
				 		</div>
				 		<div class="cand-details-sec">
				 			<div class="row d-flex justify-content-center no-gape">
				 				<div class="col-lg-9 column">
				 					<div class="cand-details">
				 						<div class="job-overview style2">
								 			<ul>
								 				<li><i class="la la-user"></i><h3>Father's Name</h3><span><?php echo $fetch['fathername']; ?></span></li>
								 				<li><i class="la la-calendar-o"></i><h3>Date of Birth</h3><span><?php echo $fetch['dob']; ?></span></li>
								 				<li><i class="la la-mars-double"></i><h3>Gender</h3><span><?php echo $fetch['gender']; ?></span></li>
								 				<li><i class="la la-life-ring"></i><h3>Marital Status</h3><span><?php echo $fetch['marital_status']; ?></span></li>
								 				<li><i class="la la-flag"></i><h3>Nationality</h3><span><?php echo $fetch['nationality']; ?></span></li>
								 				<li><i class="la la-inr"></i><h3>Expected Salary</h3><span><?php echo $fetch['expected_salary']; ?></span></li>
								 				<li><i class="la la-thumb-tack"></i><h3>Functional Area</h3><span><?php echo $fetch['functional_area']; ?></span></li>
								 				<li><i class="la la-puzzle-piece"></i><h3>Industry</h3><span><?php echo $fetch['industry']; ?></span></li>
								 				<li><i class="la la-shield"></i><h3>Experience</h3><span><?php echo $fetch['job_experience']; ?></span></li>
								 			</ul>
								 		</div><!-- Job Overview -->
				 						<div class="edu-history-sec">
				 							<h2>Education</h2>
				 							<?php
				 							$sql = "SELECT qualifications.*, manage_candidate_qualifications.institute, manage_candidate_qualifications.graduation_year FROM qualifications LEFT JOIN manage_candidate_qualifications ON qualifications.id = manage_candidate_qualifications.qualification_id WHERE manage_candidate_qualifications.candidate_id = :candidate_id ORDER BY graduation_year";
				 							$run_sql = $conn->prepare($sql);
				 							$run_sql->bindParam(":candidate_id", $id, PDO::PARAM_INT);
				 							$run_sql->execute();
											$count = $run_sql->rowCount();
											if($count > 0)
						                    {
												$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
						                        foreach($fetch_result as $query_fetch)
						                        {
						                        	echo '
						 							<div class="edu-history">
						 								<i class="la la-graduation-cap"></i>
						 								<div class="edu-hisinfo">
						 									<h3>'.$query_fetch->qualification.'<i>('.$query_fetch->abbreviation.')</i></h3>
						 									<i>'.$query_fetch->graduation_year.'</i>
						 									<span>'.$query_fetch->institute.'</span>
						 								</div>
						 							</div>';
						 						}
						 					}
						 					?>
				 						</div>
				 						<div class="edu-history-sec">
				 							<h2>Work & Experience</h2>
				 							<?php
				 							$sql = "SELECT manage_candidate_experiences.*, states.state, cities.city FROM manage_candidate_experiences LEFT JOIN states ON manage_candidate_experiences.state_id = states.id LEFT JOIN cities ON manage_candidate_experiences.city_id = cities.id WHERE candidate_id = :candidate_id";
				 							$run_sql = $conn->prepare($sql);
				 							$run_sql->bindParam(":candidate_id", $id, PDO::PARAM_INT);
				 							$run_sql->execute();
											$count = $run_sql->rowCount();
											if($count > 0)
						                    {
												$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
						                        foreach($fetch_result as $query_fetch)
						                        {
						                        	$start_date = strtotime($query_fetch->start_date);
										            $end_date = strtotime($query_fetch->end_date);
						                        	echo '
						 							<div class="edu-history style2">
						 								<i></i>
						 								<div class="edu-hisinfo">
						 									<h3>'.$query_fetch->experience_title.' <span>'.$query_fetch->company.'</span></h3>
						 									<i>'.date('jS F, Y', $start_date).' - '.date('jS F, Y', $end_date).' | <i class="la la-map-marker"></i> '.$query_fetch->city.', '.$query_fetch->state.'</i>
						 									<p>'.$query_fetch->description.'</p>
						 								</div>
						 							</div>';
						 						}
						 					}
						 					?>
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
								<span><a href="https://grandetest.com/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="d4bdbab2bb94bebbb6bca1baa0fab7bbb9">[email&#160;protected]</a></span>
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

<div class="account-popup-area signin-popup-box">
	<div class="account-popup">
		<span class="close-popup"><i class="la la-close"></i></span>
		<h3>User Login</h3>
		<span>Click To Login With Demo User</span>
		<div class="select-user">
			<span>Candidate</span>
			<span>Employer</span>
		</div>
		<form>
			<div class="cfield">
				<input type="text" placeholder="Username" />
				<i class="la la-user"></i>
			</div>
			<div class="cfield">
				<input type="password" placeholder="********" />
				<i class="la la-key"></i>
			</div>
			<p class="remember-label">
				<input type="checkbox" name="cb" id="cb1"><label for="cb1">Remember me</label>
			</p>
			<a href="#" title="">Forgot Password?</a>
			<button type="submit">Login</button>
		</form>
		<div class="extra-login">
			<span>Or</span>
			<div class="login-social">
				<a class="fb-login" href="#" title=""><i class="fa fa-facebook"></i></a>
				<a class="tw-login" href="#" title=""><i class="fa fa-twitter"></i></a>
			</div>
		</div>
	</div>
</div><!-- LOGIN POPUP -->

<div class="account-popup-area signup-popup-box">
	<div class="account-popup">
		<span class="close-popup"><i class="la la-close"></i></span>
		<h3>Sign Up</h3>
		<div class="select-user">
			<span>Candidate</span>
			<span>Employer</span>
		</div>
		<form>
			<div class="cfield">
				<input type="text" placeholder="Username" />
				<i class="la la-user"></i>
			</div>
			<div class="cfield">
				<input type="password" placeholder="********" />
				<i class="la la-key"></i>
			</div>
			<div class="cfield">
				<input type="text" placeholder="Email" />
				<i class="la la-envelope-o"></i>
			</div>
			<div class="dropdown-field">
				<select data-placeholder="Please Select Specialism" class="chosen">
					<option>Web Development</option>
					<option>Web Designing</option>
					<option>Art & Culture</option>
					<option>Reading & Writing</option>
				</select>
			</div>
			<div class="cfield">
				<input type="text" placeholder="Phone Number" />
				<i class="la la-phone"></i>
			</div>
			<button type="submit">Signup</button>
		</form>
		<div class="extra-login">
			<span>Or</span>
			<div class="login-social">
				<a class="fb-login" href="#" title=""><i class="fa fa-facebook"></i></a>
				<a class="tw-login" href="#" title=""><i class="fa fa-twitter"></i></a>
			</div>
		</div>
	</div>
</div><!-- SIGNUP POPUP -->

<div class="coverletter-popup">
	<div class="cover-letter">
		<i class="la la-close close-letter"></i>
		<h3>Ali TUFAN - UX / UI Designer</h3>
		<p>My name is Ali TUFAN I am thrilled to be applying for the [position] role in your company. After reviewing your job description, it’s clear that you’re looking for an enthusiastic applicant that can be relied upon to fully engage with the role and develop professionally in a self-motivated manner. Given these requirements, I believe I am the perfect candidate for the job.</p>
	</div>
</div>

<div class="contactus-popup">
	<div class="contact-popup">
		<i class="la la-close close-contact"></i>
		<h3>Send Message to “Ali TUFAN”</h3>
		<form>
			<div class="popup-field">
				<input type="text" placeholder="Tera Planer" />
				<i class="la la-user"></i>
			</div>
			<div class="popup-field">
				<input type="text" placeholder="demo@jobhunt.com" />
				<i class="la la-envelope-o"></i>
			</div>
			<div class="popup-field">
				<input type="text" placeholder="+90 538 845 09 85" />
				<i class="la la-phone"></i>
			</div>
			<div class="popup-field">
				<textarea placeholder="Message"></textarea>
			</div>
			<button type="submit">Send Message</button>
		</form>
	</div>
</div>

<script src="<?php echo $path; ?>/assets/js/modernizr.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/script.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/wow.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/slick.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/parallax.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/select-chosen.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/jquery.scrollbar.min.js" type="text/javascript"></script>

</body>
</html>

