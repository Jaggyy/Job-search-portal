<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $job_experience = filter_var(htmlentities($_POST['job_experience'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $created_at = date("F d, y");

    $sql = "SELECT * FROM job_experiences WHERE job_experience = :job_experience";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':job_experience', $job_experience, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($job_experience == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $job_experience_err = array('error' => ''.$job_experience.' Already Exists.');
        echo json_encode($job_experience_err);
        exit;
    }
    elseif(empty($empty) && empty($job_experience_err))
    {
        $sql = "INSERT INTO job_experiences (job_experience, created_at) VALUES(:job_experience, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':job_experience', $job_experience, PDO::PARAM_STR);
        $query->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $result = $query->execute();
        if($result)
        {
            $success = array('message' => 'Operation Successfull.', 'title' => 'Success');
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