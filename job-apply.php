<?php
session_start();
error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';
if(!isset($_SESSION["candidate_login"]) || $_SESSION["candidate_login"] !== true)
{   
	header('location:'.$path.'/candidate/');
	exit();
}
else
{
	$job_id = $_GET['id'];
	$candidate_id = $_SESSION['candidate_id'];
	$applied_at = date("F d, Y");

	$retrieve = "SELECT * FROM job_applied WHERE candidate_id = :candidate_id AND job_id  = :job_id";
	$fetch_result = $conn->prepare($retrieve);
	$fetch_result->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
	$fetch_result->bindParam(":job_id", $job_id, PDO::PARAM_INT);
	$fetch_result->execute();
	$result = $fetch_result->rowCount();
	if($result > 0)
	{
		header ("Location: ".$path."/applied-status?id=".$job_id."&status=already-applied");
	}
	else
	{
		$sql_retrieve = "SELECT company_id FROM jobs WHERE job_id = :job_id";
		$query = $conn->prepare($sql_retrieve);
		$query->bindParam(':job_id', $job_id, PDO::PARAM_INT);
		$query->execute();
		$fetch = $query->fetch();
		$company_id = $fetch['company_id'];
		if($fetch)
		{
			$sql = "INSERT INTO job_applied (candidate_id, job_id, company_id, applied_at) VALUES (:candidate_id, :job_id, :company_id, :applied_at)";
			$statement = $conn->prepare($sql);
			$statement->bindParam(":candidate_id", $candidate_id, PDO::PARAM_INT);
			$statement->bindParam(":job_id", $job_id, PDO::PARAM_INT);
			$statement->bindParam(":company_id", $company_id, PDO::PARAM_INT);
			$statement->bindParam(":applied_at", $applied_at, PDO::PARAM_STR);
			$stmt = $statement->execute();

			if($stmt)
			{
				header ("Location: ".$path."/applied-status?id=".$job_id."&status=applied");
			}
			else
			{
				header ("Location: ".$path."/error");
			}
		}
	}
}
?>