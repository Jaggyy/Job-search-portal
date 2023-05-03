<header class="main-header">
	<div class="d-flex align-items-center logo-box justify-content-start">
		<a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent text-white" data-toggle="push-menu" role="button">
			<i data-feather="menu"></i>
		</a>	
		<!-- Logo -->
		<a href="<?php echo $path; ?>/candidate/dashboard" class="logo">
		  	<!-- logo-->
		  	<div class="logo-lg">
			  	<span class="light-logo"><img src="<?php echo $path; ?>/assets/images/naukri-logo.png" alt="logo"></span>
			  	<span class="dark-logo"><img src="<?php echo $path; ?>/assets/images/naukri-logo.png" alt="logo"></span>
		  	</div>
		</a>	
	</div>  
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
      	<!-- Sidebar toggle button-->
	  	<div class="app-menu">
			<ul class="header-megamenu nav">
				<li class="btn-group nav-item d-md-none">
					<a href="#" class="waves-effect waves-light nav-link push-btn" data-toggle="push-menu" role="button">
						<i data-feather="menu"></i>
				    </a>
				</li>
			</ul> 
	  	</div>
		
      	<div class="navbar-custom-menu r-side">
        	<ul class="nav navbar-nav">	
				<li class="btn-group nav-item d-lg-flex d-none align-items-center">
					<p class="mb-0 text-fade pe-10 pt-5"><?php echo date("l, jS F Y"); ?></p>
				</li>
				<li class="btn-group nav-item d-lg-inline-flex d-none">
					<a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen" title="Full Screen">
						<i data-feather="maximize"></i>
					</a>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<!-- User Account-->
				<li class="dropdown user user-menu">
					<a href="#" class="waves-effect waves-light dropdown-toggle" data-bs-toggle="dropdown" title="User">
						<i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
					</a>
					<ul class="dropdown-menu animated flipInX">
						<li class="user-body">
							<a class="dropdown-item" href="<?php echo $path; ?>/candidate/profile"><i class="ti-user text-muted me-2"></i> Profile</a>
							<a class="dropdown-item" href="<?php echo $path; ?>/candidate/change-password"><i class="ti-lock text-muted me-2"></i> Change Password</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo $path; ?>/candidate/includes/logout"><i class="ti-lock text-muted me-2"></i> Logout</a>
						</li>
					</ul>
				</li>	
        	</ul>
      	</div>
    </nav>
</header>   