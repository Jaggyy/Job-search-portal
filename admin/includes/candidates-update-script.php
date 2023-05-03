<?php
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $status = filter_var(htmlentities($_POST['status'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $updated_at = date("F d, y");

    $sql = "UPDATE candidates SET status = :status, updated_at = :updated_at WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
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
?>