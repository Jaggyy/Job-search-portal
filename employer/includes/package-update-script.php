<?php
if(isset($_POST['submit']))
{
    $company_id = $_SESSION['company_id'];
    $package_id = filter_var(htmlentities($_POST['package_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $amount = filter_var(htmlentities($_POST['amount'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $received_for = $_POST['plan'].' Package Subscription';
    $package_start_date = date('Y-m-d');
    $package_start_date = date('Y-m-d', strtotime($package_start_date));

    $package_end_date = date('Y-m-d', strtotime("+28 days"));
    $updated_at = date("F d, Y");

    $sql = "UPDATE companies SET package_id = :package_id, package_start_date = :package_start_date, package_end_date = :package_end_date, updated_at = :updated_at WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $query->bindParam(':package_start_date', $package_start_date, PDO::PARAM_STR);
    $query->bindParam(':package_end_date', $package_end_date, PDO::PARAM_STR);
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
            header('Refresh:5;url='.$path.'/employer/subscriptions/manage');
        }
        else
        {
            $error = 'Something went wrong. Please try again later.';
            header('Refresh:5;url='.$path.'/employer/subscriptions/manage');
        }
    }
}
?>