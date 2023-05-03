<?php
error_reporting(E_NOTICE);
$candidate_id = $_SESSION['candidate_id'];
if(isset($_POST['update']))
{
    $firstname = filter_var(htmlentities($_POST['firstname']), FILTER_SANITIZE_STRING);
    $lastname = filter_var(htmlentities($_POST['lastname']), FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var(htmlentities($_POST['phone']), FILTER_SANITIZE_NUMBER_INT);
    $dob = filter_var(htmlentities($_POST['dob']), FILTER_SANITIZE_STRING);
    $gender = filter_var(htmlentities($_POST['gender']), FILTER_SANITIZE_STRING);
    $updated_at = date("F d, Y");

    if($firstname == null || $lastname == null || $email == null || $phone == null || $dob == null || $gender == null)
    {
        header ("Location: ".$path."/candidate/resume-builder?error=empty");
    }
    elseif(!filter_var($email, FILTER_SANITIZE_EMAIL))
    {
        header ("Location: ".$path."/candidate/resume-builder?email=invalid");
    }
    elseif(empty($empty) && empty($email_error))
    {
        $sql = "UPDATE candidates SET firstname = :firstname, lastname = :lastname, email = :email, phone = :phone, dob = :dob, gender = :gender, updated_at = :updated_at WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
        $stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $stmt->bindParam(':id', $candidate_id, PDO::PARAM_INT);
        $statement = $stmt->execute();
        if($statement)
        {
            header ("Location: ".$path."/candidate/resume-builder?updation=success");
        }
        else
        {
            header ("Location: ".$path."/candidate/resume-builder?error=error");
        }
        // Close statement
        unset($statement);
    }
}
?>

<!-- ****************************** Language Query ******************************************
    **************************************************************************************** -->

<?php
if(isset($_POST['addLanguage']))
{
    $language = filter_var(htmlentities($_POST['language']), FILTER_SANITIZE_STRING);
    $created_at = date("F d, Y");

    $check_exp = "SELECT * FROM manage_candidate_languages WHERE candidate_id = :candidate_id AND language = :language";
    $run_check_exp = $conn->prepare($check_exp);
    $run_check_exp->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
    $run_check_exp->bindParam(":language", $language, PDO::PARAM_STR);
    $run_check_exp->execute();

    $num_exist = $run_check_exp->rowCount();

    if($language == null)
    {
        header ("Location: ".$path."/candidate/resume-builder?error=empty-language");
    }
    elseif($num_exist == 1)
    {
        header ("Location: ".$path."/candidate/resume-builder?language=duplicate");
    }
    else
    {
        $sql = "INSERT INTO manage_candidate_languages (candidate_id, language, created_at) VALUES (:candidate_id, :language, :created_at)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $stmt->bindParam(':language', $language, PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $statement = $stmt->execute();
        if($statement)
        {
            header ("Location: ".$path."/candidate/resume-builder?language=inserted");
        }
        else
        {
            header ("Location: ".$path."/candidate/resume-builder?error=language-insertion-error");
        }
    }
}
?>

<?php
if(isset($_POST['update-4']))
{
    $id = filter_var(htmlentities($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
    $language = filter_var(htmlentities($_POST['language']),FILTER_SANITIZE_STRING);
    $updated_at = date("F d, Y");

    if($language == null || $id == null)
    {
        header ("Location: ".$path."/candidate/resume-builder?error=language-empty");
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE manage_candidate_languages SET language = :language, updated_at = :updated_at WHERE candidate_id = :candidate_id AND id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':language', $language, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $stmt->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $statement = $stmt->execute();
        if($statement)
        {
            header ("Location: ".$path."/candidate/resume-builder?language=updated");
        }
        else
        {
            header ("Location: ".$path."/candidate/resume-builder?error=language-updation-error");
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
        header ("Location: ".$path."/candidate/resume-builder?error=empty-data");
    }
    elseif($num_exist == 1)
    {
        header ("Location: ".$path."/candidate/resume-builder?data=duplicate");
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
            header ("Location: ".$path."/candidate/resume-builder?operation=success");
        }
        else
        {
            header ("Location: ".$path."/candidate/resume-builder?error=insertion-error");
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
        header ("Location: ".$path."/candidate/resume-builder?error=empty-inputs");
    }
    elseif($num_exist == 1)
    {
        header ("Location: ".$path."/candidate/resume-builder?duplicate=input");
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
            header ("Location: ".$path."/candidate/resume-builder?insertion=success");
        }
        else
        {
            header ("Location: ".$path."/candidate/resume-builder?error=operation-error");
        }
    }
}
?>

<!-- ****************************** Skill Query ******************************************
    **************************************************************************************** -->

<?php
if(isset($_POST['update-2']))
{
    $candidate_skill_id = filter_var(htmlentities($_POST['candidate_skill_id']), FILTER_SANITIZE_NUMBER_INT);
    $rating = filter_var(htmlentities($_POST['rating']),FILTER_SANITIZE_NUMBER_INT);
    $updated_at = date("F d, Y");

    if($rating == null || $candidate_skill_id == null)
    {
        header ("Location: ".$path."/candidate/resume-builder?error=empty-rating");
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE manage_candidate_skills SET rating = :rating, updated_at = :updated_at WHERE candidate_id = :id AND candidate_skill_id = :candidate_skill_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $stmt->bindParam(':id', $candidate_id, PDO::PARAM_INT);
        $stmt->bindParam(':candidate_skill_id', $candidate_skill_id, PDO::PARAM_INT);
        $statement = $stmt->execute();
        if($statement)
        {
            header ("Location: ".$path."/candidate/resume-builder?update=success");
        }
        else
        {
            header ("Location: ".$path."/candidate/resume-builder?error=update-error");
        }
        // Close statement
        unset($statement);
    }
}
?>

<!-- ****************************** Summary Query ******************************************
    **************************************************************************************** -->

<?php
if(isset($_POST['update-3']))
{
    $summary = filter_var(htmlentities($_POST['summary']), FILTER_SANITIZE_STRING);
    $updated_at = date("F d, Y");

    if($summary == null)
    {
        header ("Location: ".$path."/candidate/resume-builder?error=empty-summary");
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE candidates SET summary = :summary, updated_at = :updated_at WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':summary', $summary, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $stmt->bindParam(':id', $candidate_id, PDO::PARAM_INT);
        $statement = $stmt->execute();
        if($statement)
        {
            header ("Location: ".$path."/candidate/resume-builder?summary=updated");
        }
        else
        {
            header ("Location: ".$path."/candidate/resume-builder?error=not-updated");
        }
        // Close statement
        unset($statement);
    }
}
?>