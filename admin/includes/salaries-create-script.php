<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $salary_from = filter_var(htmlentities($_POST['salary_from'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $salary_to = filter_var(htmlentities($_POST['salary_to'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $created_at = date("F d, y");

    if($salary_from == null || $salary_to == null)
    {
        $empty = array('error' => 'Please Fill Required Fields.');
        echo json_encode($empty);
        exit;
    }
    elseif(empty($empty))
    {
        $sql = "INSERT INTO salaries (salary_from, salary_to, created_at) VALUES(:salary_from, :salary_to, :created_at)";
        $query = $conn->prepare($sql);
        $query->bindParam(':salary_from', $salary_from, PDO::PARAM_INT);
        $query->bindParam(':salary_to', $salary_to, PDO::PARAM_INT);
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