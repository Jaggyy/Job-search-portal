<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $plan = filter_var(htmlentities($_POST['plan'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $allowed_jobs = filter_var(htmlentities($_POST['allowed_jobs'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $amount = filter_var(htmlentities($_POST['amount'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("F d, y");

    $sql = "SELECT * FROM plans WHERE plan = :plan";
    $exist = $conn->prepare($sql);
    $exist->bindParam(':plan', $plan, PDO::PARAM_STR);
    $exist->execute();

    $num_exist = $exist->rowCount();

    if($plan == null || $allowed_jobs == null || $amount == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif($num_exist == 1)
    {
        $plan_err = array('error' => ''.$plan.' Already Exists.');
        echo json_encode($plan_err);
        exit;
    }
    elseif(empty($empty) && empty($plan_err))
    {
        $sql = "INSERT INTO plans (plan, allowed_jobs, amount, created_at) VALUES(:plan, :allowed_jobs, :amount, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':plan', $plan, PDO::PARAM_STR);
        $query->bindParam(':allowed_jobs', $allowed_jobs, PDO::PARAM_INT);
        $query->bindParam(':amount', $amount, PDO::PARAM_INT);
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