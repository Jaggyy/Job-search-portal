<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$page = 'resume_builder';
$path = 'http://localhost/naukri';
if(!isset($_SESSION["candidate_login"]) || $_SESSION["candidate_login"] !== true)
{   
	header('location:http://localhost/naukri/candidate');
	exit();
}
$candidate_id = $_SESSION['candidate_id'];
?>

<?php
if(isset($_POST['candidate_skill_id']))
{
    $candidate_skill_id = filter_var(htmlentities($_POST['candidate_skill_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $candidate_id = filter_var(htmlentities($_POST['candidate_id'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $rating = filter_var(htmlentities($_POST['rating'], ENT_QUOTES, 'UTF-8'),FILTER_SANITIZE_NUMBER_INT);
    $updated_at = date('F d, Y');

    $ratingsql = "SELECT * FROM manage_candidate_skills WHERE candidate_skill_id = :candidate_skill_id AND candidate_id = :candidate_id";
    $exist_rating = $conn->prepare($ratingsql);
    $exist_rating->bindParam(':candidate_skill_id', $candidate_skill_id, PDO::PARAM_INT);
    $exist_rating->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
    $exist_rating->execute();

    $num_rating = $exist_rating->rowCount();

    if($num_rating > 0)
    {
        $sql = "UPDATE manage_candidate_skills SET rating = :rating, updated_at = :updated_at WHERE candidate_id = :candidate_id AND candidate_skill_id = :candidate_skill_id";
        $query = $conn->prepare($sql);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT);
        $query->bindParam(':candidate_id', $candidate_id, PDO::PARAM_INT);
        $query->bindParam(':candidate_skill_id', $candidate_skill_id, PDO::PARAM_INT);
        $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
        $result = $query->execute();
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>