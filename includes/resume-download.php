<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
$path = 'http://localhost/naukri';

if(ISSET($_REQUEST['file_id']))
{
	$file = $_REQUEST['file_id'];
	$sql = "SELECT * FROM candidates WHERE id = :id";
	$query = $conn->prepare($sql);
	$query->bindParam(":id", $file, PDO::PARAM_STR);
	$query->execute();
	$fetch = $query->fetch();

	header("Content-Disposition: attachment; filename=".$fetch['resume']);
	header("Content-Type: application/octet-stream;");
	readfile("http://localhost/naukri/assets/images/resume/".$fetch['resume']);
}
?>