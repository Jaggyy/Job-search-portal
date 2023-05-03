<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'resume_builder';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["candidate_login"]) || $_SESSION["candidate_login"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
$candidate_id = $_SESSION['candidate_id'];
?>
<?php
$sql_retrieve = "SELECT candidates.*, states.state, cities.city FROM candidates LEFT JOIN states ON candidates.state_id = states.id LEFT JOIN cities ON candidates.city_id = cities.id WHERE candidates.id = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $candidate_id, PDO::PARAM_INT);
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
    <title>Candidate Profile | Naukri</title>
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
	<script>
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
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="container">
			<!-- Main content -->
			<section class="content printableArea">
				<div class="row">
					<div class="col-12">
						<div class="box">
                            <div class="box-body">
                                <div class="row no-print">
                                    <div class="col-12">
                                        <div class="bb-1 clearFix">
                                            <div class="text-right pb-15">
                                                <button id="print2" class="btn btn-warning" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-12 custom-preview">
                                        <h3 class="text-center heading-preview"><?php echo $row['firstname'].' '.$row['lastname']; ?></h3>
                                        <div class="media justify-content-center mb-30">
                                            <a href="javascript: void(0);">
                                                <img src="<?php echo $path; ?>/assets/images/profile_picture/<?php echo $row['photo']; ?>" class="rounded-circle custom-img">
                                            </a>
                                        </div>
                                        <?php
                                        if($row['summary'])
                                        {
                                            echo '
                                            <h4 class="heading-1">Professional Detail</h4>
                                            <p class="mb-30">'.$row['summary'].'</p>';
                                        }
                                        ?>

                                        <h4 class="heading-1">Contact Detail</h4>
                                        <div class="col-12 fw-500 mb-30">
                                            <p><span class="mdi mdi-cellphone-android mr-2"></span>+91 <?php echo $row['phone']; ?></p>
                                            <p><span class="mdi mdi-email mr-2"></span><?php echo $row['email']; ?></p>
                                            <p><span class="mdi mdi-map-marker mr-2"></span><?php echo $row['city'].', '.$row['state'].', '.$row['country']; ?></p>
                                        </div>
                                    </div>

                                    <div class="col-md-7 col-12 custom-preview">
                                        <?php
                                        $query_run = "SELECT job_skills.*, manage_candidate_skills.candidate_skill_id, manage_candidate_skills.rating FROM job_skills LEFT JOIN manage_candidate_skills ON job_skills.id = manage_candidate_skills.candidate_skill_id WHERE manage_candidate_skills.candidate_id = :candidate_id";
                                        $output = $conn->prepare($query_run);
                                        $output->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
                                        $output->execute();
                                        $count = $output->rowCount();
                                        if($count > 0)
                                        {
                                            echo '
                                            <h4 class="heading-1">Skills</h4>
                                            <div class="col-12 fw-500 mb-30">
                                                <div class="row">';
                                                
                                                    $fetch = $output->fetchAll(PDO::FETCH_OBJ);
                                                    foreach($fetch as $query_fetch)
                                                    {
                                                        echo '
                                                        <div class="col-md-5">
                                                            <p>'.$query_fetch->job_skill.'</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="progress progress-xs mt-2 mb-30 w-p100">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: '.$query_fetch->rating.'%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>';
                                                    }
                                                echo '
                                                </div>
                                            </div>';
                                        }
                                        ?>

                                        <?php
                                        $query_run = "SELECT * FROM manage_candidate_languages WHERE candidate_id = :candidate_id ORDER BY language";
                                        $output = $conn->prepare($query_run);
                                        $output->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
                                        $output->execute();
                                        $count = $output->rowCount();
                                        if($count > 0)
                                        {
                                            echo '
                                            <h4 class="heading-1">Language</h4>
                                            <div class="col-12 fw-500 mb-30">';
                                            
                                                $fetch = $output->fetchAll(PDO::FETCH_OBJ);
                                                foreach($fetch as $query_fetch)
                                                {
                                                    echo '
                                                    <span class="mr-5"><span class="badge badge-sm badge-ring fill badge badge-primary mr-2"></span>'.$query_fetch->language.'</span>';
                                                }
                                            echo '
                                            </div>';
                                        }
                                        ?>

                                        <?php
                                        $query_run = "SELECT * FROM manage_candidate_experiences WHERE candidate_id = :candidate_id ORDER BY id DESC";
                                        $output = $conn->prepare($query_run);
                                        $output->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
                                        $output->execute();
                                        $count = $output->rowCount();
                                        if($count > 0)
                                        {
                                            echo '
                                            <h4 class="heading-1">Work Experience</h4>';
                                        
                                            $fetch = $output->fetchAll(PDO::FETCH_OBJ);
                                            foreach($fetch as $query_fetch)
                                            {
                                                $start_date = strtotime($query_fetch->start_date);
                                                $end_date = strtotime($query_fetch->end_date);
                                                echo '
                                                <div class="col-12 fw-500 mb-30">
                                                    <span class="badge badge-sm badge-ring fill badge badge-primary mr-2"></span>
                                                    <span class="fs-20">'.$query_fetch->experience_title.'</span>
                                                    <span class="float-right">'.date('jS F, Y', $start_date).' - '.date('jS F, Y', $end_date).'</span>
                                                    <p class="ml-4 mb-1 gparagraph">'.$query_fetch->company.'</p>
                                                    <p class="ml-4 gparagraph-1">'.$query_fetch->description.'</p>
                                                </div>';
                                            }
                                        }
                                        ?>

                                        <?php
                                        $query_run = "SELECT qualifications.*, manage_candidate_qualifications.institute, manage_candidate_qualifications.graduation_year FROM qualifications LEFT JOIN manage_candidate_qualifications ON qualifications.id = manage_candidate_qualifications.qualification_id WHERE manage_candidate_qualifications.candidate_id = :candidate_id ORDER BY id DESC";
                                        $output = $conn->prepare($query_run);
                                        $output->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
                                        $output->execute();
                                        $count = $output->rowCount();
                                        if($count > 0)
                                        {
                                            echo '
                                            <h4 class="heading-1">Education</h4>';
                                        
                                            $fetch = $output->fetchAll(PDO::FETCH_OBJ);
                                            foreach($fetch as $query_fetch)
                                            {
                                                echo '
                                                <div class="col-12 fw-500 mb-30">
                                                    <span class="badge badge-sm badge-ring fill badge badge-primary mr-2"></span>
                                                    <span class="fs-20">'.$query_fetch->qualification.' ('.$query_fetch->abbreviation.')</span>
                                                    <span class="float-right">'.$query_fetch->graduation_year.'</span>
                                                    <p class="ml-4 mb-1 gparagraph">'.$query_fetch->institute.'</p>
                                                </div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
		  				</div>
			  			<!-- /.box -->
					</div>
				</div>
			</section>
			<!-- /.content -->
	  	</div>
	  	<!-- /.content-wrapper -->
	</div>
	<!-- ./wrapper -->

	<!-- Vendor JS -->
    <script src="<?php echo $path; ?>/admin/assets/js/vendors.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/js/popper.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/vendor_plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/icons/feather-icons/feather.min.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/vendor_components/select2/dist/js/select2.full.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/datatable/datatables.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_plugins/JqueryPrintArea/demo/jquery.PrintArea.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/advanced-form-element.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/invoice.js"></script>
</body>
</html>
