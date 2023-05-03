<?php
session_start();
error_reporting(E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$candidate_id = $_SESSION['candidate_id'];
if(isset($_POST['submit']))
{
    header('Content-Type: application/json');
    $resume = $_FILES['resume']['name'];
    $updated_at = date("F d, Y");

    $sql = "UPDATE candidates SET resume = :resume, updated_at = :updated_at WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(':resume', $resume, PDO::PARAM_STR);
    $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
    $query->bindParam(':id', $candidate_id, PDO::PARAM_INT);
    $result = $query->execute();
    if($result)
    {
        move_uploaded_file($_FILES["resume"]["tmp_name"],"../../assets/images/resume/".$_FILES["resume"]["name"]);
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