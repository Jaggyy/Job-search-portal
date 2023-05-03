<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = '';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true)
{   
  header('location:http://localhost/naukri/');
  exit();
}
$company_id = $_SESSION['company_id'];
?>
<?php
if(!empty($_FILES['logo']['name']))
{
    $logo = $_FILES['logo']['name'];
    $uploadDir = "../assets/images/logo/";
    $fileName = basename($logo);
    $targetPath = $uploadDir. $fileName;
    // get the image extension
    $extension = substr($logo,strlen($logo)-4,strlen($logo));
    // allowed extensions
    $allowed_extensions = array(".jpg","jpeg",".png");

    $sql = "UPDATE companies SET logo = :logo WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':logo', $fileName, PDO::PARAM_STR);
    $query->bindParam(':id', $company_id, PDO::PARAM_INT);
    $result = $query->execute();
    if($result)
    {
        move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath);
    }
    
    //Load JavaScript function to show the upload status
    echo '<script type="text/javascript">window.top.window.completeUpload(' . $result . ',\'' . $targetPath . '\');</script>  ';
}
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/employer/includes/company-update-script.php'); ?>
<?php
$sql_retrieve = "SELECT companies.*, industries.industry,states.state,cities.city FROM companies LEFT JOIN industries ON companies.industry_id = industries.id LEFT JOIN states ON companies.state_id = states.id LEFT JOIN cities ON companies.city_id = cities.id WHERE companies.id = :id";
$query = $conn->prepare($sql_retrieve);
$query->bindParam(':id', $company_id, PDO::PARAM_INT);
$query->execute();
$row=$query->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo $path; ?>/admin/assets/images/favicon.png">
    <title>Employer Profile | Naukri</title>
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
		    "timeOut": "5000",
		    "positionClass": "toast-top-right"
		}
    </script>
