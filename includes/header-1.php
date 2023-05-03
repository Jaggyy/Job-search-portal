<header class="gradient">
    <div class="menu-sec">
        <div class="container">
            <div class="logo">
                <a href="<?php echo $path; ?>" title=""><img src="<?php echo $path; ?>/assets/images/naukri-logo.png" alt="" style="width: 178px;height: 40px;" /></a>
            </div><!-- Logo -->

            <div class="btn-extars">
                <?php
                if(isset($_SESSION['candidate_login']) == 0)
                {
                    echo '
                    <a href="'.$path.'/candidate" title="" class="login-btn mr-2"><i class="la la-plus"></i>JOBSEEKER LOGIN</a>';
                }
                if(isset($_SESSION['login']) == 0)
                {
                    echo '
                    <a href="'.$path.'/employer" title="" class="login-btn"><i class="la la-plus"></i>EMPLOYER LOGIN</a>';
                }
                ?>
            </div><!-- Btn Extras -->
            <nav>
                <ul>
                    <li class="menu-item-has-children">
                        <a href="#" title="">JOB SEARCH</a>
                        <ul>
                            <li class="menu-item-has-children">
                                <a href="#" title="">BY LOCATION <span class="float-right"><i class="la la-angle-right"></i></span></a>
                                <ul>
                                    <?php
                                    $sql_retrieve = "SELECT DISTINCT(jobs.city_id), cities.city, cities.slug FROM jobs LEFT JOIN cities ON jobs.city_id = cities.id ORDER BY jobs.id LIMIT 5";
                                    $query = $conn->prepare($sql_retrieve);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $query_fetch)
                                        {
                                            echo '
                                            <li><a href="'.$path.'/search/location?name='.$query_fetch->slug.'" title="">JOBS IN '.strtoupper($query_fetch->city).'</a></li>';
                                        }
                                        echo '
                                        <li><a href="'.$path.'/search/jobs_by_location" title="">VIEW ALL JOBS BY LOCATION</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#" title="">BY SKILLS <span class="float-right"><i class="la la-angle-right"></i></span></a>
                                <ul>
                                    <?php
                                    $sql_retrieve = "SELECT DISTINCT(manage_job_skills.job_skill_id), job_skills.job_skill, job_skills.slug FROM manage_job_skills LEFT JOIN job_skills ON manage_job_skills.job_skill_id = job_skills.id WHERE job_skills.status = 1 ORDER BY job_skills.id LIMIT 5";
                                    $query = $conn->prepare($sql_retrieve);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $query_fetch)
                                        {
                                            echo '
                                            <li><a href="'.$path.'/search/skill?name='.$query_fetch->slug.'" title="">'.strtoupper($query_fetch->job_skill).' JOBS</a></li>';
                                        }
                                        echo '
                                        <li><a href="'.$path.'/search/jobs_by_skill" title="">VIEW ALL JOBS BY SKILLS</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#" title="">BY INDUSTRY <span class="float-right"><i class="la la-angle-right"></i></span></a>
                                <ul>
                                    <?php
                                    $sql_retrieve = "SELECT DISTINCT(jobs.industry_id), industries.industry, industries.slug FROM jobs LEFT JOIN industries ON jobs.industry_id = industries.id WHERE industries.status = 1 ORDER BY jobs.id LIMIT 5";
                                    $query = $conn->prepare($sql_retrieve);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $query_fetch)
                                        {
                                            echo '
                                            <li><a href="'.$path.'/search/industry?name='.$query_fetch->slug.'" title="">'.strtoupper($query_fetch->industry).' JOBS</a></li>';
                                        }
                                        echo '
                                        <li><a href="'.$path.'/search/jobs_by_industry" title="">VIEW ALL JOBS BY INDUSTRY</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#" title="">BY DESIGNATION <span class="float-right"><i class="la la-angle-right"></i></span></a>
                                <ul>
                                    <?php
                                    $sql_retrieve = "SELECT DISTINCT(jobs.functional_area_id), functional_areas.functional_area, functional_areas.slug FROM jobs LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id WHERE functional_areas.status = 1 ORDER BY jobs.id LIMIT 5";
                                    $query = $conn->prepare($sql_retrieve);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $query_fetch)
                                        {
                                            echo '
                                            <li><a href="'.$path.'/search/designation?name='.$query_fetch->slug.'" title="">'.strtoupper($query_fetch->functional_area).' JOBS</a></li>';
                                        }
                                        echo '
                                        <li><a href="'.$path.'/search/jobs_by_designation" title="">VIEW ALL JOBS BY DESIGNATION</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#" title="">BY COMPANY <span class="float-right"><i class="la la-angle-right"></i></span></a>
                                <ul>
                                    <?php
                                    $sql_retrieve = "SELECT DISTINCT(jobs.company_id), companies.companyname, companies.slug FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id WHERE companies.status = 1 AND companies.is_featured = 1 AND companies.verified = 1 ORDER BY jobs.id LIMIT 5";
                                    $query = $conn->prepare($sql_retrieve);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $query_fetch)
                                        {
                                            echo '
                                            <li><a href="'.$path.'/search/company?name='.$query_fetch->slug.'" title="">'.strtoupper($query_fetch->companyname).' JOBS</a></li>';
                                        }
                                        echo '
                                        <li><a href="'.$path.'/search/jobs_by_company" title="">VIEW ALL JOBS BY COMPANY</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="#" title="">BY QUALIFICATION <span class="float-right"><i class="la la-angle-right"></i></span></a>
                                <ul>
                                    <?php
                                    $sql_retrieve = "SELECT DISTINCT(jobs.qualification_id), qualifications.abbreviation, qualifications.slug FROM jobs LEFT JOIN qualifications ON jobs.qualification_id = qualifications.id WHERE qualifications.status = 1 ORDER BY jobs.id LIMIT 5";
                                    $query = $conn->prepare($sql_retrieve);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    if($query->rowCount() > 0)
                                    {
                                        foreach($results as $query_fetch)
                                        {
                                            echo '
                                            <li><a href="'.$path.'/search/qualification?name='.$query_fetch->slug.'" title="">'.strtoupper($query_fetch->abbreviation).' JOBS</a></li>';
                                        }
                                        echo '
                                        <li><a href="'.$path.'/search/jobs_by_qualification" title="">VIEW ALL JOBS BY QUALIFICATION</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#" title="">COMPANIES</a>
                        <ul>
                            <li><a href="<?php echo $path; ?>/search/jobs_by_company" title="">BROWSE ALL COMPANIES</a></li>
                        </ul>
                    </li>
                    <?php
                    if(isset($_SESSION['candidate_login']))
                    {
                        echo '
                        <li class="menu-item-has-children">
                            <a href="#" style="padding: 3px 20px;"><img src="'.$path.'/assets/images/profile_picture/'.$_SESSION['photo'].'" alt="" style="width: 50px; height: 50px; border-radius: 50%;"> '.$_SESSION['candidate_name'].' </a>
                            <ul>
                                <li><a href="'.$path.'/candidate/dashboard" style="line-height: 30px;"><i class="la la-file-text"></i>Dashboard</a></li>
                                <li><a href="'.$path.'/candidate/includes/logout" style="line-height: 30px;"><i class="la la-unlink"></i>Logout</a></li>
                            </ul>
                        </li>';
                    }
                    if(isset($_SESSION['login']))
                    {
                        echo '
                        <li class="menu-item-has-children">
                            <a href="#" style="padding: 3px 20px;"><img src="'.$path.'/assets/images/logo/'.$_SESSION['logo'].'" alt="" style="width: 50px; height: 50px; border-radius: 50%;"> '.$_SESSION['cname'].' </a>
                            <ul>
                                <li><a href="'.$path.'/employer/dashboard" style="line-height: 30px;"><i class="la la-file-text"></i>Company Dashboard</a></li>
                                <li><a href="'.$path.'/employer/includes/logout" style="line-height: 30px;"><i class="la la-unlink"></i>Logout</a></li>
                            </ul>
                        </li>';
                    } 
                    ?>
                </ul>
            </nav><!-- Menus -->
        </div>
    </div>
</header>