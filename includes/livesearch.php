<?php
include($_SERVER['DOCUMENT_ROOT'].'/naukri/includes/config.php');
try
{
    if(isset($_REQUEST["term"]))
    {
        $sql = "(SELECT companyname AS term FROM companies WHERE companyname LIKE :term AND status = 1 AND verified = 1) UNION (SELECT job_title AS term FROM jobs WHERE job_title LIKE :term AND status = 1 AND verified = 1)";
        $stmt = $conn->prepare($sql);
        $term = $_REQUEST["term"] . '%';
        $stmt->bindParam(":term", $term);
        $stmt->execute();
        if($stmt->rowCount() > 0)
        {
            while($row = $stmt->fetch())
            {
                echo "<p>" . $row["term"] . "</p>";
            }
        } 
        else
        {
            echo "<p>No matches found</p>";
        }
    }  
} 
catch(PDOException $e)
{
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
unset($stmt);
unset($conn);
?>