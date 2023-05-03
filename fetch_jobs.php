<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
?>

<?php
if (isset($_POST["action"])) 
{
    $query = "SELECT jobs.*, states.state, cities.city, functional_areas.functional_area, companies.companyname, companies.logo, companies.slug AS company_slug, industries.industry, job_types.job_type, job_experiences.job_experience FROM jobs LEFT JOIN states ON jobs.state_id = states.id LEFT JOIN cities ON jobs.city_id = cities.id LEFT JOIN functional_areas ON jobs.functional_area_id = functional_areas.id LEFT JOIN companies ON jobs.company_id = companies.id LEFT JOIN industries ON jobs.industry_id = industries.id LEFT JOIN job_types ON jobs.job_type_id = job_types.id LEFT JOIN job_experiences ON jobs.job_experience_id = job_experiences.id WHERE jobs.status = 1 AND jobs.verified = 1 AND jobs.is_featured = 1";

    if (isset($_POST["states"])) 
    {
        $states_filter = implode("','", $_POST["states"]);
        $query .= "AND jobs.state_id IN('" . $states_filter . "')";
    }

    if (isset($_POST["functional_area"])) 
    {
        $functional_area_filter = implode("','", $_POST["functional_area"]);
        $query .= "AND jobs.functional_area_id IN('" . $functional_area_filter . "')";
    }

    if (isset($_POST["experience"])) 
    {
        $experience_filter = implode("','", $_POST["experience"]);
        $query .= "AND jobs.job_experience_id IN('" . $experience_filter . "')";
    }
    if (isset($_POST["qualification"])) 
    {
        $qualification_filter = implode("','", $_POST["qualification"]);
        $query .= "AND jobs.qualification_id IN('" . $qualification_filter . "')";
    }
    if (isset($_POST["industry"])) 
    {
        $industry_filter = implode("','", $_POST["industry"]);
        $query .= "AND jobs.industry_id IN('" . $industry_filter . "')";
    }
    if (isset($_POST["job_type"])) 
    {
        $job_type_filter = implode("','", $_POST["job_type"]);
        $query .= "AND jobs.job_type_id IN('" . $job_type_filter . "')";
    }
    if (isset($_POST["salary1"])) 
    {
        $query .= "AND jobs.salary_from >= 0 AND salary_to <= 300000";
    }
    if (isset($_POST["salary2"])) 
    {
        $query .= "AND jobs.salary_from >= 300000 AND salary_to <= 600000";
    }
    if (isset($_POST["salary3"])) 
    {
        $query .= "AND jobs.salary_from >= 600000 AND salary_to <= 1000000";
    }
    if (isset($_POST["salary4"])) 
    {
        $query .= "AND jobs.salary_from >= 1000000 AND salary_to <= 1500000 ORDER BY jobs.is_featured DESC";
    }
    
    $statement = $conn->prepare($query);
    $statement->execute();
    $result    = $statement->fetchAll(PDO::FETCH_OBJ);
    $total_row = $statement->rowCount();
    if ($total_row > 0) 
    {
        echo '<div class="job-listings-sec no-border">';
        foreach($result AS $row)
        {
            $job_expiry_date = strtotime($row->job_expiry_date);
            $currentDate = time();

            if($job_expiry_date > $currentDate)
            {
                $description = $row->description;
                $strcut = substr($description,0,190);
                $description = substr($strcut,0,strrpos($strcut,' ')).'...';
                echo '
                <div class="job-listing wtabs mb-2">
                    <div class="job-title-sec">
                        <div class="c-logo"><a href="'.$path.'/companies?company='.$row->company_slug.'"> <img src="'.$path.'/assets/images/logo/'.$row->logo.'" alt="'.$row->companyname.'" /></a> </div>
                        <h3><a href="'.$path.'/jobs?job='.$row->slug.'">'.$row->job_title.'</a></h3>
                        <span><a href="'.$path.'/companies?company='.$row->company_slug.'">'.$row->companyname.'</a></span>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="job-lctn"><i class="la la-map-marker"></i>'.$row->city.', '.$row->state.'</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="job-lctn"><i class="la la-briefcase"></i>'.$row->job_experience.'</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="job-lctn"><i class="la la-inr"></i>';
                                    if($row->hide_salary = 0) 
                                    {  
                                        echo 'Not Specified'; 
                                    } 
                                    else 
                                    { 
                                        echo ''.$row->salary_from.' - '.$row->salary_to.''; 
                                    }
                                    echo '
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="job-desc">'.htmlspecialchars_decode($description).'</p>
                        </div>
                        <div class="col-md-12">
                            <b class="job-skills">Skills : </b>';
                            $job_id = $row->job_id;
                            $sql_qry = "SELECT job_skills.*, manage_job_skills.job_id, manage_job_skills.job_skill_id FROM job_skills LEFT JOIN manage_job_skills ON job_skills.id = manage_job_skills.job_skill_id WHERE manage_job_skills.job_id = :job_id";
                            $queries = $conn->prepare($sql_qry);
                            $queries->bindParam(":job_id", $job_id, PDO::PARAM_INT);
                            $queries->execute();
                            $res = $queries->fetchAll(PDO::FETCH_OBJ);
                            if($queries->rowCount() > 0)
                            {
                                foreach($res AS $skill)
                                {
                                    echo '
                                    <p class="waves-effect badge badge-secondary"><a href="'.$path.'/search/skill?name='.$skill->slug.'">'.$skill->job_skill.'</a></p>';
                                }
                            }
                            else
                            {
                                echo 'Not Specified';
                            }
                        echo '
                        </div>
                    </div>
                    <div class="job-style-bx">
                        <a href="'.$path.'/job-apply?id='.$row->job_id.'"><span class="job-is btn btn-outline-info" style="float: right;">APPLY</span></a>';
                        $created_on = strtotime($row->created_at);
                        echo '
                        <i>Posted : '.date('jS M, Y', $created_on).'</i>
                    </div>';
                    if($row->is_featured == 1)
                    {
                        echo '
                        <img src="'.$path.'/assets/images/star.png" class="featured-img" data-toggle="tooltip" data-placement="bottom" title="Featured">';
                    }
                echo '
                </div>';
            }
        }
        echo '
        </div>';
    } 
    else 
    {
        $output = '
        <div class="job-listings-sec no-border">
            <div class="job-listing wtabs mb-2">
                <div class="empty-box">
                    <img class="mb-1" src="'.$path.'/assets/images/empty_box.png" width="120px">
                    <br>
                    <span class="">Data Not Found</span>
                </div>
            </div>
        </div>';
    }
    echo $output;
}

?>