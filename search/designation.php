<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
?>
<?php
$name = $_GET['name'];

if($name == NULL) 
{
    header('location: '.$path.'');
}
else
{
	$sql = "SELECT jobs.*, states.state, cities.city, functional_areas.functional_area, companies.companyname, companies.logo, industries.industry, job_types.job_type, job_experiences.job_experience FROM jobs LEFT JOIN states ON jobs.state_id = states.id LEFT JOIN cities ON jobs.city_id = cities.id LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id LEFT JOIN companies ON jobs.company_id = companies.id LEFT JOIN industries ON jobs.industry_id = industries.id LEFT JOIN job_types ON jobs.job_type_id = job_types.id LEFT JOIN job_experiences ON jobs.job_experience_id = job_experiences.id WHERE functional_areas.slug = :name AND jobs.status = 1 AND jobs.verified = 1 AND (job_expiry_date > CURDATE())";
	$qry = $conn->prepare($sql);
	$qry->bindParam(":name", $name, PDO::PARAM_STR);
	$qry->execute();
	$count_jobs = $qry->rowCount();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $count_jobs; ?> Results Found | Naukri</title>
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

	<section class="overlape">
		<div class="block no-padding">
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header wform">
							<div class="job-search-sec">
								<div class="job-search">
									<form method="get" action="<?php echo $path; ?>/results.php">
										<div class="row">
											<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
												<div class="job-field">
													<input type="text" name="term" id="term" placeholder="JOB TITLE, SKILLS" autocomplete="off" required />
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block remove-top">
			<div class="container">
				 <div class="row no-gape">
				 	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/search/filter-aside.php'); ?>
				 	<div class="col-lg-9 column">
				 		<div class="modrn-joblist np">
					 		<div class="filterbar">
					 			<h5>Search Results</h5>
					 		</div>
						 </div><!-- MOdern Job LIst -->
						 <div class="job-list-modern filter_data">


							
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
    $(document).ready(function() {

        filter_data();

        function filter_data() {
            $('.filter_data');
            var action = 'fetch_data';
            var states = get_filter('states');
            var functional_area = get_filter('functional_area');
            var experience = get_filter('experience');
            var qualification = get_filter('qualification');
            var industry = get_filter('industry');
            var job_type = get_filter('job_type');
            var salary1 = get_filter('salary1');
            var salary2 = get_filter('salary2');
            var salary3 = get_filter('salary3');
            var salary4 = get_filter('salary4');
            $.ajax({
                url: "fetch_results.php?name=<?php echo $name; ?>",
                method: "POST",
                data: {
                    action: action,
                    states: states,
                    functional_area: functional_area,
                    experience: experience,
                    qualification: qualification,
                    industry: industry,
                    job_type: job_type,
                    salary1: salary1,
                    salary2: salary2,
                    salary3: salary3,
                    salary4: salary4,
                },
                success: function(data) {
                    $('.filter_data').html(data);
                }
            });
        }

        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function() {
                filter.push($(this).val());
            });
            return filter;
        }

        $('.filter_all').click(function() {
            filter_data();
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
<?php
}
?>