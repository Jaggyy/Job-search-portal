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
	<title>Search Jobs By Location | Naukri</title>
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
				<div class="col-lg-12 column">
			 		<div class="modrn-joblist np">
				 		<div class="filterbar">
				 			<h5>Browse Jobs By State</h5>
				 		</div>
					 </div><!-- MOdern Job LIst -->
					 <div class="job-list-modern">
					 	<div class="job-listings-sec no-border">
						 	<?php
							$retrieve = "SELECT * FROM states ORDER BY state";
							$qery = $conn->prepare($retrieve);
							$qery->execute();
							$results=$qery->fetchAll(PDO::FETCH_OBJ);
							if($qery->rowCount() > 0)
							{
								foreach($results as $fetch)
								{
									echo '
									<h6 class="list">Jobs in '.$fetch->state.'</h6>
									<div class="row">';

									$sql = "SELECT * FROM cities WHERE state_id = :state_id ORDER BY city";
									$statement = $conn->prepare($sql);
									$statement->bindParam(":state_id", $fetch->id, PDO::PARAM_INT);
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_OBJ);
									if($statement->rowCount() > 0)
									{
										foreach($result AS $row)
										{
											echo '
											<div class="col-md-3">
												<p class="fetch-list"><a href="'.$path.'/search/location?name='.$row->slug.'">'.$row->city.'</a></p>
											</div>';
										}
									}
									echo '</div>';
								}
							}
							?>
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