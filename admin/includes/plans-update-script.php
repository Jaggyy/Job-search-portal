<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $plan = filter_var(htmlentities($_POST['plan'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_STRING);
    $allowed_jobs = filter_var(htmlentities($_POST['allowed_jobs'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $amount = filter_var(htmlentities($_POST['amount'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $updated_at = date("F d, y");

    if($plan == null || $allowed_jobs == null || $amount == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif(empty($empty))
    {
        $sql = "UPDATE plans SET plan = :plan, allowed_jobs = :allowed_jobs, amount = :amount, updated_at = :updated_at WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->bindParam(':plan', $plan, PDO::PARAM_STR);
        $query->bindParam(':allowed_jobs', $allowed_jobs, PDO::PARAM_INT);
        $query->bindParam(':amount', $amount, PDO::PARAM_INT);
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