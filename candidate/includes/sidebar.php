<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">	
		<div class="user-profile px-20 py-10">
			<div class="d-flex align-items-center">			
				<div class="image">
				  <img src="<?php echo $path; ?>/assets/images/profile_picture/<?php echo $_SESSION['photo']; ?>" class="avatar avatar-lg bg-primary-light rounded100" alt="User Image">
				</div>
				<div class="info">
					<a class="px-20"><?php echo $_SESSION['candidate_name']; ?></a>
				</div>
			</div>
	    </div>
	  	<div class="multinav">
		  	<div class="multinav-scroll" style="height: 100%;">	
			  	<!-- sidebar menu-->
			  	<ul class="sidebar-menu" data-widget="tree">		
					<li class="<?php if($page == 'dashboard'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/candidate/dashboard">
							<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
							<span>Dashboard</span>
					  	</a>
					</li>	
					<li class="<?php if($page == 'profile'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/candidate/profile">
							<i class="mdi mdi-account"><span class="path1"></span><span class="path2"></span></i>
							<span>Profile</span>
					  	</a>
					</li>
					<li class="<?php if($page == 'applied_jobs'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/candidate/applied-jobs">
							<i class="fa fa-briefcase" style="font-size: 18px;"><span class="path1"></span><span class="path2"></span></i>
							<span>Applied Jobs</span>
					  	</a>
					</li>
					<li class="<?php if($page == 'resume_builder'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/candidate/resume-builder">
							<i class="mdi mdi-file-pdf" style="font-size: 18px;"><span class="path1"></span><span class="path2"></span></i>
							<span>Resume Builder</span>
					  	</a>
					</li>
			  	</ul>
		  	</div>
		</div>
    </section>
		</aside>