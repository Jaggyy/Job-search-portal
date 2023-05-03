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
$id = $_GET['id'];
?>

<?php
if(!empty($_FILES['image']['name']))
{
    $image = $_FILES['image']['name'];
    $uploadDir = "../../assets/images/blog_images/";
    $fileName = basename($image);
    $targetPath = $uploadDir. $fileName;
    // get the image extension
    $extension = substr($image,strlen($image)-4,strlen($image));
    // allowed extensions
    $allowed_extensions = array(".jpg","jpeg",".png");

    $sql = "UPDATE blogs SET image = :image WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':image', $fileName, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $result = $query->execute();
    if($result)
    {
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }
    
    //Load JavaScript function to show the upload status
    echo '<script type="text/javascript">window.top.window.completeUpload(' . $result . ',\'' . $targetPath . '\');</script>  ';
}
?>

<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/admin/includes/blog-update-script.php'); ?>

<?php
$sql_retrieve = "SELECT blogs.*, blog_categories.category FROM blogs LEFT JOIN blog_categories ON blogs.category_id = blog_categories.id WHERE blogs.id = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $id, PDO::PARAM_INT);
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
    <title>Edit Blog | Naukri</title>
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
							<h3 class="page-title">Edit Blog</h3>
							<div class="d-inline-block align-items-center">
								<nav>
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="<?php echo $path; ?>/admin/dashboard"><i class="mdi mdi-home-outline"></i></a></li>
										<li class="breadcrumb-item" aria-current="page"><a href="<?php echo $path; ?>/admin/blogs/manage">Blogs</a></li>
										<li class="breadcrumb-item active" aria-current="page">Edit Blog</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<?php
				if(isset($_POST['submit']))
				{
					if($title == null || $category_id == null || $description == null)
					{
						echo'
                        <script type="text/javascript">
                            toastr.error("'.$empty.'", "Error");
                    	</script>';
					}
					elseif(empty($empty))
					{
						if($result)
						{
							echo'
	                        <script type="text/javascript">
	                            toastr.success("'.$success.'", "Success");
	                    	</script>';
						}
						else
						{
							echo'
	                        <script type="text/javascript">
	                            toastr.error("'.$error.'", "Error");
	                    	</script>';
						}
					}
				}
				?>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<div class="media">
                                    <a href="javascript: void(0);">
                                        <img src="<?php echo $path; ?>/assets/images/blog_images/<?php echo $row['image']; ?>" class="rounded mr-75" id="imagePreview" alt="profile image" height="200" width="300"> 
                                    </a>
                                    <div class="media-body mt-2">
                                        <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                            <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 editLink" for="account-upload">Upload New Photo</label>
                                            <form method="post" action="" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
                                                <input type="file" name="image" id="account-upload"  style="display:none"/>
                                            </form>
                                            <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                        </div>
                                        <p class="text-muted mt-2"><small>Allowed JPG, JPEG or PNG.</small></p>
                                    </div>
                                </div>
								<!-- /.box-header -->
								<form class="form" method="post" action="" enctype="multipart/form-data">
									<div class="box-body">
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Title</label>
												  	<input id="title" type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Blog Category</label>
												  	<select name="category_id" id="category_id" class="form-control" required>
								                        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM blog_categories WHERE id != '".$row['category_id']."'";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $result = $rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($result as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->category.'</option>';
								                            }
								                        }
								                        ?>
								                    </select>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-12">
												<div class="form-group">
												  	<label class="form-label">Description</label>
												  	<textarea name="description" id="description" class="form-control" required><?php echo $row['description']; ?></textarea>
												</div>
										  	</div>
										</div>
									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" name="submit" class="btn fix-gr-bg submit">
										  	<i class="ti-save-alt"></i> UPDATE
										</button>
									</div>  
								</form>
								<!-- /.box-body -->
			  				</div>
				  			<!-- /.box -->
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
	<script type="text/javascript" src="<?php echo $path; ?>/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
    	CKEDITOR.replace("description");
	</script>
	<script type="text/javascript">
        $(document).ready(function () {
            //If image edit link is clicked
            $(".editLink").on('click', function(e){
                e.preventDefault();
                $("#account-upload:hidden").trigger('click');
            });

            //On select file to upload
            $("#account-upload").on('change', function(){
                var image = $('#account-upload').val();
                var img_ex = /(\.jpg|\.jpeg|\.png)$/i;

                //validate file type
                if(!img_ex.exec(image)){
                    toastr.error("Please Upload Only .JPG/.JPEG/ or /.PNG File.");
                    $('#account-upload').val('');
                    return false;
                }else{
                    $('.uploadProcess').show();
                    $('#uploadForm').hide();
                    $( "#picUploadForm" ).submit();
                }
            });
        });

        //After completion of image upload process
        function completeUpload(success, fileName) {
            if(success == 1){
                $('#imagePreview').attr("src", "");
                $('#imagePreview').attr("src", fileName);
                $('#account-upload').attr("value", fileName);
                $('.uploadProcess').hide();
                toastr.success("Image Uploaded Successfully");
            }else{
                $('.uploadProcess').hide();
                toastr.error("Something Went Wrong. Please Try Again Later.");
            }
            return true;
        }
    </script>
</body>
</html>
