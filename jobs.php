<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
?>

<?php
$job = $_GET['job'];
$sql_retrieve = "SELECT jobs.*, companies.companyname, companies.logo, companies.description AS 'desc', job_types.job_type,functional_areas.functional_area,states.state,cities.city,qualifications.qualification,job_experiences.job_experience, industries.industry FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id LEFT JOIN job_types ON jobs.job_type_id = job_types.id LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id LEFT JOIN states ON jobs.state_id = states.id LEFT JOIN cities ON jobs.city_id = cities.id LEFT JOIN qualifications ON jobs.qualification_id = qualifications.id LEFT JOIN job_experiences ON jobs.job_experience_id = job_experiences.id LEFT JOIN industries ON jobs.industry_id = industries.id WHERE jobs.slug = :slug";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':slug', $job, PDO::PARAM_STR);
$query->execute();
$fetch = $query->fetch();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
	<title><?php echo $fetch['job_title']; ?> | Naukri</title>
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
</div>

<div class="theme-layout" id="scrollup">
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-responsive.php'); ?>
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-1.php'); ?>

	<section>
		<div class="block">
			<div class="container">
				<div class="row">
				 	<div class="col-lg-12 column">
				 		<div class="job-single-sec style3">
				 			<div class="job-head-wide">
				 				<div class="row mb-2">
				 					<div class="col-lg-8">
				 						<div class="job-single-head3">
							 				<div class="job-thumb"> <img src="<?php echo $path; ?>/assets/images/logo/<?php echo $fetch['logo']; ?>"/></div>
							 				<div class="job-single-info3">
							 					<h3><?php echo $fetch['job_title']; ?></h3>
							 					<span><i class="la la-map-marker"></i><?php echo $fetch['city'].', '.$fetch['state']; ?></span><span class="job-is ft"><?php echo $fetch['job_type']; ?></span>
							 					<ul class="tags-jobs">
								 					<li><i class="la la-file-text"></i> Vacancies: <?php echo $fetch['num_of_posts']; ?></li>
								 					<?php 
								 					$created_on = strtotime($fetch['created_at']);
								 					$expires_on = strtotime($fetch['job_expiry_date']);
								 					?>
								 					<li><i class="la la-calendar-o"></i> Posted: <?php echo date('jS M, Y', $created_on); ?></li>
								 					<li><i class="la la-calendar-o"></i> Expires: <?php echo date('jS M, Y', $expires_on); ?></li>
								 				</ul>
							 				</div>
							 			</div><!-- Job Head -->
				 					</div>
				 					<div class="col-lg-2">
				 						<?php
				 						$check = "SELECT * FROM job_applied WHERE candidate_id = :candidate_id AND job_id = :job_id";
				 						$run_check = $conn->prepare($check);
				 						$run_check->bindParam(":candidate_id", $_SESSION['candidate_id'], PDO::PARAM_INT);
				 						$run_check->bindParam(":job_id", $fetch['job_id'], PDO::PARAM_INT);
				 						$run_check->execute();
				 						$count = $run_check->rowCount();
				 						if($count > 0)
				 						{
				 							echo '
				 							<a class="apply-thisjob" title="">APPLIED ALREADY</a>';
				 						}
				 						else
				 						{
				 							echo '
				 							<a class="apply-thisjob" href="'.$path.'/job-apply?id='.$fetch['job_id'].'" title="">APPLY NOW</a>';
				 						}
				 						?>
				 					</div>
				 				</div>
				 			</div>
				 			<div class="job-wide-devider">
							 	<div class="row">
							 		<div class="col-lg-8 column">		
							 			<div class="job-details">
							 				<strong>SKILLS : </strong>
							 				<?php
							 				$job_id = $fetch['job_id'];
					                        $sql_qry = "SELECT job_skills.*, manage_job_skills.job_id, manage_job_skills.job_skill_id FROM job_skills LEFT JOIN manage_job_skills ON job_skills.id = manage_job_skills.job_skill_id WHERE manage_job_skills.job_id = :job_id";
					                        $queries = $conn->prepare($sql_qry);
					                        $queries->bindParam(":job_id", $job_id, PDO::PARAM_INT);
					                        $queries->execute();
					                        $res = $queries->fetchAll(PDO::FETCH_OBJ);
					                        if($queries->rowCount() > 0)
					                        {
					                            foreach($res AS $skill)
					                            {
					                                echo '
					                                <span class="waves-effect badge badge-secondary"><a href="'.$path.'/search/skill?name='.$skill->slug.'">'.$skill->job_skill.'</a></span>';
					                            }
					                        }
					                        else
					                        {
					                            echo 'Not Specified';
					                        }
					                        ?>
							 				<h3><strong>JOB DESCRIPTION</strong></h3>
							 				<?php echo htmlspecialchars_decode($fetch['description']); ?>
							 			</div>
								 		<div class="recent-jobs">
							 				<h3>Recent Jobs</h3>
							 				<div class="job-list-modern">
											 	<div class="job-listings-sec no-border">
											 		<?php
											 		$retrieve = "SELECT jobs.*, companies.companyname, companies.logo, companies.slug AS 'company_slug', job_types.job_type,functional_areas.functional_area,states.state,cities.city,qualifications.qualification,job_experiences.job_experience, industries.industry FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id LEFT JOIN job_types ON jobs.job_type_id = job_types.id LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id LEFT JOIN states ON jobs.state_id = states.id LEFT JOIN cities ON jobs.city_id = cities.id LEFT JOIN qualifications ON jobs.qualification_id = qualifications.id LEFT JOIN job_experiences ON jobs.job_experience_id = job_experiences.id LEFT JOIN industries ON jobs.industry_id = industries.id WHERE jobs.status = 1 AND jobs.verified = 1 AND (job_expiry_date > CURDATE()) LIMIT 4";
											 		$result = $conn->prepare($retrieve);
													$result->execute();
													$results=$result->fetchAll(PDO::FETCH_OBJ);
								                    if($result->rowCount() > 0)
								                    {
								                        foreach($results as $row)
								                        {
								                        	$job_expiry_date = strtotime($row->job_expiry_date);
												            $currentDate = time();

												            if($job_expiry_date > $currentDate)
												            {
									                        	$description = $row->description;
													            $strcut = substr($description,0,190);
													            $description = substr($strcut,0,strrpos($strcut,' ')).'...';
									                        	echo '
																<div class="job-listing wtabs mb-2">
																	<div class="job-title-sec">
																		<div class="c-logo"><a href="'.$path.'/companies?company='.$row->company_slug.'"> <img src="'.$path.'/assets/images/logo/'.$row->logo.'" alt="'.$row->companyname.'" /></a> </div>
														                    <h3><a href="'.$path.'/jobs?job='.$row->slug.'">'.$row->job_title.'</a></h3>
														                    <span><a href="'.$path.'/companies?company='.$row->company_slug.'">'.$row->companyname.'</a></span>
																		<div class="col-md-12">
													                        <div class="row">
													                            <div class="col-md-5">
													                                <div class="job-lctn"><i class="la la-map-marker"></i>'.$row->city.', '.$row->state.'</div>
													                            </div>
													                            <div class="col-md-3">
													                                <div class="job-lctn"><i class="la la-briefcase"></i>'.$row->job_experience.'</div>
													                            </div>
													                            <div class="col-md-4">
													                                <div class="job-lctn"><i class="la la-inr"></i>';
													                                if($row->hide_salary = 0) 
													                                {  
													                                    echo 'Not Specified'; 
													                                } 
													                                else 
													                                { 
													                                    echo ''.$row->salary_from.' - '.$row->salary_to.''; 
													                                }
													                                echo '
													                                </div>
													                            </div>
													                        </div>
													                    </div>
													                    <div class="col-md-12">
													                        <p class="job-desc">'.htmlspecialchars_decode($description).'</p>
													                    </div>
																	</div>
													                <div class="job-style-bx">
													                    <a href="'.$path.'/job-apply?id='.$row->job_id.'"><span class="job-is btn btn-outline-info" style="float: right;">APPLY</span></a>';
													                    $created_on = strtotime($row->created_at);
													                    echo '
													                    <i>Posted : '.date('jS M, Y', $created_on).'</i>
													                </div>
																</div>';
															}
														}
													}
													?>
												</div>
											 </div>
							 			</div>
							 		</div>
							 		<div class="col-lg-4 column">
							 			<div class="job-overview">
								 			<h3>Job Overview</h3>
								 			<ul>
								 				<li><i class="la la-money"></i><h3>Offerd Salary</h3><span><?php echo $fetch['salary_from'].' - '.$fetch['salary_to']; ?> INR</span></li>
								 				<li><i class="la la-mars-double"></i><h3>Gender</h3><span><?php echo $fetch['gender']; ?></span></li>
								 				<li><i class="la la-thumb-tack"></i><h3>Role</h3><span><?php echo $fetch['functional_area']; ?></span></li>
								 				<li><i class="la la-puzzle-piece"></i><h3>Industry</h3><span><?php echo $fetch['industry']; ?></span></li>
								 				<li><i class="la la-shield"></i><h3>Experience</h3><span><?php echo $fetch['job_experience']; ?></span></li>
								 				<li><i class="la la-line-chart "></i><h3>Qualification</h3><span><?php echo $fetch['qualification']; ?></span></li>
								 			</ul>
								 		</div><!-- Job Overview -->
								 		<div class="quick-form-job">
								 			<h3>About Company</h3>
								 			<div class="company-short-desc">
								 				<?php echo htmlspecialchars_decode($fetch['desc']); ?>
								 			</div>
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

	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/footer.php'); ?>
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