<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $firstname = filter_var(htmlentities($_POST['firstname'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $lastname = filter_var(htmlentities($_POST['lastname'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var(htmlentities($_POST['phone'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $country = filter_var(htmlentities($_POST['country'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $state_id = filter_var(htmlentities($_POST['state_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $city_id = filter_var(htmlentities($_POST['city_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $industry_id = filter_var(htmlentities($_POST['industry_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $job_experience_id = filter_var(htmlentities($_POST['job_experience_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $functional_area_id = filter_var(htmlentities($_POST['functional_area_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $gender = filter_var(htmlentities($_POST['gender'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $resume = $_FILES['resume']['name'];
    $photo = $_FILES['photo']['name'];
    $status = 1;
    $created_at = date("F d, y");
    // =========================== password hashinng ==================================
    $password_var = filter_var(htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $password = password_hash($password_var, PASSWORD_DEFAULT);
    // ================================================================================
    $confirmpassword = filter_var(htmlentities($_POST['confirmpassword'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    $emailsql = "SELECT * FROM candidates WHERE email = :email";
    $exist_email = $conn->prepare($emailsql);
    $exist_email->bindParam(':email', $email, PDO::PARAM_STR);
    $exist_email->execute();

    $num_email = $exist_email->rowCount();

    if($firstname == null || $lastname == null || $email == null || $phone == null || $country == null || $state_id == null || $city_id == null || $industry_id == null || $job_experience_id == null || $functional_area_id == null || $gender == null || $resume == null || $photo == null || $password == null || $confirmpassword == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_email == 1)
    {
        $email_err = array('error' => 'Email Already Exists.');
        echo json_encode($email_err);
        exit;
    }
    elseif(strlen($password_var) < 6)
    {
        $password_err = array('error' => 'Password Must Have Atleast 6 Characters.');
        echo json_encode($password_err);
        exit;
    }
    elseif($password_var != $confirmpassword)
    {
        $confirm_password_err = array('error' => 'Password And Confirm Password Field Does Not Match.');
        echo json_encode($confirm_password_err);
        exit;
    }
    elseif(!filter_var($email, FILTER_SANITIZE_EMAIL))
    {
        $email_error = array('error' => 'Invalid Email ID.');
        echo json_encode($email_error);
        exit;
    }
    elseif(empty($empty) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($email_error))
    {
        $sql = "INSERT INTO candidates (firstname, lastname, email, phone, country, state_id, city_id, industry_id, job_experience_id, functional_area_id, gender, resume, photo, password, status, created_at) VALUES(:firstname, :lastname, :email, :phone, :country, :state_id, :city_id, :industry_id, :job_experience_id, :functional_area_id, :gender, :resume, :photo, :password, :status, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':phone', $phone, PDO::PARAM_INT);
        $query->bindParam(':country', $country, PDO::PARAM_STR);
        $query->bindParam(':state_id', $state_id, PDO::PARAM_INT);
        $query->bindParam(':city_id', $city_id, PDO::PARAM_INT);
        $query->bindParam(':industry_id', $industry_id, PDO::PARAM_INT);
        $query->bindParam(':job_experience_id', $job_experience_id, PDO::PARAM_INT);
        $query->bindParam(':functional_area_id', $functional_area_id, PDO::PARAM_INT);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':resume', $resume, PDO::PARAM_STR);
        $query->bindParam(':photo', $photo, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $result = $query->execute();
        if($result)
        {
            move_uploaded_file($_FILES["resume"]["tmp_name"],"../assets/images/resume/".$_FILES["resume"]["name"]);
            move_uploaded_file($_FILES["photo"]["tmp_name"],"../assets/images/profile_picture/".$_FILES["photo"]["name"]);
            $success = array('message' => 'Account Created Successfully.', 'title' => 'Congratulations !');
            echo json_encode($success);
            exit;
        }
        else
        {
            $error = array('error' => 'Something went wrong. Please try again later.');
            echo json_encode($error);
            exit;
        }
    }
}
?>