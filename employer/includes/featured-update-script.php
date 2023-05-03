<?php
if(isset($_POST['submit']))
{
    $company_id = $_SESSION['company_id'];
    $amount = filter_var(htmlentities($_POST['amount'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $received_for = 'Featuring Company';
    $featured_start_date = date('Y-m-d');
    $featured_start_date = date('Y-m-d', strtotime($featured_start_date));

    $featured_end_date = date('Y-m-d', strtotime("+1 year"));
    $updated_at = date("F d, Y");

    $sql = "UPDATE companies SET is_featured = 1, featured_start_date = :featured_start_date, featured_end_date = :featured_end_date, updated_at = :updated_at WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':featured_start_date', $featured_start_date, PDO::PARAM_STR);
    $query->bindParam(':featured_end_date', $featured_end_date, PDO::PARAM_STR);
    $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
    $query->bindParam(':id', $company_id, PDO::PARAM_INT);
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
            header('Refresh:5;url='.$path.'/employer/profile');
        }
        else
        {
            $error = 'Something went wrong. Please try again later.';
            header('Refresh:5;url='.$path.'/employer/profile');
        }
    }
}
?>