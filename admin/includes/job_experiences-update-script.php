<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $job_experience = filter_var(htmlentities($_POST['job_experience'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $updated_at = date("F d, y");

    if($job_experience == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE job_experiences SET job_experience = :job_experience, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':job_experience', $job_experience, PDO::PARAM_STR);
        $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
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