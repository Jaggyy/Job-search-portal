<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
if(isset($_POST['submit']))
{
    $job_id = rand(0,9999);
    $job_title = filter_var(htmlentities($_POST['job_title']), FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$job_title);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $industry_id = filter_var(htmlentities($_POST['industry_id']),FILTER_SANITIZE_NUMBER_INT);
    $company_id = filter_var(htmlentities($_POST['company_id']),FILTER_SANITIZE_NUMBER_INT);
    $functional_area_id = filter_var(htmlentities($_POST['functional_area_id']),FILTER_SANITIZE_NUMBER_INT);
    $job_type_id = filter_var(htmlentities($_POST['job_type_id']),FILTER_SANITIZE_NUMBER_INT);
    $country = filter_var(htmlentities($_POST['country']),FILTER_SANITIZE_STRING);
    $state_id = filter_var(htmlentities($_POST['state_id']),FILTER_SANITIZE_NUMBER_INT);
    $city_id = filter_var(htmlentities($_POST['city_id']),FILTER_SANITIZE_NUMBER_INT);
    $gender = filter_var(htmlentities($_POST['gender']),FILTER_SANITIZE_STRING);
    $salary_from = filter_var(htmlentities($_POST['salary_from']),FILTER_SANITIZE_NUMBER_INT);
    $salary_to = filter_var(htmlentities($_POST['salary_to']),FILTER_SANITIZE_NUMBER_INT);
    $qualification_id = filter_var(htmlentities($_POST['qualification_id']),FILTER_SANITIZE_NUMBER_INT);
    $job_experience_id = filter_var(htmlentities($_POST['job_experience_id']),FILTER_SANITIZE_NUMBER_INT);
    $job_expiry_date = filter_var(htmlentities($_POST['job_expiry_date']),FILTER_SANITIZE_STRING);
    $num_of_posts = filter_var(htmlentities($_POST['num_of_posts']),FILTER_SANITIZE_NUMBER_INT);
    $description = filter_var(htmlentities($_POST['description'],ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $job_skill_id = $_POST['job_skill_id'];
    $hide_salary = filter_var(htmlentities($_POST['hide_salary']),FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("Y-m-d");

    $check = "SELECT * FROM companies WHERE id = :id";
    $output = $conn->prepare($check);
    $output->bindParam(':id', $company_id, PDO::PARAM_INT);
    $output->execute();
    $query_fetch = $output->fetch();
    $package_id = $query_fetch['package_id'];
    $package_start_date = $query_fetch['package_start_date'];
    $package_end_date = $query_fetch['package_end_date'];
    $currentDate = date('Y-m-d');
    $currentDate = date('Y-m-d', strtotime($currentDate));

    $sql_retrieve = "SELECT companies.package_id, plans.* FROM plans LEFT JOIN companies ON plans.id = companies.package_id WHERE companies.id = :company_id";
    $query = $conn->prepare($sql_retrieve);
    $query->bindParam(':company_id', $company_id, PDO::PARAM_INT);
    $query->execute();
    $results=$query->fetch();

    $check_jobs = "SELECT jobs.id AS id, jobs.created_at, jobs.company_id, companies.package_start_date, companies.package_end_date FROM jobs LEFT JOIN companies ON jobs.company_id = companies.id WHERE jobs.company_id = :company_id AND (jobs.created_at BETWEEN companies.package_start_date AND companies.package_end_date)";
    $fetch_id = $conn->prepare($check_jobs);
    $fetch_id->bindParam(':company_id', $_SESSION['company_id'], PDO::PARAM_INT);
    $fetch_id->execute();
    $cnt = $fetch_id->rowCount();
    $jobs_left = ($results['allowed_jobs'] - $cnt);

    if($package_id == null)
    {
        header ("Location: http://localhost/naukri/employer/jobs/create?error=package_error");
    }
    elseif(($currentDate <= $package_start_date) && ($currentDate >= $package_end_date))
    {
        header ("Location: http://localhost/naukri/employer/jobs/create?error=subscription_error");
    }
    elseif($jobs_left == 0)
    {
        header ("Location: http://localhost/naukri/employer/jobs/create?error=jobs_error");
    }
    elseif($job_title == null || $functional_area_id == null || $job_type_id == null || $country == null || $state_id == null || $city_id == null || $gender == null || $salary_from == null || $salary_to == null || $qualification_id == null || $job_experience_id == null || $job_expiry_date == null || $num_of_posts == null || $description == null || $hide_salary == null)
    {
        header ("Location: http://localhost/naukri/employer/jobs/create?empty=empty");
    }
    else
    {
        $sql = "INSERT INTO jobs (job_id, job_title, slug, industry_id,company_id, functional_area_id, job_type_id, country, state_id, city_id, gender, salary_from, salary_to, qualification_id, job_experience_id, job_expiry_date, num_of_posts, description, hide_salary, created_at) VALUES (:job_id, :job_title, :slug, :industry_id, :company_id, :functional_area_id, :job_type_id, :country, :state_id, :city_id, :gender, :salary_from, :salary_to, :qualification_id, :job_experience_id, :job_expiry_date, :num_of_posts, :description, :hide_salary, :created_at)";
        $stmt = $conn->prepare($sql);
        if($stmt)
        {
            foreach ($job_skill_id as $job_skill) 
            {
                $sql_insert = "INSERT INTO manage_job_skills (job_id, job_skill_id, created_at) VALUES (:job_id, :job_skill_id, :created_at)";
                $rslt = $conn->prepare($sql_insert);
                if($rslt)
                {
                    // Bind variables to the prepared statement as parameters
                    $rslt->bindParam(":job_id", $job_id, PDO::PARAM_INT);
                    $rslt->bindParam(":job_skill_id", $job_skill, PDO::PARAM_INT);
                    $rslt->bindParam(":created_at", $created_at, PDO::PARAM_STR);
                    $result = $rslt->execute();
                    if($result)
                    {
                        // Bind variables to the prepared statement as parameters
                        $stmt->bindParam(":job_id", $job_id, PDO::PARAM_INT);
                        $stmt->bindParam(":job_title", $job_title, PDO::PARAM_STR);
                        $stmt->bindParam(":slug", $slug, PDO::PARAM_STR);
                        $stmt->bindParam(":industry_id", $industry_id, PDO::PARAM_INT);
                        $stmt->bindParam(":company_id", $company_id, PDO::PARAM_INT);
                        $stmt->bindParam(":functional_area_id", $functional_area_id, PDO::PARAM_INT);
                        $stmt->bindParam(":job_type_id", $job_type_id, PDO::PARAM_INT);
                        $stmt->bindParam(":country", $country, PDO::PARAM_STR);
                        $stmt->bindParam(":state_id", $state_id, PDO::PARAM_INT);
                        $stmt->bindParam(":city_id", $city_id, PDO::PARAM_INT);
                        $stmt->bindParam(":gender", $gender, PDO::PARAM_STR);
                        $stmt->bindParam(":salary_from", $salary_from, PDO::PARAM_INT);
                        $stmt->bindParam(":salary_to", $salary_to, PDO::PARAM_INT);
                        $stmt->bindParam(":qualification_id", $qualification_id, PDO::PARAM_INT);
                        $stmt->bindParam(":job_experience_id", $job_experience_id, PDO::PARAM_INT);
                        $stmt->bindParam(":job_expiry_date", $job_expiry_date, PDO::PARAM_STR);
                        $stmt->bindParam(":num_of_posts", $num_of_posts, PDO::PARAM_INT);
                        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
                        $stmt->bindParam(":hide_salary", $hide_salary, PDO::PARAM_INT);
                        $stmt->bindParam(":created_at", $created_at, PDO::PARAM_STR);
                        $statement = $stmt->execute();
                        // Attempt to execute the prepared statement
                        if($statement)
                        {
                            header ("Location: http://localhost/naukri/employer/jobs/create?insertion=success");
                        } 
                        else
                        {
                            header ("Location: http://localhost/naukri/employer/jobs/create?error=error");
                        }

                        // Close statement
                        unset($stmt);
                    }
                    // Close statement
                    unset($result);
                }
            }
        }
    }
}
?>