</head>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">	
	<div class="wrapper">
		<div id="loader"></div>
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/employer/includes/header.php'); ?>
  
  		<?php include($_SERVER['DOCUMENT_ROOT'].'/naukri/employer/includes/sidebar.php'); ?>
	  	<!-- Content Wrapper. Contains page content -->
	  	<div class="content-wrapper">
		  	<div class="container-full">
		  		<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="d-flex align-items-center">
						<div class="me-auto">
							<h3 class="page-title">EDIT PROFILE</h3>
						</div>
					</div>
				</div>
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-12">
							<div class="box">
								<div class="media">
                                    <a href="javascript: void(0);">
                                        <?php
                                        if($row['logo'])
                                        {
                                            echo '
                                            <img src="'.$path.'/assets/images/logo/'.$row['logo'].'" class="rounded mr-75" id="imagePreview" alt="profile image" height="200" width="300">';
                                        }
                                        else
                                        {
                                            echo '
                                            <img src="assets/images/user.png" class="rounded mr-75" id="imagePreview" alt="profile image" height="200" width="300">';
                                        }
                                        ?>
                                        
                                    </a>
                                    <div class="media-body mt-2">
                                        <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                            <label class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 editLink" for="account-upload">Upload New Photo</label>
                                            <form method="post" action="" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
                                                <input type="file" name="logo" id="account-upload"  style="display:none"/>
                                            </form>
                                            <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                        </div>
                                        <p class="text-muted mt-2"><small>Allowed JPG, JPEG or PNG.</small></p>
                                        <?php
                                        if($row['is_featured'] == null || $row['is_featured'] == 0)
                                        {
                                        	echo '
                                        	<a href="'.$path.'/employer/payment-method?id='.$company_id.'" class="btn btn-sm btn-info mt-75">Make Company Featured</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
								<!-- /.box-header -->
								<form id="profile_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
									<div class="box-body">
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">First Name</label>
												  	<input id="firstname" type="text" class="form-control" name="firstname" value="<?php echo $row['firstname']; ?>" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Last Name</label>
												  	<input id="lastname" type="text" class="form-control" name="lastname" value="<?php echo $row['lastname']; ?>" required>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Email ID</label>
												  	<input id="email" type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Contact Number</label>
												  	<input id="phone" type="text" class="form-control" name="phone" value="<?php echo $row['phone']; ?>" required>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Company Name</label>
												  	<input id="companyname" type="text" class="form-control" name="companyname" value="<?php echo $row['companyname']; ?>" required>
												</div>
										  	</div>
										  	<div class="col-md-6">
												<div class="form-group">
												  	<label class="form-label">Industry</label>
												  	<select name="industry_id" id="industry_id" class="form-control" required>
												  		<option value="<?php echo $row['industry_id']; ?>"><?php echo $row['industry']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM industries WHERE id != '".$row['industry_id']."' AND status = 1";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $result = $rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($result as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->industry.'</option>';
								                            }
								                        }
								                        ?>
												  	</select>
												</div>
										  	</div>
										</div>
										<div class="row mb-3">
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">Country</label>
												  	<input id="country" type="text" class="form-control" name="country" value="<?php echo $row['country']; ?>" readonly required>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">State</label>
												  	<select name="state_id" id="state_id" class="form-control" required>
												  		<option value="<?php echo $row['state_id']; ?>"><?php echo $row['state']; ?></option>
								                        <?php
								                        $sql = "SELECT * FROM states WHERE id != '".$row['state_id']."'";
								                        $rows = $conn->prepare($sql);
								                        $rows->execute();
								                        $output = $rows->fetchAll(PDO::FETCH_OBJ);
								                        if($rows->rowCount() > 0)
								                        {
								                            foreach($output as $qfetch)
								                            {
								                            	echo'
								                        		<option value="'.$qfetch->id.'">'.$qfetch->state.'</option>';
								                            }
								                        }
								                        ?>
												  	</select>
												</div>
										  	</div>
										  	<div class="col-md-4">
												<div class="form-group">
												  	<label class="form-label">City</label>
												  	<select name="city_id" id="city_id" class="form-control" >
												  		<option value="<?php echo $row['city_id'];?>"><?php echo $row['city'];?></option>
                                                        <?php
                                                        $query="SELECT * FROM cities WHERE id != '".$row['city_id']."' AND state_id = '".$row['state_id']."'";
                                                        $res = $conn->prepare($query);
                                                        $res->execute();
                                                        $result=$res->fetchAll(PDO::FETCH_OBJ);
                                                        if($res->rowCount() > 0)
                                                        {
                                                            foreach($result as $rw)
                                                            {
                                                            	echo '
                                                        		<option value="'.$rw->id.'">'.$rw->city.'</option>';
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
												  	<label class="form-label">Job Description</label>
												  	<textarea name="description" id="description" class="form-control" required><?php echo $row['description']; ?></textarea>
												</div>
										  	</div>
										</div>
									</div>
									<!-- /.box-body -->
									<div class="box-footer">
										<button type="submit" id="submit" class="btn fix-gr-bg submit">UPDATE</button>
										<button type="submit" id="submit" class="btn fix-gr-bg submitting" disabled style="display: none;">UPDATING...</button>
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
	<script src="<?php echo $path; ?>/admin/assets/vendor_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js"></script>
	<script src="<?php echo $path; ?>/admin/assets/vendor_components/select2/dist/js/select2.full.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/moment/min/moment.min.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/fullcalendar/fullcalendar.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/vendor_components/datatable/datatables.min.js"></script>
    
    <script src="<?php echo $path; ?>/admin/assets/js/template.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/data-table.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/dashboard.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/calendar-dash.js"></script>
    <script src="<?php echo $path; ?>/admin/assets/js/pages/advanced-form-element.js"></script>
	<script type="text/javascript" src="<?php echo $path; ?>/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
    	CKEDITOR.replace("description");
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
	<script type="text/javascript">
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right"
        }
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
                toastr.options.positionClass = "toast-top-right";
                toastr.error("Something Went Wrong. Please Try Again Later.");
            }
            return true;
        }
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
	    var _formValidation = function (form_id = '#profile_form') {
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
	                                window.location.href = "<?php echo $path; ?>/employer/profile";
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
