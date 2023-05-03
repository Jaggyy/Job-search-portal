<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $job_type = filter_var(htmlentities($_POST['job_type'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);

    //Title to friendly URL conversion
    $newurltitle=str_replace(" ","-",$job_type);
    $newurltitle=strtolower($newurltitle);
    $slug=$newurltitle; // Final URL

    $status = filter_var(htmlentities($_POST['status'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("F d, y");

    $sql = "SELECT * FROM job_types WHERE job_type = :job_type";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':job_type', $job_type, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($job_type == null || $status == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $job_type_err = array('error' => ''.$job_type.' Already Exists.');
        echo json_encode($job_type_err);
        exit;
    }
    elseif(empty($empty) && empty($job_type_err))
    {
        $sql = "INSERT INTO job_types (job_type, slug, status, created_at) VALUES(:job_type, :slug, :status, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':job_type', $job_type, PDO::PARAM_STR);
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