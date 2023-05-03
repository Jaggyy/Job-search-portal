<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
	<title>Job Search - Latest Job Openings | Naukri</title>
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
</head>
<body>
<div class="page-loading">
	<img src="<?php echo $path; ?>/assets/images/loader.gif" alt="" />
</div>

<div class="theme-layout" id="scrollup">
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-responsive.php'); ?>
	
	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/header-2.php'); ?>

	<section>
		<div class="block no-padding">
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="main-featured-sec">
							<div class="new-slide-2">
								<img src="<?php echo $path; ?>/assets/images/resource/vector-2.png">
							</div>
							<div class="job-search-sec">
								<div class="job-search">
									<h3>The Easiest Way to Get Your New Job</h3>
									<span>Explore 300,000+ Jobs</span>
									<form method="get" action="<?php echo $path; ?>/results">
										<div class="row">
											<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
												<div class="job-field">
													<input type="text" name="term" id="term" placeholder="JOB TITLE, COMPANY" autocomplete="off" required />
													<i class="la la-keyboard-o"></i>
													<div class="result"></div>
												</div>
											</div>
											<div class="col-lg-3 col-md-5 col-sm-12 col-xs-12">
												<div class="job-field">
													<select name="state_id" id="state_id" required>
														<option value="" readonly>SELECT STATE</option>
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
													<i class="la la-map-marker"></i>
												</div>
											</div>
											<div class="col-lg-3 col-md-5 col-sm-12 col-xs-12">
												<div class="job-field">
													<select name="city_id" id="city_id" required>
														<option value="" readonly>SELECT CITY</option>
													</select>
													<i class="la la-map-marker"></i>
												</div>
											</div>
											<div class="col-lg-1 col-md-2 col-sm-12 col-xs-12">
												<button type="submit"><i class="la la-search"></i></button>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="scroll-to">
								<a href="#scroll-here" title=""><i class="la la-arrow-down"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="scroll-here">
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading">
							<h2>Popular Categories</h2>
						</div><!-- Heading -->
						<div class="cat-sec">
							<div class="d-flex justify-content-center row no-gape">
							<?php
							$query = "SELECT * FROM industries WHERE status = 1 LIMIT 6";
							$result = $conn->prepare($query);
							$result->execute();
							$results=$result->fetchAll(PDO::FETCH_OBJ);
		                    if($result->rowCount() > 0)
		                    {
		                        foreach($results as $query_fetch)
		                        {
		                        	echo '
									<div class="col-lg-3 col-md-3 col-sm-6 mb-2 mr-4">
										<div class="p-category">
											<a href="#" title="">
												<img src="'.$path.'/assets/images/icon/'.$query_fetch->icon.'" />
												<span>'.$query_fetch->industry.'</span>';
												$select = "SELECT id FROM jobs WHERE industry_id = :industry_id AND status = 1 AND verified = 1 AND (job_expiry_date > CURDATE())";
												$query_run = $conn->prepare($select);
												$query_run->bindParam(":industry_id", $query_fetch->id, PDO::PARAM_INT);
												$query_run->execute();
												$count_id = $query_run->rowCount();
												echo '
												<p>('.$count_id.' open positions)</p>
											</a>
										</div>
									</div>';
								}
							}
							?>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="browse-all-cat">
							<a href="<?php echo $path; ?>/search/jobs_by_industry" title="">Browse All Categories</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block double-gap-top double-gap-bottom">
			<div data-velocity="-.1" style="background: url(<?php echo $path; ?>/assets/images/resource/parallax1.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible layer color"></div><!-- PARALLAX BACKGROUND IMAGE -->
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="simple-text-block">
							<h3>Make a Difference with Your Online Resume!</h3>
							<span>Your resume in minutes with naukri resume assistant is ready!</span>
							<button onclick="window.location.href='<?php echo $path; ?>/candidate/resume-builder'">Build Your Resume</button>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</section>

	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading">
							<h2>Featured Companies</h2>
						</div><!-- Heading -->
						<div class="comp-sec">
						<?php
						$query = "SELECT * FROM companies WHERE status = 1 AND verified = 1 AND is_featured = 1 LIMIT 5";
						$result = $conn->prepare($query);
						$result->execute();
						$results=$result->fetchAll(PDO::FETCH_OBJ);
	                    if($result->rowCount() > 0)
	                    {
	                        foreach($results as $query_fetch)
	                        {
	                        	echo '
								<div class="company-img">
									<a href="#" title="'.$query_fetch->companyname.'"><img src="'.$path.'/assets/images/logo/'.$query_fetch->logo.'" alt="'.$query_fetch->companyname.'" /></a>
								</div>';
							}
						}
						?>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="browse-all-cat">
							<a href="<?php echo $path; ?>/search/jobs_by_company?featured=yes" title="">Browse All Companies</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block no-padding">
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="simple-text">
							<div class="row">
								<div class="col-md-4">
									<h3>Gat a question?</h3>
									<span>CANDIDATES</span>
								</div>
								<div class="col-md-4">
									<?php 
									$count = "SELECT id FROM jobs WHERE status = 1 AND verified = 1 AND (job_expiry_date > CURDATE())";
									$fetch_id = $conn->prepare($count);
									$fetch_id->execute();
									$cnt = $fetch_id->rowCount();
									?>
									<h3><?php echo $cnt; ?></h3>
									<span>JOBS</span>
								</div>
								<div class="col-md-4">
									<?php 
									$count = "SELECT id FROM companies WHERE status = 1 AND verified = 1 AND is_featured = 1";
									$fetch_id = $conn->prepare($count);
									$fetch_id->execute();
									$cnt = $fetch_id->rowCount();
									?>
									<h3><?php echo $cnt; ?></h3>
									<span>COMPANIES</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="heading">
							<h2>Featured Jobs</h2>
						</div><!-- Heading -->
						<div class="job-list-modern">
							<?php
							$query = "SELECT jobs.*, companies.logo, companies.companyname, companies.slug AS company_slug, states.state, cities.city,job_types.job_type, functional_areas.functional_area, job_experiences.job_experience FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id LEFT JOIN states ON jobs.state_id = states.id LEFT JOIN cities ON jobs.city_id = cities.id LEFT JOIN job_types ON jobs.job_type_id = job_types.id LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id LEFT JOIN job_experiences ON jobs.job_experience_id = job_experiences.id WHERE jobs.status = 1 AND jobs.verified = 1 AND jobs.is_featured = 1 LIMIT 6";
							$result = $conn->prepare($query);
							$result->execute();
							$results=$result->fetchAll(PDO::FETCH_OBJ);
		                    if($result->rowCount() > 0)
		                    {
		                    	echo '<div class="job-listings-sec no-border">';
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
							                            <div class="col-md-4">
							                                <div class="job-lctn"><i class="la la-map-marker"></i>'.$row->city.', '.$row->state.'</div>
							                            </div>
							                            <div class="col-md-4">
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
							                    <div class="col-md-12">
							                        <b class="job-skills">Skills : </b>';
							                        $job_id = $row->job_id;
							                        $sql_qry = "SELECT job_skills.*, manage_job_skills.job_id, manage_job_skills.job_skill_id FROM job_skills LEFT JOIN manage_job_skills ON job_skills.id = manage_job_skills.job_skill_id WHERE job_skills.job_skill = :term OR manage_job_skills.job_id = :job_id";
							                        $queries = $conn->prepare($sql_qry);
							                        $queries->bindParam(":term", $term, PDO::PARAM_STR);
							                        $queries->bindParam(":job_id", $job_id, PDO::PARAM_INT);
							                        $queries->execute();
							                        $res = $queries->fetchAll(PDO::FETCH_OBJ);
							                        if($queries->rowCount() > 0)
							                        {
							                            foreach($res AS $skill)
							                            {
							                                echo '
							                                <p class="waves-effect badge badge-secondary"><a href="'.$path.'/search/skill?name='.$skill->slug.'">'.$skill->job_skill.'</a></p>';
							                            }
							                        }
							                        else
							                        {
							                            echo 'Not Specified';
							                        }
							                    echo '
							                    </div>
							                </div>
							                <div class="job-style-bx">
							                    <a href="'.$path.'/job-apply?id='.$row->job_id.'"><span class="job-is btn btn-outline-info" style="float: right;">APPLY</span></a>';
							                    $created_on = strtotime($row->created_at);
							                    echo '
							                    <i>Posted : '.date('jS M, Y', $created_on).'</i>
							                </div>';
						                    if($row->is_featured == 1)
						                    {
						                        echo '
						                        <img src="'.$path.'/assets/images/star.png" class="featured-img" data-toggle="tooltip" data-placement="bottom" title="Featured">';
						                    }
						                echo '
							            </div>';
							        }
								}
								echo '</div>';
							}
							?>
						</div>
					</div>
					<div class="col-lg-12">
						<div class="browse-all-cat">
							<a href="<?php echo $path; ?>/search-jobs" title="">Browse All Jobs</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	$sql = "SELECT blogs.*, blog_categories.category FROM blogs LEFT JOIN blog_categories ON blogs.category_id = blog_categories.id ORDER BY id DESC LIMIT 3";
	$run_sql = $conn->prepare($sql);
	$run_sql->execute();
	$count = $run_sql->rowCount();
	if($count > 0)
    {
		$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
		echo '
		<section>
			<div class="block">
				<div data-velocity="-.1" style="background: url('.$path.'/assets/images/resource/parallax2.jpg) repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible layer color light"></div><!-- PARALLAX BACKGROUND IMAGE -->
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<div class="heading light">
								<h2>Career Advice And Tips</h2>
							</div><!-- Heading -->
							<div class="blog-sec">
								<div class="row">';
		                        foreach($fetch_result as $query_fetch)
		                        {
		                        	$description = $query_fetch->description;
						            $strcut = substr($description,0,100);
						            $description = substr($strcut,0,strrpos($strcut,' ')).'...';

						            echo '
									<div class="col-lg-4">
										<div class="my-blog">
											<div class="blog-thumb">
												<a><img src="'.$path.'/assets/images/blog_images/'.$query_fetch->image.'" style="height: 200px;" /></a>
												<div class="blog-metas">
													<a>'.$query_fetch->created_at.'</a>
												</div>
											</div>
											<div class="blog-details">
												<h3><a href="'.$path.'/blog-details?id='.$query_fetch->slug.'" title="">'.$query_fetch->title.'</a></h3>
												<p>'.htmlspecialchars_decode($description).'</p>
												<a href="'.$path.'/career-advice/blog-details?id='.$query_fetch->slug.'" title="">Read More <i class="la la-long-arrow-right"></i></a>
											</div>
										</div>
									</div>';
								}
								echo '
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="browse-all-blog">
								<a href="'.$path.'/career-advice" title="">View All</a>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</section>';
	}
	?>

	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/footer.php'); ?>

</div>

<script src="<?php echo $path; ?>/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/modernizr.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/script.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/wow.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/slick.min.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/parallax.js" type="text/javascript"></script>
<script src="<?php echo $path; ?>/assets/js/select-chosen.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
	    $('.job-field input[type="text"]').on("keyup input", function(){
	        /* Get input value on change */
	        var inputVal = $(this).val();
	        var resultDropdown = $(this).siblings(".result");
	        if(inputVal.length){
	            $.get("<?php echo $path; ?>/includes/livesearch.php", {term: inputVal}).done(function(data){
	                // Display the returned data in browser
	                resultDropdown.html(data);
	            });
	        } else{
	            resultDropdown.empty();
	        }
	    });
	    
	    // Set search input value on click of result item
	    $(document).on("click", ".result p", function(){
	        $(this).parents(".job-field").find('input[type="text"]').val($(this).text());
	        $(this).parent(".result").empty();
	    });
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
</body>
</html>

