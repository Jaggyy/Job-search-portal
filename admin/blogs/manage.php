<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'blogs';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{   
	header('location:http://localhost/naukri/');
	exit();
}
?>
<?php
if(isset($_GET['del']))
{
	$id = $_GET['id'];
	$delete_sql = "DELETE FROM blogs WHERE id= :id";
	$delete = $conn->prepare($delete_sql);
	$delete->bindParam(':id', $id, PDO::PARAM_INT);
	if($delete->execute())
	{
		$delMsg = "Deletion Successfull.";
		header('Refresh:2;url='.$path.'/admin/blogs/manage');
	}
	else
	{
	    $delError = "Something Went Wrong! Try again..";
		header('Refresh:2;url='.$path.'/admin/blogs/manage');
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
    <title>Blogs | Naukri</title>
	<!-- Vendors Style-->
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/vendors_css.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/vendor_plugins/bootstrap/css/bootstrap.min.css">
	<!-- Style-->  
    <link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/toastr.min.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/switches.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/css/style.css">
	<link rel="stylesheet" href="<?php echo $path; ?>/admin/assets/stretchy_navigation/stretchy_navigation.css">
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
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper">
		  	<div class="container-full">
		  		<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<h3 class="page-title">Blogs</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item active" aria-current="page">Blogs</li>
									</ol>
								</nav>
							</div>
						</div>
						<div class="col-auto text-end float-end ml-auto">
							<a href="<?php echo $path; ?>/admin/blogs/create" class="btn fix-gr-bg btn-rounded"><i class="mdi mdi-plus"></i>&nbsp;&nbsp;Add New Blog</a>
						</div>
					</div>
				</div>
				<?php
				if(isset($_GET['del']))
				{
					if($delete->execute())
					{
						echo'
                        <script type="text/javascript">
                            toastr.success("'.$delMsg.'", "Success");
                    	</script>';
					}
					else
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$delError.'", "Error");
                    	</script>';
					}
				}
				?>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-md-12 col-12">
							<div class="row">
								<?php
								$sql = "SELECT blogs.*, blog_categories.category FROM blogs LEFT JOIN blog_categories ON blogs.category_id = blog_categories.id ORDER BY created_at";
								$run_sql = $conn->prepare($sql);
								$run_sql->execute();
								$count = $run_sql->rowCount();
								if($count > 0)
			                    {
									$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
			                        foreach($fetch_result as $query_fetch)
			                        {
			                        	$description = $query_fetch->description;
							            $strcut = substr($description,0,100);
							            $description = substr($strcut,0,strrpos($strcut,' ')).'...';
			                        	echo '
										<div class="col-md-3 col-12">
											<div class="box">
												<nav class="cd-stretchy-nav edit-content">
													<a class="cd-nav-trigger" href="#0">
														<span aria-hidden="true"></span>
													</a>

													<ul>
														<li><a class="text-white" href="'.$path.'/admin/blogs/edit?id='.$query_fetch->id.'"></a></li>
														<li><a class="text-white" href="#delete'.$query_fetch->id.'" data-toggle="modal" data-target="#deleteBlog'.$query_fetch->id.'"></a></li>
													</ul>

													<span aria-hidden="true" class="stretchy-nav-bg"></span>
												</nav>
												<img class="card-img-top img-responsive" src="'.$path.'/assets/images/blog_images/'.$query_fetch->image.'" style="height: 160px;">
												<div class="box-body"> 
													<div class="text-center">
														<h4 class="box-title">'.$query_fetch->title.'</h4>
														<p class="my-10">
														  <small>
															  <span class="badge badge-primary badge-pill">'.$query_fetch->category.'</span>
															  <span class="px-10">| </span><i class="fa fa-calendar"></i> '.$query_fetch->created_at.'
														  </small>
														</p>
														<p class="box-text">'.htmlspecialchars_decode($description).'</p>
														<a href="'.$path.'/admin/blogs/view?id='.$query_fetch->id.'" class="btn btn-primary btn-sm">Read more</a>
													</div>
												</div>
											</div>
										</div>

										<!--Modal Delete-->
										<div class="modal fade" id="deleteBlog'.$query_fetch->id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
										aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header bg-danger">
														<h5 class="modal-title" id="exampleModalLongTitle">DELETE BLOG</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<i class="mdi mdi-close"></i>
														</button>
													</div>
													<div class="modal-body">
														Are you sure you want to delete?
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default">Close</button>
														<a class="btn fix-gr-bg" href="'.$path.'/admin/blogs/manage?id='.$query_fetch->id.'&del=delete">Delete</a>
											  		</div>
												</div>
											</div>
										</div>';
									}
								}
								else
								{
									echo '
									<div class="col-md-12">
										<div class="box">
											<div class="box-body text-center">
												<div class="mb-20 mt-20">
													<img src="'.$path.'/assets/images/resource/data-not-found.png" style="width: 100%; height: 200px;">
												</div>
											</div>
										</div>
									</div>';
								}
								?>
							</div>
						</div>
					</div>
				</section>
				<!-- /.content -->
		  	</div>
	  	</div>
	  	<!-- /.content-wrapper -->
	  	<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/footer.php'); ?>
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
    <script src="<?php echo $path; ?>/admin/assets/stretchy_navigation/main.js"></script>
</body>
</html>
