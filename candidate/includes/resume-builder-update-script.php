<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';

if(isset($_POST['updateEducation']))
{
    $qualification_id = filter_var(htmlentities($_POST['qualification_id']), FILTER_SANITIZE_NUMBER_INT);
    $institute = filter_var(htmlentities($_POST['institute']), FILTER_SANITIZE_STRING);
    $graduation_year = filter_var(htmlentities($_POST['graduation_year']),FILTER_SANITIZE_NUMBER_INT);
    $updated_at = date("F d, Y");

    if($qualification_id == null || $institute == null || $graduation_year == null)
    {
        header ("Location: ".$path."/candidate/resume-builder?error=empty-inputs");
    }
    else
    {
        $sql = "UPDATE manage_candidate_qualifications SET qualification_id = :qualification_id, institute = :institute, graduation_year = :graduation_year, updated_at = :updated_at WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->bindParam(':qualification_id', $qualification_id, PDO::PARAM_INT);
        $stmt->bindParam(':institute', $institute, PDO::PARAM_STR);
        $stmt->bindParam(':graduation_year', $graduation_year, PDO::PARAM_INT);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $statement = $stmt->execute();
        if($statement)
        {
            header ("Location: ".$path."/candidate/resume-builder?update-education=success");
        }
        else
        {
            header ("Location: ".$path."/candidate/resume-builder?error=education-update");
        }
    }
}
?>