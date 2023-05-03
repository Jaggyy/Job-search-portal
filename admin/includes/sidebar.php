<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">	
		<div class="user-profile px-20 py-10">
			<div class="d-flex align-items-center">			
				<div class="image">
				  <img src="<?php echo $path; ?>/admin/assets/images/avatar/avatar-15.png" class="avatar avatar-lg bg-primary-light rounded100" alt="User Image">
				</div>
				<div class="info">
					<a class="px-20"><?php echo $_SESSION['name']; ?></a>
				</div>
			</div>
	    </div>
	  	<div class="multinav">
		  	<div class="multinav-scroll" style="height: 100%;">	
			  	<!-- sidebar menu-->
			  	<ul class="sidebar-menu" data-widget="tree">		
					<li class="<?php if($page == 'dashboard'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/admin/dashboard">
							<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
							<span>Dashboard</span>
					  	</a>
					</li>	
					<li class="header">Management</li>

					<li class="<?php if($page == 'companies'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/admin/companies/manage">
							<i class="mdi mdi-bank"><span class="path1"></span><span class="path2"></span></i>
							<span>Companies</span>
					  	</a>
					</li>	
					<li class="treeview">
					  	<a href="#">
							<i class="fa fa-users"><span class="path1"></span><span class="path2"></span></i>
							<span>Candidates</span>
							<span class="pull-right-container">
							  	<i class="fa fa-angle-right pull-right"></i>
							</span>
					  	</a>
					  	<ul class="treeview-menu">
							<li class="<?php if($page == 'candidates'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/candidates/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Candidates</a></li>
							<li class="<?php if($page == 'resumes'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/resumes/manage"><i class="mdi mdi-file-pdf"><span class="path1"></span><span class="path2"></span></i>Resumes</a></li>
					  	</ul>
					</li>
					<li class="treeview">
					  	<a href="#">
							<i class="icon-Briefcase"><span class="path1"></span><span class="path2"></span></i>
							<span>Jobs</span>
							<span class="pull-right-container">
							  	<i class="fa fa-angle-right pull-right"></i>
							</span>
					  	</a>
					  	<ul class="treeview-menu">
							<li class="<?php if($page == 'live-jobs'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/jobs/live"><i class="mdi mdi-thumb-up"><span class="path1"></span><span class="path2"></span></i>Live Jobs</a></li>
							<li class="<?php if($page == 'pending-jobs'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/jobs/pending"><i class="mdi mdi-thumb-down"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Pending Jobs</a></li>
							<li class="<?php if($page == 'all-jobs'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/jobs/all"><i class="mdi mdi-check-all"><span class="path1"></span><span class="path2"></span></i>All Jobs</a></li>
					  	</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="fa fa-money" style="font-size: 18px;"><span class="path1"></span><span class="path2"></span></i>
							<span>Subscriptions</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'plans'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/plans/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Subscriptions</a></li>
							<li class="<?php if($page == 'add_plans'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/plans/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Subscriptions</a></li>
							<li class="<?php if($page == 'transactions'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/transactions/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Transactions</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="mdi mdi-blogger"><span class="path1"></span><span class="path2"></span></i>
							<span>Blogs</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'blogs'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/blogs/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Blogs</a></li>
							<li class="<?php if($page == 'add_blog'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/blogs/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Blog</a></li>
							<li class="<?php if($page == 'categories'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/blogs/categories"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Blog categories</a></li>
						</ul>
					</li>
					<li class="header">Manage Locations</li>
					<li class="treeview">
						<a href="#">
							<i class="mdi mdi-map" style="font-size: 18px;"><span class="path1"></span><span class="path2"></span></i>
							<span>States</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'states'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/states/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List States</a></li>
							<li class="<?php if($page == 'add_states'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/states/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add State</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="mdi mdi-map-marker" style="font-size: 18px;"><span class="path1"></span><span class="path2"></span></i>
							<span>Cities</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'cities'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/cities/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Cities</a></li>
							<li class="<?php if($page == 'add_cities'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/cities/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add City</a></li>
						</ul>
					</li>
					<li class="header">Job Attributes</li>
					<li class="treeview">
						<a href="#">
							<i class="mdi mdi-chart-pie"><span class="path1"></span><span class="path2"></span></i>
							<span>Functional Areas</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'functional_areas'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/functional_areas/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Functional Areas</a></li>
							<li class="<?php if($page == 'add_functional_areas'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/functional_areas/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Functional Area</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="mdi mdi-office"><span class="path1"></span><span class="path2"></span></i>
							<span>Industries</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'industries'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/industries/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Industries</a></li>
							<li class="<?php if($page == 'add_industries'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/industries/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Industry</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="ti ti-stats-up"><span class="path1"></span><span class="path2"></span></i>
							<span>Job Experiences</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'job_experiences'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/job_experiences/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Job Experiences</a></li>
							<li class="<?php if($page == 'add_job_experiences'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/job_experiences/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Job Experience</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="mdi mdi-chart-line"><span class="path1"></span><span class="path2"></span></i>
							<span>Job Skills</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'job_skills'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/job_skills/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Job Skills</a></li>
							<li class="<?php if($page == 'add_job_skills'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/job_skills/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Job Skill</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="ti ti-briefcase"><span class="path1"></span><span class="path2"></span></i>
							<span>Job Types</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'job_types'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/job_types/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Job Types</a></li>
							<li class="<?php if($page == 'add_job_types'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/job_types/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Job Type</a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#">
							<i class="mdi mdi-school"><span class="path1"></span><span class="path2"></span></i>
							<span>Qualifications</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-right pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if($page == 'qualifications'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/qualifications/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Qualifications</a></li>
							<li class="<?php if($page == 'add_qualifications'){echo 'active';} ?>"><a href="<?php echo $path; ?>/admin/qualifications/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Qualification</a></li>
						</ul>
					</li>

					<li class="header">Site Setting </li>
					<li class="<?php if($page == 'settings'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/admin/settings">
							<i class="mdi mdi-bank"><span class="path1"></span><span class="path2"></span></i>
							<span>Settings</span>
					  	</a>
					</li>	
			  	</ul>
		  	</div>
		</div>
    </section>
		</aside>