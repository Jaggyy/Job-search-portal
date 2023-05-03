<?php
if(isset($_POST['update']))
{
    $job_amount = filter_var(htmlentities($_POST['job_amount'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $company_amount = filter_var(htmlentities($_POST['company_amount'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);

    $check = "SELECT * FROM featuring_amount";
    $statement = $conn->prepare($check);
    $statement->execute();
    $stmt = $statement->rowCount();
    if($stmt == 0)
    {
        $insert = "INSERT INTO featuring_amount (job_amount, company_amount) VALUES (:job_amount, :company_amount)";
        $qry = $conn->prepare($insert);
        $qry->bindParam(":job_amount", $job_amount, PDO::PARAM_INT);
        $qry->bindParam(":company_amount", $company_amount, PDO::PARAM_INT);
        $result = $qry->execute();
        if($result)
        {
            $success = 'Operation Successfull.';
        }
        else
        {
            $error = 'Something went wrong. Please try again later.';
        }
    }
    else
    {
        $update = "UPDATE featuring_amount SET job_amount = :job_amount, company_amount = :company_amount";
        $query = $conn->prepare($update);
        $query->bindParam(':job_amount', $job_amount, PDO::PARAM_INT);
        $query->bindParam(':company_amount', $company_amount, PDO::PARAM_INT);
        $results = $query->execute();
        if($results)
        {
            $success = 'Operation Successfull.';
        }
        else
        {
            $error = 'Something went wrong. Please try again later.';
        }
    }
}
?>