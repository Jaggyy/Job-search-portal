<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $job_skill = filter_var(htmlentities($_POST['job_skill'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$job_skill);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $status = filter_var(htmlentities($_POST['status'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("F d, y");

    $sql = "SELECT * FROM job_skills WHERE job_skill = :job_skill";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':job_skill', $job_skill, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($job_skill == null || $status == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $job_skill_err = array('error' => ''.$job_skill.' Already Exists.');
        echo json_encode($job_skill_err);
        exit;
    }
    elseif(empty($empty) && empty($job_skill_err))
    {
        $sql = "INSERT INTO job_skills (job_skill, slug, status, created_at) VALUES(:job_skill, :slug, :status, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':job_skill', $job_skill, PDO::PARAM_STR);
        $query->bindParam(':slug', $slug, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
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