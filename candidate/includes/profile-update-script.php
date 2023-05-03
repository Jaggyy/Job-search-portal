<?php
error_reporting(E_NOTICE);
$candidate_id = $_SESSION['candidate_id'];
if(isset($_POST['update']))
{
    $firstname = filter_var(htmlentities($_POST['firstname']), FILTER_SANITIZE_STRING);
    $lastname = filter_var(htmlentities($_POST['lastname']), FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var(htmlentities($_POST['phone']), FILTER_SANITIZE_NUMBER_INT);
    $fathername = filter_var(htmlentities($_POST['fathername']), FILTER_SANITIZE_STRING);
    $dob = filter_var(htmlentities($_POST['dob']), FILTER_SANITIZE_STRING);
    $gender = filter_var(htmlentities($_POST['gender']), FILTER_SANITIZE_STRING);
    $candidate_skill_id = $_POST['candidate_skill_id'];
    $marital_status = filter_var(htmlentities($_POST['marital_status']), FILTER_SANITIZE_STRING);
    $nationality = filter_var(htmlentities($_POST['nationality']), FILTER_SANITIZE_STRING);
    $expected_salary = filter_var(htmlentities($_POST['expected_salary']),FILTER_SANITIZE_NUMBER_INT);
    $country = filter_var(htmlentities($_POST['country']),FILTER_SANITIZE_STRING);
    $state_id = filter_var(htmlentities($_POST['state_id']),FILTER_SANITIZE_NUMBER_INT);
    $city_id = filter_var(htmlentities($_POST['city_id']),FILTER_SANITIZE_NUMBER_INT);
    $job_experience_id = filter_var(htmlentities($_POST['job_experience_id']),FILTER_SANITIZE_NUMBER_INT);
    $industry_id = filter_var(htmlentities($_POST['industry_id']),FILTER_SANITIZE_NUMBER_INT);
    $functional_area_id = filter_var(htmlentities($_POST['functional_area_id']),FILTER_SANITIZE_NUMBER_INT);
    $updated_at = date("F d, Y");

    if($firstname == null || $lastname == null || $email == null || $phone == null || $dob == null || $gender == null || $candidate_skill_id == null || $marital_status == null || $country == null || $state_id == null || $city_id == null || $job_experience_id == null || $industry_id == null || $functional_area_id == null)
    {
        header ("Location: ".$path."/candidate/profile?error=empty");
    }
    elseif(!filter_var($email, FILTER_SANITIZE_EMAIL))
    {
        header ("Location: ".$path."/candidate/profile?email=invalid");
    }
    elseif(empty($empty) && empty($email_error))
    {
        $sql = "UPDATE candidates SET firstname = :firstname, lastname = :lastname, email = :email, phone = :phone, fathername = :fathername, dob = :dob, gender = :gender, marital_status = :marital_status, nationality = :nationality, expected_salary = :expected_salary, country = :country, state_id = :state_id, city_id = :city_id, job_experience_id = :job_experience_id, industry_id = :industry_id, functional_area_id = :functional_area_id, updated_at = :updated_at WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
        $stmt->bindParam(':fathername', $fathername, PDO::PARAM_STR);
        $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':marital_status', $marital_status, PDO::PARAM_STR);
        $stmt->bindParam(':nationality', $nationality, PDO::PARAM_STR);
        $stmt->bindParam(':job_experience_id', $job_experience_id, PDO::PARAM_INT);
        $stmt->bindParam(':expected_salary', $expected_salary, PDO::PARAM_INT);
        $stmt->bindParam(':country', $country, PDO::PARAM_STR);
        $stmt->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $stmt->bindParam(':city_id', $city_id, PDO::PARAM_INT);
        $stmt->bindParam(':job_experience_id', $job_experience_id, PDO::PARAM_INT);
        $stmt->bindParam(':industry_id', $industry_id, PDO::PARAM_INT);
        $stmt->bindParam(':functional_area_id', $functional_area_id, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $stmt->bindParam(':id', $candidate_id, PDO::PARAM_INT);
        $statement = $stmt->execute();
        if($statement)
        {
            $query = "SELECT * FROM manage_candidate_skills WHERE candidate_id = :candidate_id";
            $query_run = $conn->prepare($query);
            $candidate_skill_values = [];
            $query_run->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
            $query_run->execute();
            $row = $query_run->fetchAll();

            foreach($row AS $candidate_skill_data)
            {
                $candidate_skill_values[] = $candidate_skill_data['candidate_skill_id'];
            }

            //Insert newly added skills
            foreach ($candidate_skill_id as $candidate_skill) 
            {
                if(!in_array($candidate_skill, $candidate_skill_values))
                {
                    $sql_insert = "INSERT INTO manage_candidate_skills(candidate_id, candidate_skill_id, created_at) VALUES (:candidate_id, :candidate_skill_id, :created_at)";
                    $rslt = $conn->prepare($sql_insert);
                    if($rslt)
                    {
                        // Bind variables to the prepared statement as parameters
                        $rslt->bindParam(":candidate_skill_id", $candidate_skill, PDO::PARAM_INT);
                        $rslt->bindParam(":created_at", $updated_at, PDO::PARAM_STR);
                        $rslt->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
                        $result = $rslt->execute();
                    }
                }
            }

            //Delete added skills
            foreach($candidate_skill_values AS $candidate_skill_rows)
            {
                if(!in_array($candidate_skill_rows, $candidate_skill_id))
                {
                    $sql_insert = "DELETE FROM manage_candidate_skills WHERE candidate_id = :candidate_id AND candidate_skill_id = :candidate_skill_id";
                    $rslt = $conn->prepare($sql_insert);
                    if($rslt)
                    {
                        // Bind variables to the prepared statement as parameters
                        $rslt->bindParam(":candidate_skill_id", $candidate_skill_rows, PDO::PARAM_INT);
                        $rslt->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
                        $result = $rslt->execute();
                    }
                }
            }
            if($statement || $result)
            {
                header ("Location: ".$path."/candidate/profile?updation=success");
            }
            else
            {
                header ("Location: ".$path."/candidate/profile?error=error");
            }
            // Close statement
            unset($result);
        }
        // Close statement
        unset($statement);
    }
}
?>

<!-- ****************************** Experience Query ******************************************
    **************************************************************************************** -->

<?php
if(isset($_POST['addExperience']))
{
    $experience_title = filter_var(htmlentities($_POST['experience_title']), FILTER_SANITIZE_STRING);
    $company = filter_var(htmlentities($_POST['company']), FILTER_SANITIZE_STRING);
    $state_id = filter_var(htmlentities($_POST['state_id']),FILTER_SANITIZE_NUMBER_INT);
    $city_id = filter_var(htmlentities($_POST['city_id']),FILTER_SANITIZE_NUMBER_INT);
    $start_date = filter_var(htmlentities($_POST['start_date']),FILTER_SANITIZE_STRING);
    $end_date = filter_var(htmlentities($_POST['end_date']),FILTER_SANITIZE_STRING);
    $description = filter_var(htmlentities($_POST['description']),FILTER_SANITIZE_STRING);
    $created_at = date("F d, Y");

    $check_exp = "SELECT * FROM manage_candidate_experiences WHERE candidate_id = :candidate_id AND experience_title = :experience_title AND company = :company";
    $run_check_exp = $conn->prepare($check_exp);
    $run_check_exp->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
    $run_check_exp->bindParam(":experience_title", $experience_title, PDO::PARAM_STR);
    $run_check_exp->bindParam(":company", $company, PDO::PARAM_STR);
    $run_check_exp->execute();

    $num_exist = $run_check_exp->rowCount();

    if($experience_title == null || $company == null || $state_id == null || $city_id == null || $start_date == null || $end_date == null || $description == null)
    {
        header ("Location: ".$path."/candidate/profile?error=empty-data");
    }
    elseif($num_exist == 1)
    {
        header ("Location: ".$path."/candidate/profile?data=duplicate");
    }
    else
    {
        $sql = "INSERT INTO manage_candidate_experiences (candidate_id, experience_title, company, state_id, city_id, start_date, end_date, description, created_at) VALUES (:candidate_id, :experience_title, :company, :state_id, :city_id, :start_date, :end_date, :description, :created_at)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $stmt->bindParam(':experience_title', $experience_title, PDO::PARAM_STR);
        $stmt->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $stmt->bindParam(':city_id', $city_id, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $statement = $stmt->execute();
        if($statement)
        {
            header ("Location: ".$path."/candidate/profile?operation=success");
        }
        else
        {
            header ("Location: ".$path."/candidate/profile?error=insertion-error");
        }
    }
}
?>

<!-- ****************************** Education Query ******************************************
    **************************************************************************************** -->

<?php
if(isset($_POST['addEducation']))
{
    $qualification_id = filter_var(htmlentities($_POST['qualification_id']), FILTER_SANITIZE_NUMBER_INT);
    $institute = filter_var(htmlentities($_POST['institute']), FILTER_SANITIZE_STRING);
    $graduation_year = filter_var(htmlentities($_POST['graduation_year']),FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("F d, Y");

    $check_exp = "SELECT * FROM manage_candidate_qualifications WHERE candidate_id = :candidate_id AND qualification_id = :qualification_id AND institute = :institute";
    $run_check_exp = $conn->prepare($check_exp);
    $run_check_exp->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
    $run_check_exp->bindParam(":qualification_id", $qualification_id, PDO::PARAM_INT);
    $run_check_exp->bindParam(":institute", $institute, PDO::PARAM_STR);
    $run_check_exp->execute();

    $num_exist = $run_check_exp->rowCount();

    if($qualification_id == null || $institute == null || $graduation_year == null)
    {
        header ("Location: ".$path."/candidate/profile?error=empty-inputs");
    }
    elseif($num_exist == 1)
    {
        header ("Location: ".$path."/candidate/profile?duplicate=input");
    }
    else
    {
        $sql = "INSERT INTO manage_candidate_qualifications (candidate_id, qualification_id, institute, graduation_year, created_at) VALUES (:candidate_id, :qualification_id, :institute, :graduation_year, :created_at)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $stmt->bindParam(':qualification_id', $qualification_id, PDO::PARAM_INT);
        $stmt->bindParam(':institute', $institute, PDO::PARAM_STR);
        $stmt->bindParam(':graduation_year', $graduation_year, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $statement = $stmt->execute();
        if($statement)
        {
            header ("Location: ".$path."/candidate/profile?insertion=success");
        }
        else
        {
            header ("Location: ".$path."/candidate/profile?error=operation-error");
        }
    }
}
?>