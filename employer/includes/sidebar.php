<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">	
		<div class="user-profile px-20 py-10">
			<div class="d-flex align-items-center">			
				<div class="image">
				  <img src="<?php echo $path; ?>/assets/images/logo/<?php echo $_SESSION['logo']; ?>" class="avatar avatar-lg bg-primary-light rounded100" alt="User Image">
				</div>
				<div class="info">
					<a class="px-20"><?php echo $_SESSION['cname']; ?></a>
				</div>
			</div>
	    </div>
	  	<div class="multinav">
		  	<div class="multinav-scroll" style="height: 100%;">	
			  	<!-- sidebar menu-->
			  	<ul class="sidebar-menu" data-widget="tree">		
					<li class="<?php if($page == 'dashboard'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/employer/dashboard">
							<i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i>
							<span>Dashboard</span>
					  	</a>
					</li>	
					<li class="header">Management</li>

					<li class="treeview">
					  	<a href="#">
							<i class="icon-Briefcase"><span class="path1"></span><span class="path2"></span></i>
							<span>Jobs</span>
							<span class="pull-right-container">
							  	<i class="fa fa-angle-right pull-right"></i>
							</span>
					  	</a>
					  	<ul class="treeview-menu">
							<li class="<?php if($page == 'jobs'){echo 'active';} ?>"><a href="<?php echo $path; ?>/employer/jobs/manage"><i class="mdi mdi-format-list-bulleted"><span class="path1"></span><span class="path2"></span></i>List Jobs</a></li>
							<li class="<?php if($page == 'add_jobs'){echo 'active';} ?>"><a href="<?php echo $path; ?>/employer/jobs/create"><i class="mdi mdi-plus"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Add Job</a></li>
					  	</ul>
					</li>
					<li class="<?php if($page == 'subscriptions'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/employer/subscriptions/manage">
							<i class="mdi mdi-currency-inr" style="font-size: 18px;"><span class="path1"></span><span class="path2"></span></i>
							<span>Subscriptions</span>
					  	</a>
					</li>
					<li class="<?php if($page == 'transactions'){echo 'active';} ?>">
					  	<a href="<?php echo $path; ?>/employer/transactions/manage">
							<i class="fa fa-money" style="font-size: 18px;"><span class="path1"></span><span class="path2"></span></i>
							<span>Transactions</span>
					  	</a>
					</li>
			  	</ul>
		  	</div>
		</div>
    </section>
		</aside>