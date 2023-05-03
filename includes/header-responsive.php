<div class="responsive-header">
    <div class="responsive-menubar">
        <div class="res-logo"><a href="<?php echo $path; ?>" title=""><img src="<?php echo $path; ?>/assets/images/naukri-logo.png" alt="" style="width: 178px;height: 40px;" /></a></div>
        <div class="menu-resaction">
            <div class="res-openmenu">
                <img src="<?php echo $path; ?>/assets/images/icon.png" alt="" /> Menu
            </div>
            <div class="res-closemenu">
                <img src="<?php echo $path; ?>/assets/images/icon2.png" alt="" /> Close
            </div>
        </div>
    </div>
    <div class="responsive-opensec">
        <div class="btn-extars">
            <a href="#" title="" class="post-job-btn"><i class="la la-plus"></i>Post Jobs</a>
            <ul class="account-btns">
                <li class="signup-popup"><a title=""><i class="la la-key"></i> Sign Up</a></li>
                <li class="signin-popup"><a title=""><i class="la la-external-link-square"></i> Login</a></li>
            </ul>
        </div><!-- Btn Extras -->
        <form class="res-search">
            <input type="text" placeholder="Job title, keywords or company name" />
            <button type="submit"><i class="la la-search"></i></button>
        </form>
        <div class="responsivemenu">
            <ul>
                <li class="menu-item-has-children">
                    <a href="#" title="">JOB SEARCH</a>
                    <ul>
                        <li class="menu-item-has-children">
                            <a href="#" title="">BY LOCATION <span class="float-right"><i class="la la-angle-right"></i></span></a>
                            <ul>
                                <?php
                                $sql_retrieve = "SELECT DISTINCT(jobs.city_id), cities.city FROM jobs LEFT JOIN cities ON jobs.city_id = cities.id";
                                $query = $conn->prepare($sql_retrieve);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                    foreach($results as $query_fetch)
                                    {
                                        echo '
                                        <li><a href="employer_manage_jobs.html" title="">JOBS IN '.strtoupper($query_fetch->city).'</a></li>';
                                    }
                                    echo '
                                    <li><a href="employer_manage_jobs.html" title="">VIEW ALL JOBS BY LOCATION</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#" title="">BY SKILLS <span class="float-right"><i class="la la-angle-right"></i></span></a>
                            <ul>
                                <?php
                                $sql_retrieve = "SELECT DISTINCT(manage_job_skills.job_skill_id), job_skills.job_skill FROM manage_job_skills LEFT JOIN job_skills ON manage_job_skills.job_skill_id = job_skills.id WHERE job_skills.status = 1";
                                $query = $conn->prepare($sql_retrieve);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                    foreach($results as $query_fetch)
                                    {
                                        echo '
                                        <li><a href="employer_manage_jobs.html" title="">'.strtoupper($query_fetch->job_skill).' JOBS</a></li>';
                                    }
                                    echo '
                                    <li><a href="employer_manage_jobs.html" title="">VIEW ALL JOBS BY SKILLS</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#" title="">BY INDUSTRY <span class="float-right"><i class="la la-angle-right"></i></span></a>
                            <ul>
                                <?php
                                $sql_retrieve = "SELECT DISTINCT(jobs.industry_id), industries.industry FROM jobs LEFT JOIN industries ON jobs.industry_id = industries.id WHERE industries.status = 1";
                                $query = $conn->prepare($sql_retrieve);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                    foreach($results as $query_fetch)
                                    {
                                        echo '
                                        <li><a href="employer_manage_jobs.html" title="">'.strtoupper($query_fetch->industry).' JOBS</a></li>';
                                    }
                                    echo '
                                    <li><a href="employer_manage_jobs.html" title="">VIEW ALL JOBS BY INDUSTRY</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#" title="">BY DESIGNATION <span class="float-right"><i class="la la-angle-right"></i></span></a>
                            <ul>
                                <?php
                                $sql_retrieve = "SELECT DISTINCT(jobs.functional_area_id), functional_areas.functional_area FROM jobs LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id WHERE functional_areas.status = 1";
                                $query = $conn->prepare($sql_retrieve);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                    foreach($results as $query_fetch)
                                    {
                                        echo '
                                        <li><a href="employer_manage_jobs.html" title="">'.strtoupper($query_fetch->functional_area).' JOBS</a></li>';
                                    }
                                    echo '
                                    <li><a href="employer_manage_jobs.html" title="">VIEW ALL JOBS BY DESIGNATION</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#" title="">BY COMPANY <span class="float-right"><i class="la la-angle-right"></i></span></a>
                            <ul>
                                <?php
                                $sql_retrieve = "SELECT DISTINCT(jobs.company_id), companies.companyname FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id WHERE companies.status = 1 AND companies.is_featured = 1 AND companies.verified = 1";
                                $query = $conn->prepare($sql_retrieve);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                    foreach($results as $query_fetch)
                                    {
                                        echo '
                                        <li><a href="employer_manage_jobs.html" title="">'.strtoupper($query_fetch->companyname).' JOBS</a></li>';
                                    }
                                    echo '
                                    <li><a href="employer_manage_jobs.html" title="">VIEW ALL JOBS BY COMPANY</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#" title="">BY EDUCATION <span class="float-right"><i class="la la-angle-right"></i></span></a>
                            <ul>
                                <?php
                                $sql_retrieve = "SELECT DISTINCT(jobs.qualification_id), qualifications.abbreviation FROM jobs LEFT JOIN qualifications ON jobs.qualification_id = qualifications.id WHERE qualifications.status = 1";
                                $query = $conn->prepare($sql_retrieve);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                if($query->rowCount() > 0)
                                {
                                    foreach($results as $query_fetch)
                                    {
                                        echo '
                                        <li><a href="employer_manage_jobs.html" title="">'.strtoupper($query_fetch->abbreviation).' JOBS</a></li>';
                                    }
                                    echo '
                                    <li><a href="employer_manage_jobs.html" title="">VIEW ALL JOBS BY EDUCATION</a></li>';
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="menu-item-has-children">
                    <a href="#" title="">COMPANIES</a>
                    <ul>
                        <li><a href="candidates_list.html" title="">BROWSE ALL COMPANIES</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>