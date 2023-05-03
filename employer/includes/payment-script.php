<?php
if(isset($_POST['submit']))
{
    $company_id = $_SESSION['company_id'];
    $is_featured = filter_var(htmlentities($_POST['is_featured'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $amount = filter_var(htmlentities($_POST['amount'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $received_for = 'Featuring Job';
    $updated_at = date("F d, Y");

    $sql = "UPDATE jobs SET is_featured = :is_featured, updated_at = :updated_at WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
    $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
    $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $result = $query->execute();
    if($result)
    {
        $insert = "INSERT INTO revenue (company_id, amount, received_for, created_at) VALUES (:company_id, :amount, :received_for, :created_at)";
        $stmt = $conn->prepare($insert);
        $stmt->bindParam(':company_id', $company_id, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->bindParam(':received_for', $received_for, PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $updated_at, PDO::PARAM_STR);
        $rslt = $stmt->execute();
        if($rslt)
        {
            $success = 'Operation Successfull.';
            header('Refresh:5;url='.$path.'/employer/jobs/manage');
        }
        else
        {
            $error = 'Something went wrong. Please try again later.';
            header('Refresh:5;url='.$path.'/employer/jobs/manage');
        }
    }
}
?>