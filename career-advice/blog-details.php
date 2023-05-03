<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
?>
<?php
$id = $_GET['id'];
$sql_retrieve = "SELECT blogs.*, blog_categories.category FROM blogs LEFT JOIN blog_categories ON blogs.category_id = blog_categories.id WHERE blogs.slug = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$row = $query->fetch();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $row['title']; ?> | Naukri</title>
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
				 	<div class="col-lg-9 column">
				 		<div class="blog-single">
				 			<div class="bs-thumb">
				 				<img src="<?php echo $path; ?>/assets/images/blog_images/<?php echo $row['image']; ?>" style="height: 340px;" />
				 			</div>
				 			<ul class="post-metas">
				 				<li><a><i class="la la-calendar-o"></i><?php echo $row['created_at']; ?></a></li>
				 				<li><a><span class="initialism badge badge-primary badge-pill p-1"><?php echo $row['category']; ?><span></a></li>
				 			</ul>
				 			<h2><?php echo $row['title']; ?></h2>
				 			<span><?php echo htmlspecialchars_decode($row['description']); ?></span>
				 		</div>
					</div>
					<aside class="col-lg-3 column">
				 		<div class="widget">
				 			<h3>Categories</h3>
				 			<div class="sidebar-links">
				 				<?php
								$sql = "SELECT * FROM blog_categories ORDER BY category";
								$run_sql = $conn->prepare($sql);
								$run_sql->execute();
								$count = $run_sql->rowCount();
								if($count > 0)
			                    {
									$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
			                        foreach($fetch_result as $query_fetch)
			                        {
			                        	echo '
				 						<a href="'.$path.'/career-advice/category?category='.$query_fetch->slug.'" title=""><i class="la la-angle-right"></i>'.$query_fetch->category.'</a>';
				 					}
				 				}
				 				?>
				 			</div>
				 		</div>
				 		<div class="widget">
				 			<h3>Recent Posts</h3>
				 			<div class="post_widget">
				 				<?php
								$sql = "SELECT blogs.*, blog_categories.category FROM blogs LEFT JOIN blog_categories ON blogs.category_id = blog_categories.id ORDER BY id DESC LIMIT 6";
								$run_sql = $conn->prepare($sql);
								$run_sql->execute();
								$count = $run_sql->rowCount();
								if($count > 0)
							    {
									$fetch_result = $run_sql->fetchAll(PDO::FETCH_OBJ);
									foreach($fetch_result as $query_fetch)
		                        	{
		                        		echo '
						 				<div class="mini-blog">
						 					<span><a><img src="'.$path.'/assets/images/blog_images/'.$query_fetch->image.'" alt="" /></a></span>
						 					<div class="mb-info">
						 						<h3><a href="'.$path.'/blog-details?id='.$query_fetch->slug.'">'.$query_fetch->title.'</a></h3>
						 						<span>'.$query_fetch->created_at.'</span>
						 					</div>
						 				</div>';
						 			}
						 		}
						 		?>
				 			</div>
				 		</div>
					</aside>
